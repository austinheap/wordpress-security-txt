(function( $ ) {
	'use strict';

    $(function() {
        // Only execute on the plugin settings page
        if (typeof window.WORDPRESS_SECURITY_TXT_ADMIN === 'undefined') {
            return;
        }

        // Show/hide when enabled/disabled
        jQuery('input[name="wordpress-security-txt-options[enable]"]').change(function () {
            if (jQuery(this)[0].checked) {
                jQuery('.hide-when-disabled').closest('tr').fadeIn();
                jQuery('p.hide-when-disabled, div.hide-when-disabled').fadeIn().prev().fadeIn();
            } else {
                jQuery('.hide-when-disabled').closest('tr').fadeOut();
                jQuery('p.hide-when-disabled, div.hide-when-disabled').fadeOut().prev().fadeOut();
            }
        }).trigger('change');

        jQuery('input[name="wordpress-security-txt-options[debug]"]').change(function () {
            if (jQuery(this)[0].checked) {
                jQuery('div[id="wordpress-security-txt-sections[debug]"]').fadeIn().prev().fadeIn();
            } else {
                jQuery('div[id="wordpress-security-txt-sections[debug]"]').fadeOut().prev().fadeOut();
            }
        }).trigger('change');

        // Inject multi-line encryption placeholder
        jQuery('textarea[name="wordpress-security-txt-options[encryption]"]').attr('placeholder',
            '-----BEGIN PGP PUBLIC KEY BLOCK-----\n' +
            'mQINBFez...\n' +
            '-----END PGP PUBLIC KEY BLOCK-----\n'
        );

        // Add inline upload if browser supports it
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            jQuery('textarea[name="wordpress-security-txt-options[encryption]"]')
                .after('<input type="button" name="wordpress-security-txt-options[encryption][file_input]" value="Select file...">');

            jQuery('input[name="wordpress-security-txt-options[encryption][file_input]"]')
                .click(function () {
                    jQuery('form[id="wordpress-security-txt[file_input]"] input')
                        .attr('data-target', 'textarea[name="wordpress-security-txt-options[encryption]"]')
                        .click();
                });

            jQuery('form[id="wordpress-security-txt[file_input]"] input').change(function () {
                var fileReader = new FileReader();

                fileReader.onload = function () {
                    var targetInput = jQuery('form[id="wordpress-security-txt[file_input]"] input').attr('data-target');

                    jQuery(targetInput).val(fileReader.result);

                    setTimeout(function () {
                        console.log('done!'+targetInput);
                        jQuery(targetInput).click();
                    }, 250);
                };

                fileReader.readAsText(jQuery(this).prop('files')[0]);
            });
        }

        // Inject settings reset controls
        jQuery('input[name="wordpress-security-txt[reset]"]').click(function () {
            jQuery('input[name="wordpress-security-txt-options[reset]"]')
                .val('WORDPRESS_SECURITY_TXT_RESET_REQUESTED');

            jQuery('input[name="wordpress-security-txt[submit]"]')
                .click();
        });

        // Add validation handlers
        jQuery('input[name="wordpress-security-txt-options[contact]"]').on('click keyup keypress blur change focus', function () {
            window.WORDPRESS_SECURITY_TXT_VALIDATORS.apply(jQuery(this), 'contact');
        }).trigger('click');

        jQuery('textarea[name="wordpress-security-txt-options[encryption]"]').on('click keyup keypress blur change focus', function () {
            window.WORDPRESS_SECURITY_TXT_VALIDATORS.apply(jQuery(this), 'encryption');
        }).trigger('click');

        jQuery('input[name="wordpress-security-txt-options[acknowledgement]"]').on('click keyup keypress blur change focus', function () {
            window.WORDPRESS_SECURITY_TXT_VALIDATORS.apply(jQuery(this), 'acknowledgement');
        }).trigger('click');

        // Append plugin version (on plugin settings page only)
        jQuery('div#wpfooter p#footer-upgrade').html(
            jQuery('div#wpfooter p#footer-upgrade').html().trim() +
            ', <code>wordpress-security-txt</code> Version ' +
            WORDPRESS_SECURITY_TXT_VERSION
        );
    });

})( jQuery );

