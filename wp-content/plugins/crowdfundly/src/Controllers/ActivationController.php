<?php

namespace Crowdfundly\App\Controllers;

/**
 * Plugin Activation Controller
 * Provides functionality for plugin activation event.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class ActivationController extends BaseController
{
    public static function activate()
    {
        $self = new self();
        $self->before_redirect();
        $self->create_user_roles();
        static::add_administrator_caps();
		$organization_id = $self->create_organization_page();

		if ( $organization_id ) {
			$self->create_all_campaigns_page( $organization_id );
			$self->create_single_campaign_page( $organization_id );
		}
    }

    protected function before_redirect()
    {
		add_option( 'crowdfundly_activate_redirect', true );
		// add_option( 'crowdfundly_disable_automatice_shortcode_page', false );
	}

    public static function redirect()
    {
		add_action( 'admin_init', function() {
			if ( get_option( 'crowdfundly_activate_redirect', false ) && ! isset( $_GET['activate-multi'] ) ) {
				delete_option( 'crowdfundly_activate_redirect' );
				wp_safe_redirect( admin_url( 'admin.php?page=crowdfundly-admin' ) );
				exit;
			}
		} );
	}

	public function create_organization_page()
	{
		$organization_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_organization_page_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
		) );
		
        if ( empty( $organization_page ) ) {
            $page_id = wp_insert_post( array(
                'post_type'     => 'page',
                'post_title'    => sanitize_text_field( 'Organization' ),
                'post_name'     => sanitize_text_field( 'crowdfundly-organization' ),
                'post_status'   => 'publish',
                'post_content'  => sanitize_textarea_field( '[crowdfundly-organization]' ),
                'page_template' => sanitize_file_name( 'crowdfundly-template.php' )
            ) );
            if ( $page_id ) {
                update_post_meta( $page_id, 'crowdfundly_organization_page_id', 'all' );
                update_option( 'crowdfundly_organization_page_id', $page_id );
            }
            return $page_id;
        }

        return null;
	}

	public function create_all_campaigns_page($organization_page_id)
	{
		$all_campaign_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_all_campaigns_page_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
		) );
		
        if ( empty( $all_campaign_page ) ) {
            $page_id = wp_insert_post( array(
                'post_type'         => 'page',
                'post_title'        => sanitize_text_field('All Campaigns'),
                'post_status'       => 'publish',
                'post_name'         => sanitize_text_field('crowdfundly-all-campaigns'),
                'post_content'      => sanitize_textarea_field('[crowdfundly-all-campaigns]'),
                'page_template'     => sanitize_file_name('crowdfundly-template.php'),
                'post_parent'       => $organization_page_id,
            ) );
            if ( $page_id ) {
                update_post_meta($page_id,'crowdfundly_all_campaigns_page_id', 'all');
				update_option( 'crowdfundly_all_campaigns_page_id', $page_id );
            }
        }
	}
 
	public function create_single_campaign_page($organization_page_id)
    {
        $single_campaign_page = get_posts( array(
            'post_type'      => 'page',
            'posts_per_page' => - 1,
            'meta_query'     => array(
                array(
                    'key'     => 'crowdfundly_single_campaign_page_id',
                    'value'   => 'all',
                    'compare' => '='
                ),
            ),
        ) );

        if ( empty( $single_campaign_page ) ) {
            $page_id = wp_insert_post( array(
                'post_type'         => 'page',
                'post_title'        => sanitize_text_field('Single Campaign'),
                'post_status'       => 'publish',
                'post_name'         => sanitize_text_field('crowdfundly-single-campaign'),
                'post_content'      => sanitize_textarea_field('[crowdfundly-campaign]'),
                'page_template'     => sanitize_file_name('crowdfundly-template.php'),
                'post_parent'       => $organization_page_id
            ) );
            if ( $page_id ) {
                update_post_meta($page_id,'crowdfundly_single_campaign_page_id', 'all');
				update_option( 'crowdfundly_single_campaign_page_id', $page_id );
            }
        }
	}

    /**
     * Create cf user Roles
     *
     * @return void
     */
    public function create_user_roles()
    {
        // for new version release, 
        // where new capabilities are added for cf user roles
        if ( get_role( 'crowdfundly_manager' ) ) {
            remove_role('crowdfundly_manager');
        } else if ( get_role( 'crowdfundly_admin' ) ) {
            remove_role('crowdfundly_admin');
        }

        $cf_roles = TeamController::cf_roles();
        foreach ( $cf_roles as $key => $role ) {
            add_role( $key, $role['name'], $role['capabilities'] );
        }
    }

    public static function add_administrator_caps()
    {
        $cf_roles = TeamController::cf_roles();
        $cf_admin_caps = $cf_roles['crowdfundly_admin']['capabilities'];

        foreach ( $cf_admin_caps as $key => $cap ) {
            TeamController::add_cap( 'administrator', $key );
        }
    }
}
