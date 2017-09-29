<?php /**
 * @author Bill Minozzi
 * @copyright 2017
 */
function multi_dealer_get_fields($type)
{
  global $wpdb;
   if(!function_exists('get_userdata()')) {
    include(ABSPATH . "/wp-includes/pluggable.php");
   }
    if ( $type == 'search')
    {
    $args = array(
            'post_status' => 'publish',
            'post_type' => 'multidealerfields',
            'meta_key' => 'field-order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
            array(
            'key' => 'field-searchbar',
            'value' => '1'
            )
        )
    );
    }
    elseif($type == 'all')
    {
    $args = array(
            'post_status' => 'publish',
            'post_type' => 'multidealerfields',
            'meta_key' => 'field-order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        );
    }
    elseif ( $type == 'widget')
    {
    $args = array(
            'post_status' => 'publish',
            'post_type' => 'multidealerfields',
            'meta_key' => 'field-order',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
            array(
            'key' => 'field-searchwidget',
            'value' => '1'
            )
        )
    );
    }    
        query_posts( $args );
        $afields = array();
        while ( have_posts() ) : the_post();
            $afieldsid[] = esc_attr(get_the_ID());
        endwhile;
         return $afieldsid;  
} // end Funcrions
function multi_dealer_get_meta($post_id)
{
    $fields = array(
        'field-label',
        'field-typefield',
        'field-drop_options',
        'field-searchbar',
        'field-searchwidget',
        'field-rangemin',
        'field-rangemax',
        'field-rangestep',
        'field-slidemin',
        'field-slidemax',
        'field-slidestep',  
        'field-order',
        'field-name');
    $tot = count($fields);
    for ($i = 0; $i < $tot; $i++) {
        $field_value[$i] = esc_attr(get_post_meta($post_id, $fields[$i], true));
    }
    $field_value[$tot-1] = esc_attr(get_the_title($post_id));
    return $field_value;
}
function multi_dealer_get_types()
{
    global $wpdb;
    $productmake = array();  
    $args = array(
        'taxonomy'               => 'makes',
        'orderby'                => 'name',
        'order'                  => 'ASC',
        'hide_empty'             => false,
    );
    $the_query = new WP_Term_Query($args);
    $productmake = array();  
    foreach($the_query->get_terms() as $term){ 
       $productmake[] = $term->name;
    }
 return $productmake; 
}
function multidealer_get_max()
{
    global $wpdb;
    $args = array(
        'numberposts' => 1,
        'post_type' => 'products',
        'meta_key' => 'product-price',
        'orderby' => 'meta_value_num',
        'order' => 'DESC');
    $posts = get_posts($args);
    foreach ($posts as $post) {
        $x = get_post_meta($post->ID, 'product-price', true);
        if (!empty($x)) {
            $x = (int)$x;
            if (is_int($x)) {
                $x = ($x) * 1.2;
                $x = round($x, 0, PHP_ROUND_HALF_EVEN);
                //return $x;
            }
        }
        if($x < 1)
          return '100000';
        else
          return $x;
    }
}
add_action( 'wp_loaded', 'multi_dealer_get_types' );
function multidealer_currency()
{
    if (get_option('MultiDealercurrency') == 'Dollar') {
        return "$";
    }
    if (get_option('MultiDealercurrency') == 'Pound') {
        return "&pound;";
    }
    if (get_option('MultiDealercurrency') == 'Yen') {
        return "&yen;";
    }
    if (get_option('MultiDealercurrency') == 'Euro') {
        return "&euro;";
    }
    if (get_option('MultiDealercurrency') == 'Universal') {
        return "&curren;";
    }
    if (get_option('MultiDealercurrency') == 'AUD') {
        return "AUD";
    }
    if (get_option('MultiDealercurrency') == 'Real') {
        return "$R";
    }
}
function MultiDealer_localization_init_fail()
{
    echo '<div class="error notice">
                     <br />
                     multidealerPlugin: Could not load the localization file (Language file).
                     <br />
                     Please, take a look the online Guide item Plugin Setup => Language.
                     <br /><br />
                     </div>';
}
function MultiDealer_Show_Notices1()
            {
                    echo '<div class="update-nag notice"><br />';
                    echo 'Warning: Upload directory not found (MultiDealer Plugin). Enable debug for more info.';
                    echo '<br /><br /></div>';
            }
            
function MultiDealer_plugin_was_activated()
{
                echo '<div class="updated"><p>';
                $bd_msg = '<img src="'.MULTIDEALERURL.'assets/images/infox350.png" />';
                $bd_msg .= '<h2>MultiDealer Plugin was activated! </h2>';
                $bd_msg .= '<h3>For details and help, take a look at Multi Dealer Dashboard at your left menu <br />';
                $bd_url = '  <a class="button button-primary" href="admin.php?page=multi_dealer_plugin">or click here</a>';
                $bd_msg .=  $bd_url;
                echo $bd_msg;
                echo "</p></h3></div>";
     $Multidealerplugin_installed = trim(get_option( 'Multidealerplugin_installed',''));
     if(empty($Multidealerplugin_installed)){
        add_option( 'Multidealerplugin_installed', time() );
        update_option( 'Multidealerplugin_installed', time() );
     }
} 
if( current_user_can('editor'))
{
   if(get_option('MultiDealer_activated', '0') == '1')
   {
     add_action( 'admin_notices', 'MultiDealer_plugin_was_activated' );
     $r =  update_option('MultiDealer_activated', '0'); 
     if ( ! $r )
        add_option('MultiDealer_activated', '0');
   }
} 
if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}
?>