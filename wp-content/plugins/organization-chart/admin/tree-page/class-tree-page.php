<?php

defined('ABSPATH') || exit;

class wpda_org_chart_admin_tree {

	public static $notification_html = '';

	private static $id = 0;

	private static $task = '';

	private static $page_id = 'wpda_org_chart_tree_id';

	public static function initial_task() {
		self::$task = isset($_REQUEST['task']) ? sanitize_text_field($_REQUEST['task']) : '';
		self::$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
	}

	/*############ Function for the rendering the tree ##################*/		
	
	public static function render_tree() {
		self::print_notifications();
		switch (self::$task) {
			case 'add_tree':
				self::add_edit_tree();
				break;
			case 'edit_tree':
				self::add_edit_tree();
				break;
			case 'update_tree':
				self::add_edit_tree();
				break;
			default:
				self::display_table_list();
		}
	}

	/*############ Function for the database ##################*/	
	
	public static function database_actions() {
		switch (self::$task) {
			case 'save_tree':
			case 'update_tree':			
				if (self::$id) {
					self::update_tree();
				} else {
					self::save_tree();
				}
				break;
			case 'remove_tree':
				self::remove_tree();
				break;
			case 'duplicate_tree':
				self::duplicate_tree();
				break;
		}
	}

	/*############ Function for printing the notifications ##################*/	
	
	private static function print_notifications() {
		if (self::$notification_html != '') {
			echo self::$notification_html;
			self::$notification_html = '';
		}
	}

	/*############ Function for displaying the table list ##################*/
	
	private static function display_table_list() {
		$params = array(
			'name' => 'Tree - Organization Chart',
			'add_new_link' => 'admin.php?page=wpda_chart_tree_page&task=add_tree',
			'support_link' => wpda_org_chart_support_url,
		); // params used in admin-page-task-list-header.php' file
		include wpda_org_chart_plugin_path . 'library/base-templates/admin-page-task-list-header.php';
	}

	/*############ Function for adding/editing the chart element ##################*/
	
	private static function add_edit_tree() {
		$standard_json = json_encode(
			array(
				'image_url' => wpda_org_chart_plugin_url . 'admin/assets/images/staff-icon.jpg',
				'node_title' => 'Title',
				'node_description' => 'Description',
				'theme' => '0',
			)
		);
		$params = array(
			'current_page_link' => 'admin.php?page=wpda_chart_tree_page',
			'support_link' => wpda_org_chart_support_url,
			'plugin_url' => wpda_org_chart_plugin_url,
			'tree' => self::$id ? self::get_tree_info(self::$id) : array(),
			'id' => self::$id,
			'standard_json' => $standard_json
		);
		include wpda_org_chart_plugin_path . 'library/base-templates/admin-page-task-add-edit-header.php';
		include wpda_org_chart_plugin_path . 'admin/tree-page/add-edit-tree-template.php';
	}

	/*############ Function for saving the tree ##################*/	
	
	private static function save_tree() {
		global $wpdb;
		if (count($_POST) == 0)
			return;
		if (isset($_POST['name']) && $_POST['name'] != '') {
			$name = sanitize_text_field($_POST['name']);
		} else {
			$name = "Unnamed";
		}
		$tree_nodes = self::sanitize_node_values($_POST['wpdevart_chart_tree_all_info']);
		$save_or_no = $wpdb->insert(
			wpda_org_chart_database::$table_names['tree'],
			array(
				'name' => $name,
				'tree_nodes' => $tree_nodes,
			),
			array(
				'%s',
				'%s',
			)
		);
		self::$id = $wpdb->get_var("SELECT MAX(id) FROM " . wpda_org_chart_database::$table_names['tree']);
		wpda_org_chart_user_permissions_library::set_id_to_meta_key(self::$id, self::$page_id);
		if ($save_or_no) {
			self::$notification_html = '<div class="updated"><p><strong>Item Saved</strong></p></div>';
		} else {
			self::$notification_html = '<div id="message" class="error"><p>Error please reinstall plugin</p></div>';
		}
	}

	/*############ Function for updating the tree ##################*/	
	
	private static function update_tree() {
		global $wpdb;
		if (count($_POST) == 0)
			return;
		if (isset($_POST['name']) && $_POST['name'] != '') {
			$name = sanitize_text_field($_POST['name']);
		} else {
			$name = "Unnamed";
		}
		$tree_nodes = self::sanitize_node_values($_POST['wpdevart_chart_tree_all_info']);
		$wpdb->update(
			wpda_org_chart_database::$table_names['tree'],
			array(
				'name' => $name,
				'tree_nodes' => $tree_nodes,
			),
			array(
				'id' => self::$id,
			),
			array(
				'%s',
				'%s',
			),
			array(
				'%d',
			)
		);
		self::$notification_html = '<div class="updated"><p><strong>Item Saved</strong></p></div>';
	}

	/*############ Function for sanitizing some values ##################*/	
	
	private static function sanitize_node_values($json_string) {
		$json_array = json_decode(stripslashes($json_string), true);
		if ($json_array == null) {
			return '';
		}
		return json_encode(self::sanitize_node_helper($json_array), JSON_UNESCAPED_UNICODE);
	}

	/*############ Function for sanitizing the node helper ##################*/		
	
	private static function sanitize_node_helper($nodes) {
		if (count($nodes) == 0) {
			return array();
		}
		$returned_array = array();
		for ($i = 0; $i < count($nodes); $i++) {
			if (count($nodes[$i]['node_info']) == 0) {
				$returned_array[$i]['node_info'] = array();
			}
			foreach ($nodes[$i]['node_info'] as $key => $value) {
				if (is_array($value)) {
					if (count($value) > 0) {
						foreach ($value as $key_1 => $value_1) {
							$returned_array[$i]['node_info'][$key][$key_1] = sanitize_textarea_field(htmlspecialchars($value_1));
						}
					} else {
						$returned_array[$i]['node_info'][$key] = array();
					}
				} else {
					$returned_array[$i]['node_info'][$key] = sanitize_textarea_field(htmlspecialchars($value));
				}
			}
			$returned_array[$i]['chidrens'] = self::sanitize_node_helper($nodes[$i]['chidrens']);
		}
		return $returned_array;
	}

	/*############ Function for decoding the node value ##################*/		
	
	private static function decode_node_value($json_string) {
		$json_array = json_decode($json_string, true);
		if ($json_array == null) {
			return '';
		}
		return  self::decode_node_value_helper($json_array);
	}

	/*############ Function for the node value helper ##################*/		
	
	private static function decode_node_value_helper($nodes) {
		if (count($nodes) == 0) {
			return array();
		}
		$returned_array = array($nodes);
		for ($i = 0; $i < count($nodes); $i++) {
			if (count($nodes[$i]['node_info']) == 0) {
				$returned_array[$i]['node_info'] = array();
			}
			foreach ($nodes[$i]['node_info'] as $key => $value) {
				if (is_array($value)) {
					if (count($value) > 0) {
						foreach ($value as $key_1 => $value_1) {
							$returned_array[$i]['node_info'][$key][$key_1] = stripslashes(htmlspecialchars_decode($value_1));
						}
					} else {
						$returned_array[$i]['node_info'][$key] = array();
					}
				} else {
					$returned_array[$i]['node_info'][$key] = htmlspecialchars_decode($value);
				}
			}
			$returned_array[$i]['chidrens'] = self::decode_node_value_helper($nodes[$i]['chidrens']);
		}
		return $returned_array;
	}

	/*############ Function for getting the tree themes ##################*/		
	
	public static function get_tree_themes($value = '') {
		global $wpdb;
		$html = '<select id="node_theme">';
		$themes = $wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_database::$table_names['theme'] . '');
		$html .= '<option selected="selected" value="0" ' . str_replace("'", '"', selected('', $value, false)) . '>Shortcode theme</option>';
		foreach ($themes as $theme) {
			$html .= '<option value="' . $theme->id . '" ' . str_replace("'", '"', selected($theme->id, $value, false)) . '>' . $theme->name . '</option>';
		}
		$html .= '</select>';
		return $html;
	}

	/*############ Function for getting the popup themes ##################*/		
	
	public static function get_tree_popup_themes($value = '') {
		global $wpdb;
		$html = '<select id="node_popup_theme">';
		$themes = $wpdb->get_results('SELECT `id`,`name` FROM ' . wpda_org_chart_database::$table_names['popup'] . '');
		$html .= '<option selected="selected" value="0" ' . str_replace("'", '"', selected('', $value, false)) . '>Default Popup theme</option>';
		foreach ($themes as $theme) {
			$html .= '<option value="' . $theme->id . '" ' . str_replace("'", '"', selected($theme->id, $value, false)) . '>' . $theme->name . '</option>';
		}
		$html .= '</select>';
		return $html;
	}

	private static function duplicate_tree() {
		global $wpdb;
		$wpdb->query($wpdb->prepare('INSERT INTO ' . wpda_org_chart_database::$table_names['tree'] . ' ( name, tree_nodes ) SELECT CONCAT(name,"(duplicate)"), tree_nodes FROM ' . wpda_org_chart_database::$table_names['tree'] . ' WHERE id="%d"', self::$id));
		self::$notification_html = '<div class="updated"><p><strong>Item Duplicated</strong></p></div>';
	}

	private static function remove_tree() {
		global $wpdb;
		$wpdb->query($wpdb->prepare('DELETE FROM ' . wpda_org_chart_database::$table_names['tree'] . ' WHERE id="%d"', self::$id));
		wpda_org_chart_user_permissions_library::remove_id_from_meta_key(self::$id, self::$page_id);
		self::$notification_html = '<div class="updated"><p><strong>Item Deleted</strong></p></div>';
	}

	private static function get_tree_info() {
		global $wpdb;
		$tree = $wpdb->get_row('SELECT * FROM ' . wpda_org_chart_database::$table_names['tree'] . ' WHERE id=' . self::$id);
		return $tree;
	}

	//filter rows by user
	private static function filter_by_user($rows) {
		if (current_user_can('manage_option')) {
			return $rows;
		}
		$allowed_by_other_user = wpda_org_chart_user_permissions::get_option_value('chart_page_allow_other_users');
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

	// helper functions
	public static function get_row_list() {
		global $wpdb;
		$query = "SELECT `id`,`name` FROM " . wpda_org_chart_database::$table_names['tree'];
		$row_list = $wpdb->get_results($query);
		return self::filter_by_user($row_list);
	}

	public static function enqueue_scripts_styles() {
		wp_enqueue_style('wpda_chart_tree_page_css', wpda_org_chart_plugin_url . 'admin/assets/css/tree_page.css');
		switch (self::$task) {
			case 'add_tree':
			case 'edit_tree':
			case 'update_tree':
				if (self::$id) {
					$tree = self::get_tree_info(self::$id);
				}
				wp_enqueue_style("wpda_admin_page_task_add_edit_header", wpda_org_chart_plugin_url . 'library/css/admin-page-task-add-edit-header.css');
				wp_enqueue_script("wpda_chart_tree_page_js", wpda_org_chart_plugin_url . 'admin/assets/js/tree_page.js');
				wp_localize_script("wpda_chart_tree_page_js", 'wpdaTreePageInfo', array(
					'plug_url' => wpda_org_chart_plugin_url,
					'initial_tree_string' => ((isset($tree) && isset($tree->tree_nodes)) ? self::decode_node_value($tree->tree_nodes) : ''),
					'themes_select' => self::get_tree_themes(''),
					'popup_select' => self::get_tree_popup_themes('')

				));
				if (function_exists('wp_enqueue_media')) {
					wp_enqueue_media();
				}
				if (function_exists('wp_enqueue_editor')) {
					wp_enqueue_editor();
				}
				break;
			default:
				wp_enqueue_style("wpda_admin_page_task_list_header", wpda_org_chart_plugin_url . 'library/css/admin-page-task-list-header.css');
				wp_enqueue_script("wpda_chart_tree_page_list_js", wpda_org_chart_plugin_url . 'admin/assets/js/wpda_table_maker.js');
				wp_localize_script("wpda_chart_tree_page_list_js", 'wpdaPageRowsList', self::get_row_list());
				wp_localize_script("wpda_chart_tree_page_list_js", 'wpdaPageRowsInfo', self::get_table_info());
		}
	}

	private static function get_table_info() {
		return array(
			'keys' => array(
				'id' => array('name' => 'ID', 'sortable' => true),
				'name' => array('name' => 'Name', 'link' => '&task=edit_tree', 'sortable' => true),
				'edit' => array('name' => 'Edit', 'link' => '&task=edit_tree'),
				'duplicate' => array('name' => 'Duplicate', 'link' => '&task=duplicate_tree'),
				'delete' => array('name' => 'Delete', 'link' => '&task=remove_tree')
			),
			'link_page' => 'wpda_chart_tree_page',
		);
	}
}
