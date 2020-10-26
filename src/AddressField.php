<?php

namespace Strickdj\AddressField;


use WPackio\Enqueue;

class AddressField extends \acf_field
{

    /**
     * @var Helper
     */
    protected $helper;
    /**
     * @var Enqueue
     */
    protected $enqueue;

    /**
     * AddressField constructor.
     * Setup the field type data
     *
     * @param Helper $helper
     * @param Enqueue $enqueue
     */
    public function __construct(Helper $helper, Enqueue $enqueue)
    {
        $this->helper = $helper;
        $this->enqueue = $enqueue;

        /** @var string name Single word, no spaces. Underscores allowed */
        $this->name = 'address';

        /** @var string label Multiple words, can include spaces, visible when selecting a field type */
        $this->label = __('Address', S_ACFADDRESS_TEXT_DOMAIN);

        /** @var string category ENUM: basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME */
        $this->category = 'basic';

        $defaults = static::getDefaults();
        /** @var array defaults Array of default settings which are merged into the field object. These are used later in settings */
        $this->defaults = array(
            'output_type' => 'html',
            'address_layout' => $defaults['address_layout'],
            'address_options' => $defaults['address_options'],
        );

        parent::__construct();
    }

    /**
     * Create extra settings for your field. These are visible when editing a field
     *
     * Called when creating a new Custom Field after this field is selected from the Field Type dropdown
     *
     * Also called when opening the Field Group edit screen where there is a field with this field type
     *
     * @param array $field the $field being edited
     * @return void
     */
    public function render_field_settings($field)
    {
        error_log("render_field_settings");

        acf_render_field_setting($field, array(
            'label' => __('Output Type', S_ACFADDRESS_TEXT_DOMAIN),
            'instructions' => __('Choose the data type the field returns.', S_ACFADDRESS_TEXT_DOMAIN),
            'type' => 'radio',
            'name' => 'output_type',
            'layout' => 'horizontal',
            'choices' => array(
                'html' => __('HTML', S_ACFADDRESS_TEXT_DOMAIN),
                'array' => __('Array', S_ACFADDRESS_TEXT_DOMAIN),
                'object' => __('Object', S_ACFADDRESS_TEXT_DOMAIN),
            )
        ));

        // Ensure field is complete (adds all settings).
        $field = acf_validate_field( $field );
        // Prepare field for input (modifies settings).
        $field = acf_prepare_field( $field );
        // Allow filters to cancel render.
        if( !$field ) {
            return;
        }

        // We cant use acf_render_field_setting for our custom field edit screen
        ?>
        <pre>
            <?php var_dump($field); ?>
        </pre>

        <tr class="acf-field acf-field-addyopts acf-field-setting-address_options" data-name="address_options"
            data-type="addyopts" data-key="address_options" data-setting="<?php echo $field['type']; ?>">
            <td class="acf-label">
                <label for="acf_fields-<?php echo $field["key"]; ?>-address_options"><?php _e('Address Options', S_ACFADDRESS_TEXT_DOMAIN); ?></label>
                <p class="description"><?php _e('Set the options for this address.', S_ACFADDRESS_TEXT_DOMAIN); ?></p>
            </td>
            <td class="acf-input">
                <div class="acf-input-wrap">
                    <div class="acfAddressWidget"
                         data-options-name="<?php echo $field["prefix"]; ?>[address_options]"
                         data-layout-name="<?php echo $field["prefix"]; ?>[address_layout]"
                         data-layout="<?php echo esc_js($this->jsonEncode($field['address_layout'])); ?>"
                         data-options="<?php echo esc_js($this->jsonEncode($field['address_options'])); ?>"
                    ></div>
                    <div>
                        prefix: <?php echo $field["prefix"]; ?> <br>
                        id: <?php echo $field["id"]; ?> <br>
                        ID: <?php echo $field["ID"]; ?> <br>
                        name: <?php echo $field["name"]; ?> <br>
                        key: <?php echo $field["key"]; ?> <br>
                        label: <?php echo $field["label"]; ?> <br>
                        type: <?php echo $field["type"]; ?> <br>
                        value: <?php echo $field["value"]; ?> <br>
                    </div>
                </div>
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
        // is this needed now?
//        $address_options = stripcslashes($field['address_options']);
//        $address_layout = stripcslashes($field['address_layout']);
//
//        if (strpos($address_layout, '"') === 0) {
//            // remove the extra quotes
//            $address_layout = trim($address_layout, '"');
//        }
//
//        if (strpos($address_options, '"') === 0) {
//            // remove the extra quotes
//            $address_options = trim($address_options, '"');
//        }

        ?>

        <div class="acf-address-field"
             data-name="<?php echo $field['name']; ?>"
             data-required="<?php echo $field['required']; ?>"
             data-value="<?php echo esc_js($this->jsonEncode($field['value'])); ?>"
             data-output-type="<?php echo $field['output_type']; ?>"
             data-layout="<?php echo esc_js($this->jsonEncode($field['address_layout'])); ?>"
             data-options="<?php echo esc_js($this->jsonEncode($field['address_options'])); ?>"
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
        $this->enqueue->enqueue( 'render_field', 'main', [
            'js' => true,
            'css' => true,
            'js_dep' => [],
            'css_dep' => [],
            'in_footer' => true,
            'media' => 'all',
        ] );
    }

    /**
     * This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
     * Use this action to add CSS + JavaScript to assist your render_field_options() action.
     *
     * @return void
     */
    public function field_group_admin_enqueue_scripts()
    {
        $this->enqueue->enqueue( 'address.jquery.js', 'main', [
            'js' => true,
            'css' => true,
            'js_dep' => ['jquery-ui-sortable'],
            'css_dep' => [],
            'in_footer' => true,
            'media' => 'all',
        ] );

        $assets = $this->enqueue->enqueue( 'render_field_options', 'main', [
            'js' => true,
            'css' => true,
            'js_dep' => [],
            'css_dep' => [],
            'in_footer' => true,
            'media' => 'all',
        ] );

//        $entry_point = array_pop( $assets['js'] );
//        wp_localize_script( $entry_point['handle'], 'acf_a_f_bundle_data', [
//            'publicAssetsPath' => 'dist'
//        ] );

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
        return $field;
    }

    /**
     *  This filter is applied to the $value after it is loaded from the db
     *
     * @param $value
     * @param $post_id
     * @param $field
     * @return array
     */
    public function load_value($value, $post_id, $field)
    {
        return $value;
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
//        // todo solve problem with update on duplicate field function.
//        var_dump($field);
//        die;

        if(!is_array($field['address_options'])) {
            $field['address_options'] = json_decode($field['address_options'], true);
        }
        if(!is_array($field['address_layout'])) {
            $field['address_layout'] = json_decode($field['address_layout'], true);
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
                return $value;

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


    public static function getDefaults() {
        return [
            'address_layout' =>
                [
                    [
                        [
                            'id' => 'street1',
                            'label' => 'Street 1',
                        ],
                    ],
                    [
                        [
                            'id' => 'street2',
                            'label' => 'Street 2',
                        ],
                    ],
                    [
                        [
                            'id' => 'street3',
                            'label' => 'Street 3',
                        ],
                    ],
                    [
                        [
                            'id' => 'city',
                            'label' => 'City',
                        ]
                        ,
                        [
                            'id' => 'state',
                            'label' => 'State',
                        ],
                        [
                            'id' => 'zip',
                            'label' => 'Postal Code',
                        ],
                        [
                            'id' => 'country',
                            'label' => 'Country',
                        ],
                    ],
                    [],
                ],
            'address_options' =>
                [
                    'street1' =>
                        [
                            'id' => 'street1',
                            'label' => 'Street 1',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'street1',
                            'separator' => '',
                        ],
                    'street2' =>
                        [
                            'id' => 'street2',
                            'label' => 'Street 2',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'street2',
                            'separator' => '',
                        ],
                    'street3' =>
                        [
                            'id' => 'street3',
                            'label' => 'Street 3',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'street3',
                            'separator' => '',
                        ],
                    'city' =>
                        [
                            'id' => 'city',
                            'label' => 'City',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'city',
                            'separator' => ',',
                        ],
                    'state' =>
                        [
                            'id' => 'state',
                            'label' => 'State',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'state',
                            'separator' => '',
                        ],
                    'zip' =>
                        [
                            'id' => 'zip',
                            'label' => 'Postal Code',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'zip',
                            'separator' => '',
                        ],
                    'country' =>
                        [
                            'id' => 'country',
                            'label' => 'Country',
                            'defaultValue' => '',
                            'enabled' => true,
                            'cssClass' => 'country',
                            'separator' => '',
                        ],
                ],
        ];
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
