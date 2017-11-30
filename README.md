Maintenance Mode (2.4.3)
======================

## Description

As a web developer working with Wordpress almost every day, very often I came across problem that If I wanted simple maintenance plugin to do some updates on my or client's website, I came across all these useless and overcomplicated plugins until I decided that I'll make one myself which will be the one I'll be confident and happy to use with ease.

[Maintenance Mode](https://plugins.itsluk.as/maintenance-mode/) is very simple and it's using Wordpress's wp_die() function which is core function of Wordpress, which makes this plugin feel and work as a part of Wordpress core. There is settings page under "Settings" in the main wp-admin menu where you can enable maintenance mode or change content using WYSIWYG editor so you can also add pictures, links etc. When activated and logged in as admin, you can see website as usual, rest of the users / visitors can see maintenance mode. You can see the maintenance mode as admin in preview mode using preview link on the settings page or simply open website in private mode or different browser to double check if it's enabled and working. There is also indicator in admin bar that changes colour to red when maintenance mode is enabled.

### Features: ###
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
* **WPML Compatible** - Plugin is compatible with WPML plugin
* **Optional widgets** - Optionally add widgets above and/or below the content
* **Optional style sheet** - Optionally add a custom style sheet
* **Optional ability to add code snippet** - Optionally add a code snippet to the page.
* **Support for Analytify plugin** - If you use the Analytify plugin, you can automatically insert the Google Analytics tracking code.

Bugs and pull requests are welcomed.

## Filters ##

`ljmm_site_title` - Filter page title while in maintenance mode

`ljmm_admin_bar_indicator_enabled` - Control visibility of admin bar indicator

`limm_css_filename` - The filename of the CSS style sheet (as found in the theme's stylesheet directory) - just the filename, for example: `maintenance.min.css`. (Note: you do not need to use this filter for a stylesheet; see FAQs below.)

`ljmm_css_url` - The url of the css file.


## Actions ##
`ljmm_before_mm` - Runs at the beginning of core maintenance method

## Wordpress Info

* Requires at least: 3.5.0
* Tested up to: 4.9

## Installation

1. Upload `lj-maintenance-mode` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Settings -> Maintenance Mode  or simply click on Admin Bar indicator for settings to enable maintenance mode.

## FAQ
1. Is this plugin really ad free ?<br>
Yes.

2. Can I change background colour?<br>
Not through the admin interface. You can use a custom stylesheet (see next FAQ) to do this, however.

3. What is the default stylesheet?<br>
By default, the plugin will use a stylesheet named `maintenance.min.css` in the theme's stylesheet folder. You can specify a different filename by using a Filter (above).

4. How do I add widgets?<br>
Click "Advanced Settings" and mark the checkbox to add widget areas. Then you will find two new widget areas in WordPress's Widgets page, for above and below the content.

5. Plugin doesn't seem to work. What should I do ?<br>
First, if you are using Cache plugin such as WP Super Cache or W3 Total Cache, flush all your cache. Secondly, disable all other plugins and try enabling just Maintenance Mode and see if problem persist. This should solve most common problems. If not, don't hesitate to contact me via Support button from Settings page

## Changelog
See the [CHANGELOG.MD](CHANGELOG.MD).
