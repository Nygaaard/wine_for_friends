<?php
function wine_register_wine_post_type() {
    register_post_type('wine', array(
        'labels' => array(
            'name' => 'Wines',
            'singular_name' => 'Wine',
            'add_new' => 'Add New Wine',
            'edit_item' => 'Edit Wine',
            'new_item' => 'New Wine',
            'view_item' => 'View Wine',
            'search_items' => 'Search Wines'
        ),
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-admin-post'
    ));
}
add_action('init', 'wine_register_wine_post_type');
