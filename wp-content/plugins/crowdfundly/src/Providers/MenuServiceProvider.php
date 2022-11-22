<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Controllers\DashboardController;
use Crowdfundly\App\Controllers\TeamController;
use Crowdfundly\App\Helpers\DBAccessor;
use Crowdfundly\App\Helpers\Menu;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Menu Service Provider
 * It registers all the dashboard menu and submenu items.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>, Nazmul
 * @since       2.0.0
 */
class MenuServiceProvider implements Provider
{
    use Singleton;

    /**
     * Dynamic WP admin menus for crowdfundly.
     * 
     * 5 types of menu:
     *  i. Login menus
     *  ii. After Sign up menus
     *  iii. After email login, user has organization menus
     *  iv. After email login, user has no organization menus
     *  v. Logout menus
     *
     * @return void
     */
    public function register()
    {
        if ( DBAccessor::is_login() ) {
            // after login menus
            add_action( 'admin_menu', [ $this, 'login_menu' ] );
        } elseif ( DBAccessor::get() && ! DBAccessor::getItem( 'organization' ) ) {
            // user is logged in but not have any organization stored in DB.

            if ( DBAccessor::getItem( 'temp_login' ) ) {
                // after sign up menus
                add_action( 'admin_menu', [ $this, 'partially_login' ] );
            } elseif ( ! DBAccessor::getItem( 'temp_login' ) && DBAccessor::getItem( 'select_org' ) ) {
                // after email login, user has organization but not selected any organization.
                add_action( 'admin_menu', [ $this, 'select_organization' ] );
            } else {
                // after email login, user doesn't have organization.
                add_action( 'admin_menu', [ $this, 'partially_login' ] );
            }
        } else {
            // after logout menus
            add_action( 'admin_menu', [ $this, 'logout_menu' ] );
        }
    }

    public function logout_menu()
    {
        Menu::make(__('Crowdfundly', 'crowdfundly'))
            ->slug('admin')
            ->icon(cf_asset('images/icons/crowdfundly_grey_icon.png'))
            ->permission('crowdfundly_menu_access')
            ->view(DashboardController::class, 'welcome')
            ->children([
                Menu::make(__('App Key Login', 'crowdfundly'))
                    ->slug('appkey-login')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'appkey_login'),
                Menu::make(__('Email Login'))
                    ->slug('email-login')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'email_login'),
                // Menu::make(__( 'Select Organization', 'crowdfundly' ))
                //     ->slug('select-organization')
                //     ->permission('crowdfundly_menu_access')
                //     ->hide()
                //     ->view(DashboardController::class, 'select_organization'),
                Menu::make(__( 'Sign Up', 'crowdfundly' ))
                    ->slug('signup')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'signup'),
                // Menu::make(__('Package', 'crowdfundly' ))
                //     ->slug('package')
                //     ->permission('crowdfundly_menu_access')
                //     ->hide()
                //     ->view(DashboardController::class, 'package'),
                // Menu::make(__( 'Create organization', 'crowdfundly' ))
                //     ->slug('organization-create')
                //     ->permission('crowdfundly_menu_access')
                //     ->hide()
                //     ->view(DashboardController::class, 'create_organization'),
            ])
            ->render();
    }

    /**
     * User is login but don't have any organization
     * or didn't buy any package.
     * 
     * @return void
     */
    public function partially_login()
    {
        Menu::make(__('Crowdfundly', 'crowdfundly'))
            ->slug('admin')
            ->icon(cf_asset('images/icons/crowdfundly_grey_icon.png'))
            ->permission('crowdfundly_menu_access')
            ->view(DashboardController::class, 'create_organization')
            ->children([
                Menu::make(__('Package', 'crowdfundly' ))
                    ->slug('package')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'package'),
                Menu::make(__( 'Create organization', 'crowdfundly' ))
                    ->slug('organization-create')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'create_organization'),
            ])
            ->render();
    }

    /**
     * User is login in.
     * 
     * @return void
     */
    public function login_menu()
    {
        Menu::make(__('Crowdfundly', 'crowdfundly'))
            ->slug('admin')
            ->icon(cf_asset('images/icons/crowdfundly_grey_icon.png'))
            ->permission('crowdfundly_menu_access')
            ->view(DashboardController::class, 'login_dashboard')
            ->children([
                Menu::make(__('Dashboard', 'crowdfundly'))
                    ->slug('dashboard')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'login_dashboard'),
                Menu::make(__('Campaigns', 'crowdfundly'))
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'campaigns'),
                Menu::make(__('Online Contributions', 'crowdfundly'))
                    ->slug('online-contributions')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'online_contributions'),
                Menu::make(__('Offline Contributions', 'crowdfundly'))
                    ->slug('offline-contributions')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'offline_contributions'),
                // Menu::make(__('Wallet', 'crowdfundly'))
                //     ->slug('wallet-payment')
                //     ->permission('crowdfundly_manage_payments')
                //     ->view(DashboardController::class, 'wallet_payment'),
                // Menu::make(__('Refunds', 'crowdfundly'))
                //     ->permission('crowdfundly_menu_access')
                //     ->view(DashboardController::class, 'refunds'),
                Menu::make(__('Team & Roles', 'crowdfundly'))
                    ->slug('team-roles')
                    ->permission('crowdfundly_manage_team')
                    ->view(TeamController::class, 'view'),
                // Menu::make(__('Reports', 'crowdfundly'))
                //     ->permission('crowdfundly_manage_reports')
                //     ->view(DashboardController::class, 'reports'),
                Menu::make('APPkey')
                    ->slug('appkey-login')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'appkey_login'),
                Menu::make('New Campaign')
                    ->slug('new-campaign')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'new_campaign'),
                Menu::make('Campaign Edit')
                    ->slug('campaign-edit')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'campaign_edit'),
                Menu::make('Campaign Online Contributions')
                    ->slug('campaign-online-contributions')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'campaign_online_contributions'),
                Menu::make('Campaign Offline Contributions')
                    ->slug('campaign-offline-contributions')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'campaign_offline_contributions'),
                Menu::make('Campaign Updates')
                    ->slug('campaign-updates')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'campaign_updates'),
                Menu::make('Campaign Endorsements')
                    ->slug('campaign-endorsements')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'campaign_endorsements'),
                Menu::make('Campaign Presets')
                    ->slug('campaign-presets')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'campaign_presets'),
                Menu::make(__('Settings', 'crowdfundly'))
                    ->slug('settings-basic')
                    ->permission('crowdfundly_manage_settings')
                    ->view(DashboardController::class, 'settings_basic'),
                Menu::make('Settings / Payment')
                    ->slug('settings-payment')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'settings_payment'),
                Menu::make('Settings / Media')
                     ->slug('settings-media')
                     ->permission('crowdfundly_manage_settings') 
                     ->hide()
                     ->view(DashboardController::class,'settings_media'),
                // Menu::make('Settings / Custom Email')
                //      ->slug('settings-custom-email')
                //      ->permission('crowdfundly_menu_access') 
                //      ->hide()
                //      ->view(DashboardController::class,'settings_custom_email'),
                Menu::make('Settings / Theme')
                     ->slug('settings-theme')
                     ->permission('crowdfundly_manage_settings') 
                     ->hide()
                     ->view(DashboardController::class,'settings_theme'),
                Menu::make('Settings / Social')
                     ->slug('settings-social')
                     ->permission('crowdfundly_manage_settings') 
                     ->hide()
                     ->view(DashboardController::class,'settings_social'),
                Menu::make('Settings / Integration')
                     ->slug('settings-integration')
                     ->permission('crowdfundly_manage_settings') 
                     ->hide()
                     ->view(DashboardController::class,'settings_integration'),
            ])
            ->render();
    }

    /**
     * User is login in with email and has organizatoin.
     * 
     * @return void
     */
    public function select_organization()
    {
        Menu::make(__('Crowdfundly', 'crowdfundly'))
            ->slug('admin')
            ->icon(cf_asset('images/icons/crowdfundly_grey_icon.png'))
            ->permission('crowdfundly_menu_access')
            ->view(DashboardController::class, 'select_organization')
            ->children([
                Menu::make(__('Email Login'))
                    ->slug('email-login')
                    ->permission('crowdfundly_menu_access')
                    ->hide()
                    ->view(DashboardController::class, 'select_organization'),
                Menu::make(__('Select Organization', 'crowdfundly' ))
                    ->slug('select-organization')
                    ->permission('crowdfundly_menu_access')
                    ->view(DashboardController::class, 'select_organization'),
            ])
            ->render();
    }

}
