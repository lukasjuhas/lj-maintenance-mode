<?php
/**
 * Plugin Name: Maintenance Mode
 * Plugin URI: https://github.com/lukasjuhas/lj-maintenance-mode
 * Description: Simple Maintenance mode using wordpress die function.
 * Version: 1.1.1
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

define( 'LJMM_VERSION', '1.1.1' );
define( 'LJMM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LJMM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

class ljMaintenanceMode {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'ui' ) );
		add_action( 'admin_head', array( $this, 'style' ) );
		add_action( 'admin_init', array( $this, 'settings' ) );

		$is_enabled = get_option('ljmm-enabled');


		if($is_enabled) :
			add_action('get_header', array($this, 'maintenance'));
		endif;

		add_action( 'admin_bar_menu', array( $this, 'indicator' ), 100 );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links') );

	}

	function ui() {
		add_submenu_page( 'options-general.php', 'Maintenance Mode', 'Maintenance Mode', 'delete_plugins', 'wp-maintenance-mode', array($this, 'settingsPage') );
	}

	function style() {
		echo '<style type="text/css">#wp-admin-bar-ljmm-indicator.Enabled { background: rgba(159, 0, 0, 1) }</style>';
	}

	function settings() {
		register_setting('ljmm', 'ljmm-enabled');
		register_setting('ljmm', 'ljmm-content');

		$default = get_option( 'ljmm-content-default');
		if(empty($default)) :
			$content = '<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>';
			/**
			 * f you are trying to ensure that a given option is created,
			 * use update_option() instead, which bypasses the option name check
			 * and updates the option with the desired value whether or not it exists.
			 */
			update_option( 'ljmm-content-default', $content);
		endif;
	}

	function settingsPage() { ?>
		<div class="wrap">
			<h2>Maintenance Mode</h2>

			<form method="post" action="options.php">
			    <?php settings_fields( 'ljmm' ); ?>
			    <?php do_settings_sections( 'ljmm' ); ?>

			    <table class="form-table">
			        <tr valign="top">
				        <th scope="row">Enabled</th>
				        <td><input type="checkbox" name="ljmm-enabled" value="1" <?php checked( esc_attr( get_option('ljmm-enabled') ), 1 ); ?>></td>
			        </tr>

			        <tr valign="top">
			        	<th scope="row" colspan="2">Content</th>
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
	<?php
	}

	function indicator($wp_admin_bar) {
		$is_enabled = get_option('ljmm-enabled');
		$status = 'Disabled';
		if($is_enabled)
			$status = 'Enabled';

		$indicator = array(
			'id' => 'ljmm-indicator',
			'title' => 'Maintenance Mode: '.$status,
			'parent' => false,
			'href' => get_admin_url(null, 'options-general.php?page=wp-maintenance-mode'),
			'meta' => array(
				'title' => 'Maintenance Mode',
				'class' => $status,
			)
		);
		$wp_admin_bar->add_node($indicator);
	}

	function action_links( $links ) {
	   $links[] = '<a href="'. get_admin_url(null, 'options-general.php?page=wp-maintenance-mode') .'">Settings</a>';
	   return $links;
	}

	function maintenance() {

		if ( !(current_user_can( 'administrator' ) ||  current_user_can( 'super admin' )) || ( isset($_GET['ljmm']) && $_GET['ljmm'] !== 'preview')) {
			$content = get_option('ljmm-content');
			if(empty($content)) {
				$content = get_option( 'ljmm-content-default');
			}
			$content = apply_filters('the_content', $content);

			wp_die($content, 'Maintenance Mode');
		}

	}

}

$ljMaintenanceMode = new ljMaintenanceMode();
