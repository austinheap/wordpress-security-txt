# WordPress 4.9+ `security.txt` Plugin

[![Current Release](https://img.shields.io/github/release/austinheap/wordpress-security-txt.svg)](https://github.com/austinheap/wordpress-security-txt/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/austinheap/wordpress-security-txt.svg)](https://packagist.org/packages/austinheap/wordpress-security-txt)
[![Build Status](https://travis-ci.org/austinheap/wordpress-security-txt.svg?branch=master)](https://travis-ci.org/austinheap/wordpress-security-txt)
[![Dependency Status](https://gemnasium.com/badges/github.com/austinheap/wordpress-security-txt.svg)](https://gemnasium.com/github.com/austinheap/wordpress-security-txt)
[![Scrutinizer CI](https://scrutinizer-ci.com/g/austinheap/wordpress-security-txt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/austinheap/wordpress-security-txt/?branch=master)
[![StyleCI](https://styleci.io/repos/111479243/shield?branch=master)](https://styleci.io/repos/111479243)
[![Maintainability](https://api.codeclimate.com/v1/badges/0de909dca20d2670d774/maintainability)](https://codeclimate.com/github/austinheap/wordpress-security-txt/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/0de909dca20d2670d774/test_coverage)](https://codeclimate.com/github/austinheap/wordpress-security-txt/test_coverage)
[![SensioLabs](https://insight.sensiolabs.com/projects/5d9ed5a0-dbd0-45be-a92c-6d827483e742/mini.png)](https://insight.sensiolabs.com/projects/5d9ed5a0-dbd0-45be-a92c-6d827483e742)

## A plugin for serving `security.txt` in WordPress 4.9+, based on configuration settings.

***NOTE: This plugin requires PHP 7+. It will not function with PHP5.***

The purpose of this project is to create a set-it-and-forget-it plugin that can be
installed without much effort to get a WordPress site compliant with the current
[`security.txt`](https://securitytxt.org/) spec. It is therefore highly opinionated
but built for configuration. It will automatically configure itself but you are
encouraged to visit the plugin settings page after activating it.

[`security.txt`](https://github.com/securitytxt) is a [draft](https://tools.ietf.org/html/draft-foudil-securitytxt-00)
"standard" which allows websites to define security policies. This "standard"
sets clear guidelines for security researchers on how to report security issues,
and allows bug bounty programs to define a scope. Security.txt is the equivalent
of `robots.txt`, but for security issues.

There is [documentation for `wordpress-security-txt` online](https://austinheap.github.io/wordpress-security-txt/),
the source of which is in the [`docs/`](https://github.com/austinheap/wordpress-security-txt/tree/master/docs)
directory. The most logical place to start are the [docs for the `WordPress_Security_Txt` class](https://austinheap.github.io/wordpress-security-txt/packages/WordPress.Security.Txt.html).

## Installation

### Step 1: Download a release

Navigate over to the releases page and download the latest release.

### Step 2: Upload the plugin to WordPress

In the admin section of your WordPress installation, navigate to 'Plugins' and click 'Add New Plugin'.
You will then be select the release you downloaded and upload it. It should be a zip file. After
it has installed click 'Active' next to the plugin name.

### Step 3: Configure your `security.txt` for WordPress (Optional)

The plugin will autoconfigure itself using settings from your Wordpress installation. You are encouarge
though to naviate over to the `security.txt` options page to customize your declarations and the plugin.
This is located under the 'Settings' admin menu, or if you have the menu bar option enabled it will also
be accessible via the top of your admin dashboard.

### Step 4: Profit! 

Your `security.txt` file should now be available at [http://your-awesome-wordpress-site.com/.well-known/security.txt](#)!

If you have added your public GPG encryption key, it'll also be available at [http://your-awesome-wordpress-site.com/.well-known/gpg.txt](#).

## Translations

The `security.txt` for WordPress plugin includes translations for the following 17 languages:

* Arabic ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-ar_AR.po))
* Bengali ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-bn_BN.po))
* Catalan ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-ca_ES.po))
* Chinese (Simplified) ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-zh_CN.po))
* Chinese (Traditional) ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-zh_TW.po))
* English ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-en_EN.po))
* English (AU) ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-en_AU.po))
* English (US) ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-en_US.po))
* French ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-fr_FR.po))
* German ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-de_DE.po))
* Hindi ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-hi_IN.po))
* Italian ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-it_IT.po))
* Portuguese ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-pt_PT.po))
* Portuguese (BR) ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-pt_BR.po))
* Romanian ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-ro_RO.po))
* Russian ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-ru_RU.po))
* Spanish ([PO file](https://github.com/austinheap/wordpress-security-txt-translations/blob/master/wordpress-security-txt-es_ES.po))

If you would like to contribute a new languge or you spotted in error in one of the
translation files, please feel free to contribute directly to the
[public `wordpress-security-txt` POEditor project](https://poeditor.com/join/project/utTvBn327C). Once
accepted additions/modifications are automagically built by POEditor to PO/MO files and
published to the [wordpress-security-txt-translation](https://github.com/austinheap/wordpress-security-txt-translations)
repository.

The translations repository is included in builds submitted to the WordPress plugin directory.
Users with the [GitHub Updater Plugin](https://github.com/afragen/github-updater) don't
have to wait for builds to the WordPress plugin directory -- they can get updated translations
as soon as they're published to the repository by POEditor.

## References

- [A Method for Web Security Policies (draft-foudil-securitytxt-00)](https://tools.ietf.org/html/draft-foudil-securitytxt-00)
- [php-security-txt](https://github.com/austinheap/php-security-txt)

## Credits

This is a fork of [DevinVinson/WordPress-Plugin-Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate),
which was based on earlier work.

- [DevinVinson/WordPress-Plugin-Boilerplate Contributors](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
