(function( $ ) {
    'use strict';

    $(function() {
        // Only execute on the plugin settings page
        if (typeof window.WORDPRESS_SECURITY_TXT_ADMIN === 'undefined') {
            return;
        }

        // Inject validation methods
        window.WORDPRESS_SECURITY_TXT_VALIDATORS = {
            apply: function (selector, field) {
                var valid = null;
                var data = jQuery(selector).val();

                switch (field) {
                    case 'contact': valid = this.contact(data); break;
                    case 'encryption': valid = this.encryption(data); break;
                    case 'acknowledgement': valid = this.acknowledgement(data); break;
                }

                this.stylize(selector, valid);
            },
            stylize: function (selector, valid) {
                if ( valid ) {
                    jQuery(selector).removeClass('error');
                } else {
                    jQuery(selector).addClass('error');
                }

                jQuery('input[name="wordpress-security-txt[submit]"]')
                    .prop('disabled', !valid)
                    .val(valid ? 'Save Changes' : 'Save Changes (Fix Errors First!)');
            },
            contact: function (data) {
                return this._email(data, true) || this._url(data, true);
            },
            encryption: function (data) {
                return this._pgp(data, false);
            },
            acknowledgement: function (data) {
                return this._url(data, false);
            },
            _email: function(data, required) {
                data = data.trim();

                if (data == '') {
                    return !required;
                }

                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,24})+$/;

                return data.match(mailformat);
            },
            _url: function(data, required) {
                data = data.trim();

                if (data == '') {
                    return !required;
                }

                return /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test( data );
            },
            _pgp: function(data, required) {
                data = data.trim();

                if (data == '') {
                    return !required;
                }

                return data.startsWith('-----BEGIN PGP PUBLIC KEY BLOCK-----') &&
                    data.endsWith('-----END PGP PUBLIC KEY BLOCK-----');
            }
        };

    });

})( jQuery );

