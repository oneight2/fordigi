<?php

// load utility functions
require_once __DIR__ . '/src/functions.php';

// load composer autoloader
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Autoloader for Crowdfundly classes
 * 
 * @package crowdfundly
 * @author  Keramot UL Islam <sourav926>
 * @since   2.0.0
 */
spl_autoload_register( function ($class) {
    $arr = explode( "\\", $class );
    if ( count( $arr ) < 2 ) return;

    $root_prefix = 'Crowdfundly';
    $prefix = 'App';
    // if namespace root prefix is not Crowdfundly
    // and prefix is not App then return
    if ( $arr[0] != $root_prefix && $arr[1] != $prefix ) return;
    
    $class_name = array_slice( $arr, 2 );
    $file = __DIR__ . '/src/' . implode( '/', $class_name ) . '.php';
    if ( ! file_exists( $file ) ) return;
    
    require_once $file;
} );
