<?php

namespace Crowdfundly\App\Controllers;

/**
 * Dashboard Controller
 * Provides functionality for the dashboard pages.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class DashboardController extends BaseController
{
    /**
     * User is not logged in.
     *
     * @return void
     */
    public function welcome()
    {
        $this->render( 'admin/general/welcome.php' );
    }

    /**
     * user don't have any credentials.
     * Signup page.
     *
     * @return void
     */
    public function signup()
    {
        $this->render('admin/auth/signup.php');
    }

    /**
     * user is logged in and doesn't have package.
     * Token is stored in db.
     *
     * @return void
     */
    public function package()
    {
        $this->render('admin/auth/package/index.php');
    }

    /**
     * The user is logged in.
     * Token is stored in db but doesn't have package or organization
     *
     * if don't have package then redirect to package page from create.php frontend js
     *
     * @return void
     */
    public function create_organization()
    {
        $this->render('admin/organization/create.php');
    }

    /**
     * The user is not logged in.
     * App key login page.
     *
     * @return void
     */
    public function appkey_login()
    {
        $this->render('admin/auth/appkey-login.php');
    }

    /**
     * The user is not logged in
     * Email login page.
     *
     * @return void
     */
    public function email_login()
    {
        $this->render('admin/auth/email-login.php');
    }

    /**
     * user is logged in and has organization
     *
     * @return void
     */
    public function login_dashboard()
    {
        $this->render( 'admin/dashboard/index.php' );
    }

    public function campaigns()
    {
        $this->render('admin/dashboard/campaigns/index.php');
    }

    public function online_contributions()
    {
        $this->render('admin/dashboard/contributions/index.php');
    }

    public function offline_contributions()
    {
        $this->render('admin/dashboard/contributions/offline.php');
    }

    public function fundraisers()
    {
        $this->render('admin/dashboard/fundraisers/index.php');
    }

    public function refunds()
    {
        $this->render('admin/dashboard/refunds/index.php');
    }

    public function settings()
    {
        $this->render('admin/dashboard/settings/index.php');
    }

    // public function reports()
    // {
    //     $this->render('admin/dashboard/campaigns/reports.php');
    // }

    public function new_campaign()
    {
        $this->render('admin/organization/fundraise/new-campaign.php');
    }

    public function campaign_edit()
    {
        $this->render('admin/campaign/manage/edit.php');
    }

    public function campaign_online_contributions()
    {
        $this->render('admin/campaign/manage/online-contributions.php');
    }

    public function campaign_offline_contributions()
    {
        $this->render('admin/campaign/manage/offline-contributions.php');
    }

    public function campaign_updates()
    {
        $this->render('admin/campaign/manage/updates.php');
    }

    public function campaign_endorsements()
    {
        $this->render('admin/campaign/manage/endorsements.php');
    }

    public function campaign_presets()
    {
        $this->render('admin/campaign/manage/presets.php');
    }

    public function settings_basic()
    {
        $this->render('admin/dashboard/settings/index.php');
    }

    public function settings_payment()
    {
        $this->render('admin/dashboard/settings/payment.php');
    }

    public function settings_media()
    {
        $this->render('admin/dashboard/settings/media.php');
    }

    public function settings_custom_email()
    {
        $this->render('admin/dashboard/settings/custom-domain.php');
    }

    public function settings_theme()
    {
        $this->render('admin/dashboard/settings/theme.php');
    }

    public function settings_social()
    {
        $this->render('admin/dashboard/settings/social.php');
    }

    public function settings_integration()
    {
        $this->render('admin/dashboard/settings/integration.php');
    }

    public function select_organization()
    {
        $this->render('admin/organization/select_organization.php');
    }
}
