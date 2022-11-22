<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Controllers\AdminNoticeController;
use Crowdfundly\App\Controllers\AuthenticationController;
use Crowdfundly\App\Controllers\CacheController;
use Crowdfundly\App\Controllers\CustomizerController;
use Crowdfundly\App\Controllers\OrganizationController;
use Crowdfundly\App\Controllers\TeamController;
use Crowdfundly\App\Controllers\VersionCompatibilityController;
use Crowdfundly\App\Controllers\IntegrationController;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Admin Service Provider
 * It registers admin panel functionalities.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class AdminServiceProvider implements Provider
{
    use Singleton;

    public function register()
    {
        (new VersionCompatibilityController)->register();
        (new AuthenticationController)->register();
        (new TeamController)->register();
        (new CustomizerController)->register();
        (new OrganizationController)->register();
        (new IntegrationController)->register();
        (new CacheController)->register();
        AdminNoticeController::getInstance()->register();
    }
}
