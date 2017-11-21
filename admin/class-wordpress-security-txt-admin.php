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
        $this->options     = $this::get_options($plugin_name);
    }

    /**
     * Sets the class variable $options
     *
     * @param string $plugin_name The name of the plugin.
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/' . $this->plugin_name . '-admin.css', [],
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
            ['jquery', 'jquery-ui-core', 'jquery-ui-sortable'], $this->version, true);

        wp_enqueue_script($this->plugin_name . '-validator',
            plugin_dir_url(__FILE__) . 'js/' . $this->plugin_name . '-validator.js',
            ['jquery'], $this->version, true);

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/' . $this->plugin_name . '-admin.js',
            ['jquery'], $this->version, true);
    }

    /**
     * Add an options page under the Settings submenu
     *
     * @since  1.0.0
     */
    public function add_options_page()
    {
        add_options_page(
            __('security.txt', $this->plugin_name), __('security.txt', $this->plugin_name),
            'manage_options', $this->plugin_name, [$this, 'display_settings_page']
        );

        add_submenu_page(
            'options-general.php',
            __('security.txt Help', $this->plugin_name), __('security.txt Help', $this->plugin_name),
            'manage_options', $this->plugin_name . '-help', [$this, 'display_help_page']
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
            apply_filters($this->plugin_name . 'section-title-general', esc_html__('General', $this->plugin_name)),
            [$this, 'section_general'],
            $this->plugin_name
        );

        add_settings_section(
            $this->plugin_name . '-directives',
            apply_filters($this->plugin_name . 'section-title-directives',
                esc_html__('Directives', $this->plugin_name)),
            [$this, 'section_directives'],
            $this->plugin_name
        );

        add_settings_section(
            $this->plugin_name . '-library',
            apply_filters($this->plugin_name . 'section-title-library', esc_html__('Library', $this->plugin_name)),
            [$this, 'section_library'],
            $this->plugin_name
        );

        add_settings_section(
            $this->plugin_name . '-debug',
            apply_filters($this->plugin_name . 'section-title-debug', esc_html__('Debug', $this->plugin_name)),
            [$this, 'section_debug'],
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
        (new WordPress_Security_Txt_Field($this->plugin_name, $this->version, $this->options))
            ->register_all();
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
        require plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-general.php';
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
        require plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-directives.php';
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
        require plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-library.php';
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
        require plugin_dir_path(__FILE__) . 'partials/wordpress-security-txt-section-debug.php';
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
            [$this, 'validate_options']
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
                $this->validate_repeater($input, $valid);
            } else {
                $valid[$option[0]] = $this->sanitizer($type, isset($input[$name]) ? $input[$name] : null);
            }
        }

        return $valid;
    }

    private function validate_repeater($input, &$valid)
    {
        $clean = [];

        foreach ($option[2] as $field) {
            foreach ($input[$field[0]] as $data) {
                if (!empty($data)) {
                    $clean[$field[0]][] = $this->sanitizer($field[1], $data);
                }
            }
        }

        $count = 10;

        for ($i = 0; $i < $count; $i++) {
            foreach ($clean as $field_name => $field) {
                if (isset($valid[$option[0]][$i])) {
                    $valid[$option[0]][$i][$field_name] = $field[$i];
                }
            }
        }
    }

    /**
     * Returns an array of options names, fields types, and default values
     *
     * @return        array            An array of options
     */
    public static function get_options_list()
    {
        $options = [];

        $options[] = ['enable', 'checkbox', true];
        $options[] = ['redirect', 'checkbox', true];
        $options[] = ['menu', 'checkbox', true];
        $options[] = ['contact', 'text', get_bloginfo('admin_email')];
        $options[] = ['encryption', 'textarea', null];
        $options[] = ['acknowledgement', 'text', null];
        $options[] = ['disclosure', 'select', 'default'];
        $options[] = ['cache', 'checkbox', true];
        $options[] = ['credits', 'checkbox', true];
        $options[] = ['statistics', 'checkbox', false];
        $options[] = ['debug', 'checkbox', false];

        return $options;
    }

    private function sanitizer($type, $data)
    {
        if (empty($type)) {
            throw new Exception(__('Cannot sanitize data type NULL.', $this->plugin_name));
        }

        return (new WordPress_Security_Txt_Sanitizer($this->plugin_name, $this->version, $data, $type))->clean();
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
            esc_html__('Settings', $this->plugin_name));

        $links[] = sprintf('<a href="%s">%s</a>',
            esc_url(admin_url('options-general.php?page=' . $this->plugin_name . '-help')),
            esc_html__('Help', $this->plugin_name));

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
                    'title' => __('security.txt', $this->plugin_name),
                    'href'  => '#',
                ]
            );

            $wp_admin_bar->add_menu([
                    'id'     => $this->plugin_name . '_settings_toolbar',
                    'title'  => __('Settings', $this->plugin_name),
                    'href'   => 'options-general.php?page=wordpress-security-txt',
                    'parent' => $this->plugin_name . '_root_toolbar',
                ]
            );

            $wp_admin_bar->add_menu([
                    'id'     => $this->plugin_name . '_help_toolbar',
                    'title'  => __('Help', $this->plugin_name),
                    'href'   => 'options-general.php?page=wordpress-security-txt-help',
                    'parent' => $this->plugin_name . '_root_toolbar',
                ]
            );
        }
    }
}
