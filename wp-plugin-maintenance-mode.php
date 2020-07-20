<?php
/**
 * Plugin Name: BP Maintenance Mode
 * Description: Define <code>BPWP_MAINTENANCE</code> in wp-config.php to enable.
 * Author: Bruce Phillips
 */

if (!defined('ABSPATH')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

$maintenanceMode = defined('BPWP_MAINTENANCE') && BPWP_MAINTENANCE;

add_action('template_redirect', function () use ($maintenanceMode) {
    if (!$maintenanceMode || current_user_can('activate_plugins')) {
        return;
    }

    if (is_string(BPWP_MAINTENANCE)) {
        wp_die(esc_html(BPWP_MAINTENANCE));
    } else {
        wp_die(sprintf(
            '%s will return after temporary maintenance…',
            esc_html(get_option('blogname'))
        ));
    }
}, -9);

add_action('admin_bar_menu', function ($bar) use ($maintenanceMode) {
    if (!$maintenanceMode) {
        return;
    }

    $bar->add_node([
        'id' => 'bpwp-maintenance-mode',
        'title' => 'Maintenance Mode',
        'href' => admin_url('plugins.php'),
    ]);
}, 95);
