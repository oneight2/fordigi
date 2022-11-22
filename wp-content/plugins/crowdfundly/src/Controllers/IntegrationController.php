<?php
namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Request;
use Crowdfundly\App\Helpers\Sanitizer;
use Crowdfundly\App\Providers\RestApiServiceProvider;

/**
 * Webhook handler Controller
 * functionalites for webhooks.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.8
 */
class IntegrationController extends BaseController
{

    private $event_result = [];

    public function register()
    {
        cf_wp_ajax( 'cf_enable_integration', [ $this, 'cf_enable_integration' ] );
        cf_wp_ajax( 'cf_handlers_list', [ $this, 'cf_handlers_list' ] );
        cf_wp_ajax( 'cf_update_handlers', [ $this, 'cf_update_handlers' ] );
        cf_wp_ajax( 'cf_disable_integration', [ $this, 'cf_disable_integration' ] );
        cf_wp_ajax( 'get_fcrm_data', [ IntegrationHandlerController::class, 'get_fcrm_data' ] );
    }

    public function event_callback_list()
    {
        return [
            'fcrm_contact'  => [$this, 'fcrm_action'],
            'wp_user'       => [$this, 'create_wp_user'],
        ];
    }

    public function cf_enable_integration()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $has_enabled_before = DBAccessor::getItem( 'token', 'crowdfundly_integration' );
        $disable = DBAccessor::getItem( 'disabled', 'crowdfundly_integration' ) ? false : true;
        if ( $has_enabled_before ) {
            DBAccessor::updateItem( 'crowdfundly_integration', 'disabled', $disable );

            wp_send_json(
                true,
                200
            );
            wp_die();
        }

        $res = $this->create_integration();
        // if ( $res->status_code() > 299 ) {
        //     $data['message'] = isset( $res->body()['message'] ) ? $res->body()['message'] : $res->message();
        //     $data['code'] = $res->status_code();
        //     return $data;
        // }
        wp_send_json(
            $res->body(),
            200
        );
        wp_die();
    }

    private function create_integration()
    {
        $token = $this->generate_token();
        $crowdfundly_integration = [];
        $crowdfundly_integration['token'] = $token;
        $crowdfundly_integration['disabled'] = false;
        $crowdfundly_integration['integration_handlers'] = [];
        $organization = DBAccessor::getItem( 'organization' );

        // send api request to create webhook
        $res = Request::post(
            'organization/webhook/wp',
            [
                'headers'   => [
                    'authorization' => $token
                ],
                'body' => [
                    'token'             => $token,
                    'url'               => RestApiServiceProvider::get_route('webhook'),
                    'domain'            => esc_url( get_bloginfo('url') ),
                    'organization_id'   => $organization['id'],
                ]
            ]
        );

        if ( $res->status_code() == 201 ) {
            DBAccessor::update( 'crowdfundly_integration', $crowdfundly_integration );
        }

        return $res;
    }

    public function cf_update_handlers()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $handlers = json_decode( fgets( fopen( 'php://input', 'r' ) ), true );
        // $args = [];
        // $handlers_keys = array_keys( $handlers );
        // foreach ( $handlers_keys as $key ) {
        //     $args[$key] = 'bool';
        // }
        // $data = Sanitizer::sanitize( $handlers, $args );
        DBAccessor::updateItem( 'crowdfundly_integration', 'integration_handlers', $handlers );

        wp_send_json(
            $handlers,
            200
        );
    }

    public function cf_disable_integration()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        DBAccessor::updateItem( 'crowdfundly_integration', 'disabled', true );

        wp_send_json(
            [DBAccessor::get('crowdfundly_integration')],
            200
        );
        $data = [];
        // send api request to disable webhook
        // $res = Request::post(
        //     'edit-webhook',
        //     [
        //         'body' => []
        //     ]
        // );

        // if ( $res->status_code() != 200 ) {
        //     $data['message'] = isset( $res->body()['message'] ) ? $res->body()['message'] : $res->message();
        //     $data['code'] = $res->status_code();
        //     return $data;
        // }

        // wp_send_json(
        //     $res->body(),
        //     $res->status_code()
        // );
    }

    public static function allow_route()
    {
        $is_login = DBAccessor::is_login();
        $integration = DBAccessor::get( 'crowdfundly_integration' );
        if ( ! $integration || ! $is_login ) return false;

        if ( isset( $integration['disabled'] ) && $integration['disabled'] ) {
            return false;
        }
        return true;
    }

    public static function has_integration()
    {
        $token = DBAccessor::getItem( 'token', 'crowdfundly_integration' );
        return $token ? true : false;
    }

    public function integration_api_callback( \WP_REST_Request $request )
    {
        $token = DBAccessor::getItem( 'token', 'crowdfundly_integration' );

        $body_params = json_decode( $request->get_body(), true );
        $auth_token = $request->get_header( 'authorization' );
        $auth_token = explode( ' ', $auth_token );
        update_option('auth_meta', $request->get_body());

        if ( ! isset( $auth_token[1] ) && $auth_token[1] !== $token ) {
            return new \WP_Error(
                401,
                esc_html( 'Invalid token' ),
                [ 'status' => 401 ]
            );
        }

        $handlers = DBAccessor::getItem( 'integration_handlers', 'crowdfundly_integration' );
        foreach ( $handlers as $key => $value ) {
            if ( ! isset( $this->event_callback_list()[$key] ) || ! $value ) continue;

            call_user_func( $this->event_callback_list()[$key], $body_params );
        }

        // $response = empty( $this->event_result ) ? 'Success' : $this->event_result;
        return new \WP_REST_Response( $this->event_result, 200 );
    }

    public static function status()
    {
        if ( ! DBAccessor::get( 'crowdfundly_integration' ) ) {
            return false;
        }
        return ! DBAccessor::getItem( 'disabled', 'crowdfundly_integration' );
    }

    private static function generate_token()
    {
        return bin2hex( openssl_random_pseudo_bytes( 16 ) );
    }

    public static function get_handlers($brand_name)
    {
        $schema_handlers = IntegrationSchemaController::get_brand_events($brand_name);
        return $schema_handlers;
    }

    // udpated handlers list from DB.
    public function cf_handlers_list()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $schema = IntegrationSchemaController::get_schema();
        $db_handlers = DBAccessor::getItem( 'integration_handlers', 'crowdfundly_integration' );

        $schema_handlers = [];
        $handlers = [];
        if ( empty( $db_handlers ) ) {
            foreach ( $schema as $key => $integration ) {
                $schema_handlers[] = $integration['handlers'];
            }
            foreach ( $schema_handlers as $key => $handler ) {
                foreach ( $handler as $item ) {
                    $key = array_key_first( $item );
                    $handlers[$key] = $item[$key];
                }
            }
        } else {
            $handlers = $db_handlers;
        }

        wp_send_json( $handlers, 200 );
        wp_die();
    }

    private function fcrm_action($data)
    {
        $contact = IntegrationHandlerController::fcrm_create_contact($data);
        return $this->event_result['fcrm_contact'] = $contact;
    }

    private function create_wp_user($data)
    {
        $user = IntegrationHandlerController::create_wp_user($data);
        return $this->event_result['wp_user'] = $user;
    }

}
