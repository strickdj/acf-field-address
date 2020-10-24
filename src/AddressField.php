<?php

namespace Strickdj\AddressField;


class AddressField extends \acf_field
{

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * AddressField constructor.
     * Setup the field type data
     *
     * @param $settings
     * @param Helper $helper
     */
    public function __construct($settings, Helper $helper)
    {
        $this->helper = $helper;

        /** @var string name Single word, no spaces. Underscores allowed */
        $this->name = 'address';

        /** @var string label Multiple words, can include spaces, visible when selecting a field type */
        $this->label = __('Address', 'acf-address');

        /** @var string category ENUM: basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME */
        $this->category = 'basic';

        // todo fix
        /** @var array defaults Array of default settings which are merged into the field object. These are used later in settings */
        $this->defaults = array(
            'output_type' => 'html',
            'address_layout' => '[[{"id":"street1","label":"Street 1"}],[{"id":"street2","label":"Street 2"}],[{"id":"street3","label":"Street 3"}],[{"id":"city","label":"City"},{"id":"state","label":"State"},{"id":"zip","label":"Postal Code"},{"id":"country","label":"Country"}],[]]',
            'address_options' => '{"street1":{"id":"street1","label":"Street 1","defaultValue":"","enabled":true,"cssClass":"street1","separator":""},"street2":{"id":"street2","label":"Street 2","defaultValue":"","enabled":true,"cssClass":"street2","separator":""},"street3":{"id":"street3","label":"Street 3","defaultValue":"","enabled":true,"cssClass":"street3","separator":""},"city":{"id":"city","label":"City","defaultValue":"","enabled":true,"cssClass":"city","separator":","},"state":{"id":"state","label":"State","defaultValue":"","enabled":true,"cssClass":"state","separator":""},"zip":{"id":"zip","label":"Postal Code","defaultValue":"","enabled":true,"cssClass":"zip","separator":""},"country":{"id":"country","label":"Country","defaultValue":"","enabled":true,"cssClass":"country","separator":""}}'
        );

        /** @var array settings Store plugin settings (url, path, version) as a reference for later use with assets */
        $this->settings = $settings;

        parent::__construct();
    }

    /**
     * Create extra settings for your field. These are visible when editing a field
     *
     * @param array $field the $field being edited
     * @return void
     */
    public function render_field_settings($field)
    {
        $fk = $this->getKey($field);

        acf_render_field_setting($field, array(
            'label' => __('Output Type', 'acf-address'),
            'instructions' => __('Choose the data type the field returns.', 'acf-address'),
            'type' => 'radio',
            'name' => 'output_type',
            'layout' => 'horizontal',
            'choices' => array(
                'html' => __('HTML', 'acf-address'),
                'array' => __('Array', 'acf-address'),
                'object' => __('Object', 'acf-address'),
            )
        ));

        // We cant use acf_render_field_setting for our custom field edit screen
        ?>

        <script>
          var acfAddressWidgetData = {}
          acfAddressWidgetData.address_options = <?php echo($field['address_options']); ?>;
          acfAddressWidgetData.address_layout = <?php echo($field['address_layout']); ?>;
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
     * Create the HTML interface for your field
     *
     * @param array $field the $field being rendered
     * @return void
     */
    public function render_field($field)
    {

        // Work around for the ACF export to code option adding extra slashes and quotes
        $address_options = stripcslashes($field['address_options']);
        $address_layout = stripcslashes($field['address_layout']);

        if (strpos($address_layout, '"') === 0) {
            // remove the extra quotes
            $address_layout = trim($address_layout, '"');
        }

        if (strpos($address_options, '"') === 0) {
            // remove the extra quotes
            $address_options = trim($address_options, '"');
        }

        ?>

        <div class="acf-address-field"
             data-name="<?php echo $field['name']; ?>"
             data-value="<?php echo esc_js(json_encode($field['value'], JSON_UNESCAPED_UNICODE)); ?>"
             data-output-type="<?php echo $field['output_type']; ?>"
             data-layout="<?php echo esc_js($address_layout); ?>"
             data-options="<?php echo esc_js($address_options); ?>"
        ></div>

        <?php
    }

    /**
     * This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
     * Use this action to add CSS + JavaScript to assist your render_field() action.
     *
     * @return void
     */
    public function input_admin_enqueue_scripts()
    {
        // todo implement
//        $manifest = $this->helper->get_assets_manifest();
//
//        $asset_path = $this->helper->get_assets_uri();
//
//        wp_register_script('acf_a_f_render_field', $asset_path . $manifest['render_field.js']);
//        wp_enqueue_script('acf_a_f_render_field');
//
//        if (array_key_exists('input.css', $manifest)) {
//            wp_register_style('acf_a_f_input_styles', $asset_path . $manifest['input.css']);
//            wp_enqueue_style('acf_a_f_input_styles');
//        }
    }

    /**
     * This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
     * Use this action to add CSS + JavaScript to assist your render_field_options() action.
     *
     * @return void
     */
    public function field_group_admin_enqueue_scripts()
    {
//        $manifest = $this->helper->get_assets_manifest();
//
//        $asset_path = $this->helper->get_assets_uri();
//
//        if (array_key_exists('render_field_options.css', $manifest)) {
//            wp_register_style('acf_a_f_render_field_options_styles', $asset_path . $manifest['render_field_options.css']);
//            wp_enqueue_style('acf_a_f_render_field_options_styles');
//        }
//
//        wp_register_script('acf_a_f_address_field', $asset_path . $manifest['address_jquery.js'], array('jquery-ui-sortable'));
//        wp_register_script('acf_a_f_input', $asset_path . $manifest['input.js']);
//        wp_register_script('acf_a_f_render_field_options', $asset_path . $manifest['render_field_options.js']);
//        wp_enqueue_script('acf_a_f_address_field');
//        wp_enqueue_script('acf_a_f_render_field_options');
//
//        wp_localize_script('acf_a_f_address_field', 'acf_a_f_bundle_data', [
//            'publicAssetsPath' => $this->helper->get_assets_uri()
//        ]);
    }

    /**
     * This filter is applied to the $field after it is loaded from the database
     *
     * @param array $field holds all the field options
     *
     * @return array
     */
    public function load_field($field)
    {
        // detect old fields
        if (array_key_exists('address_components', $field)) {
            $field['address_layout'] = $this->helper->transform_layout($field['address_layout']);
            $field['address_options'] = $this->helper->transform_options($field['address_components']);
            unset($field['address_components']);
        }

        if (is_array($field['address_layout'])) {
            $field['address_layout'] = $this->jsonEncode($field['address_layout']);
        }
        if (is_object($field['address_options'])) {
            $field['address_options'] = $this->jsonEncode($field['address_options']);
        }

        return $field;
    }

    /**
     * @param $value
     * @param $post_id
     * @param $field
     * @return array
     */
    public function load_value($value, $post_id, $field)
    {
        $new_value = [];

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                switch ($k) {
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
     * This filter is applied to the $field before it is saved to the database
     *
     * @param array $field holds all the field options
     *
     * @return array
     */
    public function update_field($field)
    {
        $fieldKey = $this->getKey($field);

        if (!array_key_exists('acfAddressWidget', $_POST)) {
            // This branch is to accommodate importing exported fields. (json)
            $field['address_options'] = json_decode($field['address_options']);
            $field['address_layout'] = json_decode($field['address_layout']);
        } else {
            // This branch is to accommodate regular field updates through the ui via POST
            $field['address_options'] = json_decode(stripslashes($_POST['acfAddressWidget'][$fieldKey]['address_options']));
            $field['address_layout'] = json_decode(stripslashes($_POST['acfAddressWidget'][$fieldKey]['address_layout']));
        }

        return $field;
    }

    /**
     * This filter is applied to the $value after it is loaded from the db and before it is returned to the template
     *
     * @param mixed $value the value which was loaded from the database
     * @param mixed $post_id the $post_id from which the value was loaded
     * @param array $field the field array holding all the field options
     *
     * @return mixed $value
     */
    public function format_value($value, $post_id, $field)
    {
        // bail early if no value
        if (empty($value)) {
            return $value;
        }

        switch ($field['output_type']) {
            case 'array':
                return $this->helper->valueToArray($value);

            case 'object':
                return $this->helper->valueToObject($value);

            default:
                return $this->helper->valueToHtml($value, $field);
        }
    }

    /**
     * This function is for backwards compatibility with php version 5.3
     * @param $val
     * @return mixed|string|void
     */
    private function jsonEncode($val)
    {
        return defined('JSON_UNESCAPED_UNICODE') ? json_encode($val, JSON_UNESCAPED_UNICODE) : json_encode($val);
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    private function getKey($field)
    {

        if (isset($field['key']) && $field['key'] !== '') {
            return $field['key'];
        } else {
            $matches = array();
            preg_match('/\[(.*?)\]/', $field['prefix'], $matches);

            return 'field_' . $matches[1];
        }

    }


    /*
   *  This function is called once on the 'input' page between the head and footer
   *  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
   *  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   *  seen on comments / user edit forms on the front end. This function will always be called, and includes
   *  $args that related to the current screen such as $args['post_id']
   *
   *  @param	$args (array)
   *  @return	n/a
   */

    /*
    function input_form_data( $args ) {}
    */


    /*
    *  This action is called in the admin_footer action on the edit screen where your field is created.
    *  Use this action to add CSS and JavaScript to assist your render_field() action.
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*
    function input_admin_footer() {}
    */

    /*
    *  This action is called in the admin_head action on the edit screen where your field is edited.
    *  Use this action to add CSS and JavaScript to assist your render_field_options() action.
    *
    *  @param	n/a
    *  @return	n/a
    */
    /*
    function field_group_admin_head() {}
    */

    /*
    *  This filter is applied to the $value before it is saved in the db
    *
    *  @param	$value (mixed) the value found in the database
    *  @param	$post_id (mixed) the $post_id from which the value was loaded
    *  @param	$field (array) the field array holding all the field options
    *  @return	$value
    */

    /*
    function update_value( $value, $post_id, $field ) {
        return $value;
    }
    */

    /*
    *  This filter is used to perform validation on the value prior to saving.
    *  All values are validated regardless of the field's required setting. This allows you to validate and return
    *  messages to the user if the value is not correct
    *
    *  @param	$valid (boolean) validation status based on the value and the field's required setting
    *  @param	$value (mixed) the $_POST value
    *  @param	$field (array) the field array holding all the field options
    *  @param	$input (string) the corresponding input name for $_POST value
    *  @return	$valid
    */
    /*
    function validate_value( $valid, $value, $field, $input ){
        // Basic usage
        if( $value < $field['custom_minimum_setting'] )
        {
            $valid = false;
        }
        // Advanced usage
        if( $value < $field['custom_minimum_setting'] )
        {
            $valid = __('The value is too little!','TEXTDOMAIN'),
        }
        return $valid;
    }

    */

    /*
    *  This action is fired after a value has been deleted from the db.
    *  Please note that saving a blank value is treated as an update, not a delete
    *
    *  @param	$post_id (mixed) the $post_id from which the value was deleted
    *  @param	$key (string) the $meta_key which the value was deleted
    *  @return	n/a
    */
    /*
    function delete_value( $post_id, $key ) {}
    */

    /*
    *  This action is fired after a field is deleted from the database
    *
    *  @param	$field (array) the field array holding all the field options
    *  @return	n/a
    */
    /*
    function delete_field( $field ) {
    }
    */

}
