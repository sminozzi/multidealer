<?php $afields = array(
    array(
        'name' => 'Price',
        'desc' => __('No special characters here ("$" "," "."), the plugin will auto format the number.',
            'multidealer'),
        'id' => 'product-price',
        'type' => 'text',
        'default' => ''),
    array(
        'name' => 'Year',
        'desc' => __('The year of the product. Only numbers, no point, no comma.',
            'multidealer'),
        'id' => 'product-year',
        'type' => 'text',
        'default' => ''),
    array(
        'name' => 'Featured',
        'desc' => __('Mark to show up at Featured Widget.', 'multidealer'),
        'id' => 'product-featured',
        'type' => 'checkbox'));
$afieldsId = multi_dealer_get_fields('all');
$totfields = count($afieldsId);
$ametadataoptions = array();

for ($i = 0; $i < $totfields; $i++) {
    $post_id = $afieldsId[$i];
    $ametadata = multi_dealer_get_meta($post_id);
    $field_value = array(
        'field_label', // 0
        'field_typefield', // 1
        'field_drop_options', // 2
        'field_searchbar', // 3
        'field_searchwidget', //4
        'field_rangemin', // 5
        'field_rangemax', //6
        'field_rangestep', // 7
        'field_slidemin', // 8
        'field_slidemax', // 9
        'field_slidestep', // 10
        'field_order', // 11
        'field_name'); // 12
    if (!empty($ametadata[0]))
        $label = $ametadata[0];
    else
        $label = $ametadata[12];
    if ($ametadata[1] == 'checkbox') {
        $afields[] = array(
            'name' => $label,
            'desc' => ' ',
            'id' => 'product-' . $ametadata[12],
            'type' => $ametadata[1],
            );
    } elseif ($ametadata[1] == 'text') {
        $afields[] = array(
            'name' => $label,
            'desc' => ' ',
            'id' => 'product-' . $ametadata[12],
            'type' => $ametadata[1],
            'default' => '');
    } elseif ($ametadata[1] == 'dropdown') {
        $arr = explode("\n", $ametadata[2]);
        $options = array();
        for ($z = 0; $z < count($arr); $z++) {
            // $options[$arr[$z]] = $arr[$z];
            $options[$z] = $arr[$z];
        }
        $afields[] = array(
            'name' => $label,
            'desc' => ' ',
            'id' => 'product-' . $ametadata[12],
            'type' => 'select',
            'options' => $options,
            'default' => '');
    } elseif ($ametadata[1] == 'rangeselect') {
        $init = $ametadata[5];
        $max = $ametadata[6];
        $step = $ametadata[7];
        $options = array();
        if (!empty($init) and !empty($max) and !empty($step)) {
            for ($z = $init; $z <= $max; $z += $step) {
                $options[$z] = $z;
            }
        }
        $afields[] = array(
            'name' => $label,
            'desc' => ' ',
            'id' => 'product-' . $ametadata[12],
            'type' => 'select',
            'options' => $options,
            'default' => '');
    } elseif ($ametadata[1] == 'rangeslider') {
        $init = $ametadata[8];
        $max = $ametadata[9];
        $step = $ametadata[10];
        $options = array();
        for ($z = $init; $z <= $max; $z += $step) {
            $options[$z] = $z;
        }
        $afields[] = array(
            'name' => $label,
            'desc' => ' ',
            'id' => 'product-' . $ametadata[12],
            'type' => 'select',
            'options' => $options,
            'default' => '');
    } elseif ($ametadata[1] == 'rangeselect') {
        $init = $ametadata[5];
        $max = $ametadata[6];
        $step = $ametadata[7];
        $options = array();
        for ($z = $init; $z <= $max; $z += $step) {
            $options[$z] = $z;
        }
    } elseif ($ametadata[1] == 'googlemap') {
        $afields[] = array(
            'name' => $label,
            'desc' => ' ',
            'id' => 'product-' . $ametadata[12],
            'type' => 'googlemap',
            'default' => '');
    }
}
$meta_box['products'] = array(
    'id' => 'listing-details',
    'title' => __('Details', 'multidealer'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => $afields);
add_action('admin_menu', 'multidealer_listing_add_box');
update_option('meta_boxes', $meta_box);
function multidealer_listing_add_box()
{
    global $meta_box;
    foreach ($meta_box as $post_type => $value) {
        add_meta_box($value['id'], $value['title'], 'multidealer_listing_format_box', $post_type,
            $value['context'], $value['priority']);
    }
}
function multidealer_listing_format_box()
{
    global $meta_box, $amultidealer_features, $post;
    wp_enqueue_style('meta', MULTIDEALERURL . 'includes/post-type/meta.css');
    echo '<input type="hidden" name="listing_meta_box_nonce" value="',
        wp_create_nonce(basename(__file__)), '" />';
    foreach ($meta_box[$post->post_type]['fields'] as $field) {
        $meta = get_post_meta($post->ID, $field['id'], true);
        $title = $field['name'];
        switch ($field['type']) {
            case 'text':
                echo '<div class="boxes-small">';
                echo '<div class="box-label"><label for="' . $field['id'] . '">' . $title =
                    str_replace("_", " ", $title) . '</label></div>';
                echo '<div class="box-content"><p>';
                echo '<input type="text" name="' . $field['id'] . '" class="' . $field['name'] .
                    '" id="' . $field['id'] . '" value="' . ($meta ? $meta : $field['default']) .
                    '" size="30" style="width:97%" />' . '<br />' . $field['desc'];
                echo '</div></div>';
                break;
            case 'select':
                echo '<div class="boxes">' . '<div class="box-label"><label for="' . $field['id'] .
                    '">' . $title = str_replace("_", " ", $title) . '</label></div>' .
                    '<div class="box-content"><p>';
                echo '<select name="' . $field['id'] . '" id="' . $field['id'] . '" class="' . $field['name'] .
                    '">';
                foreach ($field['options'] as $option100) {
                    echo '<option ' . ($meta == $option100 ? ' selected="selected"' : '') . '>' . $option100 .
                        '</option>';
                }
                echo '</select>';
                echo '<br />';
                echo $field['desc'];
                echo '</div></div>';
                break;
            case 'checkbox':
                echo '<div class="boxes-small">' . '<div class="box-label"><label for="' . $field['id'] .
                    '">' . $title = str_replace("_", " ", $title) . '</label></div>' .
                    '<div class="box-content"><p>';
                echo '<div class = "checkboxSlide">';
                echo '<input type="checkbox" class="' . $field['name'] .
                    '" value="enabled" name="' . $field['id'] . '" id="CheckboxSlide"' . ($meta ?
                    ' checked="checked"' : '') . '<br />' . $field['desc'];
                echo '</div>';
                echo '</div></div>';
                break;
            case 'googlemap':
                $meta = get_post_meta($post->ID, 'product-googlemap', true);
                $value = $meta ? $meta : $field['default'];
                $googlemap = explode(PHP_EOL, $value);
                if (isset($googlemap[0]))
                    $googlemap_latitude = $googlemap[0];
                else
                    $googlemap_latitude = '';
                if (isset($googlemap[1]))
                    $googlemap_longitude = $googlemap[1];
                else
                    $googlemap_longitude = '';
                if (isset($googlemap[2]))
                    $googlemap_zoom = $googlemap[2];
                else
                    $googlemap_zoom = '';
                echo '<div class="boxes-googlemaps">';
                echo '<div class="box-label"><label for="' . $field['id'] . '">' . $title =
                    str_replace("_", " ", $title) . '</label></div>';
                echo '<div class="box-content"><p>';
                echo 'Latitude';
                echo '<br />';
                echo '<input type="text" name="product-latitude" class="googlemap" id="product-latitude" value="' .
                    $googlemap_latitude . '" size="30" style="width:97%" />' . '<br />';
                echo '</div>';
                echo '<div class="box-content"><p>';
                echo 'Longitude';
                echo '<br />';
                echo '<input type="text" name="product-longitude" class="googlemap" id="product-longitude" value="' .
                    $googlemap_longitude . '" size="30" style="width:97%" />' . '<br />';
                echo '</div>';
                echo '<div class="box-content"><p>';
                echo 'Zoom';
                echo '<br />';
                echo '<input type="text" name="product-zoom" class="googlemap" id="product-zoom" value="' .
                    $googlemap_zoom . '" size="30" style="width:97%" />' . '<br />';
                echo '</div>';
                break;
        } // end Switch
        //   echo '</div></div>';
    }
} // end function listing_format_box
add_action('save_post', 'MultiDealer_listing_save_data');
function MultiDealer_listing_save_data($post_id)
{
    global $current_post_id, $meta_box, $post, $amultidealer_features;
    $current_post_id = $post_id;
    if (!is_object($post))
        return;
    if (!isset($meta_box[$post->post_type]['fields'])) {
        return;
    }
    //Verify nonce
    if (isset($_POST['listing_meta_box_nonce'])) {
        if (!wp_verify_nonce($_POST['listing_meta_box_nonce'], basename(__file__))) {
            return $post_id;
        }
    }
    //Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    //Check permissions
    if (isset($_POST['post_type'])) {
        if ('page' == sanitize_text_field($_POST['post_type'])) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
    } else
        return;
    foreach ($meta_box[$post->post_type]['fields'] as $field) {
        if ($field['id'] == 'product-googlemap') {
            $latitude = sanitize_text_field($_POST['product-latitude']);
            $longitude = sanitize_text_field($_POST['product-longitude']);
            $zoom = sanitize_text_field($_POST['product-zoom']);
            $address = sanitize_text_field($_POST['product-address']);
            $new = $latitude . PHP_EOL . $longitude . PHP_EOL . $zoom . PHP_EOL . $address;
            update_post_meta($post_id, 'product-googlemap', $new);
        } // end googlemap
        else {
            if (isset($_POST[$field['id']])) {
                $new = sanitize_text_field($_POST[$field['id']]);
            } else {
                $new = '';
            }
            $old = get_post_meta($post_id, $field['id'], true);
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], trim($new));
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    } // end loop
} // end Function Save Data
