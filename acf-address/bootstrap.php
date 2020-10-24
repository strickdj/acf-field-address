<?php

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
