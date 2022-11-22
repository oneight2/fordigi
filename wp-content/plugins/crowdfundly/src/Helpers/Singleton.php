<?php

namespace Crowdfundly\App\Helpers;

/**
 * Singleton trait.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.7
 */
trait Singleton
{
	private static $instance = null;

    public static function getInstance()
    {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
