<?php
class wpda_org_chart_admin_popup {

	public static $notification_html = '';

	private static $id = 0;

	private static $task = '';

	public static $options = array();

	private static $page_id = 'wpda_org_chart_popup_id';

	public static function initial_task() {
		self::$task = isset($_REQUEST['task']) ? sanitize_text_field($_REQUEST['task']) : '';
		self::$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	}

	public static function initial_options() {
		self::$options = array(
			"general_settings" => array(
				"heading_name" => "General settings",
				"params" => array(
					"popup_width" => array(
						"title" => "Popup width",
						"description" => "Type the popup width.",
						"default_value" => array('desktop' => '850', 'metric_desktop' => 'px', 'tablet' => '', 'metric_desktop' => 'px', 'mobile' => '', 'metric_desktop' => 'px'),
						"function_name" => "simple_input",
						"metric" => array("px"),
						"responsive" => true,
					),
					"popup_height" => array(
						"title" => "Popup height",
						"description" => "Type the popup height.",
						"default_value" => array('desktop' => '850', 'metric_desktop' => 'px', 'tablet' => '', 'metric_desktop' => 'px', 'mobile' => '', 'metric_desktop' => 'px'), "function_name" => "simple_input",
						"metric" => array("px"),
						"responsive" => true,
					),
					"popup_bg_color" => array(
						"title" => "Background Color",
						"description" => "Set the popup background color.",
						"values" => array("color1" => "", "color2" => "", "gradient" => "0"),
						"default_value" => array("color1" => "rgba(255,255,255,1)", "color2" => "rgba(255,255,255,1)", "gradient" => "none"),
						"function_name" => "gradient_color_input",
						"transparent" => true,
					),
					"padding" => array(
						"title" => "Padding",
						"description" => "Type here the padding option values.",
						"default_value" => array(
							'desktop_top' => '0',
							'desktop_right' => '10',
							'desktop_bottom' => '10',
							'desktop_left' => '10',
							'tablet_top' => '',
							'tablet_right' => '',
							'tablet_bottom' => '',
							'tablet_left' => '',
							'mobile_top' => '',
							'mobile_right' => '',
							'mobile_bottom' => '',
							'mobile_left' => '',
							'metric_desktop' => 'px',
							'metric_tablet' => 'px',
							'metric_mobile' => 'px',
						),
						"metric" => array("px"),
						"function_name" => "margin_padding_input",
						"responsive" => true,
					),
					"popup_position" => array(
						"title" => "Popup position",
						"description" => "Select the popup position.",
						"function_name" => "simple_select",
						"values" => array(
							"1" => "Top Left",
							"2" => "Top center",
							"3" => "Top right",
							"4" => "Middle Left",
							"5" => "Middle center",
							"6" => "Middle right",
							"7" => "Bottom Left",
							"8" => "Bottom center",
							"9" => "Bottom right",
						),
						"default_value" => "5",
					),
					"popup_fixed_postion" => array(
						"title" => "Popup Fixed Position",
						"description" => "Select if the vertical scroll should effect the popup position.",
						"values" => array("fixed" => "Fixed", "relative" => "Relative"),
						"default_value" => "fixed",
						"function_name" => "radio",
					),
					"popup_border_popup" => array(
						"title" => "Popup Border",
						"description" => "Set the Popup border options.",
						"function_name" => "popup",
						"params" => array(
							"popup_border_type" => array(
								"title" => "Popup Border Type",
								"description" => "Select border type",
								"function_name" => "simple_select",
								"preview" => array('id' => 'popup_border_demo', 'action' => 'border-style'),
								"values" => array("solid" => "Solid", "dotted" => "Dotted", "dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),
								"default_value" => "solid",
							),
							"popup_border_color" => array(
								"title" => "Popup Border Color",
								"description" => "Select popup border color",
								"default_value" => "#cccccc",
								"preview" => array('id' => 'popup_border_demo', 'action' => 'border-color'),
								"function_name" => "color_input",
							),
							"popup_border_width" => array(
								"title" => "Border Width",
								"description" => "Select border width",
								"default_value" => array('desktop' => '1', 'metric_desktop' => 'px'),
								"metric" => array("px"),
								"preview" => array('id' => 'popup_border_demo', 'action' => 'border-width'),
								"function_name" => "simple_input",
							),
							"popup_border_radius" => array(
								"title" => "Border Radius",
								"description" => "Select border radius",
								"default_value" => array('desktop' => '0', 'metric_desktop' => 'px'),
								"metric" => array("px", "%"),
								"preview" => array('id' => 'popup_border_demo', 'action' => 'border-radius'),
								"function_name" => "simple_input",
							),
						),
					),
					"popup_border_demo" => array(
						"title" => "Border preview",
						"function_name" => "demo_border",
					),
					"popup_animation_type" => array(
						"title" => "Popup opening animation type",
						"description" => "Choose the popup opening animation type.",
						
						"values" => array(
							"disable" => "Disable",
							"fade" => "Fade",
							"zoom_out" => "Zoom  out",
							"zoom_in" => "Zoom  in",
							"slide_in_right" => "Slide in from right",
							"slide_in_left" => "Slide in from left",
							"slide_from_top" => "Slide in from top",
							"slide_from_bottom" => "Slide in from Bottom",
							"newspaper" => "Newspaper",
							"flip_hor_left" => "Flip Horizontal Left",
							"flip_hor_right" => "Flip Horizontal Right",
							"flip_ver_top" => "Flip Vertical Top",
							"flip_ver_bottom" => "Flip Vertical Bottom",
						),
						"default_value" => "disable",
						"function_name" => "simple_select",
						"pro"=>true,
					),
					"popup_animation_time" => array(
						"title" => "Popup animation duration",
						"description" => "Choose duration of Popup animation",
						"function_name" => "simple_input",
						"default_value" => array('desktop' => '500'),
						"type" => "number",
						"small_text" => "(Milliseconds)",
						"show_when" => array('popup_animation_type' => '!=disable'),
						"pro"=>true,
					)
				)
			),
			"popup_overlay" => array(
				"heading_name" => "Overlay",
				"params" => array(
					"overlay_bg_color" => array(
						"title" => "Background Color",
						"description" => "Set the overlay background color.",
						"values" => array("color1" => "", "color2" => "", "gradient" => "0"),
						"default_value" => array("color1" => "rgba(255,255,255,0.5)", "color2" => "rgba(255,255,255,0.5)", "gradient" => "none"),
						"function_name" => "gradient_color_input",
						"transparent" => true,
					)
				),
			),
			"close_section" => array(
				"heading_name" => "Close section",
				"params" => array(
					"close_button_text" => array(
						"title" => "Close button text",
						"description" => "Type here the close button text.",
						"default_value" => array('desktop' => 'X'),
						"function_name" => "simple_input",
					),
					"close_section_type" => array(
						"title" => "Close button section type",
						"description" => "Choose the close button section type.",
						"values" => array("section" => "Full width", "button" => "Only button"),
						"default_value" => "section",
						"function_name" => "radio",
					),
					"close_aditional" => array(
						"title" => "Additional Close option",
						"description" => "Choose additional close functions",
						"values" => array("esc_click" => "ESC or click on overlay", "esc" => "ESC", "click" => "Click", "none" => "Disable"),
						"default_value" => "esc_click",
						"function_name" => "radio",
					),
					"close_button_text_font" => array(
						"title" => "Close button text font",
						"description" => "Configure the Close button text font style.",
						"function_name" => "popup",
						"params" => array(
							"close_button_text_font_family" => array(
								"title" => "Font Family",
								"description" => "Select font family",
								"function_name" => "simple_select",
								"values" => wpda_org_chart_library::fonts_select(),
								"default_value" => "serif",
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'font-family'),
							),
							"close_button_text_color" => array(
								"title" => "Color",
								"description" => "Select color",
								"default_value" => "#000000",
								"function_name" => "color_input",
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'color'),
							),
							"close_button_text_font_size" => array(
								"title" => "Font Size",
								"description" => "Font size:",
								"default_value" => array('desktop' => '20', 'metric_desktop' => 'px'),
								"function_name" => "simple_input",
								"metric" => array("px", "em", "rem", "vw"),
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'font-size'),
							),
							"close_button_text_letter_spacing" => array(
								"title" => "Letter Spacing",
								"description" => "Letter spacing",
								"default_value" => array('desktop' => 'normal', 'metric_desktop' => 'px'),
								"function_name" => "simple_input",
								"metric" => array("px", "em", "rem", "vw"),
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'letter-spacing'),
							),
							"close_button_text_line_height" => array(
								"title" => "Line Height",
								"description" => "Line height",
								"default_value" => array('desktop' => 'normal', 'metric_desktop' => 'em'),
								"function_name" => "simple_input",
								"metric" => array("px", "em", "rem", "vw"),
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'line-height'),
							),
							"close_button_text_font_weight" => array(
								"title" => "Font Weight",
								"description" => "Select font weight",
								"function_name" => "simple_select",
								"values" => array('initial' => 'Initial', '100' => '100', '200' => '200', '300' => '300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800', '900' => '900', 'normal' => 'Normal', 'bold' => 'Bold',),
								"default_value" => "initial",
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'font-weight'),
							),
							"close_button_text_font_style" => array(
								"title" => "Font Style",
								"description" => "Select font style",
								"function_name" => "simple_select",
								"values" => array('initial' => 'Initial', 'normal' => 'Normal', 'italic' => 'Italic', 'oblique' => 'Oblique'),
								"default_value" => "initial",
								"preview" => array('id' => 'close_button_demo_text', 'action' => 'font-style'),
							),
						)
					),
					"close_button_demo_text" => array(
						"title" => "X x Close Hide",
						"function_name" => "demo_text",
					),
					"close_button_section_bg_color" => array(
						"title" => "Close section background color",
						"description" => "Set the close section background color.",
						"default_value" => '#ffffff',
						"function_name" => "color_input",
						"transparent" => true,
						"show_when" => array('close_section_type' => array('section'))
					),
					"close_section_border_bottom" => array(
						"title" => "Close section border bottom",
						"description" => "Select close section border bottom",
						"function_name" => "popup",
						"show_when" => array('close_section_type' => 'section'),
						"params" => array(
							"close_section_border_bottom_type" => array(
								"title" => "Close section border type",
								"description" => "Select border type",
								"function_name" => "simple_select",
								"preview" => array('id' => 'close_section_border_bottom_demo', 'action' => 'border-bottom-style'),
								"values" => array("solid" => "Solid", "dotted" => "Dotted", "dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),
								"default_value" => "solid",
							),
							"close_section_border_bottom_color" => array(
								"title" => "Popup Border Color",
								"description" => "Select popup border color",
								"default_value" => "#cccccc",
								"preview" => array('id' => 'close_section_border_bottom_demo', 'action' => 'border-bottom-color'),
								"function_name" => "color_input",
							),
							"close_section_border_bottom_width" => array(
								"title" => "Border Width",
								"description" => "Select border width",
								"default_value" => array('desktop' => '1', 'metric_desktop' => 'px'),
								"metric" => array("px"),
								"preview" => array('id' => 'close_section_border_bottom_demo', 'action' => 'border-bottom-width'),
								"function_name" => "simple_input",
							),
						),
					),
					"close_section_border_bottom_demo" => array(
						"title" => "Border bottom preview",
						"function_name" => "demo_border",
						"show_when" => array('close_section_type' => array('section'))
					),

				),
			)
		);
	}

	public static function render_popup() {
		self::print_notifications();
		switch (self::$task) {
			case 'add_edit_popup':
			case 'update_popup_theme':
				self::add_edit_popup_theme();
				break;
			default:
				self::display_table_list();
		}
	}

	public static function database_actions() {
		switch (self::$task) {
			case 'save_popup_theme':
			case 'update_popup_theme':
				if (self::$id) {
					self::update_popup_theme();
				} else {
					self::save_popup_theme();
				}
				break;
			case 'remove_popup_theme':
				self::remove_popup_theme();
				break;
			case 'duplicate_popup_theme':
				self::duplicate_popup_theme();
				break;
			case 'set_default_popup_theme':
				self::set_default_popup_theme();
				break;
		}
	}

	private static function display_table_list() {
		$params = array(
			'name' => 'Popup theme',
			'add_new_link' => 'admin.php?page=wpda_chart_tree_popup_themes&task=add_edit_popup',
			'support_link' => wpda_org_chart_support_url,
		); // params used in admin-page-task-list-header.php' file
		include wpda_org_chart_plugin_path . 'library/base-templates/admin-page-task-list-header.php';
	}
	/*############  Save function  ################*/

	private static function save_popup_theme() {
		global $wpdb;
		if (count($_POST) == 0)
			return;
		$params_array = array();
		if (isset($_POST['name'])) {
			$name = sanitize_text_field($_POST['name']);
		} else {
			$name = "theme";
		}
		$params_array = array('name' => sanitize_text_field($name));
		foreach (self::$options as $param_heading_value) {
			foreach ($param_heading_value['params'] as $key => $value) {
				if ($value['function_name'] == 'demo_text' || $value['function_name'] == 'demo_border') {
					continue;
				}
				if (isset($value['params'])) {
					foreach ($value['params'] as $ins_key => $ins_value) {
						$params_array[$ins_key] = wpda_org_chart_library::get_value_by_name($ins_key, $ins_value);
					}
				} else {
					$params_array[$key] = wpda_org_chart_library::get_value_by_name($key, $value);
				}
			}
		}
		$save_or_no = $wpdb->insert(
			wpda_org_chart_database::$table_names['popup'],
			array(
				'name' => $name,
				'option_value' => json_encode($params_array),
			),
			array(
				'%s',
				'%s',
			)
		);
		self::$id = $wpdb->get_var("SELECT MAX(id) FROM " . wpda_org_chart_database::$table_names['popup']);
		wpda_org_chart_user_permissions_library::set_id_to_meta_key(self::$id, self::$page_id);
		if ($save_or_no) {
			self::$notification_html = '<div class="updated"><p><strong>Item Saved</strong></p></div>';
		} else {
			self::$notification_html = '<div id="message" class="error"><p>Error please reinstall plugin</p></div>';
		}
	}

	/*############  Update theme ID function  ################*/

	private static function update_popup_theme() {
		global $wpdb;
		if (count($_POST) == 0)
			return;
		$params_array = array();
		if (isset($_POST['name'])) {
			$name = sanitize_text_field($_POST['name']);
		} else {
			$name = "theme";
		}
		$params_array = array('name' => sanitize_text_field($name));
		foreach (self::$options as $param_heading_value) {
			foreach ($param_heading_value['params'] as $key => $value) {
				if ($value['function_name'] == 'demo_text' || $value['function_name'] == 'demo_border') {
					continue;
				}
				if (isset($value['params'])) {
					foreach ($value['params'] as $ins_key => $ins_value) {
						$params_array[$ins_key] = wpda_org_chart_library::get_value_by_name($ins_key, $ins_value);
					}
				} else {
					$params_array[$key] = wpda_org_chart_library::get_value_by_name($key, $value);
				}
			}
		}
		$wpdb->update(
			wpda_org_chart_database::$table_names['popup'],
			array(
				'name' => $name,
				'option_value' => json_encode($params_array),
			),
			array(
				'id' => self::$id
			),
			array(
				'%s',
				'%s'
			),
			array(
				'%d'
			)
		);
		self::$notification_html = '<div class="updated"><p><strong>Item Saved</strong></p></div>';
	}

	/*############ Function for removing the popup theme ##################*/		
	
	private static function remove_popup_theme() {
		global $wpdb;
		$default_theme = $wpdb->get_var($wpdb->prepare('SELECT `default` FROM ' . wpda_org_chart_database::$table_names['popup'] . ' WHERE id="%d"', self::$id));
		if (!$default_theme) {
			$wpdb->query($wpdb->prepare('DELETE FROM ' . wpda_org_chart_database::$table_names['popup'] . ' WHERE id="%d"', self::$id));
			wpda_org_chart_user_permissions_library::remove_id_from_meta_key(self::$id, self::$page_id);
			self::$notification_html = '<div class="updated"><p><strong>Popup theme removed</strong></p></div>';
		} else {
			self::$notification_html = '<div id="message" class="error"><p>You cannot remove default popup theme</p></div>';
		}
	}

	/*############ Function for duplicating the popup theme ##################*/		
	
	private static  function duplicate_popup_theme() {
		global $wpdb;
		$wpdb->query($wpdb->prepare('INSERT INTO ' . wpda_org_chart_database::$table_names['popup'] . ' ( `name`, `option_value`, `default` ) SELECT CONCAT(`name`,"(duplicate)"), `option_value`, 0 FROM ' . wpda_org_chart_database::$table_names['popup'] . ' WHERE id="%d"', self::$id));
		$local_id = $wpdb->get_var("SELECT MAX(id) FROM " . wpda_org_chart_database::$table_names['popup']);
		wpda_org_chart_user_permissions_library::set_id_to_meta_key($local_id, self::$page_id);
		self::$notification_html = '<div class="updated"><p><strong>Item Duplicated</strong></p></div>';
	}

	private static function generate_popup_theme_parameters() {
		global $wpdb;
		$theme_params = NULL;
		$new_theme = 1;
		if (self::$id) {
			$theme_params = $wpdb->get_row('SELECT * FROM ' . wpda_org_chart_database::$table_names['popup'] . ' WHERE id=' . self::$id);
			$new_theme = 0;
		} else {
			$theme_params = $wpdb->get_row('SELECT * FROM ' . wpda_org_chart_database::$table_names['popup'] . ' WHERE `default`=1');
		}
		if ($theme_params == NULL) {
			foreach (self::$options as $param_heading_key => $param_heading_value) {
				foreach ($param_heading_value['params'] as $key => $value) {
					self::$options[$param_heading_key]['params'][$key]["value"] = isset(self::$options[$param_heading_key]['params'][$key]["default_value"]) ? self::$options[$param_heading_key]['params'][$key]["default_value"] : '';
				}
			}
		} else {
			$databases_parameters = json_decode($theme_params->option_value, true);
			foreach (self::$options as $param_heading_key => $param_heading_value) {
				foreach ($param_heading_value['params'] as $key => $value) {
					if (self::$options[$param_heading_key]['params'][$key]["function_name"] == 'demo_text' || self::$options[$param_heading_key]['params'][$key]["function_name"] == 'demo_border') {
						continue;
					}
					if (self::$options[$param_heading_key]['params'][$key]["function_name"] == 'popup') {
						foreach (self::$options[$param_heading_key]['params'][$key]["params"] as $ins_key => $ins_value) {
							if (isset($databases_parameters[$ins_key])) {
								self::$options[$param_heading_key]['params'][$key]['params'][$ins_key]["value"] = $databases_parameters[$ins_key];
							} else {
								self::$options[$param_heading_key]['params'][$key]['params'][$ins_key]["value"] = self::$options[$param_heading_key]['params'][$key]['params'][$ins_key]["default_value"];
							}
						}
					} else {
						if (isset($databases_parameters[$key])) {
							self::$options[$param_heading_key]['params'][$key]["value"] = $databases_parameters[$key];
						} else {
							self::$options[$param_heading_key]['params'][$key]["value"] = self::$options[$param_heading_key]['params'][$key]["default_value"];
						}
					}
				}
			}
			if ($new_theme) {
				return "New Popup";
			} else {
				return $theme_params->name;
			}
		}
	}

	private static function print_notifications() {
		if (self::$notification_html != '') {
			echo self::$notification_html;
			self::$notification_html = '';
		}
	}

	private static function get_table_info() {
		return array(
			'keys' => array(
				'id' => array('name' => 'ID', 'sortable' => true),
				'name' => array('name' => 'Name', 'link' => '&task=add_edit_popup', 'sortable' => true),
				'default' => array('name' => 'Default', 'link' => '&task=set_default_popup_theme', 'replace_value' => array('0' => '<img src = "' . wpda_org_chart_plugin_url . 'admin/assets/images/default0.png">', '1' => '<img src = "' . wpda_org_chart_plugin_url . 'admin/assets/images/default1.png">')),
				'edit' => array('name' => 'Edit', 'link' => '&task=add_edit_popup'),
				'duplicate' => array('name' => 'Duplicate', 'link' => '&task=duplicate_popup_theme'),
				'delete' => array('name' => 'Delete', 'link' => '&task=remove_popup_theme')
			),
			'link_page' => 'wpda_chart_tree_popup_themes',
		);
	}

	// helper functions
	public static function get_row_list() {
		global $wpdb;
		$query = "SELECT `id`,`name`,`default` FROM " . wpda_org_chart_database::$table_names['popup'];
		$row_list = $wpdb->get_results($query);
		return self::filter_by_user($row_list);
	}

	//filter rows by user
	private static function filter_by_user($rows) {
		if (current_user_can('manage_option')) {
			return $rows;
		}
		$allowed_by_other_user = wpda_org_chart_user_permissions::get_option_value('chart_theme_page_allow_other_users');
		if ($allowed_by_other_user == 'yes') {
			return $rows;
		}
		$filtered_rows = array();
		foreach ($rows as $row) {
			if (wpda_org_chart_user_permissions_library::can_current_user_edit_element(self::$page_id, $row->id)) {
				$filtered_rows[] = $row;
			}
		}
		return $filtered_rows;
	}

	private static function add_edit_popup_theme() {
		$name = self::generate_popup_theme_parameters();
		$params = array(
			'current_page_link' => 'admin.php?page=wpda_chart_tree_popup_themes',
			'support_link' => wpda_org_chart_support_url,
			'plugin_url' => wpda_org_chart_plugin_url,
			'options' => self::$options,
			'id' => self::$id,
		);
		include wpda_org_chart_plugin_path . 'library/base-templates/admin-page-task-add-edit-header.php';
		include wpda_org_chart_plugin_path . 'admin/popup-page/add-edit-popup-template.php';
	}

	private static function set_default_popup_theme() {
		global $wpdb;
		$wpdb->update(wpda_org_chart_database::$table_names['popup'], array('default' => 0), array('default' => 1));
		$wpdb->update(wpda_org_chart_database::$table_names['popup'], array('default' => 1), array('id' => self::$id));
	}

	public static function enqueue_scripts_styles() {
		wp_enqueue_style('wpda_chart_theme_page_css', wpda_org_chart_plugin_url . 'admin/assets/css/theme_page.css');
		switch (self::$task) {
			case 'add_edit_popup':
			case 'update_popup_theme':
				wp_enqueue_style("wpda_admin_page_task_add_edit_header", wpda_org_chart_plugin_url . 'library/css/admin-page-task-add-edit-header.css');
				wp_enqueue_script('wp-color-picker');				
				wp_enqueue_script("wpda_chart_theme_page_js", wpda_org_chart_plugin_url . 'admin/assets/js/popup_page.js');
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
				if (function_exists('wp_enqueue_media')) {
					wp_enqueue_media();
				}
				if (function_exists('wp_enqueue_editor')) {
					wp_enqueue_editor();
				}
				break;
			default:
				wp_enqueue_style("wpda_admin_page_task_list_header", wpda_org_chart_plugin_url . 'library/css/admin-page-task-list-header.css');
				wp_enqueue_script("wpda_chart_popup_theme_page_list_js", wpda_org_chart_plugin_url . 'admin/assets/js/wpda_table_maker.js');
				wp_localize_script("wpda_chart_popup_theme_page_list_js", 'wpdaPageRowsList', self::get_row_list());
				wp_localize_script("wpda_chart_popup_theme_page_list_js", 'wpdaPageRowsInfo', self::get_table_info());
				wp_enqueue_style("wpda_chart_popup_theme_page_list_css", wpda_org_chart_plugin_url . 'admin/assets/css/wpda_table_maker.css');
		}
	}
}
