Maintenance Mode
======================

## Description

As a web developer working with Wordpress almost every day, very often I came across problem that If I wanted simple maintenance plugin to do some updates on my or client's website, I came across all these useless and overcomplicated plugins until I decided that I'll make one myself which will be the one I'll be confident and happy to use with ease.

[Maintenance Mode](https://plugins.itsluk.as/maintenance-mode/) is very simple and it's using Wordpress's wp_die() function which is core function of Wordpress, which makes this plugin feel and work as a part of Wordpress core. There is settings page under "Settings" in the main wp-admin menu where you can enable maintenance mode or change content using WYSIWYG editor so you can also add pictures, links etc. When activated and logged in as admin, you can see website as usual, rest of the users / visitors can see maintenance mode. You can see the maintenance mode as admin in preview mode using preview link on the settings page or simply open website in private mode or different browser to double check if it's enabled and working. There is also indicator in admin bar that changes colour to red when maintenance mode is enabled.

### Features: ###
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

Bugs and pull requests are welcomed.

## Shortcodes  ##

`[ljmm_is_maintenance_mode_enabled] ... content ... [/ljmm_is_maintenance_mode_enabled]` - Show this content only when maintenance mode is enabled.

`[ljmm_is_maintenance_mode_disabled] ... content ... [/ljmm_is_maintenance_mode_disabled]` - Show this content only when maintenance mode is disabled.

`[ljmm_is_user_logged_in] ... content ...[/ljmm_is_user_logged_in]` - Show this content only when the user is logged in to the website.

`[ljmm_is_user_logged_out] ... content ... [/ljmm_is_user_logged_out]` - Show this content only when the user is logged out of the website, they are a public user.

## Filters ##

`ljmm_site_title` - Filter page title while in maintenance mode

`ljmm_admin_bar_indicator_enabled` - Control visibility of admin bar indicator

`limm_css_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.css`. (Note: you do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_url` - The url of the css file.

`limm_css_frontend_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.frontend.css`. (Note: you do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_frontend_url` - The url of the css frontend file.

`limm_css_login_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.login.css`. (Note: you do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_login_url` - The url of the css login file.

## Actions ##
`ljmm_before_mm` - Runs at the beginning of core maintenance method

## Wordpress Info

* Requires at least: 3.5.0
* Tested up to: 5.9.2

## Installation

1. Upload `lj-maintenance-mode` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Settings -> Maintenance Mode  or simply click on Admin Bar indicator for settings to enable maintenance mode.

## FAQ
1. Is this plugin really ad free ?<br>
   Yes.

2. Plugin was activated and nothing happened, now what do I do?<br>
   1. Log in as the website WordPress administrator and navigate to the 'Setting' -> 'Maintenance Mode' section.
   2. Enter a custom maintenance mode massage.
   3. Review all the other options, including the 'Advanced Settings' to configure the user experience closer to what you want for your website.
   4. Use the 'Enable' option and 'Save Changes' button to turn the maintenance mode on and off.
   5. Remember to flush any and all website caching plugins that are installed, each time you turn maintenance mode on and off.

3. I'm the website administrator, will I always be able to login?<br>
   Yes. The `/wp-login.php` page will always be available for website administrators to login.

   Yes. All [WordPress Fatal Error Recovery Mode requests](https://make.wordpress.org/core/2019/04/16/fatal-error-recovery-mode-in-5-2/) using the `action=enter_recovery_mode&rm_token=` query string, will always be allowed through.

4. Will the search engines index my website while maintenance mode is enabled?<br>
   It depends upon which `mode` you choose.
   1. Select the `Maintenance Mode (Default)` option and it will return HTTP “503 Service Temporarily Unavailable”, which should not be indexed; or
   2. Select the `Coming Soon Page` option and it will return HTTP "200 Ok", which will be available for indexing.

5. Can I use this plugin when I have custom login pages?<br>
   Yes. The 'Allow bypass of Maintenance Mode' capability allows the website administrator to list specific pages to always be available, even when maintenance mode is enabled.

6. Is it compatible with WooCommerce and other Cart plugins?<br>
   Yes. The 'Allow bypass of Maintenance Mode' capability allows the website administrator to list specific pages to always be available while maintenance mode is enabled.

   This will let you customise a list of specific pages or any valid URI, to allow the other plugins to function as expected.

7. Can I customise the maintenance mode page?<br>
   Yes, in the spirit of 'keep it simple', a classic WYSIWYG editor box is available for you to add text, links, pictures, etc.

   Additionally, widget area's are available to use, if you choose to add them to the maintenance mode page capability (see next FAQ).

   Additionally, you can add 3 external stylesheet files to your active theme to leverage the power of CSS to visually improve the maintenance mode page, login page and the sites frontend pages.

8. How do I add widgets?<br>
   Click "Advanced Settings" and mark the checkbox to add widget areas. Then you will find two new widget areas in WordPress's Widgets page, for above and below the content.

9. Can I change background colour?<br>
   Not through the admin interface. You can use a custom stylesheet (see next FAQ) to do this, however.

10. What is the default stylesheet?<br>
    By default, the plugin will use a stylesheet named `maintenance.min.css` in the theme's stylesheet folder. You can specify a different filename by using a Filter (above).
   
    It is loaded in the maintenance mode page.

11. What is the frontend stylesheet?<br>
    By default, the plugin will use a stylesheet named `maintenance.min.frontend.css` in the theme's stylesheet folder. You can specify a different filename by using a Filter (above).
   
    It is loaded as part of the frontend (logged in) user experience, not the maintenance mode page.

12. What is the login stylesheet?<br>
    By default, the plugin will use a stylesheet named `maintenance.min.login.css` in the theme's stylesheet folder. You can specify a different filename by using a Filter (above).

    It is loaded as part of the standard login page user experience, not the maintenance mode page.

13. Plugin doesn't seem to work. What should I do ?<br>
    First, if you are using Cache plugin such as WP Super Cache or W3 Total Cache, flush all your cache.

    Secondly, disable all other plugins and try enabling just Maintenance Mode and see if problem persist. This should solve most common problems. 

    If not, don't hesitate to contact me via Support button from Settings page.

## Changelog
See the [CHANGELOG.MD](CHANGELOG.MD).
