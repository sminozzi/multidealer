<?php /**
 * @author Bill Minozzi
 * @copyright 2017
 */
add_action("template_redirect", 'MultiDealer_template_redirect');
function MultiDealer_template_redirect()
{
    global $wp;
    global $query;
    global $wp_query;
    if (isset($_GET['MultiDealer_search_type'])) {
        $MultiDealer_search_type = sanitize_text_field($_GET['MultiDealer_search_type']);
            require_once (MULTIDEALERPATH . 'includes/templates/template-showroom3.php');
        die();
    }
   if (is_single()) {
        $multidealerurl = $_SERVER['REQUEST_URI'];
        if (strpos($multidealerurl, '/product/') === false)
            return;
        if (isset($wp->query_vars["post_type"])) {
            if ($wp->query_vars["post_type"] == "products") {
                if (have_posts()) {
                    include (MULTIDEALERPATH . 'includes/templates/template-single.php');
                    die();
                }
            }
        }
    }
}