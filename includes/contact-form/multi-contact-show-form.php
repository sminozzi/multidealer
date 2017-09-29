<?php /**
 * @author William Sergio Minozzi
 * @copyright 2017
 */
// $aurl = MULTIDEALERURL . 'includes/contact-form/processForm.php';
$aurl = "#";
$MultiDealer_recipientEmail = trim(get_option('MultiDealer_recipientEmail', ''));
if ( ! is_email($MultiDealer_recipientEmail)) {
        $MultiDealer_recipientEmail = '';
        update_option('MultiDealer_recipientEmail', '');
    }
if (empty($MultiDealer_recipientEmail))
    $MultiDealer_recipientEmail = get_option('admin_email'); ?>
<?php Global $multidealer_the_title; ?>  
<form id="MultiDealer_contactForm" style="display: none;">
<!-- action="<?php echo $aurl; ?>" method="post"> -->
  <input type="hidden" name="MultiDealer_recipientEmail" id="MultiDealer_recipientEmail" value="<?php echo
$MultiDealer_recipientEmail; ?>" />
  <input type="hidden" name="multidealer_the_title" id="multidealer_the_title" value="<?php echo $multidealer_the_title; ?>" />
  <h2><?php 
  echo __('Request Information', 'multidealer'); 
  ?>...</h2>
  <ul>
    <li>
      <label for="MultiDealer_senderName" class="MultiDealer_contact" ><?php echo __('Your Name',
'multidealer'); ?>:&nbsp;</label>
      <input type="text" name="MultiDealer_senderName" id="MultiDealer_senderName" placeholder="<?php echo
__('Please type your name', 'multidealer'); ?>" required="required" maxlength="40" />
    </li>
    <li>
      <label for="MultiDealer_senderEmail" class="MultiDealer_contact"><?php echo __('Your Email',
'multidealer'); ?>:&nbsp;</label>
      <input type="email" name="MultiDealer_senderEmail" id="MultiDealer_senderEmail" placeholder="<?php echo
__('Please type your email', 'multidealer'); ?>" required="required" maxlength="50" />
    </li>
    <li>
      <label for="MultiDealer_sendermessage" class="MultiDealer_contact" style="padding-top: .5em;"><?php echo
__('Your Message', 'multidealer'); ?>:&nbsp;</label>
      <textarea name="MultiDealer_sendermessage" id="MultiDealer_sendermessage" placeholder="<?php echo
__('Please type your message', 'multidealer'); ?>" required="required"  maxlength="10000"></textarea>
    </li>
  </ul>
<br />
  <div id="formButtons">
    <input type="submit" id="MultiDealer_sendMessage" name="sendMessage" value="<?php echo
__('Send', 'multidealer'); ?>" />
    <input type="button" id="MultiDealer_cancel" name="cancel" value="<?php echo __('Cancel',
'multidealer'); ?>" />
  </div>
<?php  wp_nonce_field('multidealer_cform'); ?> 
</form>
<div id="MultiDealer_sendingMessage" class="MultiDealer_statusMessage" style="display: none; z-index:999;" ><p>Sending your message. Please wait...</p></div>
<div id="MultiDealer_successMessage" class="MultiDealer_statusMessage" style="display: none;  z-index:999;"><p>Thanks for your message! We'll get back to you shortly.</p></div>
<div id="MultiDealer_failureMessage" class="MultiDealer_statusMessage" style="display: none;  z-index:999;"><p>There was a problem sending your message. Please try again.</p></div>
<div id="MultiDealer_email_error" class="MultiDealer_statusMessage" style="display: none; z-index:999;"><p>Please enter one valid email address.</p></div>
<div id="MultiDealer_incompleteMessage" class="MultiDealer_statusMessage" style="display: none; z-index:999;"><p>Please complete all the fields in the form before sending.</p></div>
<div id="MultiDealer_name_error" class="MultiDealer_statusMessage" style="display: none; z-index:999;"><p>Name Error. Use only alpha.</p></div>
<div id="MultiDealer_message_error" class="MultiDealer_statusMessage" style="display: none; z-index:999;"><p>Message Error. Only Use only alpha and numbers.</p></div>

