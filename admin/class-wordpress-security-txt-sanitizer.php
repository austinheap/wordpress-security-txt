<?php

/**
 * Sanitize anything
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
     * The data to be sanitized
     *
     * @access    private
     * @since     0.1
     * @var    string
     */
    private $data = '';

    /**
     * The type of data
     *
     * @access    private
     * @since     0.1
     * @var    string
     */
    private $type = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        // Nothing to see here...
    }

    /**
     * Cleans the data
     *
     * @access    public
     * @since     0.1
     *
     * @uses      sanitize_email()
     * @uses      sanitize_phone()
     * @uses      esc_textarea()
     * @uses      sanitize_text_field()
     * @uses      esc_url()
     *
     * @return  mixed         The sanitized data
     */
    public function clean()
    {
        $sanitized = '';

        /**
         * Add additional santization before the default sanitization
         */
        //        do_action( 'slushman_pre_sanitize', $sanitized );

        switch ($this->type) {

            case 'color':
            case 'radio':
            case 'select':
                $sanitized = $this->sanitize_random($this->data);
                break;

            case 'date':
            case 'datetime':
            case 'datetime-local':
            case 'time':
            case 'week':
                $sanitized = $this->sanitize_wrapper($this->data, 'strtotime');
                break;

            case 'number':
            case 'range':
                $sanitized = $this->sanitize_wrapper($this->data, 'intval');
                break;

            case 'hidden':
            case 'month':
            case 'text':
                $sanitized = $this->sanitize_wrapper($this->data, 'sanitize_text_field');
                break;

            case 'checkbox':
                $sanitized = (isset($this->data) && ! is_null($this->data) ? true : false);
                break;
            case 'editor':
                $sanitized = wp_kses_post($this->data);
                break;
            case 'email':
                $sanitized = $this->sanitize_wrapper($this->data, 'sanitize_email');
                break;
            case 'file':
                $sanitized = $this->sanitize_wrapper($this->data, 'sanitize_file_name');
                break;
            case 'tel':
                $sanitized = $this->sanitize_phone($this->data);
                break;
            case 'textarea':
                $sanitized = $this->sanitize_wrapper($this->data, 'esc_textarea');
                break;
            case 'url':
                $sanitized = $this->sanitize_wrapper($this->data, 'esc_url');
                break;

        } // switch

        /**
         * Add additional santization after the default .
         */
        //        do_action( 'slushman_post_sanitize', $sanitized );

        return $sanitized;
    } // clean()

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
     * @access    private
     * @since     0.1
     * @link      http://jrtashjian.com/2009/03/code-snippet-validate-a-phone-number/
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
        } // $phone validation

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
                                   __('Specify the data type to sanitize.', 'wordpress-security-txt'));
        }

        if (is_wp_error($check)) {
            wp_die($check->get_error_message(), __('Forgot data type.', 'wordpress-security-txt'));
        }

        $this->type = $type;
    }

    /**
     * Checks a date against a format to ensure its validity
     *
     * @link    http://www.php.net/manual/en/function.checkdate.php
     *
     * @param    string $date   The date as collected from the form field
     * @param    string $format The format to check the date against
     *
     * @return    string        A validated, formatted date
     */
    private function validate_date($date, $format = 'Y-m-d H:i:s')
    {
        $version = explode('.', phpversion());

        if (((int) $version[0] >= 5 && (int) $version[1] >= 2 && (int) $version[2] > 17)) {
            $d = DateTime::createFromFormat($format, $date);
        } else {
            $d = new DateTime(date($format, strtotime($date)));
        }

        return $d && $d->format($format) == $date;
    }
}
