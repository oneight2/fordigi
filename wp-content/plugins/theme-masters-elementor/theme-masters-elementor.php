<?php
/**
 * Plugin Name: TM Elementor Addons
 * Plugin URI: https://www.thememasters.club/wordpress/premium-elementor-addons/
 * Description: Premium Addons for Elementor Page Builder
 * Version: 3.4.1
 * Author: Theme Masters
 * Author URI: http://codecanyon.net/user/egemenerd
 * License: http://codecanyon.net/licenses
 * Text Domain: theme-masters-elementor
 * Domain Path: /languages/
 *
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'TMEA_PLUGIN_FILE' ) ) {
	define( 'TMEA_PLUGIN_FILE', __FILE__ );
	define( 'TMEA_PLUGIN_NAME', "TM Elementor Addons" );
}

// Include the main TMEA class.
if ( ! class_exists( 'TMEA', false ) ) {
	include_once('class-tmea.php');
}

/**
 * Returns the main instance of TMEA.
 *
 * @since 1.0
 * @return TMEA
 */
function TMEA() {  
	return TMEA::instance();
}

// Global for backwards compatibility.
$GLOBALS['TMEA'] = TMEA(); 