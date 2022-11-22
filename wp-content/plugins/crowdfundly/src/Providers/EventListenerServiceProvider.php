<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Controllers\ActivationController;
use Crowdfundly\App\Controllers\DeactivationController;
use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Event Listener Service Provider.
 * Does somethings when an event occers.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class EventListenerServiceProvider implements Provider
{
    use Singleton; 

    public function register()
    {
        // activation event listener
        register_activation_hook(
            CROWDFUNDLY_FILE,
            [ ActivationController::class, 'activate' ]
        );
        ActivationController::redirect();   // redirect to the dashboard after activation

        // deactivation event listener
        register_deactivation_hook(
            CROWDFUNDLY_FILE,
            [ DeactivationController::class, 'deactivate' ]
        );

        // change organization page title if user is logged in.
        OrganizationController::change_organization_title();

        // change public pages permalink according to the organization name
        add_action( 'init', [ $this, 'change_permalink' ] );

        // load text domain
        add_action( 'plugins_loaded', function() {
            load_plugin_textdomain( 'crowdfundly', false, CROWDFUNDLY_DIR_PATH . 'languages' );
        } );

        // plugin update from 1.x to 2.x compatibility flug
        add_action( 'upgrader_process_complete', [ $this, 'update_plugin' ], 10, 2 );

        $current_page = isset( $_GET['page'] ) ? esc_html( $_GET['page'] ) : null;
        if ( cf_is_dashboard( $current_page ) ) {
            // modify admin footer in crowdfundly dashboard
            $this->modify_admin_footer();
        }
    }

    public function change_permalink()
    {
        $is_url_changed = get_option( 'crowdfundly_url_update' );
        if ( $is_url_changed ) return;
        
        $page_ids = [];
        $page_ids['organization'] = get_option( 'crowdfundly_organization_page_id' );
        $page_ids['all-campaigns'] = get_option( 'crowdfundly_all_campaigns_page_id' );
        $page_ids['single-campaign'] = get_option( 'crowdfundly_single_campaign_page_id' );

        $org = DBAccessor::getItem( 'organization' );

        foreach ( $page_ids as $name => $id ) {
            if ( ! isset( $org['username'] ) ) {
                $name = 'crowdfundly-' . $name;
            }

            if ( $name === 'crowdfundly-organization' ) {
                \wp_update_post(
                    [ 'ID' => $id, 'post_name' => $name ],
                    true
                );
            } elseif ( $name === 'organization' ) {
                \wp_update_post(
                    [ 'ID' => $id, 'post_name' => $org['username'] ],
                    true
                );
            } else {
                \wp_update_post(
                    [ 'ID' => $id, 'post_name' => $name ],
                    true
                );
            }
        }

        update_option( 'crowdfundly_url_update', true );
    }

    /**
     * Add a flag in DB,
     * so that backend run compatibilities for new plugin version.
     *
     * @param  \WP_Upgrader $upgrader
     * @param  array  $options
     * @return void
     */
    public function update_plugin(\WP_Upgrader $upgrader, $options)
    {
        if (
            is_array( $options ) &&
            $options['action'] == 'update' &&
            $options['type'] == 'plugin' &&
            isset( $options['plugins'] )
        ) {
            foreach ( $options['plugins'] as $plugin ) {
                if ( $plugin == plugin_basename( CROWDFUNDLY_FILE ) ) {
                    update_option( 'crowdfundly_update_v208', 1 );    // adding flug for 2.0.8
                    break;
                }
            }
        }
    }

    /**
     * Modify admin footer in crowdfundly dashboard.
     *
     * @return void
     */
    private function modify_admin_footer()
    {
        add_filter( 'update_footer', function($data) {
            return sprintf( "<p class='alignright'><a href='%s' target='_blank'><strong>%s</strong></a> %s</p>",
                esc_url( CROWDFUNDLY_URL ),
                'Crowdfundly',
                CROWDFUNDLY_VERSION
             );
        }, 999 );
    }

}
