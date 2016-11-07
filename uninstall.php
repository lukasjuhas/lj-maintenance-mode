<?php
// make sure uninstallation is triggered
if (! defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

/**
 * remove capabilities
 *
 * @since 2.1
 */
function ljmm_remove_capabilities()
{
    global $wpdb;
    $wp_roles = get_option($wpdb->prefix . 'user_roles');

    if ($wp_roles && is_array($wp_roles)) {
        foreach ($wp_roles as $role => $role_details) {
            $get_role = get_role($role);
            $get_role->remove_cap('ljmm_view_site');
        }
    }
}

/**
 * uninstall - clean up database removing plugin options
 *
 * @since 1.0
*/
function ljmm_delete_plugin()
{
    delete_option('ljmm-content-default');
    delete_option('ljmm-content');
    delete_option('ljmm-enabled');
    delete_option('ljmm-site-title');
    delete_option('ljmm-roles');
    delete_option('ljmm-mode');

    // remove capabilities
    ljmm_remove_capabilities();
}

ljmm_delete_plugin();
