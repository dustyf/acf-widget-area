<?php
/*
Plugin Name: Advanced Custom Fields: Widget Area Field
Plugin URI: https://github.com/dustyf/acf-widget-area
Description: Adds a custom field allowing you to pick one of your widget areas (aka Sidebars) from WordPress
Version: 1.0.0
Author: Dustin Filippini
Author URI: http://dustyf.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class exists, only run code if it does not
if ( ! class_exists( 'acf_field_widget_area_plugin' ) ) {

	class acf_field_widget_area_plugin {
		/*
		*  Construct
		*
		*  @since: 1.0.0
		*/

		function __construct() {

			/**
			 * Setup some base variables for the plugin
			 */
			$this->basename       = plugin_basename( __FILE__ );
			$this->directory_path = plugin_dir_path( __FILE__ );
			$this->directory_url  = plugins_url( dirname( $this->basename ) );

			/**
			 * Load Textdomain
			 */
			load_plugin_textdomain( 'acf_widget_area', false, dirname( $this->basename ) . '/languages' );

			/**
			 * Make sure we have our requirements, and disable the plugin if we do not have them.
			 */
			add_action( 'admin_notices', array( $this, 'maybe_disable_plugin' ) );

			/**
			 * Add action for version 5
			 */
			add_action( 'acf/include_field_types', array( $this, 'include_field_type' ) );

			/**
			 * Add action for version 4
			 */
			add_action( 'acf/register_fields', array( $this, 'register_fields' ) );

		}

		/**
		 * Check that all plugin requirements are met
		 *
		 * @since  1.0.0
		 *
		 * @return bool
		 */
		public static function meets_requirements() {
			/**
			 * If the main acf class doesn't exist, our plugin won't work.
			 */
			if( ! class_exists( 'acf' ) ) {
				return false;
			}

			/**
			 * We have met all requirements
			 */
			return true;
		}

		/**
		 * Check if the plugin meets requirements and disable it if they are not present.
		 *
		 * @since 1.0.0
		 */
		public function maybe_disable_plugin() {

			if ( ! $this->meets_requirements() ) {
				// Display our error
				echo '<div id="message" class="error">';
				echo '<p>' . sprintf( __( 'ACF Widget Area is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'acf_widget_area' ), admin_url( 'plugins.php' ) ) . '</p>';
				echo '</div>';

				// Deactivate our plugin
				deactivate_plugins( $this->basename );
			}

		}

		/**
		 * Include field type for ACF v5
		 *
		 * @param $version
		 */
		function include_field_type( $version ) {

			include_once( $this->directory_path . '/widget-area-v5.php' );

		}

		/*
		*  register_fields
		*
		*  @since: 1.0.0
		*/

		function register_fields() {

			include_once( $this->directory_path . '/widget-area-v4.php' );

		}

	}

	new acf_field_widget_area_plugin();

}