=== Maintenance Mode ===
Contributors: LukasNeptun
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2XPA4CKT836FJ
Tags: maintenance, maintenance mode, coming soon, coming soon page, mode, wordpress maintenance mode, site maintenance, site offline, offline mode admin, unavailable, administration, construction, offline, offline mode, maintenance plugin, plugin, wordpress maintenance plugin, lukas juhas, under construction, unavailable, landing page, landing,
Requires at least: 3.8.0
Tested up to: 4.3
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Very simple Maintenance Mode & Coming soon page. Using default Wordpress markup, No adds, no paid upgrades.

== Description ==

Very simple maintenance plugin for your website using Wordpress's wp_die() function, there is settings page under "Settings" where you can enable maintenance mode or set your custom message. There is also a default message. When activated and logged as admin, you can see website as usual, just rest of the users / visitors can see maintenance mode. You can see the maintenance mode as admin using preview button or simply opening your website in private mode. There is also indicator in admin bar that changes colour to red when maintenance mode is enabled.

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

= Can I change colours? =

Not by default. Unless you are developer and you "inject" your own styles in to the wp_die() page.

Plugin doesn't seem to work. What should I do ?

First, if you are using Cache plugin such as WP Super Cache or W3 Total Cache, flush all your cache. Secondly, disable all other plugins and try enabling just Maintenance Mode and see if problem persist. This should solve most common problems. If not, don't hesitate to contact me via Support button from Settings page

== Screenshots ==

1. Example
2. Admin Bar Indicator (Red when active)
3. wp-admin settings page

== Changelog ==

= 1.2.1 =
* Bug fixes
* Deprecated clear cache functionality as it caused errors to some users. From now on, plugin shows simple reminder to flush cache after enabling or disabling Maintenance Mode.

= 1.2 =
* Improvement: Improved Multisite Support
* Improvement: Show default maintenance message in the settings
* Improvement: Uninstalling will now clean up database
* Improvement: Added support link to the settings page
* Improvement: Translatable strings
* Improvement: Changed default site title while MM is active
* Improvement: Added preview button
* Improvement: Added support button
* Improvement: Added support for WP Super Cache
* Improvement: Added support for W3 Total Cache
* Bug Fixes

= 1.1.1 =
* Bug Fixes

= 1.1 =
* Added Indicator to Admin menu bar
* Added Settings button on plugins page
* Added Default maintenance mode message.
* Bug Fixes

= 1.0 =
* First release

== Upgrade Notice ==

= 1.1 =
New Features and Bug Fixes
