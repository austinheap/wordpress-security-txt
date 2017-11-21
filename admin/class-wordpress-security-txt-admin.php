<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for the admin-specific stylesheet and JavaScript.
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt_Admin
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
     * The admin field generation class
     *
     * @since     1.0.0
     * @access    private
     * @var    WordPress_Security_Txt_Field $field Field generator of this plugin
     */
    private $field;

    /**
     * The plugin options.
     *
     * @since         1.0.0
     * @access        private
     * @var        array $options The plugin options.
     */
    private $options;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->field       = new WordPress_Security_Txt_Field($plugin_name, $version);
        $this->options     = $this::get_options($plugin_name);
    }

    /**
     * Sets the class variable $options
     */
    public static function get_options($plugin_name = 'wordpress-security-txt')
    {
        return get_option($plugin_name . '-options');
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wordpress-security-txt-admin.css', [],
                          $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name . '-repeater',
                           plugin_dir_url(__FILE__) . 'js/' . $this->plugin_name . '-repeater.min.js',
                           [ 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ], $this->version, true);

        wp_enqueue_script($this->plugin_name . '-validator',
                           plugin_dir_url(__FILE__) . 'js/' . $this->plugin_name . '-validator.js',
                           [ 'jquery' ], $this->version, true);

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/' . $this->plugin_name . '-admin.js',
                           [ 'jquery' ], $this->version, true);
    }

    /**
     * Add an options page under the Settings submenu
     *
     * @since  1.0.0
     */
    public function add_options_page()
    {
        add_options_page(
            __('security.txt', 'wordpress-security-txt'),
            __('security.txt', 'wordpress-security-txt'),
            'manage_options',
            $this->plugin_name,
            [ $this, 'display_settings_page' ]
        );

        add_submenu_page(
            'options-general.php',
            __('security.txt Help', 'wordpress-security-txt'),
            __('security.txt Help', 'wordpress-security-txt'),
            'manage_options',
            'wordpress-security-txt-help',
            [ $this, 'display_help_page' ]
        );

        remove_submenu_page('options-general.php', 'wordpress-security-txt-help');
    }

    /**
     * Render the settings page for plugin
     *
     * @since  1.0.0
     */
    public function display_settings_page()
    {
        WordPress_Security_Txt::import_lib();
        require plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-page-settings.php';
    }

    /**
     * Render the help page for plugin
     *
     * @since  1.0.0
     */
    public function display_help_page()
    {
        WordPress_Security_Txt::import_lib();
        require plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-page-help.php';
    }

    /**
     * Registers settings sections with WordPress
     *
     * @since        1.0.0
     * @return        void
     */
    public function register_sections()
    {
        add_settings_section(
            $this->plugin_name . '-general',
            apply_filters($this->plugin_name . 'section-title-general', esc_html__('General', 'wordpress-security-txt')),
            [ $this, 'section_general' ],
            $this->plugin_name
        );

        add_settings_section(
            $this->plugin_name . '-directives',
            apply_filters($this->plugin_name . 'section-title-directives',
                           esc_html__('Directives', 'wordpress-security-txt')),
            [ $this, 'section_directives' ],
            $this->plugin_name
        );

        add_settings_section(
            $this->plugin_name . '-library',
            apply_filters($this->plugin_name . 'section-title-library', esc_html__('Library', 'wordpress-security-txt')),
            [ $this, 'section_library' ],
            $this->plugin_name
        );

        add_settings_section(
            $this->plugin_name . '-debug',
            apply_filters($this->plugin_name . 'section-title-debug', esc_html__('Debug', 'wordpress-security-txt')),
            [ $this, 'section_debug' ],
            $this->plugin_name
        );
    }

    /**
     * Registers settings fields with WordPress
     *
     * @since        1.0.0
     * @return        void
     */
    public function register_fields()
    {
        add_settings_field(
            'enable',
            apply_filters($this->plugin_name . 'label-enable', esc_html__('Enable', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
            $this->plugin_name,
            $this->plugin_name . '-general',
            [
                'description' => 'Serve ' . get_site_url() . '/.well-known/security.txt on your WordPress site.',
                'id'          => 'enable',
                'value'       => isset($this->options['enable']) ? $this->options['enable'] : false,
            ]
        );

        add_settings_field(
            'menu',
            apply_filters($this->plugin_name . 'label-menu', esc_html__('Menu', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
            $this->plugin_name,
            $this->plugin_name . '-general',
            [
                'description' => 'Show security.txt menu at the top of the WordPress admin interface. You should turn this off after you have the plugin configured.',
                'id'          => 'menu',
                'value'       => isset($this->options['menu']) ? $this->options['menu'] : false,
            ]
        );

        add_settings_field(
            'redirect',
            apply_filters($this->plugin_name . 'label-redirect', esc_html__('Redirect', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
            $this->plugin_name,
            $this->plugin_name . '-general',
            [
                'description' => 'Redirect requests for ' . get_site_url() . '/security.txt to ' . get_site_url() . '/.well-known/security.txt.',
                'id'          => 'redirect',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['redirect']) ? $this->options['redirect'] : false,
            ]
        );

        //		$contact_fields = [];
        //		$contact_fields[] =
        //			[
        //				'text'     => [
        //					'class'       => '',
        //					'description' => 'Your e-mail or URL contact address.',
        //					'id'          => 'contacts_uri',
        //					'label'       => '',
        //					'name'        => $this->plugin_name . '-options[contacts_uri]',
        //					'placeholder' => get_bloginfo( 'admin_email' ),
        //					'type'        => 'text',
        //					'value'       => '',
        //				],
        //				'checkbox' => [
        //					'class'       => '',
        //					'description' => 'Enable this contact address.',
        //					'id'          => 'contacts_enable',
        //					'label'       => '',
        //					'name'        => $this->plugin_name . '-options[contacts_enable]',
        //					'type'        => 'checkbox',
        //					'value'       => true,
        //				],
        //			];
        //
        //		add_settings_field(
        //			'contacts',
        //			apply_filters( $this->plugin_name . 'label-contacts', esc_html__( 'Contact(s)', 'wordpress-security-txt' ) ),
        //			[ $this->field, 'repeater' ],
        //			$this->plugin_name,
        //			$this->plugin_name . '-directives',
        //			[
        //				'class'        => 'repeater hide-when-disabled',
        //				'description'  => 'Your contact address. At least one is required.',
        //				'fields'       => $contact_fields,
        //				'id'           => 'contacts',
        //				'label-add'    => 'Add Contact',
        //				'label-edit'   => 'Edit Contact',
        //				'label-header' => 'Contact',
        //				'label-remove' => 'Remove Contact',
        //				'title-field'  => 'contacts',
        //			]
        //		);

        add_settings_field(
            'contact',
            apply_filters($this->plugin_name . 'label-contact', esc_html__('Contact', 'wordpress-security-txt')),
            [ $this->field, 'text' ],
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

        add_settings_field(
            'encryption',
            apply_filters($this->plugin_name . 'label-encryption', esc_html__('Encryption', 'wordpress-security-txt')),
            [ $this->field, 'textarea' ],
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

        add_settings_field(
            'disclosure',
            apply_filters($this->plugin_name . 'label-disclosure', esc_html__('Disclosure', 'wordpress-security-txt')),
            [ $this->field, 'select' ],
            $this->plugin_name,
            $this->plugin_name . '-directives',
            [
                'description' => 'Your disclosure policy. (Optional)',
                'id'          => 'disclosure',
                'class'       => 'widefat hide-when-disabled',
                'value'       => isset($this->options['disclosure']) ? $this->options['disclosure'] : 'default',
                'selections'  => [
                    [
                        'value' => 'default',
                        'label' => 'Default — do not include the "Disclosure" directive',
                    ],
                    [
                        'value' => 'full',
                        'label' => 'Full — you will fully disclose reports after the issue has been resolved',
                    ],
                    [
                        'value' => 'partial',
                        'label' => 'Partial — you will partially disclose reports after the issue has been resolved',
                    ],
                    [
                        'value' => 'none',
                        'label' => 'None — you do not want to disclose reports after the issue has been resolved',
                    ],
                ],
            ]
        );

        add_settings_field(
            'acknowledgement',
            apply_filters($this->plugin_name . 'label-acknowledgement',
                           esc_html__('Acknowledgement', 'wordpress-security-txt')),
            [ $this->field, 'text' ],
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

        add_settings_field(
            'cache',
            apply_filters($this->plugin_name . 'label-cache', esc_html__('Cache', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description' => 'Enable cacheing of your security.txt file.',
                'id'          => 'cache',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['cache']) ? $this->options['cache'] : false,
            ]
        );

        add_settings_field(
            'credits',
            apply_filters($this->plugin_name . 'label-credits', esc_html__('Credits', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description' => 'Enable credits at the bottom of your security.txt file.',
                'id'          => 'credits',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['credits']) ? $this->options['credits'] : false,
            ]
        );

        add_settings_field(
            'statistics',
            apply_filters($this->plugin_name . 'label-statistics', esc_html__('Statistics', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
            $this->plugin_name,
            $this->plugin_name . '-library',
            [
                'description' => 'Allow anonymous collection of plugin usage statistics.',
                'id'          => 'statistics',
                'class'       => 'hide-when-disabled',
                'value'       => isset($this->options['statistics']) ? $this->options['statistics'] : false,
            ]
        );

        add_settings_field(
            'debug',
            apply_filters($this->plugin_name . 'label-debug', esc_html__('Debug', 'wordpress-security-txt')),
            [ $this->field, 'checkbox' ],
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

    /**
     * Creates a general section
     *
     * @since        1.0.0
     *
     * @param        array $params Array of parameters for the section
     *
     * @return        mixed                        The settings section
     */
    public function section_general($params)
    {
        include(plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-general.php');
    }

    /**
     * Creates a directives section
     *
     * @since        1.0.0
     *
     * @param        array $params Array of parameters for the section
     *
     * @return        mixed                        The settings section
     */
    public function section_directives($params)
    {
        include(plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-directives.php');
    }

    /**
     * Creates a library section
     *
     * @since        1.0.0
     *
     * @param        array $params Array of parameters for the section
     *
     * @return        mixed                        The settings section
     */
    public function section_library($params)
    {
        include(plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-library.php');
    }

    /**
     * Creates a debug section
     *
     * @since        1.0.0
     *
     * @param        array $params Array of parameters for the section
     *
     * @return        mixed                        The settings section
     */
    public function section_debug($params)
    {
        include(plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-debug.php');
    }

    /**
     * Registers plugin settings
     *
     * @since        1.0.0
     * @return        void
     */
    public function register_settings()
    {
        register_setting(
            $this->plugin_name,// . '-options',
            $this->plugin_name . '-options',
            [ $this, 'validate_options' ]
        );
    }

    public function validate_options($input)
    {
        WordPress_Security_Txt_Public::cache_clear();

        $valid   = [];
        $options = $this->get_options_list();

        foreach ($options as $option) {
            $name = $option[0];
            $type = $option[1];

            if ($type == 'repeater' && is_array($option[2])) {
                $clean = [];

                foreach ($option[2] as $field) {
                    foreach ($input[ $field[0] ] as $data) {
                        if (empty($data)) {
                            //							print 'empty: ' . $field[0];
                            continue;
                        }

                        //                        $clean[$field[0]][] = $data;
                        $clean[ $field[0] ][] = $this->sanitizer($field[1], $data);
                    } // foreach
                } // foreach

                $count = 10;

                for ($i = 0; $i < $count; $i ++) {
                    foreach ($clean as $field_name => $field) {
                        if (! isset($valid[ $option[0] ][ $i ])) {
                            continue;
                        }

                        $valid[ $option[0] ][ $i ][ $field_name ] = $field[ $i ];
                    }
                }
            } else {
                $valid[ $option[0] ] = $this->sanitizer($type, isset($input[ $name ]) ? $input[ $name ] : null);
            }
        }

        return $valid;
    }

    /**
     * Returns an array of options names, fields types, and default values
     *
     * @return        array            An array of options
     */
    public static function get_options_list()
    {
        $options = [];

        $options[] = [ 'enable', 'checkbox', true ];
        $options[] = [ 'redirect', 'checkbox', true ];
        $options[] = [ 'menu', 'checkbox', true ];
        $options[] = [ 'contact', 'text', get_bloginfo('admin_email') ];
        //		$options[] = [ 'contacts', 'repeater', [ [ 'contacts_uri', 'text' ], [ 'contacts_enable', 'checkbox' ] ] ];
        $options[] = [ 'encryption', 'textarea', null ];
        $options[] = [ 'acknowledgement', 'text', null ];
        $options[] = [ 'disclosure', 'select', 'default' ];
        $options[] = [ 'cache', 'checkbox', true ];
        $options[] = [ 'credits', 'checkbox', true ];
        $options[] = [ 'statistics', 'checkbox', false ];
        $options[] = [ 'debug', 'checkbox', false ];

        return $options;
    }

    private function sanitizer($type, $data)
    {
        if (empty($type)) {
            throw new Exception('Cannot sanitize data type NULL.');
        }

        $return    = '';
        $sanitizer = new WordPress_Security_Txt_Sanitizer();

        $sanitizer->set_data($data);
        $sanitizer->set_type($type);

        $return = $sanitizer->clean();

        unset($sanitizer);

        return $return;
    }

    /**
     * Adds links to the plugin links row
     *
     * @since        1.0.0
     *
     * @param        array  $links The current array of row links
     * @param        string $file  The name of the file
     *
     * @return        array                    The modified array of row links
     */
    public function link_row($links, $file)
    {
        if (WORDPRESS_SECURITY_TXT_FILE === $file) {
            $links[] = '<a href="http://twitter.com/austinheap">@austinheap</a>';
            $links[] = '<a href="http://twitter.com/EdOverflow">@EdOverflow</a>';
        }

        return $links;
    }

    /**
     * Adds a link to the plugin settings page
     *
     * @since        1.0.0
     *
     * @param        array $links The current array of links
     *
     * @return        array                    The modified array of links
     */
    public function link_settings($links)
    {
        $links[] = sprintf('<a href="%s">%s</a>',
                            esc_url(admin_url('options-general.php?page=' . $this->plugin_name)),
                            esc_html__('Settings', 'wordpress-security-txt'));

        $links[] = sprintf('<a href="%s">%s</a>',
                            esc_url(admin_url('options-general.php?page=' . $this->plugin_name . '-help')),
                            esc_html__('Help', 'wordpress-security-txt'));

        return $links;
    }

    /**
     * Adds an item to the admin bar
     *
     * @since        1.0.0
     * @return       void
     */
    public function admin_bar()
    {
        global $wp_admin_bar;
        if (isset($this->options['menu']) && $this->options['menu']) {
            $wp_admin_bar->add_menu([
                                         'id'    => $this->plugin_name . '_root_toolbar',
                                         'title' => __('security.txt', 'wordpress-security-txt'),
                                         'href'  => '#',
                                     ]
            );

            $wp_admin_bar->add_menu([
                                         'id'     => $this->plugin_name . '_settings_toolbar',
                                         'title'  => __('Settings', 'wordpress-security-txt'),
                                         'href'   => 'options-general.php?page=wordpress-security-txt',
                                         'parent' => $this->plugin_name . '_root_toolbar',
                                     ]
            );

            $wp_admin_bar->add_menu([
                                         'id'     => $this->plugin_name . '_help_toolbar',
                                         'title'  => __('Help', 'wordpress-security-txt'),
                                         'href'   => 'options-general.php?page=wordpress-security-txt-help',
                                         'parent' => $this->plugin_name . '_root_toolbar',
                                     ]
            );
        }
    }
}
