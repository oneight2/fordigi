<?php
/**
 * @package crowdfundly
 *
 * Plugin Name: Crowdfundly
 * Plugin URI: https://crowdfundly.com/
 * Description: All-in-one digital crowdfunding solution. Build your own crowdfunding platform to raise money for any purpose.
 * Version: 2.2.1
 * Author: Crowdfundly
 * Author URI: https://crowdfundly.com/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt 
 * Text Domain: crowdfundly
 */
require_once __DIR__ . '/autoload.php';

use Crowdfundly\App\Providers\CrowdfundlyServiceProvider;

if ( ! defined( 'ABSPATH' ) ) die();

define( 'CROWDFUNDLY', 'crowdfundly' );
define( 'CROWDFUNDLY_VERSION', '2.2.1' );
define( 'CROWDFUNDLY_FILE', __FILE__ );
define( 'CROWDFUNDLY_DIR_PATH', plugin_dir_path( CROWDFUNDLY_FILE ) );
define( 'CROWDFUNDLY_PLUGIN_URL', plugins_url( '/', CROWDFUNDLY_FILE ) );
define( 'CROWDFUNDLY_URL', 'https://crowdfundly.com/' );
define( 'CROWDFUNDLY_API', 'https://api.crowdfundly.com/' );

// let's spread Happiness
CrowdfundlyServiceProvider::getInstance()->register();
