<?php
function producer_register_rest_fields() {
    // Define the fields for the producer post type
    $fields = ['name', 'description', 'country'];

    foreach ($fields as $field) {
        register_rest_field('producer', "producer_$field", [
            'get_callback' => function ($post) use ($field) {
                return get_post_meta($post['id'], "producer_$field", true);
            },
            'schema' => null,
        ]);
    }

    // Register the featured image for the producer post type
    register_rest_field('producer', 'featured_image_url', [
        'get_callback' => function ($post) {
            $image_id = get_post_thumbnail_id($post['id']);
            return $image_id ? wp_get_attachment_image_url($image_id, 'full') : null;
        },
        'schema' => null,
    ]);
}
add_action('rest_api_init', 'producer_register_rest_fields');
