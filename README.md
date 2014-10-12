Advanced Custom Fields: Widget Area Field
===============


Add-on to Advanced Custom Fields that allows you to pick a widget area to be displayed on a page as a custom field.

As of version 1.0, support for ACF v5 is included.


Compatibility
--

This add-on will work with:

* Advanced Custom Fields version 4 and up

Installation
--

This add-on can be treated as both a WP plugin and a theme include.

 * Plugin
   1. Install through the WordPress plugin repository
   2. Activate the plugin via the Plugins admin page

 * Plugin (Manual)
   1. Copy the 'acf-widget_area' folder into your plugins folder
   2. Activate the plugin via the Plugins admin page
 
 * Include
   1.	Copy the 'acf-widget_area' folder into your theme folder (can use sub folders).
   2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-widget_area.php file. You should also change my_register_fields function name to something unique.)

````php
add_action( 'acf/register_fields', 'my_register_fields' );

function my_register_fields() {
	include_once( 'acf-widget_area/acf-widget_area.php' );
}
````
