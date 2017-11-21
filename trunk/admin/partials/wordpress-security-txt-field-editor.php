<?php

/**
 * Provides the markup for any WP Editor field
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

if (! empty($atts['label'])) {
    ?><label for="<?php

    echo esc_attr($atts['id']); ?>"><?php

    esc_html_e($atts['label'], 'wordpress-security-txt'); ?>: </label><?php
}

wp_editor(html_entity_decode($atts['value']), $atts['id'], $atts['settings']);

?><span class="description"><?php esc_html_e($atts['description'], 'wordpress-security-txt'); ?></span>
