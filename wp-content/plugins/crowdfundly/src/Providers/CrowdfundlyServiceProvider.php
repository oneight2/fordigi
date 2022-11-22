<?php

namespace Crowdfundly\App\Providers;

use Crowdfundly\App\Providers\Provider;
use Crowdfundly\App\Helpers\Singleton;

/**
 * Main Service Provider that registers all the services
 * 
 * @package     crowdfundly
 * @author      Nazmul, Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
final class CrowdfundlyServiceProvider implements Provider
{
    use Singleton;

    /**
     * Get a list of all service providers
     */
    protected function providers()
    {
        return [
            EventListenerServiceProvider::class,
            MenuServiceProvider::class,
            AdminServiceProvider::class,
            AssetServiceProvider::class,
            PublicServiceProvider::class,
            RestApiServiceProvider::class,
        ];
    }

    /**
     * Bootstrap Crowdfundly
     */
    public function register()
    {
        foreach ( $this->providers() as $class ) {
            $class::getInstance()->register();
        }
    }
}
