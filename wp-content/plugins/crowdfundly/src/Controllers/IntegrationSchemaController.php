<?php
namespace Crowdfundly\App\Controllers;

use Crowdfundly\App\Helpers\DBAccessor;

/**
 * Integration schema Controller
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.8
 */
class IntegrationSchemaController extends BaseController
{
    public function register()
    {
    }

    public static function get_schema()
    {
        $schema = file_get_contents( CROWDFUNDLY_DIR_PATH . 'integration.json' );
        return json_decode( $schema, true );
    }

    public static function get_brand_events($brand_name)
    {
        $schema = self::get_schema();
        $events = false;
        foreach ($schema as $event) {
            if ( $event['codeName'] == $brand_name ) {
                $events = $event['handlers'];
                break;
            }
        }
        return $events;
    }

    public static function module_status($schema)
    {
        $status = [ 'status' => false, 'message' => '' ];
        if ( ! IntegrationController::status() ) {
            return $status;
        }

        $root_path = ABSPATH . "wp-content/plugins/";
        if ( isset( $schema['pluginPath'] ) && ! file_exists( $root_path . $schema['pluginPath'] ) ) {
            $status['message'] = __( 'Not Installed', 'crowdfundly' );
            return $status;
        }
        if ( isset( $schema['isActive'] ) ) {
            $is_active = $schema['isActive'];
            if ( isset( $is_active['constant'] ) && ! defined( $is_active['constant'] ) ) {
                $status['message'] = __( 'Not Active', 'crowdfundly' );
                return $status;
            } elseif ( isset( $is_active['class'] ) && ! class_exists( $is_active['class'] ) ) {
                $status['message'] = __( 'Not Active', 'crowdfundly' );
                return $status;
            }
        }

        $handlers = DBAccessor::getItem( 'integration_handlers', 'crowdfundly_integration' );
        $events = static::get_brand_events( $schema['codeName'] );
        if ( $events ) {
            foreach ( $events as $event ) {
                $handler = array_key_first( $event );
                if ( isset( $handlers[$handler] ) && $handlers[$handler] ) {
                    $status['status'] = true;
                    $status['message'] = __( 'Integrated', 'crowdfundly' );
                    return $status;
                }
            }
        }

        $status['status'] = true;
        return $status;
    }
}
