<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Request;
use Crowdfundly\App\Helpers\Sanitizer;

/**
 * Organization Controller
 * Provides functionality for the Organization page.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class OrganizationController extends BaseController
{
    public function register()
    {
        cf_wp_ajax( 'cf_org_list', [ $this, 'cf_org_list' ] );
        cf_wp_ajax( 'cf_change_theme', [ $this, 'cf_change_theme' ] );
        cf_wp_ajax( 'cf_update_payment_gateway', [ $this, 'cf_update_payment_gateway' ], true );
    }

    public function cf_org_list()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;
        
        $token = DBAccessor::getItem('token');
        $user = (new AuthenticationController)->get_user_data($token);
        $user_data = $user->body();

        if ( $user->status_code() !== 200 ) {
            $message = isset( $user_data->body()['message'] ) ? $user_data->body()['message'] : $user_data->message();
            $code = $user_data->status_code();
            wp_send_json_error( $message, $code );
            wp_die();
        }
        wp_send_json( [ 'org_list' => $user_data['organizations'] ], 200 );
        wp_die();
    }

    public function renderView()
    {
        if ( ! DBAccessor::is_login() ) return;
        
        $data = [];
        $data['organization'] = self::get_organization_info();
        $data['recent_campaigns'] = AllCampaignController::get_all_campaigns(
            [
                'limit' => 3,
                'sort'  => 'created_at',
                'order' => 'desc',
            ]
        );
        $data['org_settings'] = (new SingleCampaignController)->get_organization_settings();

        if ( empty( $data['organization'] ) ) {
            return;
        }

        return $this->render( 'public/organization.php', $data, true );
    }

    public static function change_organization_title()
    {
        add_filter( 'the_title', array( __CLASS__, 'change_organization_title_callback' ) );
    }

    public static function change_organization_title_callback($title)
    {
        if ( ! DBAccessor::is_login() ) return $title;

        $org_page_id = get_option( 'crowdfundly_organization_page_id' );
        if ( ! $org_page_id ) return $title;

        $org = DBAccessor::getItem( 'organization' );
        if ( ( $title == "Organization" ) && $org ) {
			return $org['name'];
        }

        return $title;
    }

    public static function get_organization_info()
    {
		$org = DBAccessor::getItem( 'organization' );
		if ( ! $org ) return false;

        $route = 'organizations/' . $org['username'];
        $response = Request::get($route, [ 'timeout' => 10 ]);
		if ( $response->status_code() != 200 ) {
			return false;
		}
        return $response->body();
	}

    public static function get_slider($organization)
    {
        $slides = [];
        if ( ! empty( $organization['cover_photo'] ) ) {
            array_push( $slides, $organization['cover_photo']['source_path'] );
        }
        if ( ! empty( $organization['gallery'] ) ) {
            foreach( $organization['gallery'] as $slide ) {
                array_push( $slides, $slide['source_path'] );
            }
        }

        return $slides;
    }

    public static function get_organization_permalink()
    {
        $org_id = get_option( 'crowdfundly_organization_page_id' );
        if ( ! $org_id ) return false;

        return get_permalink( $org_id );
    }

    public function cf_change_theme()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $theme_id = esc_html( $_POST['theme_id'] );

        $token = DBAccessor::getItem('token');
        $org = DBAccessor::getItem('organization');
        $args = [
            'method'    => 'PUT',
            'headers'   => [
                'authorization'     => 'Bearer ' . $token,
                'organization-id'   => $org['id']
            ],
            'body'      => [
                'template_id'   => $theme_id
            ]
        ];
        $res = Request::post( 'organization/template', $args );

        if ( $res->status_code() !== 200 ) {
            $data = [];
            $message = isset( $res->body()['message'] ) ? $res->body()['message'] : $res->message();
            $data['message'] = $message;
            $data['code'] = $res->status_code();
            wp_send_json_error( $data, $res->status_code() );
            wp_die();
        }
        $organization = DBAccessor::get()['organization'];
        $organization['template_id'] = $theme_id;
        DBAccessor::updateItem( 'crowdfundly_settings', 'organization', $organization );

        wp_send_json( $res->body(), 200 );
        wp_die();
    }

    public static function get_org_gateways()
    {
        $token = DBAccessor::getItem('token');
        $org = DBAccessor::getItem('organization');
        $args = [
            'headers'   => [
                'authorization'     => 'Bearer ' . $token,
                'organization-id'   => $org['id']
            ]
        ];
        return Request::get( 'organization/gateways', $args );
    }

    public function cf_update_payment_gateway()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $res = static::get_org_gateways();
        if ( $res->status_code() !== 200 ) {
            $data = [];
            $message = isset( $res->body()['message'] ) ? $res->body()['message'] : $res->message();
            $data['message'] = $message;
            $data['code'] = $res->status_code();
            wp_send_json_error( $data, $res->status_code() );
            wp_die();
        }
        $organization = DBAccessor::getItem('organization');
        $gateways = $res->body();
        $gateway_list = [];
        if ( ! empty( $gateways ) ) {
            foreach ( $gateways as $name => $gateway ) {
                $gateway_list[] = $name;
            }
        }
        $organization['gateways'] = $gateway_list;
        DBAccessor::updateItem( 'crowdfundly_settings', 'organization', $organization );

        wp_send_json( $gateway_list, 200 );
        wp_die();
    }

}
