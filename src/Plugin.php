<?php

namespace Strickdj\AddressField;

final class Plugin
{

    /**
     * @var AddressField
     */
    private $field;

    /**
     * @var array
     */
    public $settings;

    /**
     * Stores the instance of the class
     */
    /**
     * @var \Strickdj\AddressField\Plugin
     */
    private static $instance;

    /**
     * Get the object instance
     *
     * @return \Strickdj\AddressField\Plugin
     */
    public static function instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Plugin)) {
            self::$instance = new Plugin();
        }

        return self::$instance;
    }


    public function __construct()
    {
        // - these will be passed into the field class.
        $this->settings = [
            'version' => S_ACFADDRESS_VERSION,
            'url' => S_ACFADDRESS_PLUGIN_URL,
            'path' => S_ACFADDRESS_PLUGIN_DIR
        ];

        // include field
        add_action('acf/include_field_types', [$this, 'include_field']);
    }

    public function include_field($_)
    {
        $helper = new Helper();
        $this->field = new AddressField($this->settings, $helper);
    }

}
