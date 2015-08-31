Maintenance Mode
================

* Contributors: Lukas Juhas
* Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2XPA4CKT836FJ


## Description

Very simple maintenance plugin for your website using wordpress's wp_die() function, there is settings page under "Settings" where you can enable maintenance mode or set your custom message. There is also a default message. When activated and logged as admin, you can see website normaly, just rest of the users / visitors can see maintenance mode. There is also indicator in admin bar that changes colour to red if maintenance mode is enabled.

There are more features planned in near future.

Bugs and pull requests are welcomed.

## Wordpress Info

* Requires at least: 3.8.0
* Tested up to: 4.3

## Installation

1. Upload `lj-maintenance-mode` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Settings -> Maintenance Mode for settings or to enable maintenance mode.

## Changelog

### 1.2
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

### 1.1.1
* Bug Fixes

### 1.1
* Added Indicator to Admin menu bar
* Added Settings button on plugins page
* Added Default maintenance mode message.
* Bug Fixes

### 1.0
* First release
