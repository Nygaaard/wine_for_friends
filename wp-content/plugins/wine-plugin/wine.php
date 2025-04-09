<?php
/**
 * Plugin Name: Wine
 * Description: A plugin to manage wines in WordPress as a headless CMS.
 * Version: 1.0
 * Author: Andreas Nygård
 */

if (!defined('ABSPATH')) {
    exit;
}

// Include wines
require_once plugin_dir_path(__FILE__) . 'includes/cpt-wine.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/api.php';

// CORS for REST API
function wine_add_cors_headers() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}
add_action('rest_api_init', function () {
    add_filter('rest_pre_serve_request', function ($value) {
        wine_add_cors_headers();
        return $value;
    });
});
