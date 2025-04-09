<?php
function producer_register_post_type() {
    register_post_type('producer', array(
        'labels' => array(
            'name' => 'Producers',
            'singular_name' => 'Producer',
            'add_new' => 'Add New Producer',
            'edit_item' => 'Edit Producer',
            'new_item' => 'New Producer',
            'view_item' => 'View Producer',
            'search_items' => 'Search Producers',
        ),
        'public' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-groups'
    ));
}
add_action('init', 'producer_register_post_type');
