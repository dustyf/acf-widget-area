=== Advanced Custom Fields: Widget Area Field ===
Contributors: dustyf
Donate Link: http://dustyf.com/donate
Tags: advanced custom fields, acf, custom fields, widget, widgets, sidebar, sidebars, widget areas
Requires at least: 3.4
Tested up to: 3.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add-on to Advanced custom fields giving you a field to display Widget Areas.

== Description ==

Easily add and change Widget Areas on any page template using Advanced Custom Fields and the Advanced Custom Fields: Widget Area Field plugin.  This plugin will add a field with a drop-down selection of all registered Widget Areas in your WordPress installation.  You can select which widget area you would like to display in your template files when using ACF's get_field and the_field functions.

= This Plugin Requires Advanced Custom Fields Version 4 or Higher =

Advanced Custom Fields can be found in the [WordPress Plugin Repository Here](http://wordpress.org/plugins/advanced-custom-fields/).

= Compatibility =

This add-on will work with:

* Advanced Custom Fields version 4 and up

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

== Frequently Asked Questions ==

= How does this work? =

For this plugin to work, you need to have the [Advanced Custom Fields](http://wordpress.org/plugins/advanced-custom-fields/) Plugin installed.  Once installed, you will be able to select a Widget Area as one of your custom fields.

= How do I add new Widget Areas? =

The WordPress Codex has an article on [Widgetizing Themes](http://codex.wordpress.org/Widgetizing_Themes) which includes "How to Register a Widget Area".  If you add a new Widget Area (also called sidebar) with this method it will be available in Appearance > Widgets and also able to be selected in your new Widget Area Field.

= How do I display my Widget Area Field? =

The Advanced Custom Fields website has documentation on [displaying custom field values](http://www.advancedcustomfields.com/resources/getting-started/displaying-custom-field-values-in-your-theme/).

== Screenshots ==

Currently not available.

== Changelog ==

= 0.0.1 =
* Initial Release.
