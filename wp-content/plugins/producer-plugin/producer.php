<?php
/**
 * Plugin Name: Producer
 * Description: A plugin to manage wine producers in WordPress as a headless CMS.
 * Version: 1.0
 * Author: Andreas Nygård
 */

if (!defined('ABSPATH')) {
    exit;
}

// Includes
require_once plugin_dir_path(__FILE__) . 'includes/cpt-producer.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes-producer.php';
require_once plugin_dir_path(__FILE__) . 'includes/api-producer.php';

// CORS headers
function producer_add_cors_headers() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}
add_action('rest_api_init', function () {
    add_filter('rest_pre_serve_request', function ($value) {
        producer_add_cors_headers();
        return $value;
    });
});
