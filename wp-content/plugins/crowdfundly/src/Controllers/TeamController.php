<?php

namespace Crowdfundly\App\Controllers;

/**
 * Team Controller
 * Provides functionality for the Team page.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class TeamController extends BaseController
{
    public static $wp_current_user;

    public function register()
    {
        cf_wp_ajax( 'cf_add_role', [$this, 'cf_add_role'] );
        cf_wp_ajax( 'cf_delete_role', [$this, 'cf_delete_role'] );
        cf_wp_ajax( 'cf_get_user_caps', [ $this, 'cf_get_user_caps' ] );
        cf_wp_ajax( 'cf_update_caps', [ $this, 'cf_update_caps' ] );

        add_action( 'plugins_loaded', function() {
            static::$wp_current_user = wp_get_current_user();
        } );
    }

    public function view()
    {
        $this->render('admin/dashboard/team/team.php');
    }

    public function cf_add_role()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) {
            return;
        }

        $wp_user_id = esc_html( $_POST['cf_wp_user'] );
        $role = esc_html( $_POST['cf_role'] );

        $role = $this->add_user_role( $wp_user_id, $role );
        wp_send_json( [ 'message' => __( 'Role Assigned', 'crowdfundly' ) ], 200 );
        wp_die();
    }

    public function cf_delete_role()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $wp_user_id = esc_html( $_POST['cf_wp_user'] );
        $this->remove_user_role( $wp_user_id );

        wp_send_json( [ 'message' => __( 'Role Removed', 'crowdfundly' ) ], 200 );
        wp_die();
    }

    public static function get_wp_users($args = [])
    {
        $user_list = [];
        $users = get_users( $args );
        if ( empty( $users ) ) return false;

        foreach ( $users as $user ) {
            if ( static::$wp_current_user->ID == $user->ID ) continue;
            $user_list[$user->ID] = $user->display_name;
        }
        return $user_list;
    }

    public static function cf_roles()
    {
        $roles = [
            'crowdfundly_admin' => [
                'name'  => __( 'Crowdfundly Admin', 'crowdfundly' ),
                'capabilities' => [
                    'crowdfundly_menu_access'       => true,
                    'crowdfundly_create_campaign'   => true,
                    'crowdfundly_manage_campaign'   => true,
                    'crowdfundly_delete_campaign'   => true,
                    'crowdfundly_logout'            => true,
                    'crowdfundly_manage_team'       => true,
                    'crowdfundly_manage_settings'   => true,
                    'crowdfundly_manage_reports'    => true,
                    'crowdfundly_manage_payments'   => true,
                ],
            ],
            'crowdfundly_manager'   => [
                'name' => __( 'Crowdfundly Manager', 'crowdfundly' ),
                'capabilities' => [
                    'crowdfundly_menu_access'       => true,
                    'crowdfundly_create_campaign'   => true,
                    'crowdfundly_manage_campaign'   => true,
                    'crowdfundly_delete_campaign'   => false,
                    'crowdfundly_logout'            => false,
                    'crowdfundly_manage_team'       => true,
                    'crowdfundly_manage_settings'   => true,
                    'crowdfundly_manage_reports'    => true,
                    'crowdfundly_manage_payments'   => false,
                ]
            ]
        ];
        return $roles;
    }

    public static function get_cf_users()
    {
        $user_list = [];
        $users = get_users( [
            'role__in' => [
                'crowdfundly_admin',
                'crowdfundly_manager',
            ]
        ] );
        if (  empty( $users ) ) return false;

        foreach ( $users as $user ) {
            $user_list[$user->ID] = [ 'name' => $user->display_name, 'role' => implode( ', ', $user->roles ) ];
        }
        return $user_list;
    }

    public function remove_user_role($wp_user_id)
    {
        $user = new \WP_User( $wp_user_id );
        if (  empty( $user ) ) return false;
        
        foreach ( $user->roles as $user_role ) {
            if ( isset( static::cf_roles()[$user_role] ) ) {
                foreach ( static::cf_roles()[$user_role]['capabilities'] as $cap => $value ) {
                    $user->remove_cap( $cap );
                }
                $user->remove_role( $user_role );
            }
        }
    }

    public static function add_user_role($user_id, $role)
    {
        $user = new \WP_User( $user_id );
        if (  empty( $user ) ) return false;

        $role = $user->add_role( $role );
        return true;
    }

    public static function add_cap($role, $cap, $grant = true)
    {
        $role = get_role( $role );
        $role->add_cap( $cap, $grant );
    }

    public static function add_caps($user_id, $caps)
    {
        $user = new \WP_User( $user_id );
        if (  empty( $user ) ) return false;

        foreach ( $caps as $key => $cap ) {
            $grant = $cap[1] == 1 ? true : false;
            $user->add_cap( $key, $grant );
        }
    }

    public static function remove_cap($role, $cap)
    {
        $role = get_role( $role );
        $role->remove_cap( $cap );
    }

    public static function get_cf_roles() {
        global $wp_roles;
		$wp_role_names = $wp_roles->get_names();
		$crowdfundly_roles = [];

		foreach ( $wp_role_names as $key => $role_name ) {
            if ( isset( static::cf_roles()[$key] ) ) {
                $crowdfundly_roles[$key] = $role_name;
            }
		}

		return $crowdfundly_roles;
	}

    public static function get_cf_caps($user_id)
    {
        $user = new \WP_User( $user_id );
        if ( ! $user || empty( $user ) ) return false;

        $user_caps = $user->get_role_caps();
        $admin_caps = self::cf_roles()['crowdfundly_admin']['capabilities'];
        $cap_list = [];
        
        foreach ( $admin_caps as $cap => $grant ) {
            if ( isset( $user_caps[$cap] ) ) {
                $cap_name = str_replace( 'crowdfundly_', '', $cap );
                $cap_name = ucfirst( str_replace( '_', ' ', $cap_name ) );
                $cap_list[$cap] = [ $cap_name, $user_caps[$cap]];
            }
        }

        return $cap_list;
    }

    public function cf_get_user_caps()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $user_id = esc_html( $_POST['user_id'] );
        $user_caps = self::get_cf_caps( $user_id );

        wp_send_json( $user_caps, 200 );
        wp_die();
    }

    public function cf_update_caps()
    {
        $security = check_ajax_referer( 'crowdfundly_admin_nonce', 'security' );
        if ( false == $security ) return;

        $user_id = esc_html( $_POST['user_id'] );
        $caps = stripslashes( $_POST['caps'] );
        $caps = filter_var_array( json_decode( $caps, true ) );

        $this->add_caps( $user_id, $caps );
        wp_send_json( [ 'message' => __( 'Capabilities Updated', 'crowdfundly' ) ], 200 );
        wp_die();
    }

    public static function has_cap($capability)
    {
        $user = \wp_get_current_user();
        return $user->has_cap( $capability );
    }

}
