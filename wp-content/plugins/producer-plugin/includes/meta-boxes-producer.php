<?php
function producer_add_metabox() {
    add_meta_box('producer_metabox', 'Producer Info', 'producer_metabox_callback', 'producer', 'normal', 'high');
}
add_action('add_meta_boxes', 'producer_add_metabox');

function producer_metabox_callback($post) {
    echo '<style>
        .producer-metabox-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .producer-metabox-wrapper input[type="text"],
        .producer-metabox-wrapper textarea {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
        }
        .producer-metabox-wrapper label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }
    </style>';

    echo '<div class="producer-metabox-wrapper">';

    // Fields for Name, Description, and Country
    $fields = [
        'name' => 'Name',
        'description' => 'Description',
        'country' => 'Country'
    ];

    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, "producer_$key", true);
        echo "<p><label for='producer_$key'><strong>$label</strong></label><br>";

        if ($key === 'description') {
            echo "<textarea id='producer_$key' name='producer_$key' rows='4' style='width:100%;'>" . esc_textarea($value) . "</textarea>";
        } else {
            echo "<input type='text' id='producer_$key' name='producer_$key' value='" . esc_attr($value) . "' style='width:100%;'/>";
        }

        echo "</p>";
    }

    echo '</div>';
}

function producer_save_metabox_data($post_id) {
    // Fields to save
    $fields = [
        'name', 'description', 'country'
    ];

    foreach ($fields as $field) {
        if (isset($_POST["producer_$field"])) {
            update_post_meta($post_id, "producer_$field", sanitize_text_field($_POST["producer_$field"]));
        }
    }
}
add_action('save_post', 'producer_save_metabox_data');
