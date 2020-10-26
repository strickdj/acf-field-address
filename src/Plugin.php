<?php

namespace Strickdj\AddressField;

final class Plugin
{

    /**
     * @var AddressField
     */
    private $field;

    /**
     * @var \WPackio\Enqueue
     */
    protected $enqueue;

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

    private function __construct()
    {
        $this->enqueue = new \WPackio\Enqueue(
            'acfFieldAddress',
            'dist',
            S_ACFADDRESS_VERSION,
            'plugin',
            S_ACFADDRESS_PLUGIN_FILE
        );

        // include field
        add_action('acf/include_field_types', [$this, 'include_field']);
    }

    public function include_field($_)
    {
        $this->field = new AddressField(new Helper(), $this->enqueue);
    }

    public function aenqueue() {


        // Enqueue on admin facing pages
        add_action( 'admin_enqueue_scripts', function() {

            $time = microtime();
            error_log("{$time}: admin_enqueue_scripts");




        } );

    }

}
