<?php

/**
 * Provides the markup for a select field
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

if (! empty($atts['label'])) {
    ?>
    <label for="<?php echo esc_attr($atts['id']); ?>">
        <?php esc_html_e($atts['label'], 'employees'); ?>:
    </label>
    <?php
}

?>
<select
        aria-label="<?php esc_attr(_e($atts['aria'], $this->plugin_name)); ?>"
        class="<?php echo esc_attr($atts['class']); ?>"
        id="<?php echo esc_attr($atts['id']); ?>"
        name="<?php echo esc_attr($atts['name']); ?>">
    <?php

    if (! empty($atts['blank'])) {
        ?>
        <option value><?php esc_html_e($atts['blank'], $this->plugin_name); ?></option>
        <?php
    }

    foreach ($atts['selections'] as $selection) {
        if (is_array($selection)) {
            $label = $selection['label'];
            $value = $selection['value'];
        } else {
            $label = strtolower($selection);
            $value = strtolower($selection);
        } ?>
        <option value="<?php echo esc_attr($value); ?>"
            <?php selected($atts['value'], $value); ?>>
            <?php esc_html_e($label, $this->plugin_name); ?></option>
        <?php
    }

    ?>
</select>
<span class="description"><?php esc_html_e($atts['description'], $this->plugin_name); ?></span>
</label>
