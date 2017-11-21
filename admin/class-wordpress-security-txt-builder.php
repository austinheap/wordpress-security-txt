<?php

/**
 * The admin-specific UI builder of the plugin.
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 */

/**
 * The admin-specific UI builder of the plugin.
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin
 * @author     Austin Heap <me@austinheap.com>
 */
class WordPress_Security_Txt_Builder
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
     * The builder options.
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
     * @param      array  $options     The options of this plugin.
     */
    public function __construct($plugin_name, $version, $options)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->options     = $options;

        if ($this->version != WORDPRESS_SECURITY_TXT_VERSION) {
            throw new Exception('Internal version mismatch in plugin wordpress-security-txt; it needs to be reinstalled.');
        }
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
        $defaults['class'] = $defaults['description'] = $defaults['label'] = '';
        $defaults['name']  = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['value'] = 0;

        apply_filters($this->plugin_name . '-field-checkbox-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[$atts['id']])) {
            $atts['value'] = $this->options[$atts['id']];
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-checkbox.php';
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
        $defaults['description'] = $defaults['value'] = '';
        $defaults['settings']    = ['textarea_name' => $this->plugin_name . '-options[' . $args['id'] . ']'];

        apply_filters($this->plugin_name . '-field-editor-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[$atts['id']])) {
            $atts['value'] = $this->options[$atts['id']];
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-editor.php';
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
        $defaults['class'] = $defaults['label'] = $defaults['description'] = '';
        $defaults['name']  = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['value'] = 0;

        apply_filters($this->plugin_name . '-field-radios-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[$atts['id']])) {
            $atts['value'] = $this->options[$atts['id']];
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-radios.php';
    }

    public function repeater($args)
    {
        $defaults['class']        = 'repeater';
        $defaults['fields']       = [];
        $defaults['id']           = $defaults['title-field'] = '';
        $defaults['label-add']    = 'Add Item';
        $defaults['label-edit']   = 'Edit Item';
        $defaults['label-header'] = 'Item Name';
        $defaults['label-remove'] = 'Remove Item';

        apply_filters($this->plugin_name . '-field-repeater-options-defaults', $defaults);

        $setatts  = wp_parse_args($args, $defaults);
        $count    = 1;
        $repeater = [];

        if (! empty($this->options[$setatts['id']])) {
            $repeater = maybe_unserialize($this->options[$setatts['id']][0]);
        }

        if (! empty($repeater)) {
            $count = count($repeater);
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-repeater.php';
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
        $defaults['aria']       = $defaults['blank'] = $defaults['context'] = $defaults['description'] = $defaults['label'] = $defaults['value'] = '';
        $defaults['class']      = 'widefat';
        $defaults['name']       = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['selections'] = [];

        apply_filters($this->plugin_name . '-field-select-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[$atts['id']])) {
            $atts['value'] = $this->options[$atts['id']];
        }

        if (empty($atts['aria']) && ! empty($atts['description'])) {
            $atts['aria'] = $atts['description'];
        } elseif (empty($atts['aria']) && ! empty($atts['label'])) {
            $atts['aria'] = $atts['label'];
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-select.php';
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
        $defaults['placeholder'] = $defaults['description'] = $defaults['label'] = '';
        $defaults['class']       = 'text widefat';
        $defaults['name']        = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['type']        = 'text';
        $defaults['value']       = isset($args['value']) && ! empty($args['value']) ? $args['value'] : '';

        apply_filters($this->plugin_name . '-field-text-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[$atts['id']])) {
            $atts['value'] = $this->options[$atts['id']];
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-text.php';
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
        $defaults['context'] = $defaults['description'] = $defaults['label'] = $defaults['placeholder'] = '';
        $defaults['class']   = 'large-text';
        $defaults['cols']    = 50;
        $defaults['name']    = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['rows']    = 10;
        $defaults['value']   = isset($args['value']) && ! empty($args['value']) ? $args['value'] : '';

        apply_filters($this->plugin_name . '-field-textarea-options-defaults', $defaults);

        $atts = wp_parse_args($args, $defaults);

        if (! empty($this->options[$atts['id']])) {
            $atts['value'] = $this->options[$atts['id']];
        }

        require plugin_dir_path(__FILE__) . 'partials/' . $this->plugin_name . '-field-textarea.php';
    }
}
