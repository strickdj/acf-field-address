<?php

class acf_field_address extends acf_field {


	public function __construct()
	{


		$this->name = 'address';

		$this->label = __('Address', 'acf-address');

		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		$this->category = 'basic';

		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		$this->defaults = array(
			'output_type' => 'html',
			'address_layout' => array(
				'line1' => array(
					0 => array(
						'label' => __('Street 1', 'acf-address'),
						'id' => 'street1',
					) ),
				'line2' => array(
					0 => array(
						'label' => __('Street 2', 'acf-address'),
						'id' => 'street2',
					) ),
				'line3' => array(
					0 => array(
						'label' => __('Street 3', 'acf-address'),
						'id' => 'street3',
					) ),
				'line4' => array(
					0 => array(
						'label' => __('City', 'acf-address'),
						'id' => 'city',
					),
					1 => array(
						'label' => __('State', 'acf-address'),
						'id' => 'state',
					),
					2 => array(
						'label' => __('Postal Code', 'acf-address'),
						'id' => 'postal_code',
					),
					3 => array(
						'label' => __('Country', 'acf-address'),
						'id' => 'country',
					)
				),
				'not_displayed' => array()
			),
			'address_parts' => array(
				'street1'    => array(
					'label'         => __('Street 1', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'street1',
					'separator'     => '',
				),
				'street2'    => array(
					'label'         => __('Street 2', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'street2',
					'separator'     => '',
				),
				'street3'    => array(
					'label'         => __('Street 3', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'street3',
					'separator'     => '',
				),
				'city'        => array(
					'label'         => __('City', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'city',
					'separator'     => ',',
				),
				'state'       => array(
					'label'         => __('State', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'state',
					'separator'     => '',
				),
				'postal_code' => array(
					'label'         => __('Postal Code', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'postal_code',
					'separator'     => '',
				),
				'country'     => array(
					'label'         => __('Country', 'acf-address'),
					'default_value' => '',
					'enabled'       => 1,
					'class'         => 'country',
					'separator'     => '',
				)
			)
		);

		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('address', 'error');
		*/
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-address'),
		);

    parent::__construct();
	}
	
	
	/**
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	void
	*/
	public function render_field_settings( $field )
	{

		$post_id = $field['ID'];

		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		acf_render_field_setting( $field, array(
			'label'			=> __('Output Type','acf-address'),
			'instructions'	=> __('Choose the data type the field returns.','acf-address'),
			'type'			=> 'radio',
			'name'			=> 'output_type',
			'layout'		=> 'horizontal',
			'choices'		=> array(
				'html'		=> __('HTML','acf-address'),
				'array'	  => __('Array','acf-address'),
				'object'	=> __('Object','acf-address'),
			)
		));


		$field = array_merge($this->defaults, $field);

		?>

		<tr id="sim_address_parts" class="acf-field" data-name="address_parts" data-setting="address">
			<td class="acf-label">
				<label><?php _e('Address Parts', 'acf-address'); ?></label>
				<p class="description"><?php _e('Choose the parts of the address and set their default values', 'acf-address'); ?></p>
			</td>
			<td class="acf-input">

				<table>
				<?php
				$i = 0;
				foreach($field['address_parts'] as $component => $settings) {
					$i++;

					if( $i === 1 ) {
						?>
						<tr>
							<th>Index</th>
							<th>Enabled</th>
							<th>Label</th>
							<th>Default Value</th>
							<th>Css Class</th>
							<th>Separator</th>
						</tr>
						<?php
					}

					$checked = $settings['enabled'] ? 'checked=checked' : '';

					?>
					<tr>
						<td><?php echo $component; ?></td>
						<td><input name="sim_address_field[address_parts][enabled]" type="checkbox" value="<?php echo $component; ?>" <?php echo $checked; ?>></td>
						<td><input name="sim_address_field[address_parts][label]" type="text" value="<?php echo $settings['label']; ?>"></td>
						<td><input name="sim_address_field[address_parts][default_value]" type="text" value="<?php echo $settings['default_value']; ?>"></td>
						<td><input name="sim_address_field[address_parts][class]" type="text" value="<?php echo $settings['class']; ?>"></td>
						<td><input name="sim_address_field[address_parts][separator]" type="text" value="<?php echo $settings['separator']; ?>"></td>
					</tr>
					<?php

				}

				?>
				</table>
			</td>
		</tr>

		<tr id="sim_address_layout" class="acf-field" data-name="address_layout" data-setting="address">
			<td class="acf-label">
				<label>Address Layout</label>
				<p class="description">Drag and Drop to arrange the address as desired.</p>
			</td>
			<td class="acf-input">
				<input class="sim_layout_position" name="sim_address_field[address_layout]" type="text" value="">

				<div class="sim_grid">

					<?php
					$line = 0;
					foreach($field['address_layout'] as $row => $row_layout) {
						$line++;

						if ( $line < 5 ) {
							printf("<label>Line %u</label>", $line);
						} elseif ( $line === 5 ) {
							_e('Not Displayed', 'acf-address');
						}
						?>
						<ul class="sim_grid_row">
							<?php
							foreach($row_layout as $col => $address_part_index) {
								?>
								<li class="item" data-item="<?php echo $address_part_index['id']; ?>">
									<?php echo $address_part_index['label']; ?>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>

				</div>

			</td>
		</tr>

	  <?php

	}
	

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		
		echo '<pre>';
			print_r( $field );
		echo '</pre>';
		
		
		/*
		*  Create a simple text input using the 'font_size' setting.
		*/
		
		?>
		<input type="text" name="<?php echo esc_attr($field['name']) ?>" value="<?php echo esc_attr($field['value']) ?>" style="font-size:<?php echo $field['font_size'] ?>px;" />
		<?php
	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_enqueue_scripts() {

		$dir = plugin_dir_url( __FILE__ );


		// register & include JS
		wp_register_script( 'acf-input-address', "{$dir}js/input.js" );
		wp_enqueue_script('acf-input-address');
		
		
		// register & include CSS
		wp_register_style( 'acf-input-address', "{$dir}css/input.css" );
		wp_enqueue_style('acf-input-address');


	}

	*/
	
	


	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	
	function field_group_admin_enqueue_scripts() {

		$dir = plugin_dir_url( __FILE__ );

		// Ensure that jquery ui sortable is enqueued
		wp_enqueue_script('jquery-ui-sortable');

		// register & include JS
		wp_register_script( 'render_field_options', "{$dir}js/render_field_options.js" );
		wp_enqueue_script('render_field_options');

		// register & include CSS
		wp_register_style( 'render_field_options', "{$dir}css/render_field_options.css" );
		wp_enqueue_style('render_field_options');

	}


	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function load_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

//	function update_value( $value, $post_id, $field ) {
//
//		$i = "kdjf";
//
//		return $value;
//
//	}

	
	/*
	*  format_value()
	*
	*  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/

	
//	function format_value( $value, $post_id, $field ) {
//
//		$i = "kdjf";
//
//		// bail early if no value
//		if( empty($value) ) {
//
//			return $value;
//
//		}
//
//
//		// apply setting
//		if( $field['font_size'] > 12 ) {
//
//			// format the value
//			// $value = 'something';
//
//		}
//
//
//		// return
//		return $value;
//	}

	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/


//	function validate_value( $valid, $value, $field, $input ){
//
//		$i = "kdjf";
//
//
//		// Basic usage
//		if( $value < $field['custom_minimum_setting'] )
//		{
//			$valid = false;
//		}
//
//
//		// Advanced usage
//		if( $value < $field['custom_minimum_setting'] )
//		{
//			$valid = __('The value is too little!','acf-address');
//		}
//
//
//		// return
//		return $valid;
//
//	}

	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	function load_field( $field ) {

		$i = "kdjf";


		return $field;
		
	}	

	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/


	function update_field( $field ) {

		$i = "kdjf";


//		var_dump($field);
//
//		die();


		return $field;
		
	}	

	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
	
}


// create field
new acf_field_address();
