<?php /**
 * @author Bill Minozzi
 * @copyright 2017
 */
function multidealer_show_products($atts)
{
    if (isset($atts['type'])) {
        $multi_dealer_type = trim($atts['type']);
    } else {
        $multi_dealer_type = '';
    }
    if (isset($atts['option'])) {
        $multi_dealer_option = trim($atts['option']);
    } else {
        $multi_dealer_option = 'DESC';
    }
    if (isset($atts['pagination'])) {
        $multi_dealer_pagination = trim($atts['pagination']);
    } else {
        $multi_dealer_pagination = 'yes';
    }
    if (isset($atts['search'])) {
        $multi_dealer_show_search = trim($atts['search']);
    } else {
        $multi_dealer_show_search = 'yes';
    }
    if(isset($atts['option']))
        {$MultiDealer_option = trim($atts['option']);}
    else
        {$MultiDealer_option =  '';}
 	$output = '<div id="multi_dealer_content">';
    if (!isset($_GET['submit'])) {
        $_GET['submit'] = '';
    }
    else
      $submit = sanitize_text_field($_GET['submit']);
    if (isset($_GET['post_type'])) {
        $post_type =sanitize_text_field( $_GET['post_type']);
    }
    if (isset($_GET['postNumber'])) {
        $postNumber = sanitize_text_field($_GET['postNumber']);
    }
    if(isset($atts['max']))
        {$postNumber = trim($atts['max']);}
    // orderby
    if(isset($atts['orderby']))
        $orderby = trim($atts['orderby']);
    else
        $orderby = '';
   if(!isset($postNumber)) 
     {$postNumber = get_option('MultiDealer_quantity', 6);}  
    if( empty($postNumber))
      {$postNumber = get_option('MultiDealer_quantity', 6);}
    if ($multi_dealer_show_search == 'yes')
        $output .= MultiDealer_search(1);
    if (get_query_var('paged')) {
        $paged = get_query_var('paged');
    } elseif (get_query_var('page')) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }
    global $wp_query;
    wp_reset_query();
    if (isset($_GET['multi_dealer_search_type'])) {
        require_once (MULTIDEALERPATH . 'includes/search/search_get_par.php');
        $args = array(
            'post_type' => 'products',
            'showposts' => $postNumber,
            'paged' => $paged,
            'meta_query' => array(
                array(
                    'key' => $yearName,
                    'value' => $year,
                    ),
                array(
                    $fuelKey => $fuelName,
                    $fuelVal => $fuel,
                    ),
                array(
                    $transKey => $transName,
                    $transVal => $trans,
                    ),
                array(
                    'key' => 'product-price',
                    'value' => array($priceMin, $priceMax),
                    'type' => 'numeric',
                    'compare' => 'BETWEEN'),
                array(
                    $conKey => $conName,
                    $conVal => $con,
                    ),
                array(
                    $typeKey => $typeName,
                    $typeVal => $typemulti,
                    ),
                ),
            );
    } else {
        // Shortcodes
        if ($multi_dealer_option == 'lasts') {
            $args = array(
                'post_type' => 'products',
                'showposts' => $postNumber,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC');
        } elseif ($multi_dealer_option == 'featureds') {
            $args = array(
                'post_type' => 'products',
                'showposts' => $postNumber,
                'paged' => $paged,
                'orderby' => 'date',
                'meta_key' => 'product-featured',
                'meta_compare' => '!=',
                'meta_value' => '',
                'order' => 'DESC');
        } elseif ($multi_dealer_type <> '') {
            $args = array(
                'post_type' => 'products',
                'showposts' => $postNumber,
                'paged' => $paged,
                'orderby' => 'date',
                'meta_query' => array(array('key' => 'product-type', 'value' => $multi_dealer_type), ),
                'order' => 'DESC');
        } else {
            $args = array(
                'post_type' => 'products',
                'showposts' => $postNumber,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'ASC');
        }
        // orderby
           if( !empty($orderby))
           {
               $args['orderby'] =  'meta_value';
               $args['meta_type'] = 'NUMERIC';
               if($orderby == 'price_high')
               {
                   $args['meta_key'] = 'product-price'; 
                   $args['order'] = 'DESC';
               } 
               if($orderby == 'price_low')
               {
                   $args['meta_key'] = 'product-price'; 
                   $args['order'] = 'ASC';
               }
               if($orderby == 'year_high')
               {
                   $args['meta_key'] = 'product-year'; 
                   $args['order'] = 'DESC';
               } 
               if($orderby == 'year_low')
               {
                   $args['meta_key'] = 'product-year'; 
                   $args['order'] = 'ASC';
               }
           }
           else
           {
                    $args['orderby'] = 'date';
                    $args[] = 'ASC';           
           }
    }
    $wp_query = new WP_Query($args);
    $qposts = $wp_query->post_count;
    $ctd = 0;
    $output .= '<div class="multiGallery">';
    while ($wp_query->have_posts()):
        $wp_query->the_post();
        $ctd++;
        $price = get_post_meta(get_the_ID(), 'product-price', true);
        if (!empty($price)) {
            $price = number_format_i18n($price, 0);
        }
        $image_id = get_post_thumbnail_id();
        if (empty($image_id)) {
            $image = MULTIDEALERIMAGES . 'image-no-available-800x400_br.jpg';
            $image = str_replace("-", "", $image);
        } else {
            $image_url = wp_get_attachment_image_src($image_id, 'medium', true);
            $image = str_replace("-" . $image_url[1] . "x" . $image_url[2], "", $image_url[0]);
        }
        $thumb = MultiDealer_theme_thumb($image, 400, 280, 'br'); // Crops from bottom right
        $year = get_post_meta(get_the_ID(), 'product-year', true);
        $output .= '<br /><div class="MultiDealer_container17">';
        $output .= '<div class="MultiDealer_gallery_17">';
        $output .= '<a class="nounderline" href="' . get_permalink() . '">';
        $output .= '<img class="MultiDealer_caption_img17" src="' . $thumb . '" />';
        $output .= '</a>';
        $output .= '</div>';
        $output .= '<div class="multiInfoRight17">';
        $output .= '<a class="nounderline" href="' . get_permalink() . '">';
        $output .= '<div class="multiTitle17">' . get_the_title() . '</div>';
        $output .= '</a>';
        $output .= '<div class="multiInforightText17">';
        
        $output .= '<div class="multiInforightbold">';
        $output .= ($price <> '' ? multidealer_currency() . $price : __('Call for Price',
            'multidealer'));
        $output .= ($price <> '' ? '  -  ' : '');
        $output .= ($year <> '' ? __('Year', 'multidealer') . ': ' . $year . '     ' : '');
        $output .= '</div>';       
        
        
        $content_post = get_post(get_the_ID());
        $desc = strip_tags($content_post->post_content);
        $desc = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $desc);
        $output .= '<br>';
        $output .= substr($desc,0,200);
        if(substr($desc,200) <> '')
          $output .= '...';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</a>';
        $output .= '</div>';
        endwhile;
     $output .= '</div>';
    if ($multi_dealer_pagination == 'yes') {
        $output .= '<div class="multi_dealer_navigation">';
        $output .= '';
        ob_start();
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => __('Back', 'textdomain'),
            'next_text' => __('Onward', 'textdomain'),
            ));
        $output .= ob_get_contents();
        ob_end_clean();
        $output .= '</div>';
    }
    $output .= '</div>';
    wp_reset_postdata();
    wp_reset_query();
    if ($qposts < 1) {
        $output .= '<h4>' . __('Not Found !') . '</h4>';
    }
    return $output;
}
add_shortcode('multi_dealer', 'multidealer_show_products'); ?>