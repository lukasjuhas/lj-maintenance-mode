=== Maintenance Mode ===
Contributors: LukasNeptun, johnlang-1
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LL6TN86CDPYQN
Tags: maintenance, maintenance mode, website maintenance, coming soon, under construction, offline, site maintenance,
Requires at least: 3.5
Tested up to: 5.9.2
Stable tag: 2.5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Very simple Maintenance Mode & Coming soon page using default Wordpress markup with no ads or paid upgrades.

== Description ==

As a web developer working with Wordpress almost every day, very often I came across problem that If I wanted simple maintenance plugin to do some updates on my or client's website, I came across all these useless and overcomplicated plugins until I decided that I'll make one myself which will be the one I'll be confident and happy to use with ease.

[Maintenance Mode](https://wordpress.org/plugins/lj-maintenance-mode/) is very simple and it's using Wordpress's wp_die() function which is core function of Wordpress, which makes this plugin feel and work as a part of Wordpress core. There is settings page under "Settings" in the main wp-admin menu where you can enable maintenance mode or change content using WYSIWYG editor so you can also add pictures, links etc. When activated and logged in as admin, you can see website as usual, rest of the users / visitors can see maintenance mode. You can see the maintenance mode as admin in preview mode using preview link on the settings page or simply open website in private mode or different browser to double check if it's enabled and working. There is also indicator in admin bar that changes colour to red when maintenance mode is enabled.

**Features:**

* **Simplicity** - Built to be as simple as possible. Easy to use.
* **Customisable** - WYSIWYG available in full glory. You can add images and other media including links and pretty much everything you can do with WYSIWYG. Text/Code tab is available too for custom markup.
* **Works on mobile** - Because of it's simplicity, maintenance mode works very well on mobile devices.
* **NO ADS** - No ads. Seriously.
* **NO PAID UPGRADES** - No paid upgrades. Seriously.
* **Updates** - Regular updates and maintenance.
* **Support** - Support button available.
* **Preview** - Preview button available.
* **Compact** - It's developed to be as compact as possible.
* **Role Control** - User Role control is available since 2.0.
* **Never Locked Out** - 'wp-login.php' and the ['Fatal Error Recovery Mode'](https://make.wordpress.org/core/2019/04/16/fatal-error-recovery-mode-in-5-2/) requests for website administrators will always work.
* **Search Engine Indexing** - Choose to respond with 'Ok to Index' (HTTP 200) or 'Service Unavailable; Do Not Index' (HTTP 503).
* **Optional Widgets** - Optionally add widgets above and/or below the content.
* **Optional Style Sheets** - Optionally add a custom style sheet for maintenance mode page, frontend pages and the login page. Visually emphasise the maintenance mode status into the rest of the website with your own custom CSS, located in your active theme.
* **Optional ability to add Code Snippet** - Optionally add a code snippet to the page.
* **Shortcodes for Maintenance Mode** - Dynamically show content on any page, depending upon the maintenance mode status (enabled/disabled).
* **Shortcodes for User Login** - Dynamically show content on any page, depending upon the login status of the requesting user (logded in/logged out).
* **Support for Analytify plugin** - If you use the Analytify plugin, you can automatically insert the Google Analytics tracking code.
* **Allow bypass of Maintenance Mode** - Match one of these request conditions and maintenance mode page will be ignored.
  1. Allowed IPs - Single IPV4 value, single IPV6 value or partial matches to emulate subnet matches.
  2. Allowed URIs (Strict) - Specifically just this URI, but not any of the child pages.
  3. Allowed URIs (Contains) - Including access to all child pages under this URI.
  4. Allowed Query Strings.
  5. Allowed Referers.
  6. Allowed User Agents.

> <strong>Important! Users that are using Cache plugins, please read below:</strong><br>
> <strong>When enabling or disabling Maintenance Mode, don't forget to flush your cache!</strong>

**Shortcodes**
`[ljmm_is_maintenance_mode_enabled] ... content ... [/ljmm_is_maintenance_mode_enabled]` - Show this content only when maintenance mode is enabled.

`[ljmm_is_maintenance_mode_disabled] ... content ... [/ljmm_is_maintenance_mode_disabled]` - Show this content only when maintenance mode is disabled.

`[ljmm_is_user_logged_in] ... content ...[/ljmm_is_user_logged_in]` - Show this content only when the user is logged in to the website.

`[ljmm_is_user_logged_out] ... content ... [/ljmm_is_user_logged_out]` - Show this content only when the user is logged out of the website, they are a public user.

**Filters**
`ljmm_site_title` - Filter page title while in maintenance mode.

`ljmm_admin_bar_indicator_enabled` - Control visibility of admin bar indicator.

`ljmm_css_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.css`. (Note: You do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_url` - The url of the css file for the maintenance mode page.

`ljmm_css_frontend_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.frontend.css`. (Note: You do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_frontend_url` - The url of the css file for the main website content.

`ljmm_css_login_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.login.css`. (Note: You do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_login_url` - The url of the css file for the login page.

**Actions**

`ljmm_before_mm` - Runs at the beginning of core maintenance method

**Support**

Having trouble? Please read FAQ first, if you need any assistance, you can use support button on the settings page of the Maintenance Mode.

> <strong>Development on GitHub</strong><br>
> The development of Maintenance Mode [takes place on GitHub](https://github.com/lukasjuhas/lj-maintenance-mode). Bugs and pull requests are welcomed there.


== Installation ==

1. Upload `lj-maintenance-mode` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to Settings -> Maintenance Mode, or simply click on Admin Bar indicator for settings to enable maintenance mode.

== Frequently Asked Questions ==

= Is this plugin really ad free ? =
Yes.

= Plugin was activated and nothing happened, now what do I do? =

1. Log in as the website WordPress administrator and navigate to the 'Setting' -> 'Maintenance Mode' section.
2. Enter a custom maintenance mode massage.
3. Review all the other options, including the 'Advanced Settings' to configure the user experience closer to what you want for your website.
4. Use the 'Enable' option and 'Save Changes' button to turn the maintenance mode on and off.
5. Remember to flush any and all website caching plugins that are installed, each time you turn maintenance mode on and off.

= I'm the website administrator, will I always be able to login? =

Yes. The `/wp-login.php` page will always be available for website administrators to login.

Yes. All [WordPress Fatal Error Recovery Mode requests](https://make.wordpress.org/core/2019/04/16/fatal-error-recovery-mode-in-5-2/) using the `action=enter_recovery_mode&rm_token=` query string, will always be allowed through.

= Will the search engines index my website while maintenance mode is enabled? =

It depends upon which `mode` you choose.

1. Select the `Maintenance Mode (Default)` option and it will return HTTP “503 Service Temporarily Unavailable”, which should not be indexed; or
2. Select the `Coming Soon Page` option and it will return HTTP "200 Ok", which will be available for indexing.

= Can I use this plugin when I have custom login pages? =

Yes. The 'Allow bypass of Maintenance Mode' capability allows the website administrator to list specific pages to always be available, even when maintenance mode is enabled.

= Is it compatible with WooCommerce and other Cart plugins? =

Yes. The 'Allow bypass of Maintenance Mode' capability allows the website administrator to list specific pages to always be available while maintenance mode is enabled.
This will let you customise a list of specific pages or any valid URI, to allow the other plugins to function as expected.

= Can I customise the maintenance mode page? =

Yes, in the spirit of 'keep it simple', a classic WYSIWYG editor box is available for you to add text, links, pictures, etc.
Additionally, widget area's are available to use, if you choose to add them to the maintenance mode page capability (see next FAQ).
Additionally, you can add 3 external stylesheet files to your active theme to leverage the power of CSS to visually improve the maintenance mode page, login page and the sites frontend pages.

= How do I add widgets? =

Click "Advanced Settings" and mark the checkbox to add widget areas. Then you will find two new widget areas in WordPress's Widgets page, for above and below the content.

= Can I change background colour? =

Not through the admin interface. You can use a custom stylesheet (see next FAQ) to do this, however.

= What is the default stylesheet? =

By default, the plugin will use a stylesheet named `maintenance.min.css` in the theme's stylesheet folder, next to the [themes main stylesheet (style.css)](https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/).
You can specify a different filename by using a Filter (above).

= What is the frontend stylesheet? =

By default, the plugin will use a stylesheet named `maintenance.min.frontend.css` in the theme's stylesheet folder, next to the [themes main stylesheet (style.css)](https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/).
You can specify a different filename by using a Filter (above).

= What is the login stylesheet? =

By default, the plugin will use a stylesheet named `maintenance.min.login.css` in the theme's stylesheet folder, next to the [themes main stylesheet (style.css)](https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/).
You can specify a different filename by using a Filter (above).

= How can I submit translation updates or new language packs? =

1. All updates and new language pack files are welcome. Please raise a [GitHub issue](https://github.com/lukasjuhas/lj-maintenance-mode/issues) and upload the .po file for review and possible inclusion in a future release.
2. Alternatively, please visit the [plugins page](https://translate.wordpress.org/projects/wp-plugins/lj-maintenance-mode/) at WordPress Translate.

= Plugin still doesn't seem to work. What should I do ? =

First, if you are using Cache plugin such as WP Super Cache or W3 Total Cache, flush all your cache.
Secondly, disable all other plugins and try enabling just Maintenance Mode and see if problem persist. This should solve most common problems.
If not, don't hesitate to contact me via Support button from Settings page.


== Screenshots ==

1. Example with default message.
2. Admin Bar Indicator (Red when active)
3. Settings page in admin view with default message.
4. Settings page in admin view with advanced settings.
5. Example with image and link.
6. Custom stylesheet
7. Example: Custom stylesheet in root theme folder with sample styling
8. Example using widgets (meta)
9. Example of Widgets area with two maintenance mode widget areas (before and after)
10. Example of ShortCodes for a membership registration page (Maintenance Mode, Logged-Out and Logged-In).

== Changelog ==

= 2.5.2 =
* Add john-lang-86/lj-maintenance-mode#15 shortcodes for dynamic page content. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
  1. Add [ljmm_is_maintenance_mode_enabled] Show this content only when maintenance mode is enabled [/ljmm_is_maintenance_mode_enabled] shortcode.
  2. Add [ljmm_is_maintenance_mode_disabled] Show this content only when maintenance mode is disabled [/ljmm_is_maintenance_mode_disabled] shortcode.
  3. Add [ljmm_is_user_logged_in] Show this content only when the user is logged in to the website [/ljmm_is_user_logged_in] shortcode.
  4. Add [ljmm_is_user_logged_out] Show this content only when the user is logged out of the website, they are a public user. [/ljmm_is_user_logged_out] shortcode.
* Add john-lang-86/lj-maintenance-mode#6 to expand the supported languages. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
  1. Updated source code to be primarily human native language, removing the technology aspects (like %s) from the translatable phrases. This technique significantly improved the online translation success; while intentionally leaving 1 %s in the translation string list as a 'canary in the coal mine' test to see how well the translator handled it.
  2. Using 'PoEdit Pro' application and the DeepL/Google online ML translators. Keeping languages that had a > 98% online translation success, as anything less would be a disappointing user expectation and experience.
  3. As-at 28 Mar 2022, 145 locales (language_region combinations) have been translated. The full [journey from RTFM to commit](https://github.com/john-lang-86/lj-maintenance-mode/issues/6) has been documented.
      * Focus on [WordPress installation statistics](https://wordpress.org/about/stats/), in descending ranked order; then
      * Focus on [WordPress up-to-date translations](https://make.wordpress.org/polyglots/teams/), which indicates an active community.
      * Focus on [Stripe Payment Processor](https://support.stripe.com/questions/supported-languages-for-stripe-checkout-and-payment-links) supported languages.
* Resolves review [feedback about Twenty Twenty-Two themem compatability](https://wordpress.org/support/topic/love-this-plugin-so-much-i-donated/) as part of ['Alternative to get_header hook/action'](https://github.com/john-lang-86/lj-maintenance-mode/issues/11) solution. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Update screenshot-4.png for the new settings page options in 2.5.2, and add screenshot-10.png
* Update README.md and readme.txt files.

= 2.5.1.1 =
* Fix john-lang-86/lj-maintenance-mode#1 to improve trailing slash cmoparisons. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Fix john-lang-86/lj-maintenance-mode#13 to allow a strict comparison for the site home page. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Improved helpful messages to advanced setting options. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))

= 2.5.1 =
* Added Autoptimize message. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Added "maintenance.min.login.css" feature. When detected in theme directory, this CSS file will be loaded in the standard login page to show users that maintenance mode is active. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
  1. Added filter "ljmm_css_login_filename".
  2. Added filter "ljmm_css_login_url".
* Resolve lukasjuhas/lj-maintenance-mode#37 by adding 6 "Allowed" setting lists; match one on a list and maintenance mode lets the request proceed. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
  1. Added "Allowed IPs (Contains)" setting, where $_SERVER[REMOTE_ADDR] matching requests will by-pass maintenance mode page.
  2. Added "Allowed URIs (Strict)" setting, where $_SERVER[REQUEST_URI] matching requests will by-pass maintenance mode page.
  3. Added "Allowed URIs (Contains)" setting, where $_SERVER[REQUEST_URI] matching requests will by-pass maintenance mode page.
  4. Added "Allowed Query Strings (Contains)" setting, where $_SERVER[QUERY_STRING] matching requests will by-pass maintenance mode page.
  5. Added "Allowed Referers (Contains)" setting, where $_SERVER[HTTP_REFERER] matching requests will by-pass maintenance mode page.
  6. Added "Allowed User Agents (Contains)" setting, where $_SERVER[HTTP_USER_AGENT] matching requests will by-pass maintenance mode page.
* Resolve lukasjuhas/lj-maintenance-mode#43 by switching from 'get_header' to 'wp_loaded' hook/action. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
  1. Always allow '/wp-login.php' URI access requests.
  2. Always allow 'action=enter_recovery_mode&rm_token=' query string access requests.
* Fix lukasjuhas/lj-maintenance-mode#44 by always allowing access when "current_user_can('administrator')" check passes. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Resolve lukasjuhas/lj-maintenance-mode#47 by adding 2 DIVs to maintenance mode page (wrapper and content); for more flexible CSS options. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Add helpful messages to advanced setting options. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))

= 2.5 =
* Added WP Rocket message. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Added "maintenance.min.frontend.css" feature. When detected in theme directory, this CSS file will be loaded in the frontend to show logged in users that maintenance mode is active. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
  1. Added filter "ljmm_css_frontend_filename".
  2. Added filter "ljmm_css_frontend_url".
* Commit contains unit tested (functional) core for 'an exception allow list for non-logged in access to resources' for REMOTE_ADDR, REQUEST_URI (Strict Match), REQUEST_URI (Contains/Sloppy Match) and HTTP_REFERER; but still needs a settings page implementation. (Thanks to [@john-lang-86](https://github.com/john-lang-86/))
* Acknowledgment: Language translations for new strings in the settings page in 2.5 are missing.

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
* Added SiteOrigin Page Builder compatibility (Thanks to [@relgit](https://github.com/relgit))

= 2.3.1 =
* Hot Fix issue where user got locked out of admin area in maintenance mode.

= 2.3 =
* Small refactor, extract some of the parts to it's own method to make everything a bit cleaner
* Added 'ljmm_content' filter
* Move mode up to the "main" setting area instead of advanced settings
* From now on, `init` hook instead of `get_header` is used for maintenance mode
* Dedicated method to check if maintenance mode is enabled to make things cleaner
* Improve current_user_can checks. From codex: current_user_can( $capability ) will always return true if user is Super Admin, unless specifically denied - see [inline source code](https://developer.wordpress.org/reference/classes/wp_user/has_cap/)
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
