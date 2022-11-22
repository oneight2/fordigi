<?php

namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;

/**
 * Plugin previous version compatibility Controller
 * Provides functionality for plugin's previous version compatibility.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class VersionCompatibilityController extends BaseController
{
    public function register()
    {
        $this->compatibility_v200();
    }

    /**
     * Compatibility for plugin version 2.0.0
     *
     * @return void
     */
    private function compatibility_v200()
    {
        $data = DBAccessor::get();
        if ( isset( $data['crowdfundly_option_api_key'] ) || isset( $data['chabi'] ) ) {
            ActivationController::add_administrator_caps();
            $this->add_roles();
            DBAccessor::remove( 'crowdfundly_settings' );   // logout
            $this->login($data);  // login with old data and new data structure
        }
    }

    /**
     * Login again while updating the plugin with new data structure
     * 
     * @param array $data
     * @return void
     */
    private function login($data)
    {
        if ( isset( $data['crowdfundly_option_api_key'] ) ) {
            (new AuthenticationController)->appkey_login( $data['crowdfundly_option_api_key'] );
        }

        if ( isset( $data['chabi'] ) ) {
            $login_data = [
                'email'     => $data['email'],
                'password'  => AuthenticationController::encrypt_decrypt( 'decrypt', $data['chabi'] ),
                'type'      => 'regular'
            ];
            $org_list = (new AuthenticationController)->email_login( $login_data );
            if ( isset( $org_list['org_list'] ) && ! empty( $org_list['org_list'] ) ) {
                $this->set_organization( $org_list['org_list'][0]['username'] );
            }
        }
    }

    private function set_organization($username)
    {
        $user = (new AuthenticationController)->get_user_data( DBAccessor::getItem('token') );
        if ( $user->status_code() !== 200 ) return;

        $user_data = $user->body();
        $org = null;
        foreach (  $user_data['organizations'] as $org ) {
            if ( $org['username'] == $username ) {
                $org = $org;
                break;
            }
        }
        DBAccessor::addItem( 'crowdfundly_settings', 'organization', $org );    // org data added in db
        update_option( 'crowdfundly_url_update', false ); 
    }

    /**
     * Add cf roles while updating the plugin
     *
     * @return void
     */
    private function add_roles()
    {
        if ( get_role( 'crowdfundly_admin' ) && get_role( 'crowdfundly_manager' ) ) {
            return;
        }

        $cf_roles = TeamController::cf_roles();
        foreach ( $cf_roles as $key => $role ) {
            add_role( $key, $role['name'], $role['capabilities'] );
        }
    }
}
