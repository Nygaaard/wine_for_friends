<?php
function wine_add_metabox() {
    add_meta_box('wine_metabox', 'Vin Info', 'wine_metabox_callback', 'wine', 'normal', 'high');
}
add_action('add_meta_boxes', 'wine_add_metabox');

function wine_metabox_callback($post) {
    echo '<style>
        .wine-metabox-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .wine-metabox-wrapper input[type="text"],
        .wine-metabox-wrapper input[type="number"],
        .wine-metabox-wrapper textarea,
        .wine-metabox-wrapper select {
            width: 100%;
            padding: 10px;
            margin-top: 4px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
        }
        .wine-metabox-wrapper label {
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }
    </style>';

    echo '<div class="wine-metabox-wrapper">';

    $fields = [
        'pris' => 'Pris',
        'producent' => 'Producent',
        'argang' => 'Årgång',
        'alkohol' => 'Alkohol',
        'land' => 'Land',
        'region' => 'Region',
        'distrikt' => 'Distrikt',
        'druva' => 'Druva',
        'jordmon' => 'Jordmån',
        'vinifikation' => 'Vinifikation',
        'beskrivning' => 'Beskrivning',
        'servera_till' => 'Servera till',
        'servering' => 'Servering',
        'storlek' => 'Storlek',
        'artnr_systembolaget' => 'Art.nr Systembolaget',
        'kategori' => 'Kategori',
        'systembolaget_url' => 'Systembolaget-länk',
        'bestallning' => 'Beställning',
        'dosage' => 'Dosage',
        'varugrupp' => 'Varugrupp'
    ];

    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, "wff_$key", true);
        echo "<p><label for='wff_$key'>$label:</label>";
        
        if ($key === 'kategori') {
            echo "<select id='wff_$key' name='wff_$key'>
                    <option value='Beställningssortiment'" . selected($value, 'Beställningssortiment', false) . ">Beställningssortiment</option>
                    <option value='Privatimport'" . selected($value, 'Privatimport', false) . ">Privatimport</option>
                  </select>";
        } elseif ($key === 'varugrupp') {
            echo "<select id='wff_$key' name='wff_$key'>
                    <option value='Rött vin'" . selected($value, 'Rött vin', false) . ">Rött vin</option>
                    <option value='Vitt vin'" . selected($value, 'Vitt vin', false) . ">Vitt vin</option>
                    <option value='Mousserande vin'" . selected($value, 'Mousserande vin', false) . ">Mousserande vin</option>
                    <option value='Rosévin'" . selected($value, 'Rosévin', false) . ">Rosévin</option>
                  </select>";
        } elseif (in_array($key, ['vinifikation', 'beskrivning', 'servering'])) {
            echo "<textarea id='wff_$key' name='wff_$key' rows='4'>" . esc_textarea($value) . "</textarea>";
        } else {
            echo "<input type='text' id='wff_$key' name='wff_$key' value='" . esc_attr($value) . "' />";
        }
        echo "</p>";
    }

    echo '</div>';
}

function wine_save_metabox_data($post_id) {
    $fields = [
        'pris', 'producent', 'argang', 'alkohol',
        'land', 'region', 'distrikt', 'druva', 'jordmon',
        'vinifikation', 'beskrivning', 'servera_till', 'servering',
        'storlek', 'artnr_systembolaget', 'kategori',
        'systembolaget_url', 'bestallning',
        'dosage', 'varugrupp'
    ];

    foreach ($fields as $field) {
        if (isset($_POST["wff_$field"])) {
            update_post_meta($post_id, "wff_$field", sanitize_text_field($_POST["wff_$field"]));
        }
    }
}
add_action('save_post', 'wine_save_metabox_data');
