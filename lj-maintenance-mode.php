<?php
/**
* Plugin Name: Maintenance Mode
* Plugin URI: https://github.com/lukasjuhas/lj-maintenance-mode
* Description: Very simple Maintenance Mode & Coming soon page. Using default Wordpress markup, No adds, no paid upgrades.
* Version: 1.2.1
* Author: Lukas Juhas
* Author URI: http://lukasjuhas.com
* Text Domain: lj-maintenance-mode
* License: GPL2
*/

/*  Copyright 2014  Lukas Juhas  (email : hello@lukasjuhas.com)

	 This program is free software; you can redistribute it and/or modify
	 it under the terms of the GNU General Public License, version 2, as
	 published by the Free Software Foundation.

	 This program is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 GNU General Public License for more details.

	 You should have received a copy of the GNU General Public License
	 along with this program; if not, write to the Free Software
	 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'LJMM_VERSION', '1.2.1' );
define( 'LJMM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LJMM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LJMM_PLUGIN_BASENAME', plugin_basename( __FILE__ ));
define( 'LJMM_PLUGIN_NAME', substr(LJMM_PLUGIN_BASENAME, 0, strrpos( LJMM_PLUGIN_BASENAME, '/')) );
define( 'LJMM_CONTACT_EMAIL', 'hello@lukasjuhas.com' );

# hooks
add_action( 'activate_' . LJMM_PLUGIN_BASENAME, 'ljmm_install' );

# on installation
function ljmm_install() {
 # remove old settings. This has been deprecated in 1.2
 delete_option( 'ljmm-content-default' );

 # If content is not set, set the default content.
 $content = get_option( 'ljmm-content');
 if(empty($content)) :
	 $content = '<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>';
	 /**
	 * if you are trying to ensure that a given option is created,
	 * use update_option() instead, which bypasses the option name check
	 * and updates the option with the desired value whether or not it exists.
	 */
	 update_option( 'ljmm-content', $content);
 endif;
}

class ljMaintenanceMode {

 function __construct() {
	 add_action( 'admin_menu', array( $this, 'ui' ) );
	 add_action( 'admin_head', array( $this, 'style' ) );
	 add_action( 'admin_init', array( $this, 'settings' ) );

	 # remove old settings. This has been deprecated in 1.2
	 delete_option( 'ljmm-content-default' );

	 $is_enabled = get_option('ljmm-enabled');

	 if($is_enabled || isset($_GET['ljmm']) && $_GET['ljmm'] == 'preview') :
		 add_action('get_header', array($this, 'maintenance'));
     //add_filter( 'wp_die_handler', array($this, 'wp_die_handler'), 1, 3 );
	 endif;

	 add_action( 'admin_bar_menu', array( $this, 'indicator' ), 100 );
	 add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links') );
 }

 function ui() {
	 add_submenu_page( 'options-general.php', __('Maintenance Mode', LJMM_PLUGIN_NAME), __('Maintenance Mode', LJMM_PLUGIN_NAME), 'delete_plugins', 'wp-maintenance-mode', array($this, 'settingsPage') );
 }

 function style() {
	 echo '<style type="text/css">#wp-admin-bar-ljmm-indicator.Enabled { background: rgba(159, 0, 0, 1) }</style>';
 }

 function settings() {
	 register_setting('ljmm', 'ljmm-enabled');
	 register_setting('ljmm', 'ljmm-content');

	 $content = get_option( 'ljmm-content');
	 if(empty($content)) :
		 $content = '<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>';
		 /**
			* f you are trying to ensure that a given option is created,
			* use update_option() instead, which bypasses the option name check
			* and updates the option with the desired value whether or not it exists.
			*/
		 update_option( 'ljmm-content', stripslashes($content));
	 endif;
 }

 function wp_die_handler( $message, $title = '', $args = array() ) {
   	$defaults = array( 'response' => 500 );
  	$r = wp_parse_args($args, $defaults);
  	$have_gettext = function_exists('__');
  	if ( function_exists( 'is_wp_error' ) && is_wp_error( $message ) ) {
  		if ( empty( $title ) ) {
  			$error_data = $message->get_error_data();
  			if ( is_array( $error_data ) && isset( $error_data['title'] ) )
  				$title = $error_data['title'];
  		}
  		$errors = $message->get_error_messages();
  		switch ( count( $errors ) ) {
  		case 0 :
  			$message = '';
  			break;
  		case 1 :
  			$message = "<p>{$errors[0]}</p>";
  			break;
  		default :
  			$message = "<ul>\n\t\t<li>" . join( "</li>\n\t\t<li>", $errors ) . "</li>\n\t</ul>";
  			break;
  		}
  	} elseif ( is_string( $message ) ) {
  		$message = "<p>$message</p>";
  	}
  	if ( isset( $r['back_link'] ) && $r['back_link'] ) {
  		$back_text = $have_gettext? __('&laquo; Back') : '&laquo; Back';
  		$message .= "\n<p><a href='javascript:history.back()'>$back_text</a></p>";
  	}
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
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ( function_exists( 'language_attributes' ) && function_exists( 'is_rtl' ) ) language_attributes(); else echo "dir='$text_direction'"; ?>>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width">
  <?php wp_no_robots(); ?>
	<title><?php echo $title ?></title>
	<style type="text/css">
		html {
			background: #f1f1f1;
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
			color: #21759B;
			text-decoration: none;
		}
		a:hover {
			color: #D54E21;
		}
		.button {
			background: #f7f7f7;
			border: 1px solid #cccccc;
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
			-webkit-box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0,0,0,.08);
			box-shadow: inset 0 1px 0 #fff, 0 1px 0 rgba(0,0,0,.08);
		 	vertical-align: top;
		}
		.button.button-large {
			height: 29px;
			line-height: 28px;
			padding: 0 12px;
		}
		.button:hover,
		.button:focus {
			background: #fafafa;
			border-color: #999;
			color: #222;
		}
		.button:focus  {
			-webkit-box-shadow: 1px 1px 1px rgba(0,0,0,.2);
			box-shadow: 1px 1px 1px rgba(0,0,0,.2);
		}
		.button:active {
			background: #eee;
			border-color: #999;
			color: #333;
			-webkit-box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
		 	box-shadow: inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );
		}z
		<?php if ( 'rtl' == $text_direction ) : ?>
		body { font-family: Tahoma, Arial; }
		<?php endif; ?>
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

 function settingsPage() { ?>
	 <div class="wrap">
			 <h2><?php _e('Maintenance Mode', LJMM_PLUGIN_NAME ); ?></h2>
			 <form method="post" action="options.php">
					 <?php settings_fields( 'ljmm' ); ?>
					 <?php do_settings_sections( 'ljmm' ); ?>

           <?php $this->notify(); ?>

					 <table class="form-table">
							 <tr valign="top">
									 <th scope="row"><?php _e('Enabled', LJMM_PLUGIN_NAME ); ?></th>
									 <td><input type="checkbox" name="ljmm-enabled" value="1" <?php checked( esc_attr( get_option('ljmm-enabled') ), 1 ); ?>></td>
							 </tr>

							 <tr valign="top">
									 <th scope="row" colspan="2"><?php _e('Content', LJMM_PLUGIN_NAME ); ?></th>
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
							 <tr>
								 <td>
									 <a href="<?php echo esc_url( add_query_arg( 'ljmm', 'preview', bloginfo('url') ) ); ?>" target="_blank" class="button"><?php _e('Preview', LJMM_PLUGIN_NAME); ?></a>
									 <a class="button support" href="mailto:<?php echo LJMM_CONTACT_EMAIL; ?>?subject=[lj-maintenance-mode] Hi, I need support"><?php _e('Support', LJMM_PLUGIN_NAME); ?></a>
								 </td>
							 </tr>
					 </table>
					 <?php submit_button(); ?>
			 </form>
	 </div>
 <?php
 }

 function indicator($wp_admin_bar) {
	 $is_enabled = get_option('ljmm-enabled');
	 $status = _x('Disabled', LJMM_PLUGIN_NAME);
	 if($is_enabled)
		 $status = _x('Enabled', LJMM_PLUGIN_NAME);

	 $indicator = array(
		 'id' => 'ljmm-indicator',
		 'title' => _x('Maintenance Mode', LJMM_PLUGIN_NAME).': '.$status,
		 'parent' => false,
		 'href' => get_admin_url(null, 'options-general.php?page=wp-maintenance-mode'),
		 'meta' => array(
			 'title' => _x('Maintenance Mode', LJMM_PLUGIN_NAME),
			 'class' => $status,
		 )
	 );
	 $wp_admin_bar->add_node($indicator);
 }

 function action_links( $links ) {
		$links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=wp-maintenance-mode') .'">'._x('Settings', LJMM_PLUGIN_NAME).'</a>';
		return $links;
 }

 function maintenance() {

	 if ( !(current_user_can( 'administrator' ) ||  current_user_can( 'super admin' )) || ( isset($_GET['ljmm']) && $_GET['ljmm'] == 'preview')) {
		 $content = get_option('ljmm-content');
		 if(empty($content)) {
			 // fallback
			 $content = '<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>';
		 }
		 $content = apply_filters('the_content', $content);

		 wp_die($content, get_bloginfo( 'name' ) . ' - ' . __('Website Under Maintenance', LJMM_PLUGIN_NAME));
	 }

 }

 /**
  * notify if cache plugin detected
  */
 function notify() {
      $cache_plugin_enabled = $this->cache_plugin();
      if(!empty($cahce_plugin_enabled)) {
          $class = "error";
          $message = $this->cache_plugin(); ?>
          <?php if( isset($_GET['settings-updated']) ) {
            echo '<div class="'.$class.'"><p>'.$message.'</p></div>';
          } ?>
    <?php }
 }

 /**
  * detext cache plugins
  */
 function cache_plugin() {
   $message = '';
	 	// add wp super cache support
		if ( in_array( 'wp-super-cache/wp-cache.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$message = "Important: Don't forget to flush your cache using WP Super Cache when enabling or disabling Maintenance Mode.";
		}

		// add w3 total cache support
		if ( in_array( 'w3-total-cache/w3-total-cache.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$message = "Important: Don't forget to flush your cache using W3 Total Cache when enabling or disabling Maintenance Mode.";
		}

    return $message;
 }

}

$ljMaintenanceMode = new ljMaintenanceMode();
