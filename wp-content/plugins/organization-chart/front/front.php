<?php
class wpdevart_org_chart_front {
	private static $unique_prefix = 0;

	private $tree;
	
	function __construct() {
		$this->call_filters();
	}
	private function call_filters() {
		$this->include_files();
		add_filter('wp_head', array($this, 'include_scripts'), 99);
		add_filter('wp_footer', array($this, 'include_scripts'), 99);
		add_shortcode('wpda_org_chart', array($this, 'shortcode'));
	}
	
	/*############ Function for including the scripts ##################*/	
	
	public function include_scripts() {
		wp_enqueue_style('wpda_org_chart_front_css', wpda_org_chart_plugin_url . 'front/css/front_css.css', array(), '10.0');
		wp_enqueue_style('wpda_org_chart_front_popup_effects', wpda_org_chart_plugin_url . 'front/css/popup_effects.css', array(), '10.0');
		wp_enqueue_script('wpda_org_chart_front_js', wpda_org_chart_plugin_url . 'front/js/front_js.js', array(), '10.0');
		wp_register_script('wpda_org_chart_front_popup_js', wpda_org_chart_plugin_url . 'front/js/front_popup.js', array(), '10.0');
		wp_enqueue_script('wpda_org_chart_front_popup_js');
		wp_localize_script('wpda_org_chart_front_popup_js', 'wpda_org_chart_responsive_sizes', wpda_org_chart_responsive_sizes);
	}

	/*############ Function for including the files ##################*/		
	
	private function include_files() {
		require_once(wpda_org_chart_plugin_path . 'front/tree_class.php');
	}

	/*############ Function for the shortcode ##################*/	
	
	public function shortcode($atts) {
		$tree = new wpda_org_chart_front_tree_maker($atts);
		return $tree->controller();
	}
}
