<?php

/**
 * Provides the markup for any textarea field
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

if (! empty($atts['label'])) {
    ?><label for="<?php echo esc_attr($atts['id']); ?>"><?php esc_html_e($atts['label'], 'wordpress-security-txt'); ?>
    : </label><?php
}

?><textarea
        class="<?php echo esc_attr($atts['class']); ?>"
        cols="<?php echo esc_attr($atts['cols']); ?>"
        id="<?php echo esc_attr($atts['id']); ?>"
        placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
        name="<?php echo esc_attr($atts['name']); ?>"
        rows="<?php echo esc_attr($atts['rows']); ?>"><?php

    echo esc_textarea($atts['value']);

    ?></textarea>
<span class="description"><?php esc_html_e($atts['description'], 'wordpress-security-txt'); ?></span>
