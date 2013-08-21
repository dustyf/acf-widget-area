=== Advanced Custom Fields: Widget Area Field ===
Contributors: dustyf
Tags: advanced custom fields, acf, custom fields, widget, widgets, sidebar, sidebars, widget areas
Requires at least: 3.4
Tested up to: 3.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add-on to Advanced custom fields giving you a field to display Widget Areas.

== Description ==



= Compatibility =

This add-on will work with:

* Advanced Custom Fiedls version 4 and up

== Installation ==

This add-on can be treated as both a WP plugin and a theme include.

= Plugin =
1. Install through the WordPress plugin repository
2. Activate the plugin via the Plugins admin page

= Plugin (Manual) =
1. Copy the 'acf-widget_area' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1.	Copy the 'acf-widget_area' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.	Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-widget_area.php file)

`
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('acf-widget_area/acf-widget_area.php');
}
`

== Changelog ==

= 0.0.1 =
* Initial Release.
