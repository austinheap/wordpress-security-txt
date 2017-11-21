<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/includes
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
        WordPress_Security_Txt_Public::cache_clear();
        WordPress_Security_Txt::event('wordpress-security-txt', __FUNCTION__);
    }
}
