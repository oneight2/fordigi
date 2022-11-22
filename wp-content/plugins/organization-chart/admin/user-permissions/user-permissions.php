<?php

defined('ABSPATH') || exit;

class wpda_org_chart_user_permissions {

	public static $notification_html = '';
	private static $options;
	public static function initial_options() {
		self::$options = array(
			"chart_page" => array(
				"title" => "Charts page",
				"description" => "Select the user role. For example, if you choose the Subscriber role, then users with permissions above the Subscriber will get access to this page.",
				"values" => wpda_org_chart_user_permissions_library::get_users(),
				"default_value" => "manage_options",
				"function_name" => "simple_select",
			),
			"chart_page_allow_other_users" => array(
				"title" => "Can edit other users Charts",
				"description" => "Set the additional permission.",
				"values" => array('yes' => 'Yes', 'no' => 'No'),
				"default_value" => "yes",
				"function_name" => "radio",
			),
			"chart_theme_page" => array(
				"title" => "Themes page",
				"description" => "Select the user role. For example, if you choose the Subscriber role, then users with permissions above the Subscriber will get access to this page.",
				"values" => wpda_org_chart_user_permissions_library::get_users(),
				"default_value" => "manage_options",
				"function_name" => "simple_select",
			),
			"chart_theme_page_allow_other_users" => array(
				"title" => "Can edit other users Chart Themes",
				"description" => "Set the additional permission.",
				"values" => array('yes' => 'Yes', 'no' => 'No'),
				"default_value" => "yes",
				"function_name" => "radio",
			),
			"chart_popup_page" => array(
				"title" => "Popup Themes page",
				"description" => "Select the user role. For example, if you choose the Subscriber role, then users with permissions above the Subscriber will get access to this page.",
				"values" => wpda_org_chart_user_permissions_library::get_users(),
				"default_value" => "manage_options",
				"function_name" => "simple_select",
			),
			"chart_popup_page_allow_other_users" => array(
				"title" => "Can edit other users Popup Themes page.",
				"description" => "Set the additional permission.",
				"values" => array('yes' => 'Yes', 'no' => 'No'),
				"default_value" => "yes",
				"function_name" => "radio",
			),
		);
	}

	/*############ Function for rendering user permissions ##################*/		
	
	public static function render_user_permissions() {
		self::print_notifications();		
		$params = array(
			'current_page_link' => 'admin.php?page=wpda_chart_tree_user_permissions',
			'support_link' => wpda_org_chart_support_url,
			'plugin_url' => wpda_org_chart_plugin_url,
			'options' => self::$options
		);
		include wpda_org_chart_plugin_path . 'library/base-templates/admin-page-task-add-edit-header.php';
		include wpda_org_chart_plugin_path . 'admin/user-permissions/user-permissions-template.php';
	}

	/*############ Function for the database ##################*/		
	
	public static function database_actions() {
		self::update_permissions();
		self::generate_parameters();
	}

	/*############ Function for printing the notifications ##################*/	
	
	private static function print_notifications() {
		if (self::$notification_html != '') {
			echo self::$notification_html;
			self::$notification_html = '';
		}
	}

	/*############ Function for updating the user permissions ##################*/	
	
	private static function update_permissions() {
		
		if(isset($_REQUEST['task']) && $_REQUEST['task'] =='save'){
			$params_array = get_option('wpda_chart_user_permissions', array());
			if(!is_array($params_array)){
				$params_array =  array();
			}
			foreach (self::$options as $key => $value) {
				if ($value['function_name'] == 'demo_text' || $value['function_name'] == 'demo_border') {
					continue;
				}
				if (isset($value['params'])) {
					foreach ($value['params'] as $ins_key => $ins_value) {
						$value_of_param =  wpda_org_chart_library::get_value_by_name($ins_key, $ins_value);
						if($value_of_param !== null){
							$params_array[$ins_key] = $value_of_param;
						}
					}
				} else {
					$value_of_param =  wpda_org_chart_library::get_value_by_name($key, $value);
					if($value_of_param !== null){
						$params_array[$key] = $value_of_param;
					}
				}
			}
			update_option('wpda_chart_user_permissions', $params_array);
			self::$notification_html = '<div class="updated"><p><strong>Options saved</strong></p></div>';
		}
	}

	public static function enqueue_scripts_styles() {
		wp_enqueue_script('wpda_user_permissions_page_js', wpda_org_chart_plugin_url . 'admin/assets/js/user_permissions_page.js');
		wp_enqueue_style("wpda_admin_page_task_list_header", wpda_org_chart_plugin_url . 'library/css/admin-page-task-add-edit-header.css');
		wp_enqueue_style("wpda_user_permissions", wpda_org_chart_plugin_url . 'admin/assets/css/user_permissions.css');
		wp_enqueue_script('wpda_library_admin_js', wpda_org_chart_plugin_url . 'library/js/admin.js', array('jquery-ui-draggable'));
		wp_enqueue_style('wpda_library_admin_css', wpda_org_chart_plugin_url . 'library/css/admin.css');
		wp_localize_script('alpha-color-picker', 'wpColorPickerL10n', array(
			'clear' => 'Clear',
			'clearAriaLabel' => 'Clear color',
			'defaultString' => 'Default',
			'defaultAriaLabel' => 'Select default color',
			'pick' => 'Select Color',
			'defaultLabel' => 'Color value',
		));
		wp_enqueue_script('alpha-color-picker');
		wp_enqueue_style('wp-color-picker');
	}

	/*############ Function for the permissions ##################*/	
	
	public static function get_allowed_page_permission($key){
		if(!isset(self::$options[$key]['value']))
			self::generate_parameters();
		return self::$options[$key]['value'];
	}

	public static function get_option_value($key){
		if(!isset(self::$options[$key]['value']))
			self::generate_parameters();
		return self::$options[$key]['value'];
	}

	/*############ Function for generating the parameters ##################*/	
	
	private static function generate_parameters() {
		$options_values = array();
		if (get_option('wpda_chart_user_permissions', array())) {
			$options_values = get_option('wpda_chart_user_permissions', array());
		}
		if ($options_values == null || count($options_values) == 0) {
			foreach (self::$options as  $key => $value) {
				self::$options[$key]["value"] = isset(self::$options[$key]["default_value"]) ? self::$options[$key]["default_value"] : '';
			}
		} else {
			foreach (self::$options as $key => $value) {
				if (self::$options[$key]["function_name"] == 'demo_text' || self::$options[$key]["function_name"] == 'demo_border') {
					continue;
				}
				if (self::$options[$key]["function_name"] == 'popup') {
					foreach (self::$options[$key]["params"] as $ins_key => $ins_value) {
						if (isset($options_values[$ins_key])) {
							self::$options[$key]['params'][$ins_key]["value"] = $options_values[$ins_key];
						} else {
							self::$options[$key]['params'][$ins_key]["value"] = self::$options[$key]['params'][$ins_key]["default_value"];
						}
					}
				} else {
					if (isset($options_values[$key])) {
						self::$options[$key]["value"] = $options_values[$key];
					} else {
						self::$options[$key]["value"] = self::$options[$key]["default_value"];
					}
				}
			}
		}
	}	
}
