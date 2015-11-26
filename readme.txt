=== Maintenance Mode ===
Contributors: LukasNeptun
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2XPA4CKT836FJ
Tags: maintenance, maintenance mode, website maintenance, coming soon, coming soon page, mode, wordpress maintenance mode, site maintenance, site offline, offline mode admin, unavailable, administration, construction, offline, offline mode, maintenance plugin, plugin, wordpress maintenance plugin, lukas juhas, under construction, unavailable, landing page, landing,
Requires at least: 3.5
Tested up to: 4.4
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Very simple Maintenance Mode & Coming soon page. Using default Wordpress markup, No ads, no paid upgrades.

== Description ==

As a web developer working with Wordpress almost every day, very often I came across problem that If I wanted simple maintenance plugin to do some updates on my or client's website, I came across all these useless and overcomplicated plugins until I decided that I'll make one myself which will be the one I'll be confident and happy to use with ease.

Maintenance Mode is very simple and it's using Wordpress's wp_die() function which is core function of Wordpress, which makes this plugin feel and work as a part of Wordpress core. There is settings page under "Settings" in the main wp-admin menu where you can enable maintenance mode or change content using WYSIWYG editor so you can also add pictures, links etc. When activated and logged in as admin, you can see website as usual, rest of the users / visitors can see maintenance mode. You can see the maintenance mode as admin in preview mode using preview link on the settings page or simply open website in private mode or different browser to double check if it's enabled and working. There is also indicator in admin bar that changes colour to red when maintenance mode is enabled.

Help support and translate this plugin!

**Features:**

* **Simplicity** - Built to be as simple as possible. Easy to use.
* **Customisable** - WYSIWYG available in full glory. You can add images and other media including links and pretty much everything you can do with WYSIWYG. Text / Code tab is available too for custom markup.
* **Works on mobile** - Because of it's simplicity, maintenance mode works very well on mobile devices.
* **NO ADS** - No ads. Seriously.
* **NO PAID UPGRADES** - No paid upgrades. Seriously.
* **Updates** - Regular updates and maintenance.
* **Support** - Support button available.
* **Preview** - Preview button available.
* **Compact** - It's developed to be as compact as possible.

> <strong>Important! Users that are using Cache plugins, please read below:</strong><br>
> <strong>When enabling or disabling Maintenance Mode, don't forget to flush your cache!</strong>

Having trouble? Please read FAQ first, if you need any assistance, you can use support button on the settings page of the Maintenance Mode.

> <strong>Development on GitHub</strong><br>
> The development of Maintenance Mode [takes place on GitHub](https://github.com/lukasjuhas/lj-maintenance-mode). Bugs and pull requests are welcomed there.

== Installation ==

1. Upload `lj-maintenance-mode` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Settings -> Maintenance Mode  or simply click on Admin Bar indicator for settings to enable maintenance mode.

== Frequently Asked Questions ==

= Is this plugin really ad free ? =

Yes.

= Can I change background colour? =

Not by default. Unless you are developer and you "inject" your own styles in to the wp_die() page.

Plugin doesn't seem to work. What should I do ?

First, if you are using Cache plugin such as WP Super Cache or W3 Total Cache, flush all your cache. Secondly, disable all other plugins and try enabling just Maintenance Mode and see if problem persist. This should solve most common problems. If not, don't hesitate to contact me via Support button from Settings page

== Screenshots ==

1. Example with default message.
2. Admin Bar Indicator (Red when active)
3. Settings page in admin view with default message.
4. Example with image and link.
5. Insert Media available for WYSIWYG.

== Changelog ==
= 2.0 =
* Add hooks for add-ons

= 1.4 =
* Bug fixes (Thanks to [@gablau](https://github.com/gablau))
* Security fixes - saving content more safely (Thanks to [@gablau](https://github.com/gablau))
* Languages: Add Italian (100%) (Thanks to [@gablau](https://github.com/gablau))
* Add compatibility while installed along with wp-maintenance-mode [@gablau](https://github.com/gablau))
* Code: Avoid duplicating same code and use it as method instead.
* Code: Tidy up default messages and group them together within method to avoid repeating yourself and also searching all across code in order to change the messages in the future.

= 1.3.3 =
* Improvement: If MM is enabled, added message describing how to check if the maintenance mode is enabled as this was causing lot of confusion and unnecessary support tickets.
* Improvement: Move preview and support buttons to a more convenient place, also highlight the preview button.
* Languages: Add Canadian (100%), Hungarian(83%) languages.

= 1.3.2 =
* Fixed: Issue where non admin users could see admin bar indicator.

= 1.3.1 =
* Google is being notified right way from now on.
* Typo corrections
* General code tidy up

= 1.3 =
* Translations adjustments and corrections. Plugin is now fully translatable.
* Small code refactor and tidy up.
* Correct various typo issues.

= 1.2.1 =
* Bug fixes.
* Deprecated clear cache functionality as it caused errors to some users. From now on, plugin shows simple reminder to flush cache after enabling or disabling Maintenance Mode.

= 1.2 =
* Improvement: Improved Multisite Support.
* Improvement: Show default maintenance message in the settings.
* Improvement: Uninstalling will now clean up database.
* Improvement: Added support link to the settings page.
* Improvement: Translatable strings.
* Improvement: Changed default site title while MM is active.
* Improvement: Added preview button.
* Improvement: Added support button.
* Improvement: Added support for WP Super Cache.
* Improvement: Added support for W3 Total Cache.
* Bug Fixes.

= 1.1.1 =
* Bug Fixes.

= 1.1 =
* Added Indicator to Admin menu bar.
* Added Settings button on plugins page.
* Added Default maintenance mode message.
* Bug Fixes.

= 1.0 =
* First release.

== Upgrade Notice ==

= 1.3 =
* This updates includes new features and changes regarding translations and various bug fixes.
