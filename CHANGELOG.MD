# Changelog
## 2.4.3
* Added support for older PHP versions as per pre-2.4

## 2.4.2
* Add workaround capability management to support user role and capabilities plugins by using `delete_plugins` capability for super admins and `ljmm_control` for rest of the users

## 2.4.1
* Merge capabilities handling, tidy up and potentially fix capabilities issues some of the users have experienced

## 2.4
* More customisable than ever!
* Added support for stylesheet, widgets, code snippet injection and Analytify/Google Analytics tracking code (Thanks to Eric Mueller at [@switchplus](https://github.com/switchplus))
* Custom capability (Thanks to [@gabrielbijleveld](https://github.com/gabrielbijleveld))
* Code refactor and improvements
* Overall tidy up of the code
* Update broken support link
* Added shortcode support (Plugins like Contact Form 7 will work from now on)
* New icons and banners

## 2.3.2
* Added SiteOrigin Page Builder compatibility (Thanks to [@relgit](https://github.com/relgit))

## 2.3.1
* Hot Fix issue where user got locked out of admin area in maintenance mode.

## 2.3
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

## 2.2.5
* Add French translation (Thanks to [@doume](https://wordpress.org/support/users/doume/))

## 2.2.4
* Added missing translation strings (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)
* Updated advanced settings toggle (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)

## 2.2.3
* Updated POT file.(Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)
* Corrected typo for w3 total cache warning message. (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)

## 2.2.2
* Fixed typo in variable ($cache_plugin_enabled). (Thanks to [@doume](https://wordpress.org/support/users/doume/) for reporting this issue)

## 2.2.1
* Added Dutch translation (Thanks to [@edwarddekker](https://github.com/edwarddekker))

## 2.2
* From now on, you can change status code being used while using maintenance mode between 503 (maintenance mode) or 200 (for "coming soon" page)
* Correct support url
* General code tidy up

## 2.1
* added WPML compatibility
* added TML (Theme My Login) compatibility
* Fixed issue where plugin capabilities were not being removed on uninstall
* Shorten admin bar indicator text, added icon
* Add support link to the plugins page
* Minor code tidy up

## 2.0.4
* Added Lithuanian translation (Thanks to [@gedeminas](https://github.com/gedeminas))

## 2.0.3
* Added Spanish Translations. (Thanks to [@bcien](https://github.com/bcien))
* Fixed issue where on non English sites admin bar indicator was broken.

## 2.0.2
* Fix db prefixing while getting roles. thanks @gablau
* Further checks improvements regarding problems caused by latest update for some users
* Add missing function wrapper for translations

## 2.0.1
* Improved checks regarding problems caused by latest update for some users

## 2.0
* Advanced settings
* Role Control
* You can now change title of the site while Maintenance Mode is enabled (in advanced settings)
* General tidy up of code
* Fix issue where Jetpack share was appearing in maintenance mode
* Settings page tidy up and corrections to formatting.

## 1.4.3
* Added German (DE) translations. (Thanks to Hoellenwesen)

## 1.4.2
* Update Pot file
* Small adjustments

## 1.4.1
* Bug fixes

## 1.4
* Bug fixes (Thanks to [@gablau](https://github.com/gablau))
* Security fixes - saving content more safely (Thanks to [@gablau](https://github.com/gablau))
* Languages: Add Italian (100%) (Thanks to [@gablau](https://github.com/gablau))
* Add compatibility while installed along wp-maintenance-mode [@gablau](https://github.com/gablau))
* Code: Avoid duplicating same code and use it as method instead.
* Code: Tidy up default messages and group them together within method to avoid repeating yourself and also searching all across code in order to change the messages in the future.

## 1.3.3
* Improvement: If MM is enabled, added message describing how to check if the maintenance mode is enabled as this was causing lot of confusion and unnecessary support tickets.
* Improvement: Move preview and support buttons to a more convenient place, also highlight the preview button.
* Languages: Add Canadian (100%), Hungarian(83%) languages.

## 1.3.2
* Fixed: Issue where non admin users could see admin bar indicator.

## 1.3.1
* Google is being notified right way from now on.
* Typo corrections
* General code tidy up

## 1.3
* Improvement: Translations adjustments and corrections. Plugin is now fully translatable.
* Improvement: Small code refactor and tidy up.
* Improvement: Correct various typo issues.

## 1.2.1
* Bug fixes
* Deprecated clear cache functionality as it caused errors to some users. From now on, plugin shows simple reminder to flush cache after enabling or disabling Maintenance Mode.


## 1.2
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

## 1.1.1
* Bug Fixes

## 1.1
* Added Indicator to Admin menu bar
* Added Settings button on plugins page
* Added Default maintenance mode message.
* Bug Fixes

## 1.0
* First release
