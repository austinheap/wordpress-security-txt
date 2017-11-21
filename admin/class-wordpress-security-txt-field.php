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
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
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
    }

    /**
     * Creates a checkbox field
     *
     * @param    array $args The arguments for the field
     *
     * @return    string                        The HTML field
     */
    public function checkbox($args)
    {
        $defaults['class']       = '';
        $defaults['description'] = '';
        $defaults['label']       = '';
        $defaults['name']        = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['value']       = 0;

        apply_filters($this->plugin_name . '-field-checkbox-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[ $atts['id'] ])) {
            $atts['value'] = $this->options[ $atts['id'] ];
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-checkbox.php');
    }

    /**
     * Creates an editor field
     *
     * NOTE: ID must only be lowercase letter, no spaces, dashes, or underscores.
     *
     * @param    array $args The arguments for the field
     *
     * @return    string                        The HTML field
     */
    public function editor($args)
    {
        $defaults['description'] = '';
        $defaults['settings']    = [ 'textarea_name' => $this->plugin_name . '-options[' . $args['id'] . ']' ];
        $defaults['value']       = '';

        apply_filters($this->plugin_name . '-field-editor-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[ $atts['id'] ])) {
            $atts['value'] = $this->options[ $atts['id'] ];
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-editor.php');
    }

    /**
     * Creates a set of radios field
     *
     * @param    array $args The arguments for the field
     *
     * @return    string                        The HTML field
     */
    public function radios($args)
    {
        $defaults['class']       = '';
        $defaults['description'] = '';
        $defaults['label']       = '';
        $defaults['name']        = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['value']       = 0;

        apply_filters($this->plugin_name . '-field-radios-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[ $atts['id'] ])) {
            $atts['value'] = $this->options[ $atts['id'] ];
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-radios.php');
    }

    public function repeater($args)
    {
        $defaults['class']        = 'repeater';
        $defaults['fields']       = [];
        $defaults['id']           = '';
        $defaults['label-add']    = 'Add Item';
        $defaults['label-edit']   = 'Edit Item';
        $defaults['label-header'] = 'Item Name';
        $defaults['label-remove'] = 'Remove Item';
        $defaults['title-field']  = '';

        /*
                $defaults['name'] 			= $this->plugin_name . '-options[' . $args['id'] . ']';
        */
        apply_filters($this->plugin_name . '-field-repeater-options-defaults', $defaults);

        $setatts  = wp_parse_args($args, $defaults);
        $count    = 1;
        $repeater = [];

        if (! empty($this->options[ $setatts['id'] ])) {
            $repeater = maybe_unserialize($this->options[ $setatts['id'] ][0]);
        }

        if (! empty($repeater)) {
            $count = count($repeater);
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-repeater.php');
    }

    /**
     * Creates a select field
     *
     * Note: label is blank since its created in the Settings API
     *
     * @param    array $args The arguments for the field
     *
     * @return    string                        The HTML field
     */
    public function select($args)
    {
        $defaults['aria']        = '';
        $defaults['blank']       = '';
        $defaults['class']       = 'widefat';
        $defaults['context']     = '';
        $defaults['description'] = '';
        $defaults['label']       = '';
        $defaults['name']        = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['selections']  = [];
        $defaults['value']       = '';

        apply_filters($this->plugin_name . '-field-select-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[ $atts['id'] ])) {
            $atts['value'] = $this->options[ $atts['id'] ];
        }

        if (empty($atts['aria']) && ! empty($atts['description'])) {
            $atts['aria'] = $atts['description'];
        } elseif (empty($atts['aria']) && ! empty($atts['label'])) {
            $atts['aria'] = $atts['label'];
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-select.php');
    }

    /**
     * Creates a text field
     *
     * @param    array $args The arguments for the field
     *
     * @return    string                        The HTML field
     */
    public function text($args)
    {
        $defaults['class']       = 'text widefat';
        $defaults['description'] = '';
        $defaults['label']       = '';
        $defaults['name']        = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['placeholder'] = '';
        $defaults['type']        = 'text';
        $defaults['value']       = isset($args['value']) && !empty($args['value']) ? $args['value'] : '';

        apply_filters($this->plugin_name . '-field-text-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[ $atts['id'] ])) {
            $atts['value'] = $this->options[ $atts['id'] ];
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-text.php');
    }

    /**
     * Creates a textarea field
     *
     * @param    array $args The arguments for the field
     *
     * @return    string                        The HTML field
     */
    public function textarea($args)
    {
        $defaults['class']       = 'large-text';
        $defaults['cols']        = 50;
        $defaults['context']     = '';
        $defaults['description'] = '';
        $defaults['label']       = '';
        $defaults['name']        = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['rows']        = 10;
        $defaults['value']       = isset($args['value']) && !empty($args['value']) ? $args['value'] : '';
        $defaults['placeholder'] = '';

        apply_filters($this->plugin_name . '-field-textarea-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[ $atts['id'] ])) {
            $atts['value'] = $this->options[ $atts['id'] ];
        }

        include(plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-textarea.php');
    }
}
