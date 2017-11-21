<?php

/**
 * Provides the markup for a repeater field
 *
 * Must include an multi-dimensional array with each field in it. The
 * field type should be the key for the field's attribute array.
 *
 * $fields['file-type']['all-the-field-attributes'] = 'Data for the attribute';
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

?>
<ul class="repeaters">
    <?php

    for ($i = 0; $i <= $count; $i++) {
        if ($i === $count) {
            $setatts['class'] .= ' hidden';
        }

        if (! empty($repeater[$i][$setatts['title-field']])) {
            $setatts['label-header'] = $repeater[$i][$setatts['title-field']];
        } ?>
        <li class="<?php echo esc_attr($setatts['class']); ?>">
            <div class="handle">
                <span class="title-repeater"><?php echo esc_html($setatts['label-header']); ?></span>
                <button aria-expanded="true" class="btn-edit" type="button">
                <span class="screen-reader-text"><?php echo esc_html($setatts['label-edit']); ?></span>
                    <span class="toggle-arrow"></span>
                </button>
            </div>
            <div class="repeater-content">
                <div class="wrap-fields">
                    <?php

                    foreach ($setatts['fields'] as $fieldcount => $field) {
                        foreach ($field as $type => $atts) {
                            if (! empty($repeater) && ! empty($repeater[$i][$atts['id']])) {
                                $atts['value'] = $repeater[$i][$atts['id']];
                            }

                            $atts['id']   .= '[]';
                            $atts['name'] .= '[]'; ?><p class="wrap-field"><?php

                            require plugin_dir_path(__FILE__) . $this->plugin_name . '-field-' . $type . '.php'; ?>
                            </p>
                            <?php
                        }
                    } ?>
                </div>
                <div>
                    <a class="link-remove" href="#">
						<span>
                            <?php
                            echo esc_html(apply_filters($this->plugin_name . '-repeater-remove-link-label',
                                $setatts['label-remove'])); ?>
                        </span>
                    </a>
                </div>
            </div>
        </li>
        <?php
    }
    ?>
    <div class="repeater-more">
        <span id="status"></span>
        <a class="button" href="#" id="add-repeater">
            <?php
            echo esc_html(apply_filters($this->plugin_name . '-repeater-more-link-label', $setatts['label-add']));
            ?>
        </a>
    </div>
</ul>
