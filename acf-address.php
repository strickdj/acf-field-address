<?php

/*
Plugin Name: Advanced Custom Fields: Address
Plugin URI: https://github.com/strickdj/acf-field-address
Description: An Advanced Custom Field for working with address information.
Version: 5.1.0
Author: Daris Strickland
Author URI: http://daris-strickland.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('ACF_ADDRESS_PLUGIN_PATH', plugin_dir_path(__FILE__) . 'src/app/plugins/acf-address/');
define('ACF_ADDRESS_PLUGIN_URL', plugins_url('', __FILE__) . '/src/app/plugins/acf-address');

require "src/app/plugins/acf-address/bootstrap.php";
