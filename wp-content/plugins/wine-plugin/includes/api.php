<?php
function wine_register_rest_fields() {
    $fields = [
        'pris', 'producent', 'argang', 'alkohol',
        'land', 'region', 'distrikt', 'druva', 'jordmon',
        'vinifikation', 'beskrivning', 'servera_till', 'servering',
        'storlek', 'artnr_systembolaget'
    ];

    foreach ($fields as $field) {
        register_rest_field('wine', "wff_$field", [
            'get_callback' => function ($post) use ($field) {
                return get_post_meta($post['id'], "wff_$field", true);
            },
            'schema' => null,
        ]);
    }

    register_rest_field('wine', 'featured_image_url', [
        'get_callback' => function ($post) {
            $image_id = get_post_thumbnail_id($post['id']);
            return $image_id ? wp_get_attachment_image_url($image_id, 'full') : null;
        },
        'schema' => null,
    ]);
}
add_action('rest_api_init', 'wine_register_rest_fields');
