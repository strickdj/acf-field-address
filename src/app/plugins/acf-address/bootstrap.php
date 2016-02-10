<?php

require 'ACFAddressPluginHelper.php';

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


add_action('plugins_loaded', function() {

  // todo pass pristine $_POST into plugin...

  $PRISTINE_POST = $_POST;



});


// todo add endpoint for address field data.

add_action( 'wp_ajax_get_acf_address_data', 'get_acf_address_data' );

function get_acf_address_data() {

  $defaults = [
    'success' => true
  ];

  if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

    echo json_encode($defaults);
  }


  die();
}
