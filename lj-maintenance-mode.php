<?php
/**
 * Plugin Name: Maintenance Mode
 * Plugin URI: https://plugins.itsluk.as/maintenance-mode/
 * Description: Very simple Maintenance Mode & Coming soon page using default Wordpress markup with no ads or paid upgrades.
 * Version: 2.5.1
 * Author: Lukas Juhas
 * Author URI: https://plugins.itsluk.as/
 * Text Domain: lj-maintenance-mode
 * License: GPL2
 * Domain Path: /languages/
 *
 * Copyright 2014-2022  Lukas Juhas
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package lj-maintenance-mode
 * @author Lukas Juhas
 * @version 2.5.1
 *
 */

// define stuff
define('LJMM_VERSION', '2.5.1');
define('LJMM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LJMM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LJMM_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('LJMM_PLUGIN_DOMAIN', 'lj-maintenance-mode');
define('LJMM_VIEW_SITE_CAP', 'ljmm_view_site');
define('LJMM_PLUGIN_CAP', 'ljmm_control');
define('LJMM_SUPPORT_LINK', 'https://wordpress.org/support/plugin/lj-maintenance-mode');

/**
 * Installation
 *
 * @since 1.0
 */
function ljmm_install()
{
    // remove old settings. This has been deprecated in 1.2
    delete_option('ljmm-content-default');

    // set default content
    ljmm_set_content();
}
add_action('activate_' . LJMM_PLUGIN_BASENAME, 'ljmm_install');

/**
 * Default hardcoded settings
 *
 * @since 1.4
 */
function ljmm_get_defaults($type)
{
    switch ($type) {
        case 'maintenance_message':
            $default = __('<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>', LJMM_PLUGIN_DOMAIN);
            break;
        case 'warning_wp_super_cache':
            $default = __("Important: Don't forget to flush your cache using WP Super Cache when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'warning_w3_total_cache':
            $default = __("Important: Don't forget to flush your cache using W3 Total Cache when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'warning_comet_cache':
            $default = __("Important: Don't forget to flush your cache using Comet Cache when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'warning_wp_rocket_cache':
            $default = __("Important: Don't forget to flush your cache using WP Rocket when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'warning_autoptimize_cache':
            $default = __("Important: Don't forget to flush your cache using Autoptimize when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'ljmm_enabled':
            $default = __('Maintenance Mode is currently active. To make sure that it works, open your web page in either private / incognito mode, different browser or simply log out. Logged in users are not affected by the Maintenance Mode.', LJMM_PLUGIN_DOMAIN);
            break;
        case 'ljmm_add_widget_areas':
            $default = __('You can add widgets in <strong>Appearance -> Widgets</strong>.', LJMM_PLUGIN_DOMAIN);
            break;
        default:
            $default = false;
            break;
    }

    return $default;
}

/**
 * Set the default content
 * Avoid duplicate function.
 *
 * @since 1.0
 */
function ljmm_set_content()
{
    // If content is not set, set the default content.
    $content = get_option('ljmm-content');

    if (empty($content)) {
        $content = ljmm_get_defaults('maintenance_message');
        update_option('ljmm-content', stripslashes($content));
    }

    // If content is not set, set the default content.
    $mode = get_option('ljmm-mode');
    if (empty($mode)) {
        update_option('ljmm-mode', 'default');
    }
}

/**
 * Load plugin textdomain.
 *
 * @since 1.3.1
*/
function ljmm_load_textdomain()
{
    load_plugin_textdomain(LJMM_PLUGIN_DOMAIN, false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'ljmm_load_textdomain');

/**
 * Enqueue custom frontend stylesheet ... for logged in users (not the maintenance page).
 *
 * @since 2.5
 */
function ljmm_enqueue_custom_frontend_stylesheet()
{
    $ljmm_enabled = esc_attr( get_option('ljmm-enabled') );
    if ( ! empty( $ljmm_enabled ) ) {
       if ( file_exists( get_stylesheet_directory().'/maintenance.min.frontend.css' ) ) {
            wp_enqueue_style( 'ljmm_maintenance-mode-frontend-style', get_stylesheet_directory_uri().'/maintenance.min.frontend.css' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'ljmm_enqueue_custom_frontend_stylesheet' );

/**
 * Enqueue custom login stylesheet ... for the standard login page (not the maintenance page).
 *
 * @since 2.5.1
 */
function ljmm_enqueue_custom_login_stylesheet()
{
    $ljmm_enabled = esc_attr( get_option('ljmm-enabled') );
    if ( ! empty( $ljmm_enabled ) ) {
        if ( file_exists( get_stylesheet_directory().'/maintenance.min.login.css' ) ) {
            wp_enqueue_style( 'ljmm_maintenance-mode-login-style', get_stylesheet_directory_uri().'/maintenance.min.login.css' );
        }
    }
}
add_action( 'login_enqueue_scripts', 'ljmm_enqueue_custom_login_stylesheet' );

/**
 * Main class
 *
 * @since 1.0
*/
class ljMaintenanceMode
{
    /**
     * Constructor
     *
     * @since 1.0
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'ui'));
        add_action('admin_head', array($this, 'style'));
        add_action('admin_init', array($this, 'settings'));
        add_action('admin_init', array($this, 'manage_capabilities'));

        // remove old settings. This has been deprecated in 1.2
        delete_option('ljmm-content-default');

        // maintenance mode
        add_action('wp_loaded', array($this, 'maintenance'));
        // add_action('wp', array($this, 'maintenance'));
        // add_action('template_redirect', array($this, 'maintenance'));
        // add_action('get_header', array($this, 'maintenance'));

        add_action('admin_bar_menu', array($this, 'indicator'), 100);
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links'));

        add_action('ljmm_before_mm', array($this, 'before_maintenance_mode'));

        // add shortcode support
        add_filter('ljmm_content', 'do_shortcode', 11);

        // add widget areas if enabled
        if (get_option('ljmm_add_widget_areas')) {
            $this->register_widget_sidebars();
        }
    }

    /**
     * Settings page
     *
     * @since 1.0
    */
    public function ui()
    {
        add_submenu_page('options-general.php', __('Maintenance Mode', LJMM_PLUGIN_DOMAIN), __('Maintenance Mode', LJMM_PLUGIN_DOMAIN), $this->get_relevant_cap(), 'lj-maintenance-mode', array($this, 'settingsPage'));
    }

    /**
     * Inject styling for admin bar indicator
     *
     * @since 1.1
    */
    public function style()
    {
        echo '<style type="text/css">#wp-admin-bar-ljmm-indicator.ljmm-indicator--enabled { background: rgba(159, 0, 0, 1) }</style>';
    }

    /**
     * Settings
     *
     * @since 1.0
    */
    public function settings()
    {
        register_setting('ljmm', 'ljmm-enabled');
        register_setting('ljmm', 'ljmm-content');
        register_setting('ljmm', 'ljmm_add_widget_areas');
        register_setting('ljmm', 'ljmm_analytify');
        register_setting('ljmm', 'ljmm_code_snippet');
        register_setting('ljmm', 'ljmm-site-title');
        register_setting('ljmm', 'ljmm-roles');
        register_setting('ljmm', 'ljmm-mode');
        register_setting('ljmm', 'ljmm-allow_remote_ip');
        register_setting('ljmm', 'ljmm-allow_request_uri_strictly');
        register_setting('ljmm', 'ljmm-allow_request_uri_contains');
        register_setting('ljmm', 'ljmm-allow_request_referer');
        register_setting('ljmm', 'ljmm-allow_request_user_agent');
        register_setting('ljmm', 'ljmm-allow_request_query_string');

        // set the content
        ljmm_set_content();
    }

    /**
     * Settings page
     *
     * @since 1.0
    */
    public function settingsPage()
    {
        ?>
        <div class="wrap">
            <h2><?php _e('Maintenance Mode', LJMM_PLUGIN_DOMAIN); ?></h2>
            <form method="post" action="options.php">
                <?php settings_fields('ljmm'); ?>
                <?php do_settings_sections('ljmm'); ?>

                <?php $this->notify(); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">
                            <label for="ljmm_enabled"><?php _e('Enabled', LJMM_PLUGIN_DOMAIN); ?></label>
                        </th>
                        <td>
                            <?php $ljmm_enabled = esc_attr(get_option('ljmm-enabled')); ?>
                            <input type="checkbox" id="ljmm_enabled" name="ljmm-enabled" value="1" <?php checked($ljmm_enabled, 1); ?>>
                            <?php if ($ljmm_enabled) : ?>
                                <p class="description"><?php echo ljmm_get_defaults('ljmm_enabled'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?php _e('Mode', LJMM_PLUGIN_DOMAIN); ?></th>
                        <td>
                            <?php $ljmm_mode = esc_attr(get_option('ljmm-mode')); ?>
                            <?php $mode_default = $ljmm_mode == 'default' ? true : false; ?>
                            <?php $mode_cs = $ljmm_mode == 'cs' ? true : false; ?>
                            <label>
                                <input name="ljmm-mode" type="radio" value="default" <?php checked($mode_default, 1); ?>>
                                <?php _e('Maintenance Mode', LJMM_PLUGIN_DOMAIN); ?> (<?php _e('Default', LJMM_PLUGIN_DOMAIN); ?>)
                            </label>
                            <label>
                                <input name="ljmm-mode" type="radio" value="cs" <?php checked($mode_cs, 1); ?>>
                                <?php _e('Coming Soon Page', LJMM_PLUGIN_DOMAIN); ?>
                            </label>
                            <p class="description">
                                <?php _e('If you are putting your site into maintenance mode for a longer period of time, you should set this to "Coming Soon Page". Otherwise use "Maintenance Mode".', LJMM_PLUGIN_DOMAIN); ?><br />
                                <?php _e('Default sets HTTP to 503, coming soon will set HTTP to 200.', LJMM_PLUGIN_DOMAIN); ?> <a href="https://en.wikipedia.org/wiki/List_of_HTTP_status_codes" target="blank"><?php _e('Learn more.', LJMM_PLUGIN_DOMAIN); ?></a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            <a href="<?php echo esc_url(add_query_arg('ljmm', 'preview', bloginfo('url'))); ?>" target="_blank" class="button button-secondary"><?php _e('Preview', LJMM_PLUGIN_DOMAIN); ?></a>
                            <a class="button button-secondary support" href="<?php echo LJMM_SUPPORT_LINK ?>" target="_blank"><?php _e('Support', LJMM_PLUGIN_DOMAIN); ?></a>
                        </th>
                    </tr>

                    <tr>
                        <th colspan="2">
                            <?php $this->editor_content(); ?>
                        </th>
                    </tr>
                </table>

                <a href="#" class="ljmm-advanced-settings">
                    <span class="ljmm-advanced-settings__label-advanced">
                        <?php _e('Advanced Settings', LJMM_PLUGIN_DOMAIN); ?>
                    </span>
                    <span class="ljmm-advanced-settings__label-hide-advanced" style="display: none;">
                        <?php _e('Hide Advanced Settings', LJMM_PLUGIN_DOMAIN); ?>
                    </span>
                </a>

                <table class="form-table form--ljmm-advanced-settings" style="display: none">

                    <tr valign="top">
                        <th scope="row">
                            <label for="ljmm_add_widget_areas"><?php _e('Add widget areas above and below content', LJMM_PLUGIN_DOMAIN); ?></label>
                        </th>
                        <td>
			                <?php $ljmm_add_widget_areas = esc_attr(get_option('ljmm_add_widget_areas')); ?>
                            <input type="checkbox" id="ljmm_add_widget_areas" name="ljmm_add_widget_areas" value="1" <?php checked($ljmm_add_widget_areas, 1); ?>>
			                <?php if ($ljmm_add_widget_areas) : ?>
                                <p class="description"><?php echo ljmm_get_defaults('ljmm_add_widget_areas'); ?></p>
			                <?php endif; ?>
                        </td>
                    </tr>

                    <tr valign="middle">
                        <th scope="row"><?php _e('Site Title', LJMM_PLUGIN_DOMAIN); ?></th>
                        <td>
                            <?php $ljmm_site_title = esc_attr(get_option('ljmm-site-title')); ?>
                            <input name="ljmm-site-title" type="text" id="ljmm-site-title" placeholder="<?php echo $this->site_title(); ?>" value="<?php echo $ljmm_site_title; ?>" class="regular-text">
                            <p class="description"><?php _e('Overrides default site meta title.', LJMM_PLUGIN_DOMAIN); ?></p>
                        </td>
                    </tr>

                    <?php $options = get_option('ljmm-roles'); ?>
                    <?php $wp_roles = get_editable_roles(); ?>
                    <?php if ($wp_roles && is_array($wp_roles)) : ?>
                        <tr valign="top">
                            <th scope="row"><?php _e('User Roles', LJMM_PLUGIN_DOMAIN); ?>
                                <p class="description"><?php _e('Tick the ones that can access front-end of your website if maintenance mode is enabled', LJMM_PLUGIN_DOMAIN); ?>.</p>
                                <p class="description"><?php _e('Please note that this does NOT apply to admin area', LJMM_PLUGIN_DOMAIN); ?>.</p>
                                <p><a href="#" class="ljmm-toggle-all"><?php _e('Toggle all', LJMM_PLUGIN_DOMAIN); ?></a></p>
                            </th>
                            <td>
                                <?php foreach ($wp_roles as $role => $role_details) :  ?>
                                    <?php if ($role !== 'administrator') : ?>
                                        <fieldset>
                                            <legend class="screen-reader-text">
                                                <span><?php echo (isset($options[$role])) ? $options[$role] : ''; ?></span>
                                            </legend>
                                            <label>
                                                <input type="checkbox" class="ljmm-roles" name="ljmm-roles[<?php echo $role; ?>]" value="1" <?php checked(isset($options[$role]), 1); ?> /> <?php echo $role_details['name']; ?>
                                            </label>
                                        </fieldset>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <tr valign="top">
                            <th scope="row" colspan="2">
                                <p class="description"><?php _e('User Role control is currently not available on your website. Sorry!', LJMM_PLUGIN_DOMAIN); ?></p>
                            </th>
                        </tr>
                    <?php endif; ?>

                    <tr valign="middle">
                        <th scope="row"><?php _e('Allowed IPs (Contains)', LJMM_PLUGIN_DOMAIN); ?></th>
                        <td>
                            <textarea name="ljmm-allow_remote_ip" id="ljmm-allow_remote_ip" placeholder="<?php echo "192.168.0.10\n127.0.0.1\n2001:8004:5110:1d97:61e6:4c30:1a0c:7ecc\n203.214.74.\n2001:8004:5110:1d97:61e6:"; ?>" style="width:100%;height:150px;"><?php echo esc_attr(get_option('ljmm-allow_remote_ip')); ?></textarea>
                            <p class="description">
                                <?php
                                _e('Enter IPv4 or IPv6 values, one per line.', LJMM_PLUGIN_DOMAIN);
                                echo '<br>'.__('Which IP specification gets used? That all depends upon how the remote caller established the connection.', LJMM_PLUGIN_DOMAIN);
                                echo '<br>'.__('Partial IP values are ok; especially, when you want to identify a whole subnet.', LJMM_PLUGIN_DOMAIN);
                                $remote_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';
                                if (!empty($remote_ip)) {
                                    echo '<br>'.__('Uses', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[REMOTE_ADDR]</a> '.__('which identifies the current Remote IP:', LJMM_PLUGIN_DOMAIN).' <strong>'.$remote_ip.'</strong>';
                                }
                                $server_ip = isset( $_SERVER['SERVER_ADDR'] ) ? $_SERVER['SERVER_ADDR'] : '';
                                if (!empty($server_ip)) {
                                    echo '<br><strong>'.__('Tip:', LJMM_PLUGIN_DOMAIN).'</strong> <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[SERVER_ADDR]</a> '.__('identifies this server is at Server IP:', LJMM_PLUGIN_DOMAIN).' <strong>'.$server_ip.'</strong>';
                                }
                                ?>
                            </p>
                        </td>
                    </tr>

                  <tr valign="middle">
                    <th scope="row"><?php _e('Allowed URIs (Strict)', LJMM_PLUGIN_DOMAIN); ?></th>
                    <td>
                      <textarea name="ljmm-allow_request_uri_strictly" id="ljmm-allow_request_uri_strictly" placeholder="<?php echo "/products\n/resources/free/\n/wp-admin/admin-ajax.php\n/wp-cron.php\n/wp-mail.php\n/xmlrpc.php"; ?>" style="width:100%;height:150px;"><?php echo esc_attr(get_option('ljmm-allow_request_uri_strictly')); ?></textarea>
                      <p class="description">
                          <?php
                          echo __('The full relative path, starting with (/) when doing a strict match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Ignores the trailing slash (/) when doing a strict match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Ignores the entire query string (?) when doing a strict match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Never include the protocol, domain or port prefixes of the full URL.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Uses', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[REQUEST_URI]</a>';
                          $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
                          $request_uri_question_offset = strpos($request_uri, '?');
                          if ($request_uri_question_offset !== false) {
                              $request_uri = substr($request_uri, 0, $request_uri_question_offset);
                          }
                          if (!empty($request_uri)) {
                              echo ' '.__('and the value for this loaded page is:', LJMM_PLUGIN_DOMAIN).' <strong>'.$request_uri.'</strong>';
                          }
                          echo '<br><strong>Tip: /wp-login.php</strong> '.__('will always by-pass the maintenance mode page.', LJMM_PLUGIN_DOMAIN);
                          ?>
                      </p>
                    </td>
                  </tr>

                  <tr valign="middle">
                    <th scope="row"><?php _e('Allowed URIs (Contains)', LJMM_PLUGIN_DOMAIN); ?></th>
                    <td>
                      <textarea name="ljmm-allow_request_uri_contains" id="ljmm-allow_request_uri_contains" placeholder="<?php echo "/blog/\n/tags/\n/categories/\n/wp-content/uploads/logo-\n/wp-admin/"; ?>" style="width:100%;height:150px;"><?php echo esc_attr(get_option('ljmm-allow_request_uri_contains')); ?></textarea>
                      <p class="description">
                          <?php
                          echo __('Can be any sub-string contained within the URI, when doing a contains match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Ignores the trailing slash (/) when doing a contains match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Ignores the entire query string (?) when doing a contains match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Never include the protocol, domain or port prefixes of the full URL.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Uses', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[REQUEST_URI]</a>';
                          $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
                          $request_uri_question_offset = strpos($request_uri, '?');
                          if ($request_uri_question_offset !== false) {
                              $request_uri = substr($request_uri, 0, $request_uri_question_offset);
                          }
                          if (!empty($request_uri)) {
                              echo ' '.__('and the value for this loaded page is:', LJMM_PLUGIN_DOMAIN).' <strong>'.$request_uri.'</strong>';
                          }
                          ?>
                      </p>
                    </td>
                  </tr>

                  <tr valign="middle">
                    <th scope="row"><?php _e('Allowed Query Strings (Contains)', LJMM_PLUGIN_DOMAIN); ?></th>
                    <td>
                      <textarea name="ljmm-allow_request_query_string" id="ljmm-allow_request_query_string" placeholder="<?php echo "doing_wp_cron\ndoing_wp_cron&qUhYNCrdHSHOPwPgrdyY19yi0"; ?>" style="width:100%;height:150px;"><?php echo esc_attr(get_option('ljmm-allow_request_query_string')); ?></textarea>
                      <p class="description">
                          <?php
                          echo __('Can be any sub-string value after the (?) in the URI, when doing a contains match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Enter sub-string values that conform to output by', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/function.urldecode" target="_blank">urldecode()</a>.';
                          echo '<br>'.__('Uses', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[QUERY_STRING]</a>';
                          $request_query_string = isset( $_SERVER['QUERY_STRING'] ) ? urldecode($_SERVER['QUERY_STRING']) : '';
                          if (!empty($request_query_string)) {
                              echo ' '.__('and the value for this loaded page is:', LJMM_PLUGIN_DOMAIN).' <strong>'.$request_query_string.'</strong>';
                          }
                          echo '<br><strong>Tip:</strong> <a href="https://make.wordpress.org/core/2019/04/16/fatal-error-recovery-mode-in-5-2/" target="_blank">action=enter_recovery_mode&rm_token=</a> '.__('will always by-pass the maintenance mode page.', LJMM_PLUGIN_DOMAIN);
                          ?>
                      </p>
                    </td>
                  </tr>

                  <tr valign="middle">
                    <th scope="row"><?php _e('Allowed Referers (Contains)', LJMM_PLUGIN_DOMAIN); ?></th>
                    <td>
                      <textarea name="ljmm-allow_request_referer" id="ljmm-allow_request_referer" placeholder="<?php echo "camo\ngo-camo\ngithub-camo\nwww.mydomain.com\nnews.google.com"; ?>" style="width:100%;height:150px;"><?php echo esc_attr(get_option('ljmm-allow_request_referer')); ?></textarea>
                      <p class="description">
                          <?php
                          echo __('Can be any sub-string contained within the URI, when doing a contains match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Uses', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[HTTP_REFERER]</a>';
                          $request_referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
                          if (!empty($request_referer)) {
                              echo ' '.__('and the value for this loaded page is:', LJMM_PLUGIN_DOMAIN).' <strong>'.$request_referer.'</strong>';
                          }
                          ?>
                      </p>
                    </td>
                  </tr>

                  <tr valign="middle">
                    <th scope="row"><?php _e('Allowed User Agents (Contains)', LJMM_PLUGIN_DOMAIN); ?></th>
                    <td>
                      <textarea name="ljmm-allow_request_user_agent" id="ljmm-allow_request_user_agent" placeholder="<?php echo "android\nhtc one\niPhone\nwindows phone"; ?>" style="width:100%;height:150px;"><?php echo esc_attr(get_option('ljmm-allow_request_user_agent')); ?></textarea>
                      <p class="description">
                          <?php
                          echo __('Can be any sub-string contained within the URI, when doing a contains match.', LJMM_PLUGIN_DOMAIN);
                          echo '<br>'.__('Uses', LJMM_PLUGIN_DOMAIN).' <a href="https://www.php.net/manual/en/reserved.variables.server.php" target="_blank">$_SERVER[HTTP_USER_AGENT]</a>';
                          $request_user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
                          if (!empty($request_user_agent)) {
                              echo ' '.__('and the value for this loaded page is:', LJMM_PLUGIN_DOMAIN).' <strong>'.$request_user_agent.'</strong>';
                          }
                          ?>
                      </p>
                    </td>
                  </tr>

                  <?php
                        // do we have Analytify installed and linked to google?
                        wp_cache_delete('analytify_ua_code', 'options'); // see https://wordpress.stackexchange.com/questions/100040/can-i-force-get-option-to-go-back-to-the-db-instead-of-cache
                        $ua_code = get_option('analytify_ua_code'); ?>
                        <?php if ($ua_code) {
                            $ljmm_analytify = esc_attr(get_option('ljmm_analytify')); ?>
                            <tr valign="top">
                                <th scope="row">
                                    <label for="ljmm_analytify"><?php echo sprintf(__('Add Google Analytics code', LJMM_PLUGIN_DOMAIN)); ?></label>
                                </th>
                                <td>
                                    <input type="checkbox" id="ljmm_analytify" name="ljmm_analytify" value="1" <?php checked($ljmm_analytify, 1); ?>>
                                    <?php echo sprintf(__('for Analytics profile <b>%s</b> (<a href="/wp-admin/admin.php?page=analytify-settings">configured in Analytify</a>)', LJMM_PLUGIN_DOMAIN), $ua_code); ?>
                                    <p class="description">
				                        <?php _e('Since you have the Analytify plugin installed, this will add Google Analytics tracking code to the maintenance page.', LJMM_PLUGIN_DOMAIN); ?>
                                    </p>
                                </td>
                            </tr>
                        <?php
                        } ?>

                    <tr valign="middle">
                        <th scope="row"><?php _e('Custom Stylesheet', LJMM_PLUGIN_DOMAIN); ?></th>
                        <td>
                            <?php /* $ljmm_site_title = esc_attr(get_option('ljmm-site-title')); // Variable not used. */ ?>
                            <?php $ljmm_stlylesheet_filename = $this->get_css_filename(); ?>
                            <?php $ljmm_has_custom_stylsheet = (bool) $this->get_custom_stylesheet_url(); ?>
                            <?php if ($ljmm_has_custom_stylsheet) : ?>
                                <p>
                                    <span style="line-height: 1.3; font-weight: 600; color: green;">You are currently using custom stylesheet.</span>
                                    <span class="description">(<?php _e("'$ljmm_stlylesheet_filename' file in your theme folder", LJMM_PLUGIN_DOMAIN); ?>)</span>
                            <?php else : ?>
                                <p class="description"><?php _e("For custom stylesheet, add '$ljmm_stlylesheet_filename' file to your theme folder. If your custom stylesheet file is picked up by the Maintenance Mode, it will be indicated here.", LJMM_PLUGIN_DOMAIN); ?>
                            <?php endif; ?>
                            <?php
                            echo '<br><strong>Tip:</strong> The maintenance mode page DOM structure is:';
                            echo '<br>'.htmlspecialchars('<body id="error-page">');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<div class="wp-die-message">');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<script type="application/javascript">...</script>');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<style type="text/css">...</style>').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<-- '.$ljmm_stlylesheet_filename;
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<div class="ljmm-wrapper">');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<div class="ljmm-content">');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<div id="block-#" class="widget widget_block ...">...</div>');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('... the "maintenance mode page content" is here ...');
                            echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.htmlspecialchars('<div id="block-#" class="widget widget_block ...">...</div>');
                            ?>
                            </p>
                        </td>
                    </tr>

                    <tr valign="middle">
                        <th scope="row"><?php _e('Custom Frontend Stylesheet', LJMM_PLUGIN_DOMAIN); ?></th>
                        <td>
                            <?php $ljmm_stlylesheet_frontend_filename = $this->get_css_frontend_filename(); ?>
                            <?php $ljmm_has_custom_frontend_stylsheet = (bool) $this->get_custom_frontend_stylesheet_url(); ?>
                            <?php if ($ljmm_has_custom_frontend_stylsheet) : ?>
                                <p>
                                <span style="line-height: 1.3; font-weight: 600; color: green;">You are currently using custom frontend stylesheet.</span>
                                <span class="description">(<?php _e("'$ljmm_stlylesheet_frontend_filename' file in your theme folder", LJMM_PLUGIN_DOMAIN); ?>)</span>
                                </p>
                            <?php else : ?>
                                <p class="description"><?php _e("For custom stylesheet, add '$ljmm_stlylesheet_frontend_filename' file to your theme folder. If your custom stylesheet file is picked up by the Maintenance Mode, it will be indicated here.", LJMM_PLUGIN_DOMAIN); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>

                  <tr valign="middle">
                    <th scope="row"><?php _e('Custom Login Stylesheet', LJMM_PLUGIN_DOMAIN); ?></th>
                    <td>
                        <?php $ljmm_stlylesheet_login_filename = $this->get_css_login_filename(); ?>
                        <?php $ljmm_has_custom_login_stylsheet = (bool) $this->get_custom_login_stylesheet_url(); ?>
                        <?php if ($ljmm_has_custom_login_stylsheet) : ?>
                          <p>
                            <span style="line-height: 1.3; font-weight: 600; color: green;">You are currently using custom login stylesheet.</span>
                            <span class="description">(<?php _e("'$ljmm_stlylesheet_login_filename' file in your theme folder", LJMM_PLUGIN_DOMAIN); ?>)</span>
                          </p>
                        <?php else : ?>
                          <p class="description"><?php _e("For custom stylesheet, add '$ljmm_stlylesheet_login_filename' file to your theme folder. If your custom stylesheet file is picked up by the Maintenance Mode, it will be indicated here.", LJMM_PLUGIN_DOMAIN); ?></p>
                        <?php endif; ?>
                    </td>
                  </tr>

                  <tr valign="top">
                        <th scope="row">
                            <label for="ljmm_code_snippet"><?php _e('Inject code snippet', LJMM_PLUGIN_DOMAIN); ?></label>
                        </th>
                        <td>
                            <textarea id="ljmm_code_snippet" name="ljmm_code_snippet" style="width:100%;height:150px"><?php echo esc_attr(get_option('ljmm_code_snippet')); ?></textarea>
                            <p class="description">
				                    <?php
				                        _e('This is useful to add a Javascript snippet to the maintenance page.', LJMM_PLUGIN_DOMAIN);
                               echo '<br><strong>Tip:</strong> Do include the surrounding <strong>'.htmlspecialchars('<script type="application/javascript">...</script><noscript>...</noscript>').'</strong>';
                            ?>
    				                <?php
                                if ($ua_code) {
                                    _e('NOTE: if you are using the option above to add Google Analytics code, do NOT paste GA tracking code here.', LJMM_PLUGIN_DOMAIN);
                                }
                            ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <script>
          jQuery(document).ready(function() {
            jQuery('.ljmm-advanced-settings').on('click', function(event) {
              event.preventDefault();
              jQuery('.form--ljmm-advanced-settings').toggle();
              if (jQuery('.form--ljmm-advanced-settings').is(':visible')) {
                jQuery(this).find('.ljmm-advanced-settings__label-advanced').hide();
                jQuery(this).find('.ljmm-advanced-settings__label-hide-advanced').show();
              } else {
                jQuery(this).find('.ljmm-advanced-settings__label-advanced').show();
                jQuery(this).find('.ljmm-advanced-settings__label-hide-advanced').hide();
              }
            });
            jQuery('.ljmm-toggle-all').on('click', function(event) {
              event.preventDefault();
              var checkBoxes = jQuery("input.ljmm-roles");
              checkBoxes.prop("checked", !checkBoxes.prop("checked"));
            });
          });
        </script>
    <?php
    }

    /**
     * Admin bar indicator
     *
     * @since 1.1
    */
    public function indicator($wp_admin_bar)
    {
        $enabled = apply_filters('ljmm_admin_bar_indicator_enabled', $enabled = true);

        if (!current_user_can($this->get_relevant_cap())) {
            return false;
        }

        if (!$enabled) {
            return false;
        }

        $is_enabled = get_option('ljmm-enabled');
        $status = _x('Disabled', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN);

        if ($is_enabled) {
            $status = _x('Enabled', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN);
        }

        $indicatorClasses = $is_enabled ? 'ljmm-indicator ljmm-indicator--enabled' : 'ljmm-indicator';

        $indicator = [
            'id' => 'ljmm-indicator',
            'title' => '<span class="ab-icon dashicon-before dashicons-hammer"></span> ' . $status,
            'parent' => false,
            'href' => get_admin_url(null, 'options-general.php?page=lj-maintenance-mode'),
            'meta' => [
                'title' => _x('Maintenance Mode', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN),
                'class' => $indicatorClasses,
            ]
        ];

        $wp_admin_bar->add_node($indicator);
        return true;
    }

    /**
     * Plugin action links
     *
     * @since 1.1
     * @return mixed
    */
    public function action_links($links)
    {
        $links[] = '<a href="' . get_admin_url(null, 'options-general.php?page=lj-maintenance-mode') . '">' . _x('Settings', 'Plugin Settings link', LJMM_PLUGIN_DOMAIN) . '</a>';
        $links[] = '<a target="_blank" href="' . LJMM_SUPPORT_LINK . '">' . _x('Support', 'Plugin Support link', LJMM_PLUGIN_DOMAIN) . '</a>';

        return $links;
    }

    /**
     * Default site title for maintenance mode
     *
     * @since 2.0
     * @return string
     */
    public function site_title()
    {
        return apply_filters('ljmm_site_title', get_bloginfo('name') . ' - ' . __('Website Under Maintenance', LJMM_PLUGIN_DOMAIN));
    }

    /**
     * Manage capabilities
     *
     * @since 2.0
     */
    public function manage_capabilities()
    {
        $wp_roles = get_editable_roles();
        $all_roles = get_option('ljmm-roles');

        // extra checks
        if ($wp_roles && is_array($wp_roles)) {
            foreach ($wp_roles as $role => $role_details) {
                $get_role = get_role($role);

                if (is_array($all_roles) && array_key_exists($role, $all_roles)) {
                    $get_role->add_cap(LJMM_VIEW_SITE_CAP);
                } else {
                    $get_role->remove_cap(LJMM_VIEW_SITE_CAP);
                }
            }
        }

        // administrator by default
        $admin_role = get_role('administrator');
        $admin_role->add_cap(LJMM_VIEW_SITE_CAP);
        $admin_role->add_cap(LJMM_PLUGIN_CAP);
    }

    /**
     * Get mode
     *
     * @since 2.2
     * @return int
     */
    public function get_mode()
    {
        $mode = get_option('ljmm-mode');
        if ($mode == 'cs') {
            // coming soon page
            return 200;
        }

        // maintenance mode
        return 503;
    }

    /**
     * Get content
     *
     * @since 2.3
     * @return string
     */
    public function get_content()
    {
        $get_content = get_option('ljmm-content');
        $content = (!empty($get_content)) ? $get_content : ljmm_get_defaults('maintenance_message');
        $content = apply_filters('wptexturize', $content);
        $content = apply_filters('wpautop', $content);
        // $content = nl2br($content); /* Do NOT implement. It generates <p></p><br> which messes with spacing & presentations of all existing installations. */
        $content = apply_filters('shortcode_unautop', $content);
        $content = apply_filters('prepend_attachment', $content);
        $content = apply_filters('wp_make_content_images_responsive', $content);
        $content = apply_filters('convert_smilies', $content);
        $content = apply_filters('ljmm_content', $content);

        // analytify support
        $analytify = $this->analytify_support();

        // custom code snippets
        $code = get_option('ljmm_code_snippet');

        // add widgets
        $widget_before = $this->widget_before();
        $widget_after = $this->widget_after();

        // add custom stylesheet
        $stylesheet = $this->custom_stylesheet();

        return $analytify . $code . $stylesheet . '<div class="ljmm-wrapper"><div class="ljmm-content">' . $widget_before . $content . $widget_after . '</div></div>';
    }

    /**
     * Get title
     *
     * @since 2.3
     * @return string
     */
    public function get_title()
    {
        $site_title = get_option('ljmm-site-title');
        return $site_title ? $site_title : $this->site_title();
    }

    /**
     * Get CSS file name
     *
     * @since 2.4
     * @return string
     */
    public function get_css_filename()
    {
        return apply_filters('ljmm_css_filename', 'maintenance.min.css');
    }

    /**
     * Get CSS frontend file name
     *
     * @since 2.5
     * @return string
     */
    public function get_css_frontend_filename()
    {
        return apply_filters('ljmm_css_frontend_filename', 'maintenance.min.frontend.css');
    }

    /**
     * Get CSS login file name
     *
     * @since 2.5.1
     * @return string
     */
    public function get_css_login_filename()
    {
        return apply_filters('ljmm_css_login_filename', 'maintenance.min.login.css');
    }

    /**
     * Custom stylsheet
     *
     * @since 2.4
     * @return string
     */
    public function custom_stylesheet()
    {
        $stylesheet = '';
        $url = $this->get_custom_stylesheet_url();

        if ($url) {
            $stylesheet = '<style type="text/css">' . file_get_contents($url) . '</style>';
        }

        return $stylesheet;
    }

    /**
     * Check for custom stylesheet
     *
     * @since 2.4
     * @return boolean
     */
    public function get_custom_stylesheet_url()
    {
        $stylesheet_url = false;

        $url_filename = $this->get_css_filename();

        if (!validate_file($url_filename)) {
            $url = apply_filters('ljmm_css_url', get_stylesheet_directory() . '/' . $url_filename);

            if (file_exists($url)) {
                $stylesheet_url = $url;
            }
        }

        return $stylesheet_url;
    }

    /**
     * Custom frontend stylsheet
     *
     * @since 2.5
     * @return string
     */
    public function custom_frontend_stylesheet()
    {
        $stylesheet = '';
        $url = $this->get_custom_frontend_stylesheet_url();

        if ($url) {
            $stylesheet = '<style type="text/css">' . file_get_contents($url) . '</style>';
        }

        return $stylesheet;
    }

    /**
     * Check for custom frontend stylesheet
     *
     * @since 2.5
     * @return boolean
     */
    public function get_custom_frontend_stylesheet_url()
    {
        $stylesheet_url = false;

        $url_filename = $this->get_css_frontend_filename();

        if (!validate_file($url_filename)) {
            $url = apply_filters('ljmm_css_frontend_url', get_stylesheet_directory() . '/' . $url_filename);

            if (file_exists($url)) {
                $stylesheet_url = $url;
            }
        }

        return $stylesheet_url;
    }

    /**
     * Custom login stylsheet
     *
     * @since 2.5.1
     * @return string
     */
    public function custom_login_stylesheet()
    {
        $stylesheet = '';
        $url = $this->get_custom_login_stylesheet_url();

        if ($url) {
            $stylesheet = '<style type="text/css">' . file_get_contents($url) . '</style>';
        }

        return $stylesheet;
    }

    /**
     * Check for custom login stylesheet
     *
     * @since 2.5.1
     * @return boolean
     */
    public function get_custom_login_stylesheet_url()
    {
        $stylesheet_url = false;

        $url_filename = $this->get_css_login_filename();

        if (!validate_file($url_filename)) {
            $url = apply_filters('ljmm_css_login_url', get_stylesheet_directory() . '/' . $url_filename);

            if (file_exists($url)) {
                $stylesheet_url = $url;
            }
        }

        return $stylesheet_url;
    }

    /**
     * Editor content
     *
     * @since 2.4
     * @return void
     */
    public function editor_content()
    {
        $content = get_option('ljmm-content');
        $editor_id = 'ljmm-content';
        wp_editor($content, $editor_id);
    }

    /**
     * Before maintenance mode
     */
    public function before_maintenance_mode()
    {
        // remove jetpack sharing
        remove_filter('the_content', 'sharing_display', 19);
    }

    /**
     * Is maintenance enabled?
     *
     * @since 2.3
     * @return boolean
     */
    public function enabled()
    {
        // enabled
        if (get_option('ljmm-enabled') || isset($_GET['ljmm']) && $_GET['ljmm'] == 'preview') {
            return true;
        }

        // disabled
        return false;
    }

    /**
     * Maintenance Mode
     *
     * @since 1.0
    */
    public function maintenance()
    {
        if (!$this->enabled()) {
            return false;
        }

        do_action('ljmm_before_mm');

        // TML Compatibility
        if (class_exists('Theme_My_Login')) {
            if (Theme_My_Login::is_tml_page()) {
                return false;
            }
        }

        if (!(current_user_can(LJMM_VIEW_SITE_CAP) || current_user_can('super admin') || current_user_can('administrator')) || (isset($_GET['ljmm']) && $_GET['ljmm'] == 'preview')) {

            // Allowable exceptions list processing to by-pass the maintenance mode page.
            // Acceptance Criteria 1: All comparisons must be case-insensitive.
            // Acceptance Criteria 2: Trim whitespace and '/' suffix for better matching comparisons.
            // Acceptance Criteria 3: All URL values function from a relative path perspective '/______'; handle missing '/' prefix cleanly.
            // Acceptance Criteria 4: A strict URI comparison should ignore query string parameters; everythign from the '?'.
            // Acceptance Criteria 5: Decode values, allowing user input to be the human friendly values.
            // Reference: https://www.php.net/manual/en/reserved.variables.server.php
            // Reference: https://www.php.net/manual/en/function.rawurldecode.php
            // Reference: https://www.php.net/manual/en/function.urldecode.php
            // $_SERVER['REMOTE_ADDR'] will always be only IPv4 or IPv6; it all depends upon how the connection to the server was made.

            // Allowed list of IPs (contains/sloppy match) ... allows for whole subnets to be identified.
            $allow_remote_ip_text = get_option('ljmm-allow_remote_ip');
            $allow_remote_ip_text = trim($allow_remote_ip_text);
            if (!empty($allow_remote_ip_text)) {
                $allow_remote_ip_list = preg_split("/[\f\r\n]+/", $allow_remote_ip_text);
                $remote_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '';
                if (!empty($remote_ip) && is_array($allow_remote_ip_list) === true) {
                    $remote_ip = strtolower($remote_ip);
                    foreach ($allow_remote_ip_list as $needle) {
                        $needle = trim($needle);
                        if (!empty($needle)) {
                            $needle = strtolower($needle);
                            if (strpos($remote_ip, $needle) === 0) {
                                // Could add a filter for 'Yes, it is allowed' here.
                                return false;
                            }
                        }
                    }
                }
            }

            // Allowed list of URIs (strict match) ... does not allow access to child pages.
            $allow_request_uri_strictly_text = "/wp-login.php\n";  // Due to 'wp_loaded' hook triggering quite early.

            $allow_request_uri_strictly_text .= get_option('ljmm-allow_request_uri_strictly');
            $allow_request_uri_strictly_text = trim($allow_request_uri_strictly_text);
            // if (!empty($allow_request_uri_strictly_text)) {
                $allow_request_uri_strictly_list = preg_split("/[\f\r\n]+/", $allow_request_uri_strictly_text);
                $request_uri = isset($_SERVER['REQUEST_URI']) ? rawurldecode($_SERVER['REQUEST_URI']) : '';
                $request_uri_question_offset = strpos($request_uri, '?');
                if ($request_uri_question_offset !== false) {
                    $request_uri = substr($request_uri, 0, $request_uri_question_offset);
                }
                $request_uri = ltrim($request_uri);  // [REQUEST_URI] always starts with '/'.
                $request_uri = rtrim($request_uri);
                $request_uri = rtrim($request_uri, '/');
                if (!empty($request_uri) && is_array($allow_request_uri_strictly_list) === true) {
                    foreach ($allow_request_uri_strictly_list as $needle) {
                        $needle = ltrim($needle);
                        $needle = '/' . ltrim($needle, '/'); // Ensure prefix is '/', always.
                        $needle = rtrim($needle);
                        $needle = rtrim($needle, '/');     // Remove suffix of '/'.
                        if (!empty($needle) && strcasecmp($request_uri, $needle) == 0) {
                            // Could add a filter for 'Yes, it is allowed' here.
                            return false;
                        }
                    }
                }
            // }

            // Allowed list of URIs (contains/sloppy match) ... allowing child pages to show.
            $allow_request_uri_contains_text = get_option('ljmm-allow_request_uri_contains');
            $allow_request_uri_contains_text = trim($allow_request_uri_contains_text);
            if (!empty($allow_request_uri_contains_text)) {
                $allow_request_uri_contains_list = preg_split("/[\f\r\n]+/", $allow_request_uri_contains_text);
                $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( $_SERVER['REQUEST_URI'] ) : '';
                $request_uri_question_offset = strpos($request_uri, '?');
                if ($request_uri_question_offset !== false) {
                    $request_uri = substr($request_uri, 0, $request_uri_question_offset);
                }
                $request_uri = ltrim($request_uri);  // [REQUEST_URI] always starts with '/'.
                $request_uri = rtrim($request_uri);
                $request_uri = rtrim($request_uri, '/');
                if (!empty($request_uri) && is_array($allow_request_uri_contains_list) === true) {
                    foreach ($allow_request_uri_contains_list as $needle) {
                        $needle = trim($needle);
                        if (!empty($needle) && !stristr($request_uri, $needle) === false) {
                            // Could add a filter for 'Yes, it is allowed' here.
                            return false;
                        }
                    }
                }
            }

            // Allowed list of referers (contains/sloppy matching).
            $allow_request_referer_text = get_option('ljmm-allow_request_referer');
            $allow_request_referer_text = trim($allow_request_referer_text);
            if (!empty($allow_request_referer_text)) {
                $allow_request_referer_list = preg_split("/[\f\r\n]+/", $allow_request_referer_text);
                $request_referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : '';
                if (!empty($request_referer) && is_array($allow_request_referer_list) === true) {
                    foreach ($allow_request_referer_list as $needle) {
                        $needle = trim($needle);
                        if (!empty($needle) && !stristr($request_referer, $needle) === false) {
                            // Could add a filter for 'Yes, it is allowed' here.
                            return false;
                        }
                    }
                }
            }

            // Allowed list of user agents (contains/sloppy matching).
            $allow_request_user_agent_text = get_option('ljmm-allow_request_user_agent');
            $allow_request_user_agent_text = trim($allow_request_user_agent_text);
            if (!empty($allow_request_user_agent_text)) {
                $allow_request_user_agent_list = preg_split("/[\f\r\n]+/", $allow_request_user_agent_text);
                $request_user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
                if (!empty($request_user_agent) && is_array($allow_request_user_agent_list) === true) {
                    foreach ($allow_request_user_agent_list as $needle) {
                        $needle = trim($needle);
                        if (!empty($needle) && !stristr($request_user_agent, $needle) === false) {
                            // Could add a filter for 'Yes, it is allowed' here.
                            return false;
                        }
                    }
                }
            }

            // Allowed list in query string (contains/sloppy matching).
            $allow_request_query_string_text = "action=enter_recovery_mode&rm_token=\n";  // We never want to interfere with 'WordPress Recovery Mode'.

            $allow_request_query_string_text .= get_option('ljmm-allow_request_query_string');
            $allow_request_query_string_text = trim($allow_request_query_string_text);
            // if (!empty($allow_request_query_string_text)) {
                $allow_request_query_string_list = preg_split("/[\f\r\n]+/", $allow_request_query_string_text);
                $request_query_string = isset( $_SERVER['QUERY_STRING'] ) ? urldecode($_SERVER['QUERY_STRING']) : '';
                if (!empty($request_query_string) && is_array($allow_request_query_string_list) === true) {
                    foreach ($allow_request_query_string_list as $needle) {
                        $needle = urldecode($needle);
                        $needle = trim($needle);
                        if (!empty($needle) && !stristr($request_query_string, $needle) === false) {
                            // Could add a filter for 'Yes, it is allowed' here.
                            return false;
                        }
                    }
                }
            // }

            wp_die($this->get_content(), $this->get_title(), ['response' => $this->get_mode()]);
        }
    }

    /**
     * Get relevant cap
     *
     * This has been implemented due to lack of compatibility with user role
     * and capabilities plugins that caused some users problems viewing the settings
     * page. So if user is a super admin, plugin will use 'delete_plugins' cap, otherwise
     * plugins' cap 'ljmm_control'
     *
     * @return string
     * @since 2.4.2
     */
    public function get_relevant_cap()
    {
        return is_super_admin() ? 'delete_plugins' : LJMM_PLUGIN_CAP;
    }

    /**
     * Notify if cache plugin detected
     *
     * @since 1.2
    */
    public function notify()
    {
        $cache_plugin_enabled = $this->cache_plugin();
        if (!empty($cache_plugin_enabled)) {
            $class = 'error';
            $message = $this->cache_plugin();
            if (isset($_GET['settings-updated'])) {
                echo '<div class="' . $class . '"><p>' . $message . '</p></div>';
            }
        }
    }

    /**
     * Register widget sidebars
     *
     * @return void
     */
    public function register_widget_sidebars()
    {
        if (function_exists('register_sidebar')) {
            register_sidebar([
                'id' => 'ljmm-before',
                'name' => __('Maintenance mode - before content', LJMM_PLUGIN_DOMAIN),
                'description' => __('', LJMM_PLUGIN_DOMAIN),
                'before_widget' => "\n" . '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>' . "\n",
            ]);

            register_sidebar([
                'id' => 'ljmm-after',
                'name' => __('Maintenance mode - after content', LJMM_PLUGIN_DOMAIN),
                'description' => __('', LJMM_PLUGIN_DOMAIN),
                'before_widget' => "\n" . '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>' . "\n",
            ]);
        }
    }

    /**
     * Widget
     *
     * @param string $id
     * @return string|false
     */
    public function widget($id)
    {
        $widget = '';

        if (get_option('ljmm_add_widget_areas')) {
            ob_start();
            dynamic_sidebar(sprintf('ljmm-%s', $id));
            $widget = ob_get_clean();
        }

        return $widget;
    }

    /**
     * Widget before
     *
     * @return false|string
     */
    public function widget_before()
    {
        return $this->widget('before');
    }

    /**
     * Widget after
     *
     * @return false|string
     */
    public function widget_after()
    {
        return $this->widget('after');
    }

    /**
     * Analytify plugin support
     *
     * @since 2.4
     * @return string
     */
    public function analytify_support()
    {
        // Do we have a UA code from Analytify plugin?
        $analytify = '';
        if (get_option('ljmm_analytify') && $ua_code = get_option('analytify_ua_code')) {
            // Yes, so we can generate the code to inject
            $analytify = <<<EOD
                <script>
                  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                  ga('create', '{$ua_code}', 'auto');
                  ga('send', 'pageview');

                </script>
EOD;
        }

        return $analytify;
    }

    /**
     * Detect cache plugins
     *
     * @since 1.2
     * @return string
    */
    public function cache_plugin()
    {
        $message = '';
        // add wp super cache support
        if (in_array('wp-super-cache/wp-cache.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $message = ljmm_get_defaults('warning_wp_super_cache');
        }

        // add w3 total cache support
        if (in_array('w3-total-cache/w3-total-cache.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $message = ljmm_get_defaults('warning_w3_total_cache');
        }

        // add comet cache support
        if (in_array('comet-cache/comet-cache.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $message = ljmm_get_defaults('warning_comet_cache');
        }

        // add WP Rocket support
        if (in_array('wp-rocket/wp-rocket.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $message = ljmm_get_defaults('warning_wp_rocket_cache');
        }

        // add Autoptimize support ... which can be running in parallel to the cache plugins listed above.
        if (in_array('autoptimize/autoptimize.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $message .= empty($message) ? '' : '<br>';
            $message .= ljmm_get_defaults('warning_autoptimize_cache');
        }

        return $message;
    }
}

// initialise plugin.
$ljMaintenanceMode = new ljMaintenanceMode();
