<?php

/**
 * The admin-specific fields of the plugin.
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 */

/**
 * The admin-specific fields of the plugin.
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt_Field
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * The field options.
     *
     * @since         1.0.0
     * @access        private
     * @var        array $options The plugin options.
     */
    private $options;

    /**
     * The admin field builder class
     *
     * @since     1.0.0
     * @access    private
     * @var    WordPress_Security_Txt_Field $builder Field builder of this plugin
     */
    private $builder;

    /**
     * The fields this class can build.
     *
     * @since    1.0.0
     * @access   private
     * @var      array $available_fields The fields this class can build.
     */
    private static $available_fields = [
        'enable',
        'menu',
        'redirect',
        'contact',
        'encryption',
        'disclosure',
        'acknowledgement',
        'cache',
        'credits',
        'statistics',
        'debug',
    ];

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     * @param      array  $options     The options of this plugin.
     */
    public function __construct($plugin_name, $version, $options)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->options     = $options;
        $this->builder     = new WordPress_Security_Txt_Builder($this->plugin_name, $this->version, $this->options);
    }

    /**
     * Returns all the fields available in this class.
     *
     * @return array
     */
    public static function available_fields()
    {
        return self::$available_fields;
    }

    /**
     * Determines if a field is available in this class.
     *
     * @param string $name
     *
     * @return bool
     */
    public static function field_available($name)
    {
        return in_array($name, self::$available_fields, true);
    }

    /**
     * Registers a specific field.
     *
     * @param string $name
     *
     * @return void
     */
    public function register_field($name)
    {
        $this->$name();
    }

    /**
     * Registers all available fields.
     *
     * @return void
     */
    public function register_all()
    {
        foreach (self::$available_fields as $available_field) {
            $this->register_field($available_field);
        }
    }

    /**
     * Render the enable field.
     *
     * @return void
     */
    public function enable()
    {
        add_settings_field(
            'enable',
            apply_filters($this->plugin_name . 'label-enable', esc_html__('Enable', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-general',
            [
                'description' => 'Serve ' . get_site_url() . '/.well-known/security.txt on your WordPress site.',
                'id'          => 'enable',
                'value'       => isset($this->options['enable']) ? $this->options['enable'] : false,
            ]
        );
    }

    /**
     * Render the menu field.
     *
     * @return void
     */
    public function menu()
    {
        add_settings_field(
            'menu',
            apply_filters($this->plugin_name . 'label-menu', esc_html__('Menu', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-general',
            [
                'description' => 'Show security.txt menu at the top of the WordPress admin interface. You should turn this off after you have the plugin configured.',
                'id'          => 'menu',
                'value'       => isset($this->options['menu']) ? $this->options['menu'] : false,
            ]
        );
    }

    /**
     * Render the redirect field.
     *
     * @return void
     */
    public function redirect()
    {
        add_settings_field(
            'redirect',
            apply_filters($this->plugin_name . 'label-redirect', esc_html__('Redirect', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-general',
            [
                'description' => 'Redirect requests for ' . get_site_url() . '/security.txt to ' . get_site_url() . '/.well-known/security.txt.',
                'id'          => 'redirect',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['redirect']) ? $this->options['redirect'] : false,
            ]
        );
    }

    /**
     * Render the contact field.
     *
     * @return void
     */
    public function contact()
    {
        add_settings_field(
            'contact',
            apply_filters($this->plugin_name . 'label-contact', esc_html__('Contact', $this->plugin_name)),
            [$this->builder, 'text'],
            $this->plugin_name,
            $this->plugin_name . '-directives',
            [
                'description' => 'Your contact address. Valid formats: e-mail, URL, phone number. (Required)',
                'id'          => 'contact',
                'class'       => 'text widefat hide-when-disabled',
                'value'       => isset($this->options['contact']) ? $this->options['contact'] : false,
                'placeholder' => get_bloginfo('admin_email'),
            ]
        );
    }

    /**
     * Render the encryption field.
     *
     * @return void
     */
    public function encryption()
    {
        add_settings_field(
            'encryption',
            apply_filters($this->plugin_name . 'label-encryption', esc_html__('Encryption', $this->plugin_name)),
            [$this->builder, 'textarea'],
            $this->plugin_name,
            $this->plugin_name . '-directives',
            [
                'description' => 'Your GPG public key. (Optional)',
                'id'          => 'encryption',
                'class'       => 'large-text hide-when-disabled',
                'value'       => isset($this->options['encryption']) ? $this->options['encryption'] : false,
                'rows'        => 5,
            ]
        );
    }

    /**
     * Render the disclosure field.
     *
     * @return void
     */
    public function disclosure()
    {
        add_settings_field(
            'disclosure',
            apply_filters($this->plugin_name . 'label-disclosure', esc_html__('Disclosure', $this->plugin_name)),
            [$this->builder, 'select'],
            $this->plugin_name,
            $this->plugin_name . '-directives',
            [
                'description' => 'Your disclosure policy. (Optional)',
                'id'          => 'disclosure',
                'class'       => 'widefat hide-when-disabled',
                'value'       => isset($this->options['disclosure']) ? $this->options['disclosure'] : 'default',
                'selections'  => [
                    ['value' => 'default',
                     'label' => 'Default — do not include the "Disclosure" directive'],
                    ['value' => 'full',
                     'label' => 'Full — you will fully disclose reports after the issue has been resolved'],
                    ['value' => 'partial',
                     'label' => 'Partial — you will partially disclose reports after the issue has been resolved'],
                    ['value' => 'none',
                     'label' => 'None — you do not want to disclose reports after the issue has been resolved'],
                ],
            ]
        );
    }

    /**
     * Render the acknowledgement field.
     *
     * @return void
     */
    public function acknowledgement()
    {
        add_settings_field(
            'acknowledgement',
            apply_filters($this->plugin_name . 'label-acknowledgement',
                esc_html__('Acknowledgement', $this->plugin_name)),
            [$this->builder, 'text'],
            $this->plugin_name,
            $this->plugin_name . '-directives',
            [
                'description' => 'Your acknowledgements URL. (Optional)',
                'id'          => 'acknowledgement',
                'class'       => 'text widefat hide-when-disabled',
                'value'       => isset($this->options['acknowledgement']) ? $this->options['acknowledgement'] : false,
                'placeholder' => get_site_url() . '/security-hall-of-fame/',
            ]
        );
    }

    /**
     * Render the cache field.
     *
     * @return void
     */
    public function cache()
    {
        add_settings_field(
            'cache',
            apply_filters($this->plugin_name . 'label-cache', esc_html__('Cache', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description' => 'Enable cacheing of your security.txt file.',
                'id'          => 'cache',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['cache']) ? $this->options['cache'] : false,
            ]
        );
    }

    /**
     * Render the credits field.
     *
     * @return void
     */
    public function credits()
    {
        add_settings_field(
            'credits',
            apply_filters($this->plugin_name . 'label-credits', esc_html__('Credits', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description' => 'Enable credits at the bottom of your security.txt file.',
                'id'          => 'credits',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['credits']) ? $this->options['credits'] : false,
            ]
        );
    }

    /**
     * Render the statistics field.
     *
     * @return void
     */
    public function statistics()
    {
        add_settings_field(
            'statistics',
            apply_filters($this->plugin_name . 'label-statistics', esc_html__('Statistics', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description_raw' => 'Allow anonymous collection of plugin usage statistics. <a href="?page=wordpress-security-txt-help#statistics">Learn more</a> about what is collected and how the data is used.',
                'id'          => 'statistics',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['statistics']) ? $this->options['statistics'] : false,
            ]
        );
    }

    /**
     * Render the debug field.
     *
     * @return void
     */
    public function debug()
    {
        add_settings_field(
            'debug',
            apply_filters($this->plugin_name . 'label-debug', esc_html__('Debug', $this->plugin_name)),
            [$this->builder, 'checkbox'],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description' => 'Enable debug at the bottom of your security.txt file & this page.',
                'id'          => 'debug',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['debug']) ? $this->options['debug'] : false,
            ]
        );
    }
}
