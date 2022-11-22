<?php

namespace Crowdfundly\App\Helpers;

/**
 * Helper class for bulk sanitization.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926> 
 * @since       2.0.5
 */
class Sanitizer
{
    public static function sanitize($data, $args)
    {
        $sanitized = [];
        foreach ($data as $key => $val) {
            if ( ! isset( $args[$key] ) ) continue;
            
            if ($args[$key] == 'email') {
                $sanitized[$key] = sanitize_email($val);
            } elseif ($args[$key] == 'url') {
                $sanitized[$key] = esc_url($val);
            } elseif ($args[$key] == 'text') {
                $sanitized[$key] = sanitize_text_field($val);
            } elseif ($args[$key] == 'int') {
                $sanitized[$key] = absint($val);
            } elseif ($args[$key] == 'float') {
                $sanitized[$key] = floatval($val);
            } elseif ($args[$key] == 'bool') {
                $sanitized[$key] = (bool) $val;
            } elseif ($args[$key] == 'array') {
                $sanitized[$key] = (array) $val;
            } elseif ($args[$key] == 'html') {
                $sanitized[$key] = esc_html($val);
            } elseif ($args[$key] == 'allowed_html') {
                $sanitized[$key] = wp_kses_post($val);
            } elseif ($args[$key] == 'html_array') {
                $sanitized[$key] = wp_kses_post_deep($val);
            } else {
                $sanitized[$key] = $val;
            }
        }
        return $sanitized;
    }

}
