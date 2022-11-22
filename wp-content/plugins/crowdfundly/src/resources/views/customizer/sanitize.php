<?php

if ( ! function_exists( 'crowdfundly_sanitize_integer' ) ) {
	function crowdfundly_sanitize_integer( $input ) {
		return absint( $input );
	}
}

if ( ! function_exists( 'crowdfundly_sanitize_float' ) ) {
	function crowdfundly_sanitize_float( $input ) {
		return filter_var( $input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	}
}

if ( ! function_exists( 'crowdfundly_sanitize_choices' ) ) {
	function crowdfundly_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug
		$input = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'crowdfundly_sanitize_checkbox' ) ) {
	function crowdfundly_sanitize_checkbox( $input ) {
		if ( $input ) {
			$output = '1';
		} else {
			$output = false;
		}
		return $output;
	}
}

if ( ! function_exists( 'crowdfundly_sanitize_rgba' ) ) {
	function crowdfundly_sanitize_rgba( $color ) {
		if ( empty( $color ) || is_array( $color ) )
			return 'rgba(0,0,0,0)';

		if ( false === strpos( $color, 'rgba' ) ) {
			return sanitize_hex_color( $color );
		}

		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		return 'rgba('. $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
	}
}

if ( ! function_exists( 'crowdfundly_sanitize_select' ) ) {
	function crowdfundly_sanitize_select( $input, $setting ) {
		$input = sanitize_key($input);
		//get the list of possible select options 
		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
			
	}
}
