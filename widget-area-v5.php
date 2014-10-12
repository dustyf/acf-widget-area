<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class exists, only run code if it does not
if ( ! class_exists( 'acf_5_field_widget_area' ) ) {

	class acf_5_field_widget_area extends acf_field {


		/**
		 *  Set everything up
		 */

		function __construct() {

			/**
			 * Name of field
			 */
			$this->name = 'widget_area';

			/**
			 *  label visible when selecting a field type
			 */
			$this->label = __( 'Widget Area', 'acf_widget_area' );

			/**
			 *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			 */
			$this->category = 'content';

			/**
			 *  defaults (array) Array of default settings which are merged into the field object.
			 */
			$this->defaults = array();

			/**
			 *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
			 *  var message = acf._e('FIELD_NAME', 'error');
			 */
			$this->l10n = array();

			// do not delete!
			parent::__construct();

		}


		/**
		 *  Create extra settings for your field. These are visible when editing a field
		 *
		 *  @param	$field (array) the $field being edited
		 *  @return	n/a
		 */
		function render_field_settings( $field ) {

			$field = array_merge( $this->defaults, $field );

			$key = $field['name'];

			acf_render_field_setting( $field, array(
				'label'        => __( "Allow Null?", 'acf' ),
				'type'         => 'radio',
				'name'         => 'allow_null',
				'choices' => array(
					1 => __( "Yes", 'acf' ),
					0 => __( "No", 'acf' ),
				),
				'layout'  => 'horizontal',
			) );

			acf_render_field_setting( $field, array(
				'label'        => __( "Display Widget Area HTML or Return Widget Area Name", 'acf_widget_area' ),
				'type'         => 'radio',
				'name'         => 'display_or_return',
				'choices' => array(
					'display' => __( "Display Widget Area HTML", 'acf_widget_area' ),
					'return'  => __( "Return Widget Name", 'acf_widget_area' ),
				),
				'layout'  => 'horizontal',
			) );

		}


		/**
		 *  Create the HTML interface for your field
		 *
		 *  @param	$field (array) the $field being rendered
		 *
		 *  @param	$field (array) the $field being edited
		 *  @return	n/a
		 */

		function render_field( $field ) {

			// create Field HTML
			echo sprintf( '<select id="%d" class="%s" name="%s">', esc_attr( $field['id'] ), esc_attr( $field['class'] ), esc_attr( $field['name'] ) );

			// null
			if ( $field['allow_null'] ) {
				echo '<option value="null">' . _x( '- Select - ','ACF Widget Area Null Select Option', 'acf_widget_area' ) . '</option>';
			}

			global $wp_registered_sidebars;
			$i = 0;
			foreach ( $wp_registered_sidebars as $registered_sidebar ) {
				$widget_areas[ $i ]['id']   = $registered_sidebar['id'];
				$widget_areas[ $i ]['name'] = $registered_sidebar['name'];
				$i ++;
			}

			foreach ( $widget_areas as $widget_area ) {
				$selected = selected( $field['value'], $widget_area['id'] );
				echo sprintf( '<option value="%1$s" %3$s>%2$s</option>', esc_attr( $widget_area['id'] ), esc_attr( $widget_area['name'] ), $selected );
			}

			echo '</select>';

		}

		/**
		 *
		 *  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
		 *
		 *  @param	$value (mixed) the value which was loaded from the database
		 *  @param	$post_id (mixed) the $post_id from which the value was loaded
		 *  @param	$field (array) the field array holding all the field options
		 *
		 *  @return string The HTML value of the sidebar.
		 */
		function format_value( $value, $post_id, $field ) {

			// bail early if no value
			if( empty($value) ) {
				return $value;
			}

			// If selected to return the name, we will do that now.
			if ( 'return' == $field['display_or_return'] ) {
				return esc_attr( $value );
			}


			ob_start();
			if ( is_active_sidebar( $value ) ) :
				echo '<div id="' . esc_attr( $field['id'] ) . '" class="acf-widget-area ' . esc_attr( $field['name'] ) . '" role="complementary">';
				dynamic_sidebar( $value );
				echo '</div>';
			endif;

			return ob_get_clean();

		}

	}

	// create field
	new acf_5_field_widget_area();

}