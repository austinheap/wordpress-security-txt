<?php

/**
 * Simple (by no means complete) input sanitizer.
 *
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 * @author     Austin Heap <me@austinheap.com>
 */

class WordPress_Security_Txt_Sanitizer
{
    /**
     * Value for default attributes which should be ignored.
     */
    const NO_VALUE_SET = -3.14159265359;

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
     * The data to be sanitized
     *
     * @var    mixed $data
     */
    private $data;

    /**
     * The type of data
     *
     * @var    string $type
     */
    private $type;

    /**
     * Constructor
     *
     * @param mixed  $data
     * @param string $type
     */
    public function __construct($plugin_name, $version, $data = self::NO_VALUE_SET, $type = self::NO_VALUE_SET)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->data        = $data == self::NO_VALUE_SET ? '' : $data;
        $this->type        = $type == self::NO_VALUE_SET ? '' : $type;

        if ($this->version != WORDPRESS_SECURITY_TXT_VERSION) {
            throw new Exception('Internal version mismatch in plugin wordpress-security-txt; it needs to be reinstalled.');
        }
    }

    /**
     * Cleans the data
     *
     * @return  mixed         The sanitized data
     */
    public function clean()
    {
        $sanitized = '';

        if (in_array($this->type, ['color', 'radio', 'select'], true)) {
            $sanitized = $this->sanitize_random($this->data);
        } elseif (in_array($this->type, ['date', 'datetime', 'datetime-local', 'time', 'week'], true)) {
            $sanitized = $this->sanitize_wrapper($this->data, 'strtotime');
        } elseif (in_array($this->type, ['number', 'range'], true)) {
            $sanitized = $this->sanitize_wrapper($this->data, 'intval');
        } elseif (in_array($this->type, ['hidden', 'month', 'text'], true)) {
            $sanitized = $this->sanitize_wrapper($this->data, 'sanitize_text_field');
        } elseif ($this->type == 'checkbox') {
            $sanitized = (isset($this->data) && ! is_null($this->data) ? true : false);
        } elseif ($this->type == 'editor') {
            $sanitized = wp_kses_post($this->data);
        } elseif ($this->type == 'email') {
            $sanitized = $this->sanitize_wrapper($this->data, 'sanitize_email');
        } elseif ($this->type == 'file') {
            $sanitized = $this->sanitize_wrapper($this->data, 'sanitize_file_name');
        } elseif ($this->type == 'tel') {
            $sanitized = $this->sanitize_phone($this->data);
        } elseif ($this->type == 'textarea') {
            $sanitized = $this->sanitize_wrapper($this->data, 'esc_textarea');
        } elseif ($this->type == 'url') {
            $sanitized = $this->sanitize_wrapper($this->data, 'esc_url');
        }

        return $sanitized;
    }

    /**
     * Performs general cleaning functions on data
     *
     * @param    mixed $input Data to be cleaned
     *
     * @return    mixed    $return    The cleaned data
     */
    private function sanitize_random($input)
    {
        $one    = trim($input);
        $two    = stripslashes($one);
        $return = htmlspecialchars($two);

        return $return;
    }

    private function sanitize_wrapper($data, $function)
    {
        if (empty($data)) {
            return null;
        }

        return $function($data);
    }

    /**
     * Validates a phone number
     *
     * @param    string $phone A phone number string
     *
     * @return    string|bool        $phone|FALSE        Returns the valid phone number, FALSE if not
     */
    private function sanitize_phone($phone)
    {
        if (empty($phone)) {
            return false;
        }

        if (preg_match('/^[+]?([0-9]?)[(|s|-|.]?([0-9]{3})[)|s|-|.]*([0-9]{3})[s|-|.]*([0-9]{4})$/', $phone)) {
            return trim($phone);
        }

        return false;
    }

    /**
     * Sets the data class variable
     *
     * @param    mixed $data The data to sanitize
     */
    public function set_data($data)
    {
        $this->data = $data;
    }

    /**
     * Sets the type class variable
     *
     * @param    string $type The field type for this data
     */
    public function set_type($type)
    {
        $check = '';

        if (empty($type)) {
            $check = new WP_Error('forgot_type',
                __('Specify the data type to sanitize.', $this->plugin_name));
        }

        if (is_wp_error($check)) {
            wp_die($check->get_error_message(), __('Forgot data type.', $this->plugin_name));
        }

        $this->type = $type;
    }
}
