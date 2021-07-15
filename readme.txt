=== Maintenance Mode ===
Contributors: LukasNeptun
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LL6TN86CDPYQN
Tags: maintenance, maintenance mode, website maintenance, coming soon, under construction, offline, site maintenance,
Requires at least: 3.5
Tested up to: 5.8
Stable tag: 2.4.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Very simple Maintenance Mode & Coming soon page using default Wordpress markup with no ads or paid upgrades.

== Description ==

As a web developer working with Wordpress almost every day, very often I came across problem that If I wanted simple maintenance plugin to do some updates on my or client's website, I came across all these useless and overcomplicated plugins until I decided that I'll make one myself which will be the one I'll be confident and happy to use with ease.

[Maintenance Mode](https://plugins.itsluk.as/maintenance-mode/) is very simple and it's using Wordpress's wp_die() function which is core function of Wordpress, which makes this plugin feel and work as a part of Wordpress core. There is settings page under "Settings" in the main wp-admin menu where you can enable maintenance mode or change content using WYSIWYG editor so you can also add pictures, links etc. When activated and logged in as admin, you can see website as usual, rest of the users / visitors can see maintenance mode. You can see the maintenance mode as admin in preview mode using preview link on the settings page or simply open website in private mode or different browser to double check if it's enabled and working. There is also indicator in admin bar that changes colour to red when maintenance mode is enabled.

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
* **Role Control** - User Role control is available since 2.0
* **Optional widgets** - Optionally add widgets above and/or below the content
* **Optional style sheet** - Optionally add a custom style sheet
* **Optional ability to add code snippet** - Optionally add a code snippet to the page.
* **Support for Analytify plugin** - If you use the Analytify plugin, you can automatically insert the Google Analytics tracking code.

> <strong>Important! Users that are using Cache plugins, please read below:</strong><br>
> <strong>When enabling or disabling Maintenance Mode, don't forget to flush your cache!</strong>

**Filters**
`ljmm_site_title` - Filter page title while in maintenance mode

`ljmm_admin_bar_indicator_enabled` - Control visibility of admin bar indicator

`limm_css_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.css`. (Note: you do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_url` - The url of the css file.

**Actions**
`ljmm_before_mm` - Runs at the beginning of core maintenance method


Having trouble? Please read FAQ first, if you need any assistance, you can use support button on the settings page of the Maintenance Mode.

> <strong>Development on GitHub</strong><br>
> The development of Maintenance Mode [takes place on GitHub](https://github.com/lukasjuhas/lj-maintenance-mode). Bugs and pull requests are welcomed there.

== Installation ==

1. Upload `lj-maintenance-mode` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Settings -> Maintenance Mode, or simply click on Admin Bar indicator for settings to enable maintenance mode.

== Frequently Asked Questions ==

= Plugin doesn't seem to work. What should I do ? =

First, if you are using Cache plugin such as WP Super Cache or W3 Total Cache, flush all your cache. Secondly, disable all other plugins and try enabling just Maintenance Mode and see if problem persist. This should solve most common problems. If not, don't hesitate to contact me via Support button from Settings page

= Can I change background colour? =

Not through the admin interface. You can use a custom stylesheet (see next FAQ) to do this, however.

= What is the default stylesheet? =

By default, the plugin will use a stylesheet named `maintenance.min.css` in the theme's stylesheet folder. You can specify a different filename by using a Filter (above).

= How do I add widgets? =

Click "Advanced Settings" and mark the checkbox to add widget areas. Then you will find two new widget areas in WordPress's Widgets page, for above and below the content.

== Screenshots ==

1. Example with default message.
2. Admin Bar Indicator (Red when active)
3. Settings page in admin view with default message.
4. Settings page in admin view with advanced settings.
5. Example with image and link.
6. Custom stylesheet
7. Example: Custom stylesheet in root theme folder with sample styling
8. Example using widgets (meta)
9. Widgets area with two maintenance mode widget areas (before and after)


== Changelog ==
= 2.4.4 =
* Bumped up "Tested up to"

= 2.4.3 =
* Added support for older PHP versions as per pre-2.4

= 2.4.2 =
* Add workaround capability management to support user role and capabilities plugins by using `delete_plugins` capability for super admins and `ljmm_control` for rest of the users

= 2.4.1 =
* Merge capabilities handling, tidy up and potentially fix capabilities issues some of the users have experienced

= 2.4 =
* More customisable than ever!
* Added support for stylesheet, widgets and code snippet injection (Thanks to Eric Mueller at [@switchplus](https://github.com/switchplus))
* Custom capability (Thanks to [@gabrielbijleveld](https://github.com/gabrielbijleveld))
* Code refactor and improvements
* Overall tidy up of the code
* Update broken support link
* Added shortcode support (Plugins like Contact Form 7 will work from now on)
* New icons and banners

= 2.3.2 =
* Added SiteOrigin Page Builder compatibilty (Thanks to [@relgit](https://github.com/relgit))

= 2.3.1 =
* Hot Fix issue where user got locked out of admin area in maintenance mode.

= 2.3 =
* Small refactor, extract some of the parts to it's own method to make everything a bit cleaner
* Added 'ljmm_content' filter
* Move mode up to the "main" setting area instead of advanced settings
* From now on, `init` hook instead of `get_header` is used for maintenance mode
* Dedicated method to check if maintenance mode is enabled to make things cleaner
* Improve current_user_can checks. From codex: current_user_can( $capability ) will aways return true if user is Super Admin, unless specifically denied - see [inline source code](https://developer.wordpress.org/reference/classes/wp_user/has_cap/)
* Update readme
* Preview mode will now perform capabilities check. (Thanks to [@esemlabel](https://wordpress.org/support/users/esemlabel/))
* Added Comet Cache support. (Thanks to [@doume](https://wordpress.org/support/users/doume/))
* Update translation files
* Updated French translation (Thanks to [@doume](https://wordpress.org/support/users/doume/))

= 2.2.5 =
* Add French translation (Thanks to [@doume](https://wordpress.org/support/users/doume/))

= 2.2.4 =
* Added missing translation strings (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)
* Updated advanced settings toggle (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)

= 2.2.3 =
* Updated POT file.(Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)
* Corrected typo for w3 total cache warning message. (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)

= 2.2.2 =
* Fixed typo in variable ($cache_plugin_enabled). (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)

= 2.2.1 =
* Added Dutch translation (Thanks to [@edwarddekker](https://github.com/edwarddekker))

= 2.2 =
* From now on, you can change status code being used while using maintenance mode between 503 (maintenance mode) or 200 (for "coming soon" page)
* Correct support url
* General code tidy up

= 2.1 =
* added WPML compatibility
* added TML (Theme My Login) compatibility
* Fixed issue where plugin capabilities were not being removed on uninstall
* Shorten admin bar indicator text, added icon
* Add support link to the plugins page
* Minor code tidy up

= 2.0.4 =
* Added Lithuanian translation (Thanks to [@gedeminas](https://github.com/gedeminas))

= 2.0.3 =
* Added Spanish Translations. (Thanks to [@bcien](https://github.com/bcien))
* Fixed issue where on non English sites admin bar indicator was broken.

= 2.0.2 =
* Fix db prefixing while getting roles. thanks @gablau
* Further checks improvements regarding problems caused by latest update for some users
* Add missing function wrapper for translations

= 2.0.1 =
* Improved checks regarding problems caused by latest update for some users

= 2.0 =
* Advanced settings
* Role Control
* You can now change title of the site while Maintenance Mode is enabled (in advanced settings)
* General tidy up of code
* Fix issue where Jetpack share was appearing in maintenance mode
* Settings page tidy up and corrections to formatting.

= 1.4.3 =
* Added German (DE) translations. (Thanks to Hoellenwesen)

= 1.4.2 =
* Update Pot file
* Small adjustments

= 1.4.1 =
* Bug fixes

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

= 2.4.3 =
* 2.4 - More customisable than ever! 2.4.3 - Added support for older PHP versions as per pre-2.4
