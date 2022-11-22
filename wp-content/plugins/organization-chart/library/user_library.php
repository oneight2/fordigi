<?php

defined('ABSPATH') || exit;

class wpda_org_chart_user_permissions_library {
	private static $current_user;

	/*############ Function for the initial information ##################*/		
	
	public static function initial_information() {
		self::$current_user = get_current_user_id();
	}

	/*############ Function for setting the ID to meta key ##################*/		
	
	public static function set_id_to_meta_key($id, $meta_key) {
		$user_meta = self::get_all_ids($meta_key);
		if (isset($user_meta[0]) && is_array($user_meta[0])) {
			$user_meta = $user_meta[0];
		}
		if (!in_array($id, $user_meta)) {
			array_push($user_meta, $id);
			update_user_meta(self::$current_user,  $meta_key, $user_meta);
		}
	}

	/*############ Function for removing the ID from meta key ##################*/		
	
	public static function remove_id_from_meta_key($id, $meta_key) {
		$user_meta = self::get_all_ids($meta_key);
		$key = array_search($id, $user_meta);
		if ($key !== false) {
			unset($user_meta[$key]);
			update_user_meta(self::$current_user, $meta_key,  $user_meta);
		} else {
			//when current user delete row created by other user. we get all users find who make row and then remove it.
			$all_user_ids = self::get_all_user_ids();
			foreach ($all_user_ids as  $user_id) {
				$loc_user_meta = self::get_all_ids($meta_key, $user_id);
				$loc_key =  array_search($id, $loc_user_meta);
				if ($loc_key !== false) {
					unset($loc_user_meta[$loc_key]);
					update_user_meta($user_id, $meta_key,  $loc_user_meta);
					break;
				}
			}
		}
	}

	/*############ Function for getting all users IDs ##################*/		
	
	private static function get_all_user_ids() {
		$users = get_users();
		$user_ids = array();
		foreach ($users as $user) {
			$user_ids[] = $user->ID;
		}
		return $user_ids;
	}

	/*############ Function for getting all IDs ##################*/		
	
	public static function get_all_ids($meta_key, $user_id = 0) {
		if ($user_id == 0) {
			$user_id = self::$current_user;
		}
		$user_meta = get_user_meta($user_id, $meta_key, true);
		if ($user_meta == '') {
			return array();
		}
		return $user_meta;
	}

	/*############ Function for finding out if the current user can edit the element ##################*/		
	
	public static function can_current_user_edit_element($key, $id) {
		if (current_user_can('manage_options')) {
			return true;
		}
		$user_meta = self::get_all_ids($key);
		if (in_array($id, $user_meta)) {
			return true;
		}
		return false;
	}

	/*############ Function for the user roles ##################*/	
	
	public static function get_users() {
		$users_role = get_option("wp_user_roles");
		$users = array(
			"manage_options" => __("Administrator", 'booking-calendar'),
			"publish_pages" => __("Editor", 'booking-calendar'),
			"publish_posts" => __("Author", 'booking-calendar'),
			"edit_posts" => __("Contributor", 'booking-calendar'),
			"read" => __("Subscriber", 'booking-calendar')
		);
		$user_arr = array("administrator", "editor", "author", "contributor", "subscriber");
		if ($users_role && is_array($users_role)) {
			foreach ($users_role as $key => $user) {
				if (!in_array($key, $user_arr)) {
					$users[$key] = $user["name"];
				}
			}
		}
		return  $users;
	}
}
