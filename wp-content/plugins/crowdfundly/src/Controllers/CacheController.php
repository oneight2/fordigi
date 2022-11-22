<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Request;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Cache api response
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class CacheController extends BaseController
{
    use Singleton;

    public function register()
    {
        add_action( 'admin_menu', [ $this, 'cache_sync' ] );
    }

    public function cache_sync()
    {
        // checking crowdfundly dashboard
        // if ( ! isset( $_GET['page'] ) ) return;
        // if ( ! cf_is_dashboard( $_GET['page'] ) ) {
        //     return;
        // }
        // checking crowdfundly user login
        // if ( ! DBAccessor::get() ) return;

        // sync cache time is not expired
        $is_sync = get_transient( 'crowdfundly_api_sync' );
        if ( $is_sync ) return;

        $this->api_sync();
    }

    private function api_sync()
    {
        $wp_meta = esc_html( get_bloginfo( 'version' ) ) . ";" . esc_url( get_bloginfo( 'url' ) );
        $org = DBAccessor::getItem( 'organization' );
        $org_id = isset( $org['id'] ) ? $org['id'] : '';
        $response = Request::post(
            'wp/sync',
            [
                'content-type'  => 'application/json',
                'Accept'        => 'application/json',
                'headers' => [
                    'Authorization' => 'Bearer ' . DBAccessor::getItem( 'token' ),
                ],
                'body' => [
                    'meta'  => [
                        'X-Requested-With'  => 'XMLHttpRequest',
                        'X-Plugin-Version'  => CROWDFUNDLY_VERSION,
                        'X-Wp-Meta'         => "WordPress;" . $wp_meta,
                        'X-Php-Version'     => phpversion(),
                        'X-Server-Os'       => php_uname('s'),
                        'X-Org-Id'          => $org_id,
                    ],
                    'wp_plugins' => $this->get_plugins_list()
                ]
            ]
        );

        // sync successful, add cache
        set_transient( 'crowdfundly_api_sync', true, 2 * HOUR_IN_SECONDS );
    }

    public function get_plugins_list()
    {
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if ( ! function_exists( 'get_plugins' ) ) {
            return get_option( 'active_plugins' );
        }

        $plugins = get_plugins();
        $plugins_list = [];
        foreach ( $plugins as $plugin_path => $plugin ) {
            $data = [];
            foreach ( $plugin as $key => $pl ) {
                if (
                    $key == 'Name'
                    || $key == 'PluginURI'
                    || $key == 'Version'
                    || $key == 'Author'
                    || $key == 'AuthorURI'
                ) {
                    $data[$key] = $pl;
                }
            }
            $plugins_list[] = $data;
        }
        return $plugins_list;
    }
}
