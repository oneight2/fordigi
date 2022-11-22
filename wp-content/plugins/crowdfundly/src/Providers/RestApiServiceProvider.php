<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Controllers\IntegrationController;
use Crowdfundly\App\Helpers\Request;
use Crowdfundly\App\Providers\Provider;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Main Service Provider that registers rest api.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.8
 */
class RestApiServiceProvider implements Provider
{
    use Singleton;

    private static $namespace = 'crowdfundly';
    private static $version = '/v1';

    public function register()
    {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    /**
     * All rest api routes are listed here.
     *
     * @return array
     */
    private function route_list()
    {
        return [
            'webhook' => [
                'callback'      => [ (new IntegrationController), 'integration_api_callback' ],
                'methods'       => 'POST',
                'allow_route'   => [ IntegrationController::class, 'allow_route' ],
            ],
        ];
    }

    /**
     * Register all the rest api.
     *
     * @return void
     */
    public function register_routes()
    {
        foreach ( $this->route_list() as $route => $data ) {
            if ( isset( $data['allow_route'] ) ) {
                $is_allowed = call_user_func( $data['allow_route'] );
                if ( ! $is_allowed ) continue;

                unset( $data['allow_route'] );
                register_rest_route(
                    static::$namespace . static::$version,
                    "/" . $route,
                    $data
                );
                continue;
            }
            register_rest_route(
                static::$namespace . static::$version,
                "/" . $route,
                $data
            );
        }
    }

    public static function get_route($route_name)
    {
        $router_list = RestApiServiceProvider::getInstance()->route_list();
        if ( ! isset( $router_list[$route_name] ) ) {
            return false;
        }
        $base_url = get_bloginfo('url') . "/wp-json/" . static::$namespace . static::$version;
        return esc_url( $base_url . '/' . $route_name );
    }
}
