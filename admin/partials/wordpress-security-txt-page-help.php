<?php

/**
 * Provide a admin area help view for the plugin
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

$links = [
	'repo'          => 'https://github.com/austinheap/wordpress-security-txt',
	'issues'        => 'https://github.com/austinheap/laravel-security-txt/issues',
	'pulls'         => 'https://github.com/austinheap/laravel-security-txt/pulls',
	'readme'        => 'https://github.com/austinheap/laravel-security-txt/blob/master/README.md',
	'license'       => 'https://github.com/austinheap/laravel-security-txt/blob/master/LICENSE.md',
	'contributing'  => 'https://github.com/austinheap/laravel-security-txt/blob/master/CONTRIBUTING.md',
	'specification' => 'https://github.com/austinheap/laravel-security-txt/blob/master/SPECIFICATION.md',
];

?>

    <div class="wrap">
        <h2>security.txt Help</h2>
        <p>
            You are running <code>wordpress-security-txt v<?php echo WORDPRESS_SECURITY_TXT_VERSION ?></code>. Please
            report any issues you encounter via the <a href="<?php echo $links['issues']; ?>">GitHub issues tracker</a>.
            If you'd like to contribute to this plugin, <a href="<?php echo $links['pulls']; ?>">pull requests</a> are
            welcome. For more information please see <a href="<?php echo $links['contributing']; ?>">CONTRIBUTING.md</a>.
        </p>
        <p>
            This version of the plugin implements the <code>security.txt</code>
            <a href="<?php echo $links['specification']; ?>">specification</a> as follows:
        </p>
        <div class="specification">
            <pre><?php echo htmlspecialchars( file_get_contents( plugin_dir_path( __FILE__ ) . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'SPECIFICATION.txt' ) ); ?></pre>
        </div>
    </div>

<?php

unset( $links );
