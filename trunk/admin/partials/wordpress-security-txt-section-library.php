<?php

/**
 * Provide a view for the library section
 *
 * @link       https://github.com/austinheap/wordpress-security-txt
 * @since      1.0.0
 *
 * @package    WordPress_Security_Txt
 * @subpackage WordPress_Security_Txt/admin/partials
 */

?>

<p id="wordpress-security-txt-sections[library]" class="hide-when-disabled">
    This plugin uses the library
    <code>
        <a href="https://github.com/austinheap/php-security-txt">php-security-txt</a>
        <a href="https://github.com/austinheap/php-security-txt/tree/v<?php echo \AustinHeap\Security\Txt\SecurityTxt::VERSION; ?>">
            v<?php echo \AustinHeap\Security\Txt\SecurityTxt::VERSION; ?>
        </a>
    </code> to maniplate and render your <code>security.txt</code> document. If you'd like to tweak its behaviour,
    you may do so here.
</p>
