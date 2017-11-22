<?php
// Make sure uninstallation is triggered
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

/**
 * Remove capabilities
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
            $get_role->remove_cap('ljmm_control');
        }
    }
}

/**
 * Uninstall - clean up database removing plugin options
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
    delete_option('ljmm_add_widget_areas');
    delete_option('ljmm_analytify');
    delete_option('ljmm_code_snippet');

    // remove capabilities
    ljmm_remove_capabilities();
}

ljmm_delete_plugin();
