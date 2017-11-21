<?php

/**
 * Provides the markup for any text field
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

?><input
    class="<?php echo esc_attr($atts['class']); ?>"
    id="<?php echo esc_attr($atts['id']); ?>"
    name="<?php echo esc_attr($atts['name']); ?>"
    placeholder="<?php echo esc_attr($atts['placeholder']); ?>"
    type="<?php echo esc_attr($atts['type']); ?>"
    value="<?php echo esc_attr($atts['value']); ?>" /><?php

if (! empty($atts['description'])) {
    ?><span class="description"><?php esc_html_e($atts['description'], 'wordpress-security-txt'); ?></span><?php
}
