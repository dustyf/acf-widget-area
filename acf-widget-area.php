<?php
/*
Plugin Name: Advanced Custom Fields: Widget Area Field
Plugin URI: https://github.com/dustyf/acf-widget-area
Description: Adds a custom field allowing you to pick one of your widget areas (aka Sidebars) from WordPress
Version: 0.0.1
Author: Dustin Filippini
Author URI: http://dustyf.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class acf_field_widget_area_plugin
{
	/*
	*  Construct
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function __construct()
	{
		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));
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
		include_once('widget-area-v4.php');
	}

}

new acf_field_widget_area_plugin();
