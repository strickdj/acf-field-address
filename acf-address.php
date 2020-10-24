<?php

/*
Plugin Name: Advanced Custom Fields: Address
Plugin URI: https://github.com/strickdj/acf-field-address
Description: An Advanced Custom Field for working with address information.
Version: 6.0.0
Author: Daris Strickland
Author URI: https://daris-strickland.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

//define('ACF_ADDRESS_PLUGIN_PATH', plugin_dir_path(__FILE__) . 'src/app/plugins/acf-address/');
//define('ACF_ADDRESS_PLUGIN_URL', plugins_url('', __FILE__) . '/src/app/plugins/acf-address');

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// Plugin version.
if (!defined('S_ACFADDRESS_VERSION')) {
    define('S_ACFADDRESS_VERSION', '6.0.0');
}

// Plugin Folder Path.
if (!defined('S_ACFADDRESS_PLUGIN_DIR')) {
    define('S_ACFADDRESS_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

// Plugin Folder URL.
if (!defined('S_ACFADDRESS_PLUGIN_URL')) {
    define('S_ACFADDRESS_PLUGIN_URL', plugin_dir_url(__FILE__));
}

// Plugin Root File.
if (!defined('S_ACFADDRESS_PLUGIN_FILE')) {
    define('S_ACFADDRESS_PLUGIN_FILE', __FILE__);
}

// Plugin textdomain
if (!defined('S_ACFADDRESS_TEXT_DOMAIN')) {
    define('S_ACFADDRESS_TEXT_DOMAIN', 'wpgqlforms');
}

// Plugin autoload
if (!defined('S_ACFADDRESS_AUTOLOAD')) {
    define('S_ACFADDRESS_AUTOLOAD', true);
}


if (!function_exists('s_acfaddress_init')) {
    /**
     * Function that instantiates the plugins main class
     */
    function s_acfaddress_init()
    {
        /**
         * Include required files.
         * Uses composer's autoload
         */
        if ( defined( 'S_ACFADDRESS_AUTOLOAD' ) && true === S_ACFADDRESS_AUTOLOAD ) {
            require_once S_ACFADDRESS_PLUGIN_DIR . 'vendor/autoload.php';
        }

        $q = new \WPackio\Enqueue(
            'acfFieldAddress',
            'dist',
            S_ACFADDRESS_VERSION,
            'plugin',
            __FILE__
        );

        $enqueue = function() use($q) {
            $assets = $q->enqueue( 'foo', 'main', [
                'js' => true,
                'css' => true,
                'js_dep' => [],
                'css_dep' => [],
                'in_footer' => true,
                'media' => 'all',
            ] );

            $entry_point = array_pop( $assets['js'] );
            wp_localize_script( $entry_point['handle'], 'acfFieldAddress', [
                'foo' => 'bar'
            ] );
        };

        // Enqueue on user facing pages
        add_action( 'wp_enqueue_scripts', $enqueue );

        // Enqueue on admin facing pages
        add_action( 'admin_enqueue_scripts', $enqueue );

        return \Strickdj\AddressField\Plugin::instance();
    }
}

s_acfaddress_init();
