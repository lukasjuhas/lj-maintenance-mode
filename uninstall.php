<?php
// make sure uninstallation is triggered
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

/**
 * uninstall - clean up database removing plugin options
 *
 * @since 1.0
*/
function ljmm_delete_plugin() {
		delete_option( 'ljmm-content-default' );
		delete_option( 'ljmm-content' );
    delete_option( 'ljmm-enabled' );
		delete_option( 'ljmm-site-title' );
    delete_option( 'ljmm-roles' );
}

ljmm_delete_plugin();

?>
