<?php

namespace Crowdfundly\App\Controllers;

/**
 * Base Controller.
 * 
 * @package     crowdfundly
 * @author      Nazmul, Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class BaseController
{
    public function render( $file_path, $data = [], $buffer = false )
    {
        if ( ! $buffer ) {
            return cf_loadViewTemplate($file_path, $data);
        }
        ob_start();
        cf_loadViewTemplate($file_path, $data);
        return ob_get_clean();
    }
}
