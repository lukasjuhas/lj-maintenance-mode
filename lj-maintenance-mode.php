<?php
/**
 * Plugin Name: Maintenance Mode
 * Plugin URI: https://github.com/lukasjuhas/lj-maintenance-mode
 * Description: Very simple Maintenance Mode & Coming soon page. Using default Wordpress markup, No ads, no paid upgrades.
 * Version: 1.4.1
 * Author: Lukas Juhas
 * Author URI: http://lukasjuhas.com
 * Text Domain: lj-maintenance-mode
 * License: GPL2
 * Domain Path: /languages/
 *
 * Copyright 2014-2015  Lukas Juhas  (email : hello@lukasjuhas.com)
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
 * @version 1.4.1
 *
 */

// define stuff
define( 'LJMM_VERSION', '1.4.1' );
define( 'LJMM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LJMM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LJMM_PLUGIN_BASENAME', plugin_basename( __FILE__ ));
define( 'LJMM_PLUGIN_DOMAIN', 'lj-maintenance-mode' );
define( 'LJMM_CONTACT_EMAIL', 'hello@lukasjuhas.com' );

// activation hook
add_action( 'activate_' . LJMM_PLUGIN_BASENAME, 'ljmm_install' );

/**
 * Installation
 *
 * @since 1.0
*/
function ljmm_install() {
    // remove old settings. This has been deprecated in 1.2
    delete_option( 'ljmm-content-default' );

    // set default content
    ljmm_set_content();
}

/**
 * Default hardcoded settings
 *
 * @since 1.4
 */
function ljmm_get_defaults($type) {
    switch($type) {
        case 'maintenance_message':
            $default = __("<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>", LJMM_PLUGIN_DOMAIN );
            break;
        case 'warning_wp_super_cache' :
            $default = __("Important: Don't forget to flush your cache using WP Super Cache when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'warning_w3_total_cache' :
            $default = __("Important: Don't forget to flush your cache using WP Super Cache when enabling or disabling Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'ljmm_enabled' :
            $default = __("Maintenance Mode is currently active. To make sure that it works, open your web page in either private / incognito mode, different browser or simply log out. Logged in users are not affected by the Maintenance Mode.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'ljmm_center' :
            $default = __("Center the content in page.", LJMM_PLUGIN_DOMAIN);
            break;
        case 'ljmm_bgimage' :
            $default = __("Backgrounds should have 1920x1280 px size. Leave empty for no background", LJMM_PLUGIN_DOMAIN);
            break;  
        case 'ljmm_bgcolor' :
            $default = __("Set the background color.", LJMM_PLUGIN_DOMAIN);
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
 * @since 1.0
 */
function ljmm_set_content() {
  // If content is not set, set the default content.
  $content = get_option( 'ljmm-content');
  if(empty($content)) :
      $content = ljmm_get_defaults('maintenance_message');
      /**
      * f you are trying to ensure that a given option is created,
      * use update_option() instead, which bypasses the option name check
      * and updates the option with the desired value whether or not it exists.
      */
      update_option( 'ljmm-content', stripslashes($content));
  endif;
}

/**
 * Load plugin textdomain.
 *
 * @since 1.3.1
*/
function ljmm_load_textdomain() {
    load_plugin_textdomain( LJMM_PLUGIN_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'ljmm_load_textdomain' );

/**
 * main class
 *
 * @since 1.0
*/
class ljMaintenanceMode {

    function __construct() {
        add_action( 'admin_menu', array( $this, 'ui' ) );
        add_action( 'admin_head', array( $this, 'style' ) );
        add_action( 'admin_init', array( $this, 'settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_color_picker' ) );

        // remove old settings. This has been deprecated in 1.2
        delete_option( 'ljmm-content-default' );

        $is_enabled = get_option('ljmm-enabled');

        if($is_enabled || isset($_GET['ljmm']) && $_GET['ljmm'] == 'preview') :
            add_action('get_header', array($this, 'maintenance'));
        endif;

        add_action( 'admin_bar_menu', array( $this, 'indicator' ), 100 );
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links') );
    }

    /**
     * Settings page
     *
     * @since 1.0
    */
    function ui() {
        add_submenu_page( 'options-general.php', __('Maintenance Mode', LJMM_PLUGIN_DOMAIN), __('Maintenance Mode', LJMM_PLUGIN_DOMAIN), 'delete_plugins', 'lj-maintenance-mode', array($this, 'settingsPage') );
    }

    /**
     * Inject styling
     *
     * @since 1.1
    */
    function style() {
        echo '<style type="text/css">#wp-admin-bar-ljmm-indicator.Enabled { background: rgba(159, 0, 0, 1) }</style>';
    }
    
    function enqueue_color_picker( $hook_suffix ) {
        if('lj-maintenance-mode' == $_GET['page'] ) {
          wp_enqueue_style( 'wp-color-picker' );
          wp_enqueue_script( 'wp-color-picker');
        }
    }
    
    /**
     * Settings
     *
     * @since 1.0
    */
    function settings() {
        register_setting('ljmm', 'ljmm-enabled');
        register_setting('ljmm', 'ljmm-content');
        register_setting('ljmm', 'ljmm-center');
        register_setting('ljmm', 'ljmm-bgimage');
        register_setting('ljmm', 'ljmm-bgcolor');

        //set the content
        ljmm_set_content();
    }

    /**
     * Settings page
     *
     * @since 1.0
    */
    function settingsPage() { ?>
        <script type="text/javascript">
          jQuery(document).ready(function($){
              var lj_uploader;
              $('#ljmm-bgimage-button').click(function(e) {
                  e.preventDefault();
                  //If the uploader object has already been created, reopen the dialog
                  if (lj_uploader) {
                      lj_uploader.open();
                      return;
                  }
                  //Extend the wp.media object
                  lj_uploader = wp.media.frames.file_frame = wp.media({
                      title: '<?php _e('Choose Image', LJMM_PLUGIN_DOMAIN ); ?>',
                      button: {
                          text: '<?php _e('Choose Image', LJMM_PLUGIN_DOMAIN ); ?>'
                      },
                      multiple: false
                  });
                  //When a file is selected, grab the URL and set it as the text field's value
                  lj_uploader.on('select', function() {
                      attachment = lj_uploader.state().get('selection').first().toJSON();
                      $('#ljmm-bgimage').val(attachment.url);
                  });
                  //Open the uploader dialog
                  lj_uploader.open();
              });
              $('.lj-color-field').wpColorPicker();
          });
        </script>
        <div class="wrap">
            <h2><?php _e('Maintenance Mode', LJMM_PLUGIN_DOMAIN ); ?></h2>
            <form method="post" action="options.php">
                <?php settings_fields( 'ljmm' ); ?>
                <?php do_settings_sections( 'ljmm' ); ?>

                <?php $this->notify(); ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Enabled', LJMM_PLUGIN_DOMAIN ); ?></th>
                        <td>
                            <?php $ljmm_enabled = esc_attr( get_option('ljmm-enabled') ); ?>
                            <input type="checkbox" name="ljmm-enabled" value="1" <?php checked( $ljmm_enabled, 1 ); ?>>
                            <?php if($ljmm_enabled) : ?>
                                <p class="description"><?php echo ljmm_get_defaults('ljmm_enabled'); ?></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Center', LJMM_PLUGIN_DOMAIN ); ?></th>
                        <td>
                            <?php $ljmm_center = esc_attr( get_option('ljmm-center') ); ?>
                            <input type="checkbox" name="ljmm-center" value="1" <?php checked( $ljmm_center, 1 ); ?>>
                                <p class="description"><?php echo ljmm_get_defaults('ljmm_center'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Background Image', LJMM_PLUGIN_DOMAIN ); ?></th>
                        <td>
                            <?php $ljmm_bgimage = esc_attr( get_option('ljmm-bgimage') ); ?>
                            <div class="uploader">
                              <input id="ljmm-bgimage" type="text" size="36" name="ljmm-bgimage" value="<?php echo $ljmm_bgimage; ?>" /> 
                              <input id="ljmm-bgimage-button" class="button" type="button" value="<?php _e('Upload Image', LJMM_PLUGIN_DOMAIN ); ?>" />
                            </div>
                                <p class="description"><?php echo ljmm_get_defaults('ljmm_bgimage'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Background Color', LJMM_PLUGIN_DOMAIN ); ?></th>
                        <td>
                            <?php $ljmm_bgcolor = esc_attr( get_option('ljmm-bgcolor') ); ?>
                            <input id="ljmm-bgcolor" name="ljmm-bgcolor" type="text" value="<?php echo $ljmm_bgcolor; ?>" class="lj-color-field" data-default-color="#f1f1f1" />
                                <p class="description"><?php echo ljmm_get_defaults('ljmm_bgcolor'); ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" colspan="2"><?php _e('Content', LJMM_PLUGIN_DOMAIN ); ?></th>
                    </tr>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url( add_query_arg( 'ljmm', 'preview', bloginfo('url') ) ); ?>" target="_blank" class="button button-primary"><?php _e('Preview', LJMM_PLUGIN_DOMAIN); ?></a>
                            <a class="button support" href="http://lukasjuhas.github.io/maintenance-mode/" target="_blank"><?php _e('Support', LJMM_PLUGIN_DOMAIN); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                              $content = get_option('ljmm-content');
                              $editor_id = 'ljmm-content';
                              wp_editor( $content, $editor_id );
                            ?>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php }

    /**
     * admin bar indicator
     *
     * @since 1.1
    */
    function indicator($wp_admin_bar) {
        if ( !current_user_can( 'delete_plugins' ) )
            return false;

        $is_enabled = get_option('ljmm-enabled');
        $status = _x('Disabled', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN);

        if($is_enabled)
            $status = _x('Enabled', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN);

        $indicator = array(
            'id' => 'ljmm-indicator',
            'title' => _x('Maintenance Mode', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN).': '.$status,
            'parent' => false,
            'href' => get_admin_url(null, 'options-general.php?page=lj-maintenance-mode'),
            'meta' => array(
                'title' => _x('Maintenance Mode', 'Admin bar indicator', LJMM_PLUGIN_DOMAIN),
                'class' => $status,
            )
        );
        $wp_admin_bar->add_node($indicator);
    }

    /**
     * plugin action links
     *
     * @since 1.1
    */
    function action_links( $links ) {
        $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=lj-maintenance-mode') .'">'._x('Settings','Plugin Settings link', LJMM_PLUGIN_DOMAIN).'</a>';
        return $links;
    }

    /**
     * Maintenance Mode
     *
     * @since 1.0
    */
    function maintenance() {
        if ( !(current_user_can( 'administrator' ) ||  current_user_can( 'super admin' )) || ( isset($_GET['ljmm']) && $_GET['ljmm'] == 'preview')) {
            $content = get_option('ljmm-content');
            if(empty($content)) {
                // fallback
                $content = ljmm_get_defaults('maintenance_message');
            }
            $content = apply_filters('the_content', $content);
            $this->lj_die($content, get_bloginfo( 'name' ) . ' - ' . __('Website Under Maintenance', LJMM_PLUGIN_DOMAIN), array('response' => '503'));
        }
    }

   /**
    * notify if cache plugin detected
    *
    * @since 1.2
   */
    function notify() {
        $cache_plugin_enabled = $this->cache_plugin();
        if(!empty($cahce_plugin_enabled)) {
            $class = "error";
            $message = $this->cache_plugin();
            if( isset($_GET['settings-updated']) ) {
                echo '<div class="'.$class.'"><p>'.$message.'</p></div>';
            }
        }
    }

    /**
     * detect cache plugins
     *
     * @since 1.2
    */
    function cache_plugin() {
        $message = '';
        // add wp super cache support
        if ( in_array( 'wp-super-cache/wp-cache.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $message = ljmm_get_defaults('warning_wp_super_cache');
        }

        // add w3 total cache support
        if ( in_array( 'w3-total-cache/w3-total-cache.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            $message = ljmm_get_defaults('warning_w3_total_cache');
        }

        return $message;
    }
    
    /**
     * replace wp_die from wp-includes/functions.php function _default_wp_die_handler
     *
     * @since 1.4
    */

function lj_die( $message, $title = '', $args = array() ) {
	$defaults = array( 'response' => 500 );
	$r = wp_parse_args($args, $defaults);

	$have_gettext = function_exists('__');

	$message = "<p>$message</p>";

	if ( ! did_action( 'admin_head' ) ) :
		if ( !headers_sent() ) {
			status_header( $r['response'] );
			nocache_headers();
			header( 'Content-Type: text/html; charset=utf-8' );
		}

		if ( empty($title) )
			$title = $have_gettext ? __('WordPress &rsaquo; Error') : 'WordPress &rsaquo; Error';

		$text_direction = 'ltr';
		if ( isset($r['text_direction']) && 'rtl' == $r['text_direction'] )
			$text_direction = 'rtl';
		elseif ( function_exists( 'is_rtl' ) && is_rtl() )
			$text_direction = 'rtl';
?>
<!DOCTYPE html>
<!-- Ticket #11289, IE bug fix: always pad the error page with enough characters such that it is greater than 512 bytes, even after gzip compression abcdefghijklmnopqrstuvwxyz1234567890aabbccddeeffgghhiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz11223344556677889900abacbcbdcdcededfefegfgfhghgihihjijikjkjlklkmlmlnmnmononpopoqpqprqrqsrsrtstsubcbcdcdedefefgfabcadefbghicjkldmnoepqrfstugvwxhyz1i234j567k890laabmbccnddeoeffpgghqhiirjjksklltmmnunoovppqwqrrxsstytuuzvvw0wxx1yyz2z113223434455666777889890091abc2def3ghi4jkl5mno6pqr7stu8vwx9yz11aab2bcc3dd4ee5ff6gg7hh8ii9j0jk1kl2lmm3nnoo4p5pq6qrr7ss8tt9uuvv0wwx1x2yyzz13aba4cbcb5dcdc6dedfef8egf9gfh0ghg1ihi2hji3jik4jkj5lkl6kml7mln8mnm9ono
-->
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ( function_exists( 'language_attributes' ) && function_exists( 'is_rtl' ) ) language_attributes(); else echo "dir='$text_direction'"; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width">
	<title><?php echo $title ?></title>
	<style type="text/css">
		html {
      <?php $bgimage = esc_attr( get_option('ljmm-bgimage') );
      $bgcolor = esc_attr( get_option('ljmm-bgcolor') );       
      if ( '' == $bgcolor ) $bgcolor = '#f1f1f1' ;
      if ( $bgimage != '' ): ?>
      background: url(<?php echo $bgimage; ?>) no-repeat center center fixed; 
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      <?php else: ?>
      background: <?php echo $bgcolor; ?>;
      <?php endif; ?>
		}
		body {
			background: #fff;
			color: #444;
			font-family: "Open Sans", sans-serif;
			margin: 2em auto;
			padding: 1em 2em;
			max-width: 700px;
			-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.13);
			box-shadow: 0 1px 3px rgba(0,0,0,0.13);
      <?php if ( esc_attr( get_option('ljmm-center') ) ): ?>
			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: 0px !important;  
			margin-right: -50%;
			transform: translate(-50%, -50%);
  		<?php endif; ?>
      
		}
		h1 {
			border-bottom: 1px solid #dadada;
			clear: both;
			color: #666;
			font: 24px "Open Sans", sans-serif;
			margin: 30px 0 0 0;
			padding: 0;
			padding-bottom: 7px;
		}
		#error-page {
			margin-top: 50px;
		}
		#error-page p {
			font-size: 14px;
			line-height: 1.5;
			margin: 25px 0 20px;
		}
		#error-page code {
			font-family: Consolas, Monaco, monospace;
		}
		ul li {
			margin-bottom: 10px;
			font-size: 14px ;
		}
		a {
			color: #0073aa;
		}
		a:hover,
		a:active {
			color: #00a0d2;
		}
		a:focus {
			color: #124964;
		    -webkit-box-shadow:
		    	0 0 0 1px #5b9dd9,
				0 0 2px 1px rgba(30, 140, 190, .8);
		    box-shadow:
		    	0 0 0 1px #5b9dd9,
				0 0 2px 1px rgba(30, 140, 190, .8);
			outline: none;
		}
		.button {
			background: #f7f7f7;
			border: 1px solid #ccc;
			color: #555;
			display: inline-block;
			text-decoration: none;
			font-size: 13px;
			line-height: 26px;
			height: 28px;
			margin: 0;
			padding: 0 10px 1px;
			cursor: pointer;
			-webkit-border-radius: 3px;
			-webkit-appearance: none;
			border-radius: 3px;
			white-space: nowrap;
			-webkit-box-sizing: border-box;
			-moz-box-sizing:    border-box;
			box-sizing:         border-box;

			-webkit-box-shadow: 0 1px 0 #ccc;
			box-shadow: 0 1px 0 #ccc;
		 	vertical-align: top;
		}

		.button.button-large {
			height: 30px;
			line-height: 28px;
			padding: 0 12px 2px;
		}

		.button:hover,
		.button:focus {
			background: #fafafa;
			border-color: #999;
			color: #23282d;
		}

		.button:focus  {
			border-color: #5b9dd9;
			-webkit-box-shadow: 0 0 3px rgba( 0, 115, 170, .8 );
			box-shadow: 0 0 3px rgba( 0, 115, 170, .8 );
			outline: none;
		}

		.button:active {
			background: #eee;
			border-color: #999;
		 	-webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
		 	box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
		 	-webkit-transform: translateY(1px);
		 	-ms-transform: translateY(1px);
		 	transform: translateY(1px);
		}

		<?php
		if ( 'rtl' == $text_direction ) {
			echo 'body { font-family: Tahoma, Arial; }';
		}
		?>
	</style>
</head>
<body id="error-page">
<?php endif; // ! did_action( 'admin_head' ) ?>
	<?php echo $message; ?>
</body>
</html>
<?php
	die();
}

} //end ljMaintenanceMode class

/**
 * initialise plugin.
 *
 * @since 1.0
*/
$ljMaintenanceMode = new ljMaintenanceMode();
