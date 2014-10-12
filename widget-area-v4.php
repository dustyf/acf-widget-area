<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class exists, only run code if it does not
if ( ! class_exists( 'acf_field_widget_area' ) ) {

	class acf_field_widget_area extends acf_field {

		// vars
		var $settings, // will hold info such as dir / path
			$defaults; // will hold default field options


		/**
		 *  Setting everything up
		 *
		 *  @since	3.6
		 */
		function __construct() {

			// vars
			$this->name     = 'widget_area';
			$this->label    = __( 'Widget Area', 'acf_widget_area' );
			$this->category = __( 'Content', 'acf' ); // Basic, Content, Choice, etc
			$this->defaults = array(
				'allow_null' => 0,
			);

			// do not delete!
			parent::__construct();

			// settings
			$this->settings = array(
				'path'    => apply_filters( 'acf/helpers/get_path', __FILE__ ),
				'dir'     => apply_filters( 'acf/helpers/get_dir', __FILE__ ),
				'version' => '1.0.0'
			);

		}


		/**
		 *  Create extra options for your field. This is rendered when editing a field.
		 *  The value of $field['name'] can be used (like bellow) to save extra data to the $field
		 *
		 *  @param	$field	- an array holding all the field's data
		 */
		function create_options( $field ) {

			// defaults?
			$field = array_merge( $this->defaults, $field );

			// key is needed in the field names to correctly save the data
			$key = $field['name'];


			// Create Field Options HTML
			?>
			<tr class="field_option field_option_<?php echo esc_attr( $this->name ); ?>">
				<td class="label">
					<label><?php _e( "Allow Null?", 'acf' ); ?></label>
				</td>
				<td>
					<?php
					do_action( 'acf/create_field', array(
						'type'    => 'radio',
						'name'    => 'fields[' . $key . '][allow_null]',
						'value'   => isset( $field['allow_null'] ) ? $field['allow_null'] : 0,
						'choices' => array(
							1 => __( "Yes", 'acf' ),
							0 => __( "No", 'acf' ),
						),
						'layout'  => 'horizontal',
					) );
					?>
				</td>
			</tr>
			<tr class="field_option field_option_<?php echo esc_attr( $this->name ); ?>">
				<td class="label">
					<label><?php _e( "Display Widget Area HTML or Return Widget Area Name", 'acf_widget_area' ); ?></label>
				</td>
				<td>
					<?php
					do_action( 'acf/create_field', array(
						'type'    => 'radio',
						'name'    => 'fields[' . $key . '][display_or_return]',
						'value'   => isset( $field['display_or_return'] ) ? esc_attr( $field['display_or_return'] ) : 'display',
						'choices' => array(
							'display' => __( "Display Widget Area HTML", 'acf_widget_area' ),
							'return'  => __( "Return Widget Name", 'acf_widget_area' ),
						),
						'layout'  => 'horizontal',
					) );
					?>
				</td>
			</tr>
			<?php

		}


		/**
		 *  Create the HTML interface for your field
		 *
		 *  @param	$field - an array holding all the field's data
		 */

		function create_field( $field ) {

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
		 *  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
		 *
		 *  @param	$value	- the value which was loaded from the database
		 *  @param	$post_id - the $post_id from which the value was loaded
		 *  @param	$field	- the field array holding all the field options
		 *
		 *  @return string The HTML value of the sidebar.
		 */
		function format_value_for_api( $value, $post_id, $field ) {

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
	new acf_field_widget_area();

}