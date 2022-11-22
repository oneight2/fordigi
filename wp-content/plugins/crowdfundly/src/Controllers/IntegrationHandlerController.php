<?php
namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;

/**
 * Integration handlers Controller
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.1.0
 */
class IntegrationHandlerController extends BaseController
{
    public static function fcrm_create_contact($data)
    {
        if ( ! defined( 'FLUENTCRM' ) ) {
            return __( 'FluentCRM is not installed', 'crowdfundly' );
        }

        // fluent crm create contact
        $integration = DBAccessor::getItem( 'integration_handlers', 'crowdfundly_integration' );
        $list_ids = [];
        $tag_ids = [];
        if ( $integration['fcrm_contact'] && ! empty( $integration['fcrm_contact']['list'] ) ) {
            foreach ( $integration['fcrm_contact']['list'] as $list ) {
                array_push( $list_ids, $list['id'] );
            }
        }
        if ( $integration['fcrm_contact'] && ! empty( $integration['fcrm_contact']['tag'] ) ) {
            foreach ( $integration['fcrm_contact']['list'] as $tag ) {
                array_push( $tag_ids, $tag['id'] );
            }
        }

        $contactApi = FluentCrmApi('contacts');
        // $data = [
        //     'first_name' => 'Jhon',
        //     'last_name' => 'Doe',
        //     'email' => 'jhon@doe.com', // requied
            // 'status' => 'pending',
            // 'tags' => [1,2,3],
            // 'lists' => [4]
        // ];
        $data['email'] = isset( $data['user_email'] ) ? esc_html( $data['user_email'] ) : '';
        $data['first_name'] = isset( $data['user_name'] ) ? esc_html( $data['user_name'] ) : '';
        $data['lists'] = $list_ids;
        $data['tags'] = $tag_ids;

        $contact = $contactApi->createOrUpdate($data);
        return $contact;
    }

    public static function create_wp_user($data)
    {
        $name = isset( $data['user_name'] ) && ! empty( $data['user_name'] ) ? esc_html( $data['user_name'] ) : 'crowdfundly_' . time();
        $password = isset( $data['password'] ) ? $data['password'] : bin2hex( openssl_random_pseudo_bytes( 8 ) );
        $email = isset( $data['user_email'] ) ? esc_html( $data['user_email'] ) : '';
        $user_id = \wp_create_user( $name, $password, $email );
        
        if ( is_wp_error( $user_id ) ) {
            return $user_id->get_error_message();
        }

        return __( 'User created', 'crowdfundly' );
    }

    public static function get_fcrm_data()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $type = isset( $_GET['data_type'] ) ? esc_html( $_GET['data_type'] ) : false;

        $data = [];
        if ( $type == 'list' ) {
            $data = static::get_fcrm_lists();
        } elseif ( $type == 'tag' ) {
            $data = static::get_fcrm_tags();
        }

        wp_send_json( $data, 200 );
        wp_die();
    }

    public static function get_fcrm_lists()
    {
        if ( ! defined( 'FLUENTCRM' ) ) return false;

        $contactApi = FluentCrmApi('lists');
        if ( ! $contactApi || empty( $contactApi->all() ) ) return false;

        $lists = [];
        foreach ( $contactApi->all() as $list ) {
            $lists['crm'][] = ['id' => $list->id, 'name' => $list->title];
        }
        $integration_handlers = DBAccessor::getItem( 'integration_handlers', 'crowdfundly_integration' );
        if ( $integration_handlers['fcrm_contact'] && ! empty( $integration_handlers['fcrm_contact']['list'] ) ) {
            $lists['default'] = $integration_handlers['fcrm_contact']['list'];
        }
        return $lists;
    }

    public static function get_fcrm_tags()
    {
        if ( ! defined( 'FLUENTCRM' ) ) return false;

        $contactApi = FluentCrmApi('tags');
        if ( ! $contactApi || empty( $contactApi->all() ) ) return false;

        $tags = [];
        foreach ( $contactApi->all() as $tag ) {
            $tags['crm'][] = ['id' => $tag->id, 'name' => $tag->title];
        }
        $integration_handlers = DBAccessor::getItem( 'integration_handlers', 'crowdfundly_integration' );
        if ( $integration_handlers['fcrm_contact'] && ! empty( $integration_handlers['fcrm_contact']['tag'] ) ) {
            $tags['default'] = $integration_handlers['fcrm_contact']['tag'];
        }
        return $tags;
    }
}
