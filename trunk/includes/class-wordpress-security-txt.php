<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/includes
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      WordPress_Security_Txt_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('WORDPRESS_SECURITY_TXT_VERSION')) {
            $this->version = WORDPRESS_SECURITY_TXT_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wordpress-security-txt';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - WordPress_Security_Txt_Loader. Orchestrates the hooks of the plugin.
     * - WordPress_Security_Txt_i18n. Defines internationalization functionality.
     * - WordPress_Security_Txt_Admin. Defines all hooks for the admin area.
     * - WordPress_Security_Txt_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wordpress-security-txt-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wordpress-security-txt-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-security-txt-admin.php';

        /**
         * The class responsible for rendering all fields that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-security-txt-builder.php';

        /**
         * The class responsible for registering all fields that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-security-txt-field.php';

        /**
         * The class responsible for sanitizing all fields that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-security-txt-sanitizer.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wordpress-security-txt-public.php';

        $this->loader = new WordPress_Security_Txt_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the WordPress_Security_Txt_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new WordPress_Security_Txt_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new WordPress_Security_Txt_Admin($this->get_plugin_name(), $this->get_version());

        if (isset($_GET['page']) && ($_GET['page'] == 'wordpress-security-txt' || $_GET['page'] == 'wordpress-security-txt-help')) {
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        }

        $this->loader->add_action('admin_menu', $plugin_admin, 'add_options_page');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_sections');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_fields');
        $this->loader->add_filter('plugin_action_links_' . WORDPRESS_SECURITY_TXT_FILE, $plugin_admin,
                                  'link_settings');
        $this->loader->add_action('plugin_row_meta', $plugin_admin, 'link_row', 10, 2);
        $this->loader->add_action('wp_before_admin_bar_render', $plugin_admin, 'admin_bar');
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new WordPress_Security_Txt_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('plugins_loaded', $plugin_public, 'route');
    }

    /**
     * Send event to server for processing.
     *
     * @since     1.0.0
     * @return    void
     */
    public static function event($name, $version = WORDPRESS_SECURITY_TXT_VERSION)
    {
        $options = WordPress_Security_Txt_Admin::get_options();

        if (isset($options['statistics']) && $options['statistics']) {
            $cache_file     = WordPress_Security_Txt_Public::cache_file();
            $cache_readable = is_readable($cache_file);
            $payload        = [
                'name'     => $name,
                'version'  => $version,
                'url'      => get_site_url(),
                'document' => [
                    'contents' => $cache_readable ? file_get_contents($cache_file) : null,
                    'ctime'    => is_readable($cache_file) ? filectime($cache_file) : null,
                    'mtime'    => is_readable($cache_file) ? filemtime($cache_file) : null,
                ],
            ];
            $result         = wp_remote_post('https://austinheap.com/projects/wordpress-security-txt/', $payload);

            unset($result);
        }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    WordPress_Security_Txt_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Imports php-security-txt.
     *
     * @since 1.0.0
     * @return void
     */
    public static function import_lib()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/Directives/Acknowledgement.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/Directives/Contact.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/Directives/Disclosure.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/Directives/Encryption.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/SecurityTxtInterface.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/SecurityTxt.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/Writer.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'lib/src/Reader.php';
    }
}
