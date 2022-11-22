<?php

defined('ABSPATH') || exit;

// previous defined admin constants
// wpda_org_chart_plugin_url
// wpda_org_chart_plugin_path

class wpda_chart_gutenberg {
	function __construct() {
		$this->hooks_for_gutenberg();
	}

	private function hooks_for_gutenberg() {
		add_action('enqueue_block_editor_assets', array($this, 'gutenberg_init'));
	}

	public function gutenberg_init() {
		if (!function_exists('register_block_type')) {
			return;
		}
		wp_enqueue_script('wpda_chart_gutenberg_js');
		wp_enqueue_style('wpda_chart_gutenberg_css');
		wp_add_inline_script(
			'wpda_chart_gutenberg_js',
			sprintf('var wpda_chart_gutenberg = { charts: %s, themes: %s,other_data: %s};', json_encode($this->get_timers(), JSON_PRETTY_PRINT), json_encode($this->get_themes(), JSON_PRETTY_PRINT), json_encode($this->other_dates(), JSON_PRETTY_PRINT)),
			'before'
		);
	}

	private function get_timers() {
		global $wpdb;
		$timers = $wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_database::$table_names['tree']);
		$array = array();
		foreach ($timers as $timer) {
			$array[$timer->id] = $timer->name;
		}
		return $array;
	}

	private function other_dates() {
		$array = array('icon_src' => wpda_org_chart_plugin_url . "includes/admin/images/icon.svg");
		return $array;
	}

	private function get_themes() {
		global $wpdb;
		$themes = array();
		$array = array();
		$themes = $wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_database::$table_names['theme']);
		foreach ($themes as $theme) {
			$array[$theme->id] = $theme->name;
		}
		return $array;
	}
	
}
