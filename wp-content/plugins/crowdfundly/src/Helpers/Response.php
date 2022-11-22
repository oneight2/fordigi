<?php

namespace Crowdfundly\App\Helpers;

/**
 * Helper class for HTTP response
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class Response
{
    private $response;

    public function __construct($response) {
        $this->response = $response;
        return $this;
    }

    public function dump($die = false) {
        $data = $this->response;
        if ( function_exists('dump') ) {
            if (  $die ) {
                dd($data);
            } else {
                dump($data);
            }
        } else {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }

        return $this;
    }

    public function body($decode = true)
    {
        if ( $decode ) {
            return json_decode( \wp_remote_retrieve_body( $this->response ), true );
        }
        return \wp_remote_retrieve_body( $this->response );
    }

    public function status_code()
    {
        return \wp_remote_retrieve_response_code( $this->response );
    }

    public function message()
    {
        return \wp_remote_retrieve_response_message( $this->response );
    }

    public function headers()
    {
        return \wp_remote_retrieve_headers( $this->response );
    }

}
