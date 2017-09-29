<?php /**
 * @author William Sergio Minozzi
 * @copyright 2017
 */
function MultiDealer_contact_form()
{
     wp_enqueue_script('contact-form-js', MULTIDEALERURL . 'includes/contact-form/js/multi-contact-form.js', array('jquery'));   
} 
add_action('wp_loaded', 'MultiDealer_contact_form');
function multidealer_form_ajaxurl()
{
        echo '<script type="text/javascript">
                var ajaxformurl = "' . admin_url('admin-ajax.php') . '";
              </script>';
}
add_action('wp_head', 'multidealer_form_ajaxurl');
add_action('wp_ajax_md_process_form', 'md_process_form_callback');
function md_process_form_callback()
{
    check_ajax_referer( 'multidealer_cform'); // , 'security', false );
    $Car_name = isset($_POST['multidealer_the_title']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/",
        "", sanitize_text_field($_POST['multidealer_the_title'])) : "";
    define("RECIPIENT_NAME", "WordPress");
    define("EMAIL_SUBJECT", "Visitor Message From MultiDealer Plugin About: ".$Car_name);
    $success = false;
    $recipient_email = isset($_POST['MultiDealer_recipientEmail']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/",
        "", sanitize_text_field($_POST['MultiDealer_recipientEmail'])) : "";
    $senderName = isset($_POST['MultiDealer_senderName']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/",
        "", sanitize_text_field($_POST['MultiDealer_senderName'])) : "";
    $senderEmail = isset($_POST['MultiDealer_senderEmail']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/",
        "", sanitize_text_field($_POST['MultiDealer_senderEmail'])) : "";
    if (isset($_POST['title']))
       $message = sanitize_text_field($_POST['title'].PHP_EOL);
    else
       $message = '';
    $message .= isset($_POST['MultiDealer_sendermessage']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/",
        "", sanitize_text_field($_POST['MultiDealer_sendermessage'])) : "";
    if ($senderName && $senderEmail && $message && $recipient_email) {
        $recipient = RECIPIENT_NAME . " <" . $recipient_email . ">";
        $headers = "From: " . $senderName . " <" . $senderEmail . ">";
        $success = wp_mail($recipient_email, EMAIL_SUBJECT, $message, $headers);
    }
    echo $success ? "success" : "error";
    wp_die();
} 
?>