<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

?>

<script type="text/javascript">
window.WORDPRESS_SECURITY_TXT_VERSION = '<?php echo $this->version; ?>';
window.WORDPRESS_SECURITY_TXT_ADMIN = true;
</script>

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    <form method="post" action="options.php">
		<?php

        settings_fields($this->plugin_name);

        do_settings_sections($this->plugin_name);

        submit_button(
            'Loading...',
            'primary',
            'wordpress-security-txt[submit]',
            false,
            ['disabled' => 'disabled']
        );

        ?>
        <input type="button" name="wordpress-security-txt[reset]" value="Reset to Defaults" disabled="disabled" />
        <input type="hidden" name="wordpress-security-txt-options[reset]" value="WORDPRESS_SECURITY_TXT_DO_NOT_RESET" />
    </form>
</div>

<form id="wordpress-security-txt[file_input]">
    <input type="file" />
</form>
