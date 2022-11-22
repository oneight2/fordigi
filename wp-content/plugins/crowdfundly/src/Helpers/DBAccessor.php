<?php

namespace Crowdfundly\App\Helpers;

/**
 * Helper class for options table interaction for crowdfundly.
 * 
 * @package     crowdfundly
 * @author      Keramot UL Islam <sourav926>
 * @since       2.0.0
 */
class DBAccessor
{
    /**
     * Get option from options table.
     *
     * @param string $key
     *
     * @return mixed|false
     */
    public static function get( $key = 'crowdfundly_settings' ) {
        return get_option( $key );
    }

    /**
     * Get option array item from options table.
     *
     * @param string $key
     * @param string $option_key
     *
     * @return mixed|false
     */
    public static function getItem($key, $option_key = 'crowdfundly_settings') {
        $data = self::get( $option_key );
        if ( empty( $data ) ) {
            return false;
        }

        return isset( $data[$key] ) ? $data[$key] : false;
    }

    /**
     * Add option in options table.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return boolean
     */
    public static function add( $key, $value) {
        $data = self::get( $key );
        if ( ! $data ) {
            return add_option( $key, $value );
        }

        return update_option( $key, $value );
    }

    /**
     * Add option array item in options table.
     *
     * @param string $subject
     * @param string $key
     * @param mixed $value
     *
     * @return boolean
     */
    public static function addItem( $subject, $key, $value) {
        $data = self::get( $subject );
        if ( ! $data ) return false;

        $data[$key] = $value;
        return update_option( $subject, $data );
    }

    /**
     * Update option in options table.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return boolean
     */
    public static function update( $key, $value) {
        return update_option( $key, $value );
    }

    /**
     * Update option array item in options table.
     *
     * @param string $subject
     * @param string $key
     * @param mixed $value
     *
     * @return boolean
     */
    public static function updateItem( $subject, $key, $value) {
        $data = self::get( $subject );
        if ( ! $data ) {
            return false;
        }

        if ( ! isset( $data[$key] ) ) {
            return false;
        }
        $data[$key] = $value;
        return update_option( $subject, $data );
    }

    /**
     * Delete option from options table.
     *
     * @param string $key
     *
     * @return boolean
     */
    public static function remove( $key ) {
        return delete_option( $key );
    }

    /**
     * Check crowdfundly user is logged in.
     * Checking user organization and token.
     *
     * @return boolean
     */
    public static function is_login() {
        $data = self::get();
        return isset( $data['organization'] ) && isset( $data['token'] ) ? true : false;
    }

}
