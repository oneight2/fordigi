<?php
/**
 * Plugin Name: WpDevArt Organization Chart
 * Plugin URI: https://wpdevart.com/wordpress-organization-chart-plugin
 * Author URI: https://wpdevart.com
 * Description: WpDevArt Organization Chart plugin is a nice tool for creating a beautiful organizational chart tree. Use this plugin and create different charts just in a few minutes.
 * Version: 1.4.3
 * Author: wpdevart
 * License: GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('ABSPATH') || exit;

class wpda_org_chart {

	private $version = 2;

	function __construct() {
		$this->version = get_option('wpda_org_chart_version', 1);
		// def constants for charts
		$this->define_constants();
		// include files 
		$this->include_files();
		$this->database = new wpda_org_chart_database();
		$this->call_base_filters();
		$this->create_admin();
		$this->front_end();
	}

	/*############ Function for creating the admin page ##################*/	
	
	private function create_admin() {
		$this->admin = new wpda_org_chart_admin_main();
	}

	/*############ Function for creating the front-end page ##################*/	
	
	public function front_end() {
		$this->front = new wpdevart_org_chart_front();
	}

	/*############ Function for calling base filters ##################*/		
	
	private function call_base_filters() {
		register_activation_hook(__FILE__, array($this, 'install_database'));
		add_action('init',  array($this, 'register_required_scripts'));
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_activate_sub_link'));
		if($this->version == 1){
			$this->update_database();
		}
	}

	/*############ Function for plugin URL and Path ##################*/		
	
	private function define_constants() {
		define('wpda_org_chart_plugin_url', trailingslashit(plugins_url('', __FILE__)));
		define('wpda_org_chart_plugin_path', trailingslashit(plugin_dir_path(__FILE__)));
		define('wpda_org_chart_support_url', "https://wordpress.org/support/plugin/organization-chart/");
		define('wpda_org_chart_responsive_sizes', array("tablet" => '1000', 'mobile' => '450'));
	}

	/*############ Function for registering the required scripts ##################*/
	
	public function register_required_scripts() {
		wp_register_style('wpda_chart_gutenberg_css', wpda_org_chart_plugin_url . 'admin/gutenberg/style.css');
		wp_register_script('wpda_chart_gutenberg_js', wpda_org_chart_plugin_url . 'admin/gutenberg/block.js', array('wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'underscore'));
		wp_register_script('alpha-color-picker', wpda_org_chart_plugin_url . 'admin/assets/js/alpha-color-picker.js', array('wp-color-picker'));
	}

	/*############ Function for including the files ##################*/
	
	private function include_files() {
		require_once(wpda_org_chart_plugin_path . 'library/user_library.php');
		require_once(wpda_org_chart_plugin_path . 'library/wpdevart_admin_library.php');
		require_once(wpda_org_chart_plugin_path . 'admin/admin.php');
		require_once(wpda_org_chart_plugin_path . 'database/database.php');
		require_once(wpda_org_chart_plugin_path . 'front/front.php');
	}

	public function install_database() {
		// new class for installing database
		$this->database->install_org_chart_tree_table();
		$this->database->install_org_chart_tree_theme_table();
		$this->database->install_org_chart_tree_popup_table();
		$this->database->insert_to_theme_default_values();
		$this->database->insert_to_popup_theme_default_values();
		$this->database->insert_to_chart_default_values();
		$this->database->update_urls();
		update_option('wpda_org_chart_version', 2);
	}

	public function update_database(){
		$this->database->install_org_chart_tree_popup_table();
		$this->database->insert_to_popup_theme_default_values();
		$this->database->update_urls();
		update_option('wpda_org_chart_version', 2);
	}

	public function plugin_activate_sub_link($links) {
		$plugin_submenu_added_link = array();
		$added_link = array('<a target="_blank" style="color: #7052fb; font-weight: bold; font-size: 13px;" href="https://wpdevart.com/wordpress-organization-chart-plugin/">Upgrade to Pro</a>');
		$plugin_submenu_added_link = array_merge($plugin_submenu_added_link, $added_link);
		$plugin_submenu_added_link = array_merge($plugin_submenu_added_link, $links);
		return $plugin_submenu_added_link;
	}
}
$wpda_org_chart = new wpda_org_chart();
