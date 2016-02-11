<?php

/*
Copyright (c) 2012, CAMPUS CRUSADE FOR CHRIST
All rights reserved.

Redistribution and use in source and binary forms, with or without modification,
are permitted provided that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this
list of conditions and the following disclaimer.
Redistributions in binary form must reproduce the above copyright notice,
this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.
Neither the name of CAMPUS CRUSADE FOR CHRIST nor the names of its
contributors may be used to endorse or promote products derived from this
software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
OF THE POSSIBILITY OF SUCH DAMAGE.
*/


class acf_field_address extends acf_field {
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

	function __construct() {
		// vars
		$this->name     = 'address';
		$this->label    = __( 'Address' );
		$this->category = __( "Basic", 'acf' ); // Basic, Content, Choice, etc
		$this->defaults = array(
			'address1'    => array(
				'label'         => 'Address 1',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'address1',
				'separator'     => '',
			),
			'address2'    => array(
				'label'         => 'Address 2',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'address2',
				'separator'     => '',
			),
			'address3'    => array(
				'label'         => 'Address 3',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'address3',
				'separator'     => '',
			),
			'city'        => array(
				'label'         => 'City',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'city',
				'separator'     => ',',
			),
			'state'       => array(
				'label'         => 'State',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'state',
				'separator'     => '',
			),
			'postal_code' => array(
				'label'         => 'Postal Code',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'postal_code',
				'separator'     => '',
			),
			'country'     => array(
				'label'         => 'Country',
				'default_value' => '',
				'enabled'       => 1,
				'class'         => 'country',
				'separator'     => '',
			),
			// add default here to merge into your field.
			// This makes life easy when creating the field options as you don't need to use any if( isset('') ) logic. eg:
			//'preview_size' => 'thumbnail'
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
	function create_options( $field ) {
		// defaults
		$field = array_merge( $this->defaults, $field );
		// key is needed in the field names to correctly save the data
		$key                         = $field['name'];
		$layout_defaults             = array(
			0 => array( 0 => 'address1' ),
			1 => array( 0 => 'address2' ),
			2 => array( 0 => 'address3' ),
			3 => array( 0 => 'city', 1 => 'state', 2 => 'postal_code', 3 => 'country' ),
		);
		$field['address_components'] = ( array_key_exists( 'address_components', $field ) && is_array( $field['address_components'] ) ) ?
			wp_parse_args( (array) $field['address_components'], $this->defaults ) :
			$this->defaults;
		$field['address_layout']     = ( array_key_exists( 'address_layout', $field ) && is_array( $field['address_layout'] ) ) ?
			(array) $field['address_layout'] : $layout_defaults;
		$components                  = $field['address_components'];
		$layout                      = $field['address_layout'];
		$missing                     = array_keys( $components );
		// Create Field Options HTML
		?>

		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e( 'Address Components', 'acf' ); ?></label>

				<p class="description">
					<strong><?php _e( 'Enabled', 'acf' ); ?></strong>: <?php _e( 'Is this component used.', 'acf' ); ?>
					<br/>
					<strong><?php _e( 'Label', 'acf' ); ?></strong>: <?php _e( 'Used on the add or edit a post screen.', 'acf' ); ?>
					<br/>
					<strong><?php _e( 'Default Value', 'acf' ); ?></strong>: <?php _e( 'Default value for this component.', 'acf' ); ?>
					<br/>
					<strong><?php _e( 'CSS Class', 'acf' ); ?></strong>: <?php _e( 'Class added to the component when using the api.', 'acf' ); ?>
					<br/>
					<strong><?php _e( 'Separator', 'acf' ); ?></strong>: <?php _e( 'Text placed after the component when using the api.', 'acf' ); ?>
					<br/>
				</p>
			</td>
			<td>
				<table>
					<thead>
					<tr>
						<th><?php _e( 'Field', 'acf' ); ?></th>
						<th><?php _e( 'Enabled', 'acf' ); ?></th>
						<th><?php _e( 'Label', 'acf' ); ?></th>
						<th><?php _e( 'Default Value', 'acf' ); ?></th>
						<th><?php _e( 'CSS Class', 'acf' ); ?></th>
						<th><?php _e( 'Separator', 'acf' ); ?></th>
					</tr>
					</thead>
					<tfoot>
					<tr>
						<th><?php _e( 'Field', 'acf' ); ?></th>
						<th><?php _e( 'Enabled', 'acf' ); ?></th>
						<th><?php _e( 'Label', 'acf' ); ?></th>
						<th><?php _e( 'Default Value', 'acf' ); ?></th>
						<th><?php _e( 'CSS Class', 'acf' ); ?></th>
						<th><?php _e( 'Separator', 'acf' ); ?></th>
					</tr>
					</tfoot>
					<tbody>
					<?php foreach ( $components as $name => $settings ) : ?>
						<tr>
							<td><?php echo $name; ?></td>
							<td>
								<?php
								do_action( 'acf/create_field', array(
									'type'  => 'true_false',
									'name'  => "fields[{$key}][address_components][$name][enabled]",
									'value' => $settings['enabled'],
									'class' => 'address_enabled',
								) );
								?>
							</td>
							<td>
								<?php
								do_action( 'acf/create_field', array(
									'type'  => 'text',
									'name'  => "fields[{$key}][address_components][$name][label]",
									'value' => $settings['label'],
									'class' => 'address_label',
								) );
								?>
							</td>
							<td>
								<?php
								do_action( 'acf/create_field', array(
									'type'  => 'text',
									'name'  => "fields[{$key}][address_components][$name][default_value]",
									'value' => $settings['default_value'],
									'class' => 'address_default_value',
								) );
								?>
							</td>
							<td>
								<?php
								do_action( 'acf/create_field', array(
									'type'  => 'text',
									'name'  => "fields[{$key}][address_components][$name][class]",
									'value' => $settings['class'],
									'class' => 'address_class',
								) );
								?>
							</td>
							<td>
								<?php
								do_action( 'acf/create_field', array(
									'type'  => 'text',
									'name'  => "fields[{$key}][address_components][$name][separator]",
									'value' => $settings['separator'],
									'class' => 'address_separator',
								) );
								?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr class="field_option field_option_<?php echo $this->name; ?>">
			<td class="label">
				<label><?php _e( 'Address Layout', 'acf' ); ?></label>

				<p class="description"><?php _e( 'Drag address components to the desired location. This controls the layout of the address in post metaboxes and the get_field() api method.', 'acf' ); ?></p>
				<input type="hidden" name="address_layout_key" value="<?php echo $key; ?>"/>
			</td>
			<td>
				<div class="address_layout">
					<?php
					$row = 0;
					foreach ( $layout as $layout_row ) :
						if ( count( $layout_row ) <= 0 ) {
							continue;
						}
						?>
						<label><?php printf( __( 'Line %d:', 'acf' ), $row + 1 ); ?></label>
						<ul class="row">
							<?php
							$col = 0;
							foreach ( $layout_row as $name ) :
								if ( empty( $name ) ) {
									continue;
								}
								if ( ! $components[ $name ]['enabled'] ) {
									continue;
								}
								if ( ( $index = array_search( $name, $missing, true ) ) !== false ) {
									array_splice( $missing, $index, 1 );
								}
								?>
								<li class="item" name="<?php echo $name; ?>">
									<?php echo $components[ $name ]['label']; ?>
									<input type="hidden"
									       name="<?php echo "fields[{$key}][address_layout][.$row.][.$col.]"?>"
									       value="<?php echo $name; ?>"/>
								</li>
								<?php
								$col ++;
							endforeach;
							?>
						</ul>
						<?php
						$row ++;
					endforeach;
					for ( ; $row < 4; $row ++ ) :
						?>
						<label><?php printf( __( 'Line %d:', 'acf' ), $row + 1 ); ?></label>
						<ul class="row">
						</ul>
					<?php endfor; ?>
					<label><?php _e( 'Not Displayed:', 'acf' ); ?></label>
					<ul class="row missing">
						<?php foreach ( $missing as $name ) : ?>
							<li class="item <?php echo $components[ $name ]['enabled'] ? '' : 'disabled'; ?>"
							    name="<?php echo $name; ?>">
								<?php echo $components[ $name ]['label']; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</td>
		</tr>

		<style type="text/css">
			/* Field Options Screen */
			tr.field_option_address .address_layout ul {
				list-style-type: none;
				border: 1px solid #999999;
				background-color: #AAAAAA;
				min-height: 36px;
			}

			tr.field_option_address .address_layout li {
				display: inline-block;
				margin: 3px;
				padding: 5px;
				border: 1px solid #CCCCCC;
				background-color: #EEEEEE;
				min-width: 100px;
				min-height: 15px;
				cursor: move;
			}

			tr.field_option_address .address_layout li.placeholder {
				border: 1px dashed #333333;
				background-color: #FFFFFF;
			}

			tr.field_option_address .address_layout li.disabled {
				display: none;
			}

			/* Add/Edit Post */
			.postbox .address .address_row {
				clear: both;
			}

			.postbox .address .address_row label {
				float: left;
				padding: 5px 10px 0 0;
			}
		</style>

		<script>
			(function ($) {
				function split_acf_name(name) {
					var matches = name.match(/\[.*?(?=\])/g);
					for (var i = 0; i < matches.length; i++)
						matches[i] = matches[i].replace('[', '');
					return matches;
				}

				function update_item_layout(item) {
					if (item.parents('ul.missing').size() > 0) {
						item.find('input').remove();
					}
					else if ($('input', item).size() == 0) {
						item.append(
							$('<input type="hidden" />')
								.val(item.attr('name'))
						);
					}
					var field = item.closest('.field');
					var key = field.find('input[name="address_layout_key"]').val();
					$('ul.row li.item input', field).each(function () {
						var $this = $(this);
						var col = $this.closest('li.item').index();
						var row = $this.closest('div.address_layout').children('ul.row').index($this.closest('ul.row'));
						$this.val($this.closest('li.item').attr('name'));
						$this.attr('name', 'fields[' + key + '][address_layout][' + row + '][' + col + ']');
					});
				}

				$('#acf_fields .address_enabled input[type="checkbox"]').live('change', function () {
					var $this = $(this),
						field = $this.closest('.field'),
						matches = split_acf_name($this.attr('name')),
						layout_item = $('li.item[name="' + matches[2] + '"]', field),
						missing_row = $('ul.row.missing', field);
					if ($this.is(':checked')) {
						layout_item.removeClass('disabled');
					}
					else {
						layout_item
							.addClass('disabled')
							.remove()
							.appendTo(missing_row);
					}
					update_item_layout(layout_item);
				});
				$('#acf_fields input.address_label[type="text"]').live('keyup', function () {
					var $this = $(this),
						field = $this.closest('.field'),
						matches = split_acf_name($this.attr('name')),
						layout_item = $('li.item[name="' + matches[2] + '"]', field);
					layout_item.text($this.val());
				});
				function init_address_layout(address_layout) {
					if (!address_layout.is('.address_layout'))
						return;
					if ($('ul.row', address_layout).data('sortable'))
						return;
					$('ul.row', address_layout).sortable({
						connectWith: ".row",
						placeholder: "placeholder",
						start: function (event, ui) {
							ui.placeholder.html('&nbsp;');
						},
						update: function (event, ui) {
							update_item_layout(ui.item);
						}
					}).disableSelection();
				}

				//Initialize existing address fields or fields that have changed to address fields
				$('#acf_fields .field_type select.select').live('change', function () {
					var $this = $(this),
						field = $this.closest('.field');
					if ($this.val() == 'address') {
						//If address-field already exists, initialize it
						if ($('.field_option_address', field).exists()) {
							init_address_layout($('.address_layout', field));
						}
					}
				});
				//Listen to ajax requests and initialize and new address fields
				$(document).bind('ajaxSuccess', function (e, xhr, settings) {
					if (settings.url == ajaxurl && settings.data.indexOf('field_type=address') != -1) {
						init_address_layout($('.address_layout'));
					}
				});
				//Trigger change even to initialize all address fields on document.ready event.
				$(function () {
					$('#acf_fields .field_type select.select').trigger('change');
				})
			})(jQuery)
		</script>

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

	function create_field( $field ) {
		// defaults
		$field      = array_merge( $this->defaults, $field );
		$components = $field['address_components'];
		$layout     = $field['address_layout'];
		$values     = (array) $field['value'];
		// perhaps use $field['preview_size'] to alter the markup?


		// create Field HTML
		?>

		<style type="text/css">
			/* Field Options Screen */
			tr.field_option_address .address_layout ul {
				list-style-type: none;
				border: 1px solid #999999;
				background-color: #AAAAAA;
				min-height: 36px;
			}

			tr.field_option_address .address_layout li {
				display: inline-block;
				margin: 3px;
				padding: 5px;
				border: 1px solid #CCCCCC;
				background-color: #EEEEEE;
				min-width: 100px;
				min-height: 15px;
				cursor: move;
			}

			tr.field_option_address .address_layout li.placeholder {
				border: 1px dashed #333333;
				background-color: #FFFFFF;
			}

			tr.field_option_address .address_layout li.disabled {
				display: none;
			}

			/* Add/Edit Post */
			.postbox .address .address_row {
				clear: both;
			}

			.postbox .address .address_row label {
				float: left;
				padding: 5px 10px 0 0;
			}
		</style>

		<div class="address">
			<?php foreach ( $layout as $layout_row ) : if ( empty( $layout_row ) ) {
				continue;
			} ?>
				<div class="address_row">
					<?php foreach ( $layout_row as $name ) : if ( empty( $name ) || ! $components[ $name ]['enabled'] ) {
						continue;
					} ?>
						<label class="<?php echo $components[ $name ]['class']; ?>">
							<?php echo $components[ $name ]['label']; ?>
							<input type="text" id="<?php echo $field['name']; ?>[<?php echo $name; ?>]"
							       name="<?php echo $field['name']; ?>[<?php echo $name; ?>]"
							       value="<?php echo esc_attr( $values[ $name ] ); ?>"/>
						</label>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="clear"></div>
	<?php
	}

	function load_value( $value, $post_id, $field ) {
		if ( is_array( $value ) && (
				array_key_exists( 'address1', $value ) ||
				array_key_exists( 'address2', $value ) ||
				array_key_exists( 'address3', $value ) ||
				array_key_exists( 'city', $value ) ||
				array_key_exists( 'state', $value ) ||
				array_key_exists( 'postal_code', $value ) ||
				array_key_exists( 'country', $value )
			)
		) {
		} else {
			$components = $field['address_components'];
			$defaults   = array();
			foreach ( $components as $name => $settings ) {
				$defaults[ $name ] = $settings['default_value'];
			}
			$value = do_action( 'afc/load_value', $value, $post_id, $field );
			$value = wp_parse_args( $value, $defaults );
		}

		return $value;
	}

	function format_value_for_api( $value, $post_id, $field ) {
		$components = $field['address_components'];
		$layout     = $field['address_layout'];
		$values     = $this->load_value( $value, $post_id, $field );
		$output     = '';
		foreach ( $layout as $layout_row ) {
			if ( empty( $layout_row ) ) {
				continue;
			}
			$output .= '<div class="address_row">';
			foreach ( $layout_row as $name ) {
				if ( empty( $name ) || ! $components[ $name ]['enabled'] ) {
					continue;
				}
				$output .= sprintf(
					'<span %2$s>%1$s%3$s </span>',
					$values[ $name ],
					$components[ $name ]['class'] ? 'class="' . esc_attr( $components[ $name ]['class'] ) . '"' : '',
					$components[ $name ]['separator'] ? esc_html( $components[ $name ]['separator'] ) : ''
				);
			}
			$output .= '</div>';
		}

		return $output;
	}

}

// create field
new acf_field_address();
?>
