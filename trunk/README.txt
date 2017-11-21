=== wp-security-txt ===
Plugin Name: wp-security-txt
Contributors: securitytxt
Donate link: https://securitytxt.org/
Tags: security, infosec, netsec, security.txt, responsible disclosure, bug bounty
Requires at least: 4.9
Tested up to: 4.9
Stable tag: 4.9
Requires PHP: 7.0
License: MIT License
License URI: https://github.com/austinheap/wordpress-security-txt/blob/master/LICENSE.md
GitHub Plugin URI: https://github.com/austinheap/wordpress-security-txt
GitHub Languages:  https://github.com/austinheap/wordpress-security-txt-translations

A plugin for serving 'security.txt' in WordPress 4.9+, based on configuration settings.

== Description ==

The purpose of this project is to create a set-it-and-forget-it plugin that can be installed without much effort to get a WordPress site compliant with the current [`security.txt`](https://securitytxt.org/) spec. It is therefore highly opinionated but built for configuration. It will automatically configure itself but you are encouraged to visit the plugin settings page after activating it.

[`security.txt`](https://github.com/securitytxt) is a [draft](https://tools.ietf.org/html/draft-foudil-securitytxt-00) "standard" which allows websites to define security policies. This "standard" sets clear guidelines for security researchers on how to report security issues, and allows bug bounty programs to define a scope. Security.txt is the equivalent of `robots.txt`, but for security issues.

There is a help page built into the plugin if you need help configuring it. For developers, there is [documentation for `wordpress-security-txt` online](https://austinheap.github.io/wordpress-security-txt/), the source of which is in the [`docs/`](https://github.com/austinheap/wordpress-security-txt/tree/master/docs) directory. The most logical place to start are the [docs for the `WordPress_Security_Txt` class](https://austinheap.github.io/wordpress-security-txt/packages/WordPress.Security.Txt.html).

== Installation ==

This section describes how to install `wordpress-security-txt` and get it working.

1. Upload `wordpress-security-txt` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Configure the plugin using the 'settings.txt' link under 'Settings'.

== Frequently Asked Questions ==

= Where should I report bugs I encounter? =

Please report any issues you encounter via the [GitHub issues tracker](https://github.com/austinheap/laravel-security-txt/issues).

= How can I contribute to the code base? =

If you'd like to contribute to this plugin, [pull requests](https://github.com/austinheap/laravel-security-txt/pulls) are welcome. For more information please see [CONTRIBUTING.md](https://github.com/austinheap/laravel-security-txt/blob/master/CONTRIBUTING.md).

= What version of the `security.txt` spec does this plugin implement? =

This version of the plugin implements the `security.txt` specification found in the plugin folder. The specification the plugin implements is also [available online](https://github.com/austinheap/laravel-security-txt/blob/master/SPECIFICATION.md) or via the 'settings.txt Help' page in the WordPress admin.

= Can I add more than one `Contact` directive? =

While the specification explicitly allows for more than one `Contact` directive, this plugin currently only supports a single entry.

== Screenshots ==

1. Easily control the declaratives of your `security.txt` document.
2. Generates valid `security.txt` documents for the latest spec.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
* Initial release.

== Translations ==

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

If you would like to contribute a new languge or you spotted in error in one of the translation files, please feel free to contribute directly to the [public `wordpress-security-txt` POEditor project](https://poeditor.com/join/project/utTvBn327C). Once accepted additions/modifications are automagically built by POEditor to PO/MO files and published to the [wordpress-security-txt-translation](https://github.com/austinheap/wordpress-security-txt-translations) repository.

The translations repository is included in builds submitted to the WordPress plugin directory. Users with the [GitHub Updater Plugin](https://github.com/afragen/github-updater) don't have to wait for builds to the WordPress plugin directory -- they can get updated translations as soon as they're published to the repository by POEditor.

== Anonymous Statistics (Opt-in) ==

This plugin has an option --- that is **disabled** by default and _can only be enabled by explicilty opt-ing in_ on the `security.txt` Settings page --- to collect anonymous statistics to help better understand how this plugin is used and how people are implementing their `security.txt` documents. The goal of collecting this data is to aid in research and design of the [specification](https://tools.ietf.org/html/draft-foudil-securitytxt-00), the [PHP library](https://github.com/austinheap/php-security-txt), the [plugin](https://github.com/austinheap/wordpress-security-txt) itself, and to help us create a better experience for all users.

For example, one function of anonymous statistics is to send your <code>security.txt</code> document to our servers. This allows us to track what percent of users are implementing the specification according to the draft RFC, and how it might differ from the explicit definitions submitted to the [Internet Engineering Task Force (IETF)](https://www.ietf.org/).

We respect your privacy and are happy to clarify on any aspect of the statistics collection and analysis. More importantly, you can [verify this in the code for yourself on GitHub](https://github.com/austinheap/wordpress-security-txt/tree/master/trunk).

We do not track **any** personally-identifiable information and we are committed to protecting your privacy. With regards to performance, the tracking is implemented in such a way so as to not impact of your WordPress site at all.

== Badges ==

All the badges!

[![Current Release](https://img.shields.io/github/release/austinheap/wordpress-security-txt.svg)](https://github.com/austinheap/wordpress-security-txt/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/austinheap/wordpress-security-txt.svg)](https://packagist.org/packages/austinheap/wordpress-security-txt)
[![Build Status](https://travis-ci.org/austinheap/wordpress-security-txt.svg?branch=master)](https://travis-ci.org/austinheap/wordpress-security-txt)
[![Dependency Status](https://gemnasium.com/badges/github.com/austinheap/wordpress-security-txt.svg)](https://gemnasium.com/github.com/austinheap/wordpress-security-txt)
[![Scrutinizer CI](https://scrutinizer-ci.com/g/austinheap/wordpress-security-txt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/austinheap/wordpress-security-txt/?branch=master)
[![StyleCI](https://styleci.io/repos/111479243/shield?branch=master)](https://styleci.io/repos/111479243)
[![Maintainability](https://api.codeclimate.com/v1/badges/0de909dca20d2670d774/maintainability)](https://codeclimate.com/github/austinheap/wordpress-security-txt/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/0de909dca20d2670d774/test_coverage)](https://codeclimate.com/github/austinheap/wordpress-security-txt/test_coverage)
[![SensioLabs](https://insight.sensiolabs.com/projects/5d9ed5a0-dbd0-45be-a92c-6d827483e742/mini.png)](https://insight.sensiolabs.com/projects/5d9ed5a0-dbd0-45be-a92c-6d827483e742)
