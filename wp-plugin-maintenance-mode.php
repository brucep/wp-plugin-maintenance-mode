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

add_action('template_redirect', function () {
    if (!defined('BPWP_MAINTENANCE') || !BPWP_MAINTENANCE || current_user_can('activate_plugins')) {
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
