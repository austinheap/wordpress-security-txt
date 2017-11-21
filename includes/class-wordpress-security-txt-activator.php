<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/includes
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wordpress-security-txt-admin.php';

        flush_rewrite_rules();

        $opts    = [];
        $options = WordPress_Security_Txt_Admin::get_options_list();

        foreach ($options as $option) {
            $opts[ $option[0] ] = $option[2];
        }

        update_option('wordpress-security-txt-options', $opts);

        WordPress_Security_Txt::event(__FUNCTION__);
    }
}
