<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Request;
use Crowdfundly\App\Helpers\Sanitizer;

/**
 * User authentication Controller
 * Provides functionality for the Crowdfundly authentications.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class AuthenticationController extends BaseController
{
    public function register()
    {
        cf_wp_ajax( 'cf_create_organization', [ $this, 'cf_create_organization' ] );
        cf_wp_ajax( 'cf_package_gateway', [ $this, 'cf_package_gateway' ] );
        cf_wp_ajax( 'cf_package_capture', [ $this, 'cf_package_capture' ] );
        cf_wp_ajax( 'cf_appkey_auth', [ $this, 'cf_appkey_auth' ] );
        cf_wp_ajax( 'cf_email_auth', [ $this, 'cf_email_auth' ] );
        cf_wp_ajax( 'cf_after_email_login', [ $this, 'cf_after_email_login' ] );
        cf_wp_ajax( 'cf_signup', [ $this, 'cf_signup' ] );
        cf_wp_ajax( 'cf_disconnect', [ $this, 'cf_disconnect' ] );

        $this->auto_login();
    }

    public function appkey_login($appkey)
    {
        $data = [];
        $res = Request::post(
            'wp/authenticate',
            [
                'body' => [ 'token' => $appkey ]
            ]
        );

        if ( $res->status_code() != 200 ) {
            $data['message'] = isset( $res->body()['message'] ) ? $res->body()['message'] : $res->message();
            $data['code'] = $res->status_code();
            return $data;
        }

        $data['appkey'] = $appkey;
        $body = $res->body();
        $data['login_session'] = time() + $body['ttl'];
        unset( $body['countries'] );
        unset( $body['currencies'] );

        $user = $this->get_user_data( $body['token'] );
        if ( $user->status_code() !== 200 ) {
            $data['message'] = isset( $body['message'] ) ? $body['message'] : $res->message();
            $data['code'] = $res->status_code();
            return $data;
        }
        $user_data = $user->body();
        unset( $user_data['organizations'] );
        $data['user'] = $user_data;

        $data = array_merge( $data, $body );
        DBAccessor::add('crowdfundly_settings', $data);  // data added to db
        update_option( 'crowdfundly_url_update', false );   // allow to change public pages permalink
        
        $data['message'] = 'OK';
        $data['code'] = 200;
        return $data;
    }

    public function cf_appkey_auth()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $appkey = esc_html( $_POST['app_key'] );
        
        $data = $this->appkey_login($appkey);
        if ( $data['code'] !== 200 ) {
            wp_send_json_error(
                [ 'message' =>  $data['message'], 'code' => $data['code'] ],
                $data['code']
            );
            wp_die();
        }
        wp_send_json(
            [ 'message' =>  $data['message'], 'code' => $data['code'] ],
            $data['code']
        );
        wp_die();
    }

    public function email_login($login_data)
    {
        $result = [];
        $args = [
            'email' => 'email',
            'password' => 'html'
        ];
        $data = Sanitizer::sanitize( $login_data, $args );
        $data['type'] = 'regular';

        // email login
        $res = Request::post(
            'auth/login',
            [
                'body' => $data,
                'content_type' => 'application/json'
            ]
        );
        $body = $res->body();
        if ( $res->status_code() != 200 ) {
            $result['message'] = isset( $body['message'] ) ? $body['message'] : $res->message();
            $result['code'] = $res->status_code();
            return $result;
        }

        $db_data = [];
        $db_data['login_session'] = time() + $body['ttl'];
        $db_data['token'] = $body['access_token'];
        $db_data['ttl'] = $body['ttl'];
        $db_data['email_login'] = true;
        $db_data['email'] = $data['email'];
        $db_data['password'] = $this->encrypt_decrypt( 'encrypt', $data['password'] );

        // get user data
        $user = $this->get_user_data( $body['access_token'] );
        $user_data = $user->body();
        if ( $user->status_code() !== 200 ) {
            $result['message'] = isset( $body['message'] ) ? $body['message'] : $res->message();
            $result['code'] = $res->status_code();
            return $result;
        }
        $org_list = $user_data['organizations'];
        unset( $user_data['organizations'] );
        $db_data['user'] = $user_data;

        DBAccessor::add( 'crowdfundly_settings', $db_data );  // data added to db
        update_option( 'crowdfundly_url_update', false );   // allow to change public pages permalink

        $result['message'] = 'OK';
        $result['code'] = 200;
        $result['org_list'] = $org_list;
        return $result;
    }

    public function cf_email_auth()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $auth_data = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $data = $this->email_login( $auth_data );
        wp_send_json($data);
        wp_die();

        if ( $data['code'] != 200 ) {
            wp_send_json_error( $data, $data['code'] );
            wp_die();
        }

        if ( ! empty( $data['org_list'] ) ) {
            DBAccessor::addItem( 'crowdfundly_settings', 'select_org', true );
        }
        wp_send_json( $data, 200 );
        wp_die();
    }

    public static function encrypt_decrypt($action, $string) {
		$output = false;
		$encrypt_method = "aes-128-cbc-hmac-sha256";
		$secret_key = 'crowdfundly-aes-128-cbc-hmac-sha256';
		$secret_iv = 'crowdfundly-aes-128-cbc-hmac-sha256';
		$key = hash('sha256', $secret_key);
		
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} elseif ( $action == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}

    public function cf_after_email_login()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $org_user = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $org_user_name = esc_html( $org_user['orgUserName'] );
        $user = $this->get_user_data( DBAccessor::getItem('token') );

        if ( $user->status_code() !== 200 ) {
            wp_send_json_error(
                [ 'message' =>  $user->message() ],
                $user->status_code()
            );
            wp_die();
        }

        $org = null;
        $user_data = $user->body();
        foreach (  $user_data['organizations'] as $org ) {
            if ( $org['username'] == $org_user_name ) {
                $org = $org;
                break;
            }
        }
        DBAccessor::addItem( 'crowdfundly_settings', 'organization', $org );    // org data added in db
        DBAccessor::updateItem( 'crowdfundly_settings', 'select_org', false );
        update_option( 'crowdfundly_url_update', false ); 

        wp_send_json( [ true ], 200 );
        wp_die();
    }

    public function cf_create_organization() {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $organization = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $args = [
            'address'               => 'html',
            'contact_number'        => 'html',
            'contact_number_code'   => 'int',
            'country_id'            => 'int',
            'currency_id'           => 'int',
            'description'           => 'allowed_html',
            'name'                  => 'html',
            'subscription_id'       => 'int',
            'username'              => 'html',
        ];
        $organization = Sanitizer::sanitize( $organization, $args );

        $token = DBAccessor::getItem('token');
        $res = Request::post(
            'organizations',
            [
                'headers' => [
                    'authorization' => 'Bearer ' . $token
                ],
                'body' => $organization,
            ]
        );

        if ( $res->status_code() > 299 ) {
            $error = $res->body() ? $res->body() : $res->message(); 
            wp_send_json( $error, $res->status_code() );
            wp_die();
        }
        $organization = $res->body();
        // DBAccessor::updateItem( 'crowdfundly_settings', 'organization', $res->body() );

        $user_data = [];
        $user_res = $this->get_user_data( $token );
        if ( $user_res->status_code() !== 200 ) {
            $user_data['message'] = isset( $res->body()['message'] ) ? $res->body()['message'] : $res->message();
            $user_data['code'] = $res->status_code();
            return $user_data;
        }
        $user_data = $user_res->body();
        if ( isset( $user_data['organizations'] ) ) {
            unset( $user_data['organizations'] );
        }

        $crowdfundly_settings = DBAccessor::get();
        $crowdfundly_settings['organization'] = $organization;
        $crowdfundly_settings['user'] = $organization;
        $crowdfundly_settings['temp_login'] = false;
        DBAccessor::update( 'crowdfundly_settings', $crowdfundly_settings );
        update_option( 'crowdfundly_url_update', false );

        wp_send_json( 'login', $user_res->status_code() );
        wp_die();
    }

    public function get_user_data($token)
    {
		$args = array(
            'headers'   => array(
                'Authorization' => 'Bearer ' . $token,
            ),
            'timeout' => 15,
        );

        return Request::get( 'user', $args );
    }

    private function auto_login()
    {
        if ( ! DBAccessor::is_login() ) return;
        
        $session = DBAccessor::getItem('login_session');
        if ( time() <= $session ) return;

        $data = [];
        $route = '';
        $appkey = DBAccessor::getItem('appkey');
        if ( $appkey ) {
            $route = 'wp/authenticate';
            $data['token'] = $appkey;
        } else {
            $route = 'auth/login';
            $data['email'] = DBAccessor::getItem('email');
            $data['password'] = $this->encrypt_decrypt( 'decrypt', DBAccessor::getItem('password') );
            $data['type'] = 'regular';
        }
        $res = Request::post(
            $route,
            [
                'body' => $data,
                'timeout' => 20,
            ]
        );
        if ( $res->status_code() !== 200 ) return;

        $data = DBAccessor::get();
        $body = $res->body();
        $data['token'] = $appkey ? $body['token'] : $body['access_token'];    // update token
        $data['login_session'] = time() + $body['ttl']; // update session
        DBAccessor::update('crowdfundly_settings', $data);  // update DB
    }

    public function cf_disconnect()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;
        
        $disconnect = isset( $_POST['disconnect'] ) ? esc_html( $_POST['disconnect'] ) : false;
       if ( $disconnect == 'true' ) {
            delete_option('crowdfundly_settings');
            update_option( 'crowdfundly_url_update', false );

            wp_send_json_success(
                [ 'message' => __( 'Successfully Disconnected.', 'crowdfundly' ) ],
                200
            );
            wp_die();
        }
    }

    public function cf_signup()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $args = [
            'name'                  => 'html',
            'email'                 => 'email',
            'password'              => 'html',
            'type'                  => 'html',
            'password_confirmation' => 'html',
        ];
        $signup_data = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        $data = Sanitizer::sanitize( $signup_data, $args );
        $res = Request::post(
            'auth/register',
            [ 'body' => $data, ]
        );
        if ( $res->status_code() != 200 ) {
            $error = $res->body() ? $res->body() : $res->message(); 
            wp_send_json_error( $error, $res->status_code() );
            wp_die();
        }
        $data = $res->body();
        $token = $data['access_token'];
        unset(  $data['access_token'] );
        $data['token'] = $token;
        $data['login_session'] = time() + $data['ttl'];
        $data['temp_login'] = true;

        DBAccessor::update( 'crowdfundly_settings', $data );
        wp_send_json( $data, $res->status_code() );
        wp_die();
    }

    public function cf_package_gateway()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $package = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );

        $res = Request::post(
            'cashier/package/buy',
            [
                'headers' => [
                    'authorization' => 'Bearer ' . DBAccessor::getItem('token')
                ],
                'body' => $package,
            ]
        );
        if ( $res->status_code() > 299 ) {
            $error = $res->body() ? $res->body() : $res->message();
            wp_send_json_error( $error, $res->status_code() );
            wp_die();
        }
        wp_send_json( $res->body(), $res->status_code() );
        wp_die();
    }

    public function cf_package_capture()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $capture = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );

        $res = Request::post(
            'cashier/payment/' . $capture['payment_id'] . '/capture',
            [
                'headers' => [
                    'authorization' => 'Bearer ' . DBAccessor::getItem('token')
                ],
                'body' => $capture['payment_intent'],
            ]
        );

        if ( $res->status_code() > 299 ) {
            $error = $res->body() ? $res->body() : $res->message();
            wp_send_json_error( $error, $res->status_code() );
            wp_die();
        }
        wp_send_json( $res->body(), $res->status_code() );
    }

}
