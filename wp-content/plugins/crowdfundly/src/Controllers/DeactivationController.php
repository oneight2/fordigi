<?php

namespace Crowdfundly\App\Controllers;

/**
 * Plugin Deactivation Controller
 * Provides functionality for plugin deactivation event.
 *
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */

class DeactivationController extends BaseController
{
    public static function deactivate()
    {
        update_option( 'crowdfundly_url_update', false );
        delete_option( 'crowdfundly_settings' );
    }
}
