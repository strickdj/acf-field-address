<?php

class acf_field_address extends acf_field {

  public function __construct(ACFAddressPluginHelper $helper) {

    $this->helper = $helper;

    $this->name = 'address';

    $this->label = __( 'Address', 'acf-address' );

    /*
    *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
    */
    $this->category = 'basic';

    /*
    *  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
    */
    // todo fix this garbage
    $this->defaults = array(
      'output_type'     => 'html',
      'address_layout'  => '[[{"id":"street1","label":"Street 1"}],[{"id":"street2","label":"Street 2"}],[{"id":"street3","label":"Street 3"}],[{"id":"city","label":"City"},{"id":"state","label":"State"},{"id":"zip","label":"Postal Code"},{"id":"country","label":"Country"}],[]]',
      'address_options' => '{"street1":{"id":"street1","label":"Street 1","defaultValue":"","enabled":true,"cssClass":"street1","separator":""},"street2":{"id":"street2","label":"Street 2","defaultValue":"","enabled":true,"cssClass":"street2","separator":""},"street3":{"id":"street3","label":"Street 3","defaultValue":"","enabled":true,"cssClass":"street3","separator":""},"city":{"id":"city","label":"City","defaultValue":"","enabled":true,"cssClass":"city","separator":","},"state":{"id":"state","label":"State","defaultValue":"","enabled":true,"cssClass":"state","separator":""},"zip":{"id":"zip","label":"Postal Code","defaultValue":"","enabled":true,"cssClass":"zip","separator":""},"country":{"id":"country","label":"Country","defaultValue":"","enabled":true,"cssClass":"country","separator":""}}'
    );

    /*
    *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
    *  var message = acf._e('address', 'error');
    */
    $this->l10n = array(
      'error' => __( 'Error! Please enter a higher value', 'acf-address' ),
    );

    parent::__construct();
  }

  /**
   *  Create extra settings for your field. These are visible when editing a field
   *
   * @type    action
   * @since    3.6
   * @date    23/01/13
   *
   * @param    $field (array) the $field being edited
   *
   * @return    void
   */
  public function render_field_settings( $field ) {

    $fk = $this->getKey( $field );

    acf_render_field_setting( $field, array(
      'label'        => __( 'Output Type', 'acf-address' ),
      'instructions' => __( 'Choose the data type the field returns.', 'acf-address' ),
      'type'         => 'radio',
      'name'         => 'output_type',
      'layout'       => 'horizontal',
      'choices'      => array(
        'html'   => __( 'HTML', 'acf-address' ),
        'array'  => __( 'Array', 'acf-address' ),
        'object' => __( 'Object', 'acf-address' ),
      )
    ) );

    // We cant use acf_render_field_setting for our super custom field edit screen
    ?>

    <script>
      var acfAddressWidgetData = {};
      acfAddressWidgetData.address_options = <?php echo ($field['address_options']); ?>;
      acfAddressWidgetData.address_layout = <?php echo ($field['address_layout']); ?>;
    </script>

    <tr class="acf-field field_type-address" data-name="address_options" data-type="address" data-setting="address">
      <td class="acf-label">

        <label>Address Options</label>

        <p class="description">Set the options for this address.</p>

      </td>
      <td class="acf-input">
        <div class="acfAddressWidget"
             data-field="<?php echo $fk; ?>"
        ></div>
      </td>
    </tr>

    <?php

  }

  /**
   * @param $field
   *
   * @return mixed
   */
  private function getKey( $field ) {

    if ( isset( $field['key'] ) && $field['key'] !== '' ) {
      return $field['key'];
    } else {
      $matches = array();
      preg_match( '/\[(.*?)\]/', $field['prefix'], $matches );

      return 'field_'.$matches[1];
    }

  }

  /**
   *  render_field()
   *
   *  Create the HTML interface for your field
   *
   * @param    $field (array) the $field being rendered
   *
   * @type    action
   * @since    3.6
   * @date    23/01/13
   *
   * @param    $field (array) the $field being edited
   *
   * @return    n/a
   */
  function render_field( $field ) {

    // Work around for the ACF export to code option adding extra slashes and quotes
    $address_options = stripcslashes( $field['address_options'] );
    $address_layout  = stripcslashes( $field['address_layout'] );

    if ( strpos( $address_layout, '"' ) === 0 ) {
      // remove the extra quotes
      $address_layout = trim( $address_layout, '"' );
    }

    if ( strpos( $address_options, '"' ) === 0 ) {
      // remove the extra quotes
      $address_options = trim( $address_options, '"' );
    }

    ?>

    <div class="acf-address-field"
         data-name="<?php echo $field['name']; ?>"
         data-value="<?php echo esc_js( json_encode( $field['value'], JSON_UNESCAPED_UNICODE ) ); ?>"
         data-output-type="<?php echo $field['output_type']; ?>"
         data-layout="<?php echo esc_js( $address_layout ); ?>"
         data-options="<?php echo esc_js( $address_options ); ?>"
    ></div>

    <?php
  }

  /**
   *  input_admin_enqueue_scripts()
   *
   *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
   *  Use this action to add CSS + JavaScript to assist your render_field() action.
   *
   * @type    action (admin_enqueue_scripts)
   * @since    3.6
   * @date    23/01/13
   *
   * @param    n /a
   *
   * @return    n/a
   */
  function input_admin_enqueue_scripts() {

    $manifest = $this->helper->get_assets_manifest();

    $asset_path = $this->helper->get_assets_uri();

    // todo render_field.css never gets used why?

    wp_register_script( 'acf_a_f_render_field', $asset_path . $manifest['render_field.js'] );
    wp_enqueue_script( 'acf_a_f_render_field' );

    if(array_key_exists('input.css', $manifest)) {
      wp_register_style( 'acf_a_f_input_styles', $asset_path . $manifest['input.css'] );
      wp_enqueue_style( 'acf_a_f_input_styles' );
    }

  }

  /**
   *  field_group_admin_enqueue_scripts()
   *
   *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
   *  Use this action to add CSS + JavaScript to assist your render_field_options() action.
   *
   * @type    action (admin_enqueue_scripts)
   * @since    3.6
   * @date    23/01/13
   *
   * @param    n /a
   *
   * @return    n/a
   */
  function field_group_admin_enqueue_scripts() {

    $manifest = $this->helper->get_assets_manifest();

    $asset_path = $this->helper->get_assets_uri();

    if(array_key_exists('render_field_options.css', $manifest)) {
      wp_register_style( 'acf_a_f_render_field_options_styles', $asset_path . $manifest['render_field_options.css'] );
      wp_enqueue_style( 'acf_a_f_render_field_options_styles' );
    }

    wp_register_script( 'acf_a_f_address_field', $asset_path . $manifest['address_jquery.js'], array('jquery-ui-sortable') );
    wp_register_script( 'acf_a_f_input', $asset_path . $manifest['input.js'] );
    wp_register_script( 'acf_a_f_render_field_options', $asset_path . $manifest['render_field_options.js'] );
    wp_enqueue_script( 'acf_a_f_address_field' );
    wp_enqueue_script( 'acf_a_f_render_field_options' );

    wp_localize_script('acf_a_f_address_field', 'acf_a_f_bundle_data', [
      'publicAssetsPath' => $this->helper->get_assets_uri()
    ]);

  }

  /**
   *  load_field()
   *
   *  This filter is applied to the $field after it is loaded from the database
   *
   * @type    filter
   * @date    23/01/2013
   * @since    3.6.0
   *
   * @param    $field (array) the field array holding all the field options
   *
   * @return    $field
   */
  public function load_field( $field ) {
    // detect old fields
    if ( array_key_exists( 'address_components', $field ) ) {
      $field['address_layout']  = $this->helper->transform_layout( $field['address_layout'] );
      $field['address_options'] = $this->helper->transform_options( $field['address_components'] );
      unset( $field['address_components'] );
    }

    if ( is_array( $field['address_layout'] ) ) {
      $field['address_layout'] = $this->jsonEncode( $field['address_layout'] );
    }
    if ( is_object( $field['address_options'] ) ) {
      $field['address_options'] = $this->jsonEncode( $field['address_options'] );
    }

    return $field;
  }

  public function load_value($value, $post_id, $field) {
    $new_value = [];

    if(is_array($value)) {
      foreach($value as $k => $v) {
        switch($k) {
          case 'address1':
            $new_value['street1'] = $v;
            break;
          case 'address2':
            $new_value['street2'] = $v;
            break;
          case 'address3':
            $new_value['street3'] = $v;
            break;
          case 'postal_code':
            $new_value['zip'] = $v;
            break;
          default:
            $new_value[$k] = $v;
        }
      }
    }

    return $new_value;
  }

  /**
   * This function is for backwards compatibility with php version 5.3
   * @param $val
   * @return mixed|string|void
   */
  private function jsonEncode($val) {
    return defined('JSON_UNESCAPED_UNICODE') ? json_encode($val, JSON_UNESCAPED_UNICODE) : json_encode($val);
  }


  /**
   *  update_field()
   *
   *  This filter is applied to the $field before it is saved to the database
   *
   * @type    filter
   * @date    23/01/2013
   * @since    3.6.0
   *
   * @param    $field (array) the field array holding all the field options
   *
   * @return    $field
   */
  function update_field( $field ) {
    $fieldKey = $this->getKey( $field );

    if(!array_key_exists('acfAddressWidget', $_POST)) {
      // This branch is to accommodate importing exported fields. (json)
      // todo write test for this.
      $field['address_options'] = json_decode( $field['address_options'] );
      $field['address_layout']  = json_decode( $field['address_layout'] );
    } else {
      // This branch is to accommodate regular field updates through the ui via POST
      $field['address_options'] = json_decode( stripslashes( $_POST['acfAddressWidget'][ $fieldKey ]['address_options'] ) );
      $field['address_layout']  = json_decode( stripslashes( $_POST['acfAddressWidget'][ $fieldKey ]['address_layout'] ) );
    }

    return $field;
  }

  /**
   *  format_value()
   *
   *  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
   *
   * @type    filter
   * @since    3.6
   * @date    23/01/13
   *
   * @param mixed $value the value which was loaded from the database
   * @param mixed $post_id the $post_id from which the value was loaded
   * @param array $field the field array holding all the field options
   *
   * @return mixed $value
   */
  public function format_value( $value, $post_id, $field ) {
    // bail early if no value
    if ( empty( $value ) ) {
      return $value;
    }

    switch ( $field['output_type'] ) {
      case 'array':
        return $this->helper->valueToArray( $value );

      case 'html':
        return $this->helper->valueToHtml( $value, $field );

      case 'object':
        return $this->helper->valueToObject( $value );

      default:
        return $this->helper->valueToHtml( $value, $field );
    }
  }

  // todo implement method validate_value

}

// create field
new acf_field_address(new ACFAddressPluginHelper());
