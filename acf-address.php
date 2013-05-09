<?php
/*
Plugin Name: Advanced Custom Fields: address
Plugin URI: https://github.com/strickdj/acf-address
Description: Adds an address field type
Version: 4.0.0
Author: Daris Strickland
Author URI: https://github.com/strickdj/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class acf_field_address_plugin
{
	/*
	*  Construct
	*
	*  @description: 
	*  @since: 4.0
	*  @created: 05/09/13
	*/
	
	function __construct()
	{
		// set text domain
		/*
		$domain = 'acf-address';
		$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		load_textdomain( $domain, $mofile );
		*/
		
		
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));	

		
		// version 3-
		add_action( 'init', array( $this, 'init' ));
	}
	
	
	/*
	*  Init
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function init()
	{
		if(function_exists('register_field'))
		{ 
			register_field('acf_field_address', dirname(__File__) . '/address-v3.php');
		}
	}
	
	/*
	*  register_fields
	*
	*  @description: 
	*  @since: 3.6
	*  @created: 1/04/13
	*/
	
	function register_fields()
	{
		include_once('address-v4.php');
	}
	
}

new acf_field_address_plugin();
		
?>
