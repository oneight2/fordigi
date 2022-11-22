<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\SingleCampaignController;
use Crowdfundly\App\Controllers\TeamController;
use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Assets Service Provider.
 * it registers all assets of the plugin.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class AssetServiceProvider implements Provider
{
    use Singleton;

    private $current_page;

    public function register()
    {
        $this->current_page = isset( $_GET['page'] ) ? esc_html( $_GET['page'] ) : null;
        add_action( 'admin_enqueue_scripts', [$this, 'admin_scripts'] );
        add_action( 'wp_enqueue_scripts', [$this, 'public_scripts'] );
    }

    public function admin_scripts()
    {
        wp_enqueue_style(
            cf_prefix( '-dashboard-global-css' ),
            cf_asset( 'admin/css/admin-global.css' ),
            [],
            CROWDFUNDLY_VERSION,
            'all'
        );
        wp_enqueue_script(
            cf_prefix( '-global-js' ),
            cf_asset( 'admin/js/admin-global.js' ),
            [],
            CROWDFUNDLY_VERSION,
            false
        );
        wp_localize_script(
            cf_prefix( '-global-js' ),
            'crowdfundlyAuthGlobal',
            [
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'nonce'     => wp_create_nonce( 'crowdfundly_admin_global_nonce' ),
            ]
        );

        if ( cf_is_dashboard( $this->current_page ) ) {
            wp_enqueue_style(
                cf_prefix( '-dashboard-main-css' ),
                cf_asset( 'admin/css/main.css' ),
                [],
                CROWDFUNDLY_VERSION,
                'all'
            );
            // wp_enqueue_style(
            //     cf_prefix( '-crowdfundly-ui-css' ),
            //     cf_url( 'crowdfundly-ui/dist/crowdfundly-ui.css' ),
            //     [],
            //     CROWDFUNDLY_VERSION,
            //     'all'
            // );

            wp_enqueue_script(
                cf_prefix( '-dashboard-js' ),
                cf_asset( 'admin/js/index.js' ),
                [ 'wp-i18n' ],
                CROWDFUNDLY_VERSION,
                false
            );

            $this->admin_api();
            // $this->modify_admin_footer();
        }
    }

    public function admin_api()
    {
        wp_localize_script(
            cf_prefix( '-dashboard-js' ),
            'crowdfundlyAuth',
            [
                'wp_version'            => esc_html( get_bloginfo('version') ),
                'wp_site_url'           => esc_url( get_bloginfo('url') ),
                'plugin_version'        => CROWDFUNDLY_VERSION,
                'php_version'           => phpversion(),
                'server_os'             => php_uname('s'),
                'ajax_url'              => admin_url( 'admin-ajax.php' ),
                'nonce'                 => wp_create_nonce( 'crowdfundly_admin_nonce' ),
                'assets_path'           => cf_asset( '' ),
                'is_login'              => DBAccessor::is_login(),
                'bearer_token'          => DBAccessor::getItem('token'),
                'organization'          => DBAccessor::getItem('organization'),
                'token_ttl'             => DBAccessor::getItem('login_session'),
                'cf_admin_url'          => admin_url( 'admin.php?page=' . $this->current_page ),
                'imagePath'             => cf_asset( 'images/admin' ),
                'user'                  => DBAccessor::getItem('user'),
                'organization_url'      => OrganizationController::get_organization_permalink(),
                'campaign_base_url'     => SingleCampaignController::get_camp_base_url(),
                'connected'             => __( 'Connected', 'crowdfundly' ),
                'connecting'            => __( 'Connecting...', 'crowdfundly' ),
                'success_connected'     => __( 'Successfully connected', 'crowdfundly' ),
                'success_login'         => __( 'Successfully Login', 'crowdfundly' ),
                'success'               => __( 'Success', 'crowdfundly' ),
                'failed'                => __( 'Failed', 'crowdfundly' ),
                'log_out'               => __( 'Log Out', 'crowdfundly' ),
                'temp_login'            => DBAccessor::getItem('temp_login'),
                'team'                  => [
                    'table_head'    => [
                        'name'      => __( 'Name', 'crowdfundly' ),
                        'role'      => __( 'Role', 'crowdfundly' ),
                        'action'    => __( 'Actions', 'crowdfundly' ),
                    ],
                ],
                'capabilities'          => [
                    'logout' => TeamController::has_cap( 'crowdfundly_logout' ),
                    'create_campaign' => TeamController::has_cap( 'crowdfundly_create_campaign' ),
                ],
            ]
        );
    }

    public function public_scripts()
    {
        wp_enqueue_style(
            cf_prefix('-bootstrap'),
            cf_asset('public/vendors/bootstrap/css/bootstrap.min.css'),
            [],
            CROWDFUNDLY_VERSION
        );
		wp_enqueue_style(
            cf_prefix('-fontawesome'), 
            '//pro.fontawesome.com/releases/v5.10.0/css/all.css',
            [],
            CROWDFUNDLY_VERSION
        );
		wp_enqueue_style( 
            cf_prefix('-slick'), 
            cf_asset('public/vendors/slick-dist/slick/slick.css'),
            [],
            CROWDFUNDLY_VERSION
        );
		wp_enqueue_style(
            cf_prefix('-slick-theme'),
            cf_asset('public/vendors/slick-dist/slick/slick-theme.css'),
            [],
            CROWDFUNDLY_VERSION
        );
        wp_enqueue_style(
            cf_prefix('-select2'),
            cf_asset('public/vendors/select2/build/css/select2.min.css'),
            [],
            CROWDFUNDLY_VERSION
        );
        // main css
        wp_enqueue_style(
            cf_prefix( '-public-css' ),
            cf_asset( 'public/css/crowdfundly-public.css' ),
            [],
            CROWDFUNDLY_VERSION
        );

        wp_enqueue_script(
            cf_prefix( '-bootstrap-js' ),
            cf_asset( 'public/vendors/bootstrap/js/bootstrap.min.js' ),
            array( 'jquery' ),
            CROWDFUNDLY_VERSION,
            true
        ); 
        wp_enqueue_script(
            cf_prefix( '-slick-js' ),
            cf_asset( 'public/vendors/slick-dist/slick/slick.min.js' ),
            array( 'jquery' ),
            CROWDFUNDLY_VERSION,
            true
        );
        wp_enqueue_script(
            cf_prefix( '-sharer-js' ),
            cf_asset( 'public/vendors/sharerJS/sharer.min.js' ),
            array( 'jquery' ),
            CROWDFUNDLY_VERSION,
            true
        );
        wp_enqueue_script(
            cf_prefix( '-swal' ),
            cf_asset( 'public/vendors/sweetalert/sweetalert.min.js' ),
            array('jquery'),
            CROWDFUNDLY_VERSION,
            true
        );
        wp_enqueue_script(
            cf_prefix( '-select2' ),
            cf_asset( 'public/vendors/select2/build/js/select2.min.js' ),
            array('jquery'),
            CROWDFUNDLY_VERSION,
            true
        );

        // stripe
        wp_enqueue_script(
            cf_prefix( '-stripe-js' ),
            '//js.stripe.com/v3/',
            array(),
            CROWDFUNDLY_VERSION,
            true
        );
        // Razorpay
        wp_enqueue_script(
            cf_prefix( '-checkout-js' ),
            '//checkout.razorpay.com/v1/checkout.js',
            array(),
            CROWDFUNDLY_VERSION,
            true
        );
        // main js
        wp_enqueue_script(
            cf_prefix( '-public-js' ),
            cf_asset( 'public/js/public.min.js' ),
            array( 'jquery', cf_prefix('-slick-js'), cf_prefix('-stripe-js') ),
            CROWDFUNDLY_VERSION,
            true
        );

        $this->public_api();
    }

    public function public_api()
    {
        wp_localize_script( cf_prefix('-public-js'), 'crowdfundlyPublicData',
            [
                'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
                'nonce' 		=> wp_create_nonce( 'crowdfundly_public_nonce' ),
                'cf_api_url'    => CROWDFUNDLY_API . 'api/v1/',
                'failed'        => __( 'Failed', 'crowdfundly' ),
                'help_text'             => __( 'Please try again', 'crowdfundly' ),
                'contribution_thanks'   => __( 'Thanks, for your contribution', 'crowdfundly' ),
                'success'               => __( 'Success', 'crowdfundly' ),
                'loading'               => __( 'Loading...', 'crowdfundly' ),
                'activities'            => __( 'Activities', 'crowdfundly' ),
                'load_more'             => __( 'Load More', 'crowdfundly' ),
                'contribute_now'        => __( 'Contribute Now', 'crowdfundly' ),
            ]
        );
    }

}
