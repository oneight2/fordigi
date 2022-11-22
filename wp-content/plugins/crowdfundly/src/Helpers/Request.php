<?php

namespace Crowdfundly\App\Helpers;

/**
 * Helper class for HTTP requests
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class Request
{
    private static $base_url = CROWDFUNDLY_API;
    private static $namespace = 'api/';
    private static $version = 'v1/';

    /**
     * Create API URL with Base URL, Namespace, Version and Route
     *
     * @param string $route
     * @return string
     */
    private static function get_url( $route )
    {
        return static::$base_url . static::$namespace . static::$version . $route;
    }

    /**
     * POST request
     * 
     * @param (string) $route
     * @param (array) $args
     * @return \Crowdfundly\App\Helpers\Response
     */
    public static function post($route, $args = [])
    {
        $arguments = static::set_arguments($args);
        $url = static::get_url( $route );

        $res = wp_remote_post( $url, $arguments );
        return new Response( $res );
    }

    /**
     * GET request
     * 
     * @param (string) $route
     * @param (array) $args
     * @return \Crowdfundly\App\Helpers\Response
     */
    public static function get($route, $args = [])
    {
        $arguments = static::set_arguments($args);

        $url = static::get_url( $route );

        $res = wp_remote_get( $url, $arguments );
        return new Response($res);
    }

    private static function set_arguments($args)
    {
        $wp_meta = esc_html( get_bloginfo('version') ) . ";" . esc_url( get_bloginfo('url') );
        $org = DBAccessor::getItem( 'organization' );
        $org_id = isset( $org['id'] ) ? $org['id'] : '';
        $default = [
            'headers' => [
                'X-Requested-With'  => 'XMLHttpRequest',
                'X-Plugin-Version'  => CROWDFUNDLY_VERSION,
                'X-Wp-Meta'         => "WordPress;" . $wp_meta,
                'X-Php-Version'     => phpversion(),
                'X-Server-Os'       => php_uname('s'),
                'X-Org-Id'          => $org_id,
            ],
        ];
        $headers = isset( $args['headers'] ) ? $args['headers'] : [];
        $args['headers'] = array_merge( $default['headers'], $headers );
        $args['timeout'] = isset( $args['timeout'] ) ? $args['timeout'] : 15;
        return $args;
    }

}
