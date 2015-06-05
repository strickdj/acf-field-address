<?php

/*
Plugin Name: Advanced Custom Fields: Address
Plugin URI: https://github.com/strickdj/acf-field-address
Description: A field to hold an address street, city, state
Version: 5.0.4
Author: Daris Strickland
Author URI: https://github.com/strickdj/acf-field-address
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-address', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_address( $version ) {
	include_once( 'acf-address-v5.php' );
}

add_action( 'acf/include_field_types', 'include_field_types_address' );

// 3. Include field type for ACF4
function register_fields_address() {
	include_once( 'acf-address-v4.php' );
}

add_action( 'acf/register_fields', 'register_fields_address' );
