<?php 
/**
 * @author William Sergio Minozzi
 * @copyright 2017
 */
// ob_start();
add_action( 'admin_init', 'fordummies_settings_init' );
add_action( 'admin_menu', 'fordummies_add_admin_menu' );
function fordummies_enqueue_scripts() {
      	wp_enqueue_style( 'bill-help' , MULTIDEALERURL.'/dashboard/css/help.css');
}
add_action('admin_init', 'fordummies_enqueue_scripts');
 function fields_callback() {
    ?>
    <script type="text/javascript">
    <!--
     window.location  = "/wp-admin/edit.php?post_type=multidealerfields";
    -->
</script>
<?php
}
 function products_callback() {
    ?>
    <script type="text/javascript">
    <!--
     window.location  = "/wp-admin/edit.php?post_type=products";
    -->
</script>
<?php
}
function makes_callback() {
    ?>
    <script type="text/javascript">
    <!--
     window.location  = "/wp-admin/edit-tags.php?taxonomy=makes&post_type=products";
    -->
</script>
<?php
 }
function locations_callback() {
    ?>
    <script type="text/javascript">
    <!--
     window.location  = "/wp-admin/edit-tags.php?taxonomy=locations&post_type=products";
    -->
</script>
<?php
 }
function settings_callback() {
    ?>
    <script type="text/javascript">
    <!--
     window.location  = "/wp-admin/options.php?page=md_settings";
    -->
</script>
<?php
 }
function fordummies_add_admin_menu(  ) {
 //   global $vmtheme_hook;
 //   $vmtheme_hook = add_theme_page( 'For Dummies', 'For Dummies Help', 'manage_options', 'for_dummies', 'fordummies_options_page' );
 //   add_action('load-'.$vmtheme_hook, 'vmtheme_contextual_help');     
    Global $menu;
    add_menu_page(
    'Multi Dealer', 
    'Multi Dealer', 
    'manage_options', 
    'multi_dealer_plugin',
    'fordummies_options_page', 
    MULTIDEALERURL.'assets/images/multidealer.png' , 
    '30' );
 include_once(ABSPATH . 'wp-includes/pluggable.php');
$link_our_new_CPT = urlencode('edit.php?post_type=multidealerfields');
   add_submenu_page('multi_dealer_plugin', 'Fields Table', 'Fields Table', 'manage_options', 'fields-table', 'fields_callback');
   add_submenu_page('multi_dealer_plugin', 'Products Table', 'Products Table', 'manage_options', 'products-table', 'products_callback');
   add_submenu_page('multi_dealer_plugin', 'Makes', 'Makes', 'manage_options', 'md-makes', 'makes_callback');
   add_submenu_page('multi_dealer_plugin', 'Locations', 'Locations', 'manage_options', 'md-locations', 'locations_callback');
   add_submenu_page('multi_dealer_plugin', 'Settings', 'Settings', 'manage_options', 'md-settings', 'settings_callback');
}
function fordummies_settings_init(  ) { 
	register_setting( 'fordummies', 'fordummies_settings' );
}
function fordummies_options_page(  ) { 
    global $activated, $fordummies_update_theme;
            $wpversion = get_bloginfo('version');
            $current_user = wp_get_current_user();
            $plugin = plugin_basename(__FILE__); 
            $email = $current_user->user_email;
            $username =  trim($current_user->user_firstname);
            $user = $current_user->user_login;
            $user_display = trim($current_user->display_name);
            if(empty($username))
               $username = $user;
            if(empty($username))
               $username = $user_display;
            $theme = wp_get_theme( );
            $themeversion = $theme->version ; 
            $memory['limit'] = (int) ini_get('memory_limit') ;	
            $memory['usage'] = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 0) : 0;
            $memory['wplimit'] =  WP_MEMORY_LIMIT ;
  ?>
    <!-- Begin Page -->
<div id = "fordummies-theme-help-wrapper">   
     <div id="fordummies-not-activated"></div>
     <div id="fordummies-logo">
       <img alt="logo" src="<?php echo MULTIDEALERIMAGES;?>logosmall.png" />
     </div>
     <div id="fordummies_help_title">
         Help and Support Page
     </div> 
 <?php
if( isset( $_GET[ 'tab' ] ) ) 
    $active_tab = strip_tags($_GET[ 'tab' ]);
else
   $active_tab = 'dashboard';
?>
    <h2 class="nav-tab-wrapper">
    <a href="?page=multi_dealer_plugin&tab=memory&tab=dashboard" class="nav-tab">Dashboard</a>
    <a href="?page=multi_dealer_plugin&tab=memory" class="nav-tab">Memory Check Up</a>
    </h2>
<?php  
if($active_tab == 'memory') {     
   require_once (MULTIDEALERPATH . 'dashboard/memory.php');
} 
else
{ 
    require_once (MULTIDEALERPATH . 'dashboard/dashboard.php');
}
 echo '</div> <!-- "fordummies-theme_help-wrapper"> -->';
} // end Function fordummies_options_page
     require_once(ABSPATH . 'wp-admin/includes/screen.php');
// ob_end_clean();
 include_once(ABSPATH . 'wp-includes/pluggable.php');
?>