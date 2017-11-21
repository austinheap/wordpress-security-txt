<?php

/**
 * Provide a view for the debug section
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

?>

<div id="wordpress-security-txt-sections[debug]" class="hide-when-disabled">

    <p>
        This plugin was executed with the following configuration. If you're reporting an issue with the plugin please
        include the information below.
    </p>

    <h3>Database</h3>
    <p>Values in the WordPress database <code><?php echo DB_NAME; ?></code> on <code><?php echo DB_HOST; ?></code> for
        option key <code>wordpress-security-txt-options</code> as of <code><?php echo date('c'); ?></code>:</p>
    <ul id="wordpress-security-txt-sections[debug][database]">
		<?php
        foreach (WordPress_Security_Txt_Admin::get_options($this->plugin_name) as $key => $value) {
            if (! is_null($value)) {
                switch (gettype($value)) {
                    case 'boolean':
                        $value = $value ? 'true' : 'false';
                        break;
                }
            }

            if (is_array($value)) {
                ?>
                <li><strong><?php echo $key; ?></strong>: <?php if (! is_null($value)) {
                    ?>
                        <code>[count: <?php echo count($value); ?>]</code> <?php
                } ?>
                    (<em><?php echo gettype($value); ?></em>)
                    <ul>
						<?php
                        foreach ($value as $sub_key => $sub_value) {
                            if (is_array($sub_value)) {
                                ?>
                                <li><strong><?php echo $sub_key; ?></strong>: <?php if (! is_null($sub_value)) {
                                    ?>
                                        <code>[count: <?php echo count($sub_value); ?>]</code> <?php
                                } ?>
                                    (<em><?php echo gettype($sub_value); ?></em>)
                                </li>
                                <ul>
									<?php
                                    foreach ($sub_value as $sub_sub_key => $sub_sub_value) {
                                        if (is_array($sub_sub_value)) {
                                            ?>
                                            <li>
                                                <strong><?php echo $sub_sub_key; ?></strong>: <?php if (! is_null($sub_sub_value)) {
                                                ?>
                                                    <code>[count: <?php echo count($sub_sub_value); ?>
                                                        ]</code> <?php
                                            } ?>
                                                (<em><?php echo gettype($sub_sub_value); ?></em>)
                                                <ul>
                                                    <li>
                                                        <strong>[...]</strong>
                                                        <code>[maximum nesting level reached]</code>
                                                        (<em><?php echo gettype($sub_sub_value); ?></em>)
                                                    </li>
                                                </ul>
                                            </li>
											<?php
                                        } else {
                                            ?>
                                            <li>
                                                <strong><?php echo $sub_sub_key; ?></strong>: <?php if (! is_null($sub_sub_value)) {
                                                ?>
                                                    <code><?php echo $sub_sub_value; ?></code> <?php
                                            } ?>
                                                (<em><?php echo gettype($sub_sub_value); ?></em>)
                                            </li>
											<?php
                                        }
                                    } ?>
                                </ul>
								<?php
                            } else {
                                ?>
                                <li><strong><?php echo $key; ?></strong>: <?php if (! is_null($value)) {
                                    ?>
                                        <code><?php echo $value; ?></code> <?php
                                } ?>
                                    (<em><?php echo gettype($value); ?></em>)
                                </li>
								<?php
                            }
                        } ?>
                    </ul>
                </li>
				<?php
            } else {
                ?>
                <li><strong><?php echo $key; ?></strong>: <?php if (! is_null($value)) {
                    ?>
                        <code><?php echo strlen($value) > 255 ? substr($value, 0, 36) : $value; ?></code><?php echo strlen($value) > 255 ? '...' : ''; ?> <?php
                } ?>(<em><?php echo gettype($value); ?></em>)
                </li>
				<?php
            }
        }
        ?>
    </ul>

    <h3>Cache</h3>
    <p>Details for plugin cache on the WordPress filesystem <code><?php echo get_temp_dir(); ?></code> for <code>wordpress-security-txt</code>:
    </p>
    <ul id="wordpress-security-txt-sections[debug][cache]">
        <li><strong>Enabled</strong>: <?php if (! is_null($this->options['cache'])) {
            ?>
                <code><?php echo $this->options['cache'] ? 'true' : 'false'; ?></code> <?php
        } ?>
            (<em><?php echo gettype($this->options['debug']); ?></em>)
        </li>
		<?php if (isset($this->options['cache']) && $this->options['cache']) {
            ?>
            <li><strong>Location</strong>: <code><?php echo WordPress_Security_Txt_Public::cache_file(); ?></code></li>
            <li><strong>Cleared</strong>:
                <code><?php echo WordPress_Security_Txt_Public::cache_cleared(true) ? 'true' : 'false'; ?></code>
            </li>
            <li><strong>Exists</strong>:
                <code><?php echo is_file(WordPress_Security_Txt_Public::cache_file()) ? 'true' : 'false'; ?></code>
            </li>
			<?php if (is_file(WordPress_Security_Txt_Public::cache_file())) {
                ?>
                <li><strong>File Size</strong>:
                    <code><?php echo filesize(WordPress_Security_Txt_Public::cache_file()); ?> bytes</code></li>
                <li><strong>Creation Time</strong>: <code><?php echo date('c',
                                                                           filectime(WordPress_Security_Txt_Public::cache_file())); ?></code>
                </li>
                <li><strong>Modification Time</strong>: <code><?php echo date('c',
                                                                               filemtime(WordPress_Security_Txt_Public::cache_file())); ?></code>
                </li>
			<?php
            } ?>
		<?php
        } ?>
    </ul>

</div>
