<?php
/**
 * Utility functions for the Crowdfundly plugin.
 * 
 * @package crowdfundly
 */


if ( ! function_exists( 'cf_view' ) ) {
     /**
     * Load Controller view method
     * 
     * @param  string $controller - Controller name
     * @param  string $method - Controller method
     * 
     * @package crowdfundly
     * @author  Nazmul
     * @since   2.0.0
     */
    function cf_view($controller, $method = false)
    {
        if ( is_callable( $controller ) ) {
            return $controller;
        }
        if ( class_exists( $controller) ) {
            $controller = new $controller;
        }
        if ( ! $method ) {
            $method = '__invoke';
        }

        return [$controller, $method];
    }
}

if ( ! function_exists( 'cf_url' ) ) {
    /**
     * Create a URL for the given path.
     * 
     * @param  string $path
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_url($path)
    {
        return CROWDFUNDLY_PLUGIN_URL . "$path";
    }
}

if ( ! function_exists( 'cf_asset' ) ) {
    /**
     * Create a assets URL for the given path.
     * 
     * @param  string $path
     * 
     * @package crowdfundly
     * @author  Nazmul
     * @since   2.0.0
     */
    function cf_asset($path)
    {
        return cf_url( "assets/$path" );
    }
}

if ( ! function_exists( 'cf_prefix' ) ) {
    /**
     * Add prefix for the given string.
     * 
     * @param  string $name
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_prefix($name)
    {
        return CROWDFUNDLY . $name;
    }
}

if ( ! function_exists( 'cf_wp_ajax' ) ) {
    /**
     * Wrapper function for wp_ajax_* and wp_ajax_nopriv_*
     * 
     * @param  string $action - action name
     * @param string $method - callback method name
     * @param bool $public - is this a public ajax action
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_wp_ajax($action, $callback, $public = false)
    {
        add_action( 'wp_ajax_' . $action, $callback );
        if ( $public ) {
            add_action( 'wp_ajax_nopriv_' . $action, $callback );
        }
    }
}

if ( ! function_exists( 'cf_loadViewTemplate' ) ) {
    /**
     * Require a View file.
     * 
     * @param  string $file_path
     * @param array $data
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_loadViewTemplate($file_path, $data = [])
    {
        return cf_loadTemplate("resources/views/" . $file_path, $data);
    }
}

if ( ! function_exists( 'cf_loadTemplate' ) ) {
    /**
     * Require a Template file.
     * 
     * @param  string $file_path
     * @param array $data
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_loadTemplate($file_path, $data = [])
    {
        $file = CROWDFUNDLY_DIR_PATH . "src/" . $file_path;
        if ( ! file_exists( $file ) ) {
            throw new \Exception("File not found");
        }
        return require_once $file;
    }
}

if ( ! function_exists( 'cf_dashboard_route' ) ) {
    /**
     * Redirect to a given URL.
     * 
     * @param  string $route
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_dashboard_route($route)
    {
        return esc_url( admin_url( "admin.php?page={$route}" ) );
    }
}

if ( ! function_exists( 'cf_is_dashboard' ) ) {
    /**
     * Redirect to a given URL.
     * 
     * @param  string $route
     * 
     * @package crowdfundly
     * @author  Keramot UL Islam <sourav926>
     * @since   2.0.0
     */
    function cf_is_dashboard($page)
    {
        if ( ! $page ) return null;
		return strpos( $page, 'crowdfundly' ) === 0;
    }
}
