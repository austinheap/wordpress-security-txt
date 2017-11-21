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
        <h3><a name="overview"></a>Overview</h3>
        <p>
            You are running <code>wordpress-security-txt v<?php echo WORDPRESS_SECURITY_TXT_VERSION ?></code>. Please
            report any issues you encounter via the <a href="<?php echo $links['issues']; ?>">GitHub issues tracker</a>.
            If you'd like to contribute to this plugin, <a href="<?php echo $links['pulls']; ?>">pull requests</a> are
            welcome. For more information please see <a href="<?php echo $links['contributing']; ?>">CONTRIBUTING.md</a>.
        </p>
        <h3><a name="specification"></a>Specification</h3>
        <p>
            This version of the plugin implements the <code>security.txt</code>
            <a href="<?php echo $links['specification']; ?>">specification</a> as follows:
        </p>
        <div class="specification">
            <pre><?php echo htmlspecialchars(file_get_contents(plugin_dir_path(__FILE__) . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'SPECIFICATION.txt')); ?></pre>
        </div>
        <h3><a name="statistics"></a>Anonymous Statistics</h3>
        <p>
            This plugin has an option &mdash; that is <strong>disabled</strong> by default and <em>can only be enabled
            by explicilty opt-ing in</em> on the <a href="?page=wordpress-security-txt"><code>security.txt</code>
            Settings</a> page &mdash; to collect anonymous statistics to help better understand how this plugin
            is used and how people are implementing their <code>security.txt</code> documents. The goal of collecting
            this data is to aid in research and design of the specification, the PHP library, the plugin itself, and to
            help us create a better experience for all users.
        </p>
        <p>
            For example, one function of anonymous statistics is to send your <code>security.txt</code> document to our
            servers. This allows us to track what percent of users are implementing the specification according to the
            draft RFC, and how it might differ from the explicit definitions submitted to the
            <a href="https://www.ietf.org/">Internet Engineering Task Force (IETF)</a>.
        </p>
        <p>
            We respect your privacy and are happy to clarify on any aspect of the statistics collection and analysis.
            More importantly, you can <a href="https://github.com/austinheap/wordpress-security-txt">verify this in the
            code for yourself on GitHub</a>.
        </p>
        <p>
            We do not track <strong>any</strong> personally-identifiable information and we are committed to protecting
            your privacy. With regards to performance, the tracking is implemented in such a way so as to not impact of
            your WordPress site at all.
        </p>
    </div>

<?php

unset($links);
