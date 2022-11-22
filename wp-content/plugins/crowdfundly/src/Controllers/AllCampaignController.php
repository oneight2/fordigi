<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Request;

/**
 * Campaigns Controller
 * Provides functionality for the all campaign page.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class AllCampaignController extends BaseController
{

    public function register()
    {
        cf_wp_ajax( 'cf_all_campaign_load_more', [ $this, 'cf_all_campaign_load_more' ], true );
    }

    public function renderView()
    {
        if ( ! DBAccessor::is_login() ) return;

        $data = [];
        $data['campaign'] = $this->get_all_campaigns();
        if ( ! $data['campaign'] ) return;

        $data['org_settings'] = (new SingleCampaignController)->get_organization_settings();
        return $this->render( 'public/all-campaign.php', $data, true );
    }

    public static function get_all_campaigns($params = [])
    {
        $org = DBAccessor::getItem( 'organization' );
        if ( ! $org ) return false;

        $body_param = [
            'organization' => $org['id'],
            'limit' => 6,
            'status' => 'published'
        ];
        if ( isset( $_GET['search'] ) ) $body_param['q'] = esc_html( $_GET['search'] );
        if ( isset( $_GET['type'] ) ) $body_param[esc_html( $_GET['type'] )] = true;

        $body_param = array_merge( $body_param, $params );
        
        $route = 'campaign';
        $response = Request::get( $route,
            [
                'timeout' => 15,
                'body' => $body_param
            ]
        );
        if ( $response->status_code() != 200 ) return false;

        return $response->body();
    }

    public static function get_all_campaigns_permalink()
    {
		$page_id = get_option( 'crowdfundly_all_campaigns_page_id', null );
		if ( ! $page_id ) return;

		return get_page_link( $page_id );
	}

    public function cf_all_campaign_load_more()
    {
        $security = check_ajax_referer( 'crowdfundly_public_nonce', 'security' );
        if ( false == $security ) return;

        $column = esc_html( $_POST['grid_column'] );
        $per_page = esc_html( $_POST['per_page'] );
        $current_page = esc_html( $_POST['current_page'] );
        $org_settings = esc_html( $_POST['org_settings'] );
        $total_cam = esc_html( $_POST['total_cam'] );
        $published = 'published';

        $organization = DBAccessor::getItem( 'organization' );
        $route = 'campaign';
        $body_param = ['body' => []];
        $body_param['body']['organization'] = $organization['id'];
        $body_param['body']['limit'] = $per_page;
        $body_param['body']['page'] = $current_page;
        $body_param['body']['total'] = $total_cam;
        $body_param['body']['status'] = $published;
        $response = Request::get( $route, $body_param );

        if ( $response->status_code() != 200 ) {
            echo wp_send_json_error( $response->message(), $response->status_code() );
            wp_die();
        }
        $res_body = $response->body();
        if ( empty( $res_body['data'] ) ) return false;

        ob_start();
        return cf_loadViewTemplate(
            'public/all-campaigns/camp-loadmore.php',
            [
                'campaigns'     => $res_body['data'],
                'column'        => $column,
                'org_settings'  => $org_settings 
            ]
        );
        return ob_get_clean();
        wp_die();
    }

}
