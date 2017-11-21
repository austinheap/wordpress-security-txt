<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://github.com/austinheap/wordpress-security-txt
 * @since             1.0.0
 * @package           WordPress_Security_Txt
 *
 * @wordpress-plugin
 * Plugin Name:       wp-security-txt
 * Plugin URI:        https://github.com/austinheap/wordpress-security-txt
 * Description:       A plugin for serving 'security.txt' in WordPress 4.9+, based on configuration settings.
 * Version:           1.0.0
 * Author:            Austin Heap
 * Author URI:        https://github.com/austinheap
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress-security-txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/austinheap/wordpress-security-txt
 * GitHub Languages:  https://github.com/austinheap/wordpress-security-txt-translations
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

// Used for referring to the plugin file or basename
if (! defined('WORDPRESS_SECURITY_TXT_FILE')) {
    define('WORDPRESS_SECURITY_TXT_FILE', plugin_basename(__FILE__));
}

define('WORDPRESS_SECURITY_TXT_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wordpress-security-txt-activator.php
 */
function activate_wordpress_security_txt()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wordpress-security-txt-activator.php';
    WordPress_Security_Txt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wordpress-security-txt-deactivator.php
 */
function deactivate_wordpress_security_txt()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-wordpress-security-txt-deactivator.php';
    WordPress_Security_Txt_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wordpress_security_txt');
register_deactivation_hook(__FILE__, 'deactivate_wordpress_security_txt');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-wordpress-security-txt.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wordpress_security_txt()
{
    $plugin = new WordPress_Security_Txt();
    $plugin->run();
}

run_wordpress_security_txt();
