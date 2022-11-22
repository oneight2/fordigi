<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Controllers\AllCampaignController;
use Crowdfundly\App\Controllers\ElementorController;
use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\PageTemplateController;
use Crowdfundly\App\Controllers\SingleCampaignController;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Public Page Service Provider
 * Service provider for public pages (organization, all campaign, and single campaign).
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class PublicServiceProvider implements Provider
{
    use Singleton;

    public function register()
    {
        $this->create_shortcodes();

        (new PageTemplateController)->register();
        (new AllCampaignController)->register();
        (new SingleCampaignController)->register();
        (new ElementorController)->register();
    }

    public function create_shortcodes()
    {
        add_shortcode( 'crowdfundly-organization', array( $this, 'render_organization' ) );
        add_shortcode( 'crowdfundly-all-campaigns', array( $this, 'render_all_campaign' ) );
        add_shortcode( 'crowdfundly-campaign', array( $this, 'render_single_campaign' ) );
    }

    public function render_organization()
    {
        return (new OrganizationController)->renderView();
    }

    public function render_all_campaign()
    {
        return (new AllCampaignController)->renderView();
    }

    public function render_single_campaign()
    {
        return (new SingleCampaignController)->renderView();
    }
}
