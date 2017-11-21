<?php

/**
 * Provides the markup for any checkbox field
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

?><label for="<?php echo esc_attr($atts['id']); ?>">
    <input aria-role="checkbox"
        <?php checked(1, $atts['value'], true); ?>
           class="<?php echo esc_attr($atts['class']); ?>"
           id="<?php echo esc_attr($atts['id']); ?>"
           name="<?php echo esc_attr($atts['name']); ?>"
           type="checkbox"
           value="1"/>
    <span class="description"><?php if (!empty($atts['description_raw'])) {
    print $atts['description_raw'];
} else {
    esc_html_e($atts['description'], 'wordpress-security-txt');
} ?></span>
</label>
