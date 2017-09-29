<?php 
/*
Plugin Name: MultiDealer 
Plugin URI: http://multidealerplugin.com
Description: Dealers and Real Estate Brokers can manage, list and sell products online quickly by create custom fieds.
Version: 1.0
Text Domain: MultiDealer
Domain Path: /language
Author: Bill Minozzi
Author URI: http://billminozzi.com
License:     GPL2
Copyright (c) 2017 Bill Minozzi
MultiDealer is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
multidealer is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with multidealer. If not, see {License URI}.
Permission is hereby granted, free of charge subject to the following conditions:
The above copyright notice and this FULL permission notice shall be included in
all copies or substantial portions of the Software.
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
*/
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
define('MULTIDEALERVERSION', '1.0');
define('MULTIDEALERPATH', plugin_dir_path(__file__));
define('MULTIDEALERURL', plugin_dir_url(__file__));
define('MULTIDEALERIMAGES', plugin_dir_url(__file__) . 'assets/images/');
include_once(ABSPATH . 'wp-includes/pluggable.php');
function multidealer_plugin_settings_link($links)
{
    $settings_link = '<a href="edit.php?post_type=products&page=settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__file__);
if( current_user_can('editor')) {
    add_action('admin_print_scripts-post-new.php', 'MultiDealer_add_admstylesheet');
            $path = dirname(plugin_basename(__file__)) . '/language/';
            $loaded = load_plugin_textdomain('multidealer', false, $path);
            if (!$loaded and get_locale() <> 'en_US') {
                if (function_exists('MultiDealer_localization_init_fail'))
                    add_action('admin_notices', 'MultiDealer_localization_init_fail');
            }
} 
else {
    add_action('plugins_loaded', 'MultiDealer_localization_init');
}
add_filter("plugin_action_links_$plugin", 'multidealer_plugin_settings_link');
require_once (MULTIDEALERPATH . "settings/load-plugin.php");
require_once (MULTIDEALERPATH . "settings/options/plugin_options_tabbed.php");
 require_once (MULTIDEALERPATH . 'includes/contact-form/multi-contact-form.php');
require_once (MULTIDEALERPATH . 'includes/help/help.php');
require_once (MULTIDEALERPATH . 'includes/functions/functions.php');
require_once (MULTIDEALERPATH . 'includes/post-type/meta-box.php');
require_once (MULTIDEALERPATH . 'includes/post-type/post-functions.php');
require_once (MULTIDEALERPATH . 'includes/templates/template-functions.php');
require_once (MULTIDEALERPATH . 'includes/templates/redirect.php');
require_once (MULTIDEALERPATH . 'includes/widgets/widgets.php');
require_once (MULTIDEALERPATH . 'includes/search/search-function.php');
require_once (MULTIDEALERPATH . 'includes/multi/multi.php');
require_once (MULTIDEALERPATH . 'dashboard/main.php');
$Multidealer_template_gallery = trim(get_option('MultiDealer_template_gallery', 'yes'));
require_once (MULTIDEALERPATH . 'includes/templates/template-showroom1.php');
require_once (MULTIDEALERPATH . 'includes/multi/multi-functions.php');
$multidealerurl = $_SERVER['REQUEST_URI'];
    if (strpos($multidealerurl,'product') !== false) {
               $MultiDealer_overwrite_gallery = strtolower(get_option('MultiDealer_overwrite_gallery',
    'yes'));
    if($MultiDealer_overwrite_gallery == 'yes')
                    require_once (MULTIDEALERPATH . 'includes/gallery/gallery.php');
}
add_action('wp_enqueue_scripts', 'MultiDealer_add_files');
function MultiDealer_add_files()
{
    wp_enqueue_style('show-room', MULTIDEALERURL . 'includes/templates/show-room.css');
    wp_enqueue_style('pluginStyleGeneral', MULTIDEALERURL .
        'includes/templates/template-style.css');
    wp_enqueue_style('pluginStyleSearch2', MULTIDEALERURL .
        'includes/search/style-search-box.css');
    wp_enqueue_style('pluginStyleSearchwidget', MULTIDEALERURL . 'includes/widgets/style-search-widget.css');
    wp_enqueue_style('pluginStyleGeneral4', MULTIDEALERURL .
        'includes/gallery/css/flexslider.css');
    wp_enqueue_style('pluginStyleGeneral5', MULTIDEALERURL .
        'includes/contact-form/css/multi-contact-form.css');
     wp_register_style('jqueryuiSkin', MULTIDEALERURL . 'assets/jquery/jqueryui.css', array(), '1.12.1');
    wp_enqueue_style('jqueryuiSkin');
    wp_enqueue_script('jquery-ui-slider');
}
function MultiDealer_activated()
{
    $w = update_option('MultiDealer_activated', '1');
    if (!$w)
        add_option('MultiDealer_activated', '1');   
    $admin_email = get_option('admin_email');
    $old_admin_email = trim(get_option('MultiDealer_recipientEmail', ''));
    if (empty($old_admin_email)) {
        $w = update_option('MultiDealer_recipientEmail', $admin_email);
        if (!$w)
            add_option('MultiDealer_recipientEmail', $admin_email);
    }
}
register_activation_hook(__file__, 'MultiDealer_activated');
function MultiDealer_localization_init()
{
    $path = dirname(plugin_basename(__file__)) . '/language/';
    $loaded = load_plugin_textdomain('multidealer', false, $path);
} 
function multidealerplugin_load_bill_stuff()
{
        wp_enqueue_script( 'jquery-ui-core' );
}   
add_action( 'wp_loaded', 'multidealerplugin_load_bill_stuff' );
?>