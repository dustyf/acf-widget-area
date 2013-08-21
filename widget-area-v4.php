<?php

class acf_field_widget_area extends acf_field
{
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options


	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct()
	{
		// vars
		$this->name = 'widget_area';
		$this->label = __('Widget Area');
		$this->category = __("Content",'acf'); // Basic, Content, Choice, etc
		$this->defaults = array(
			'allow_null' => 0
		);


		// do not delete!
    parent::__construct();


    // settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}


	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/

	function create_options($field)
	{
		// defaults?
		$field = array_merge($this->defaults, $field);

		// key is needed in the field names to correctly save the data
		$key = $field['name'];


		// Create Field Options HTML
		?>

		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e("Allow Null?",'acf'); ?></label>
			</td>
			<td>
				<?php 
				do_action('acf/create_field', array(
					'type'	=>	'radio',
					'name'	=>	'fields['.$key.'][allow_null]',
					'value'	=>	$field['allow_null'],
					'choices'	=>	array(
						1	=>	__("Yes",'acf'),
						0	=>	__("No",'acf'),
					),
					'layout'	=>	'horizontal',
				));
				?>
			</td>
		</tr>
		<?php

	}


	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function create_field( $field )
	{
		// create Field HTML
		echo sprintf( '<select id="%d" class="%s" name="%s">', $field['id'], $field['class'], $field['name']  );

		// null
		if( $field['allow_null'] )
		{
			echo '<option value="null"> - Select - </option>';
		}
		
		global $wp_registered_sidebars;
		$i = 0;
		foreach ( $wp_registered_sidebars as $registered_sidebar ) {
			$widget_areas[$i]['id'] = $registered_sidebar['id'];
			$widget_areas[$i]['name'] = $registered_sidebar['name'];
			$i++;
		}
		
		foreach ( $widget_areas as $widget_area ) {
			$selected = selected( $field['value'], $widget_area['id'] );
			echo sprintf( '<option value="%1$s" %3$s>%2$s</option>', $widget_area['id'], $widget_area['name'], $selected );
		}

		echo '</select>';
	}

	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/

	function format_value_for_api($value, $post_id, $field)
	{
		$value = '';
		if ( is_active_sidebar( $field['value'] ) ) :
			$value .= '<div id="secondary" class="widget-area" role="complementary">';
				dynamic_sidebar( $field['value'] );
			$value .= '</div><!-- #secondary -->';
		endif;
		return $value;
	}

}


// create field
new acf_field_widget_area();
