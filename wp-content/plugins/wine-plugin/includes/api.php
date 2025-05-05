<?php
function wine_register_rest_fields() {
    $fields = [
        'pris', 'producent', 'argang', 'alkohol',
        'land', 'region', 'distrikt', 'druva', 'jordmon',
        'vinifikation', 'beskrivning', 'servera_till', 'servering',
        'storlek', 'artnr_systembolaget', 'kategori',
        'systembolaget_url', 'bestallning',
        'dosage', 'varugrupp'
    ];

    foreach ($fields as $field) {
        register_rest_field('wine', "wff_$field", [
            'get_callback' => function ($post) use ($field) {
                $value = get_post_meta($post['id'], "wff_$field", true);
                if ($field === 'producent') {
                    $producer = get_post($value);
                    return $producer ? [
                        'id' => $producer->ID,
                        'title' => $producer->post_title
                    ] : null;
                }
                return $value;
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
