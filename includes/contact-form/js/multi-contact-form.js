jQuery(document).ready(function() {
	var messageDelay = 3000;
	jQuery("#MultiDealer_sendMessage").click(function(evt) {
		evt.preventDefault();
		var MultiDealer_contactForm = jQuery(this);
        var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
    	var uemail = jQuery('#MultiDealer_senderEmail').val();
		if (!jQuery('#MultiDealer_senderName').val() || !jQuery('#MultiDealer_senderEmail').val() || !jQuery('#MultiDealer_sendermessage').val()) {
            jQuery('#MultiDealer_incompleteMessage').fadeIn().delay(messageDelay).fadeOut();
            MultiDealer_contactForm.fadeOut().delay(messageDelay).fadeIn();
			// jQuery('#MultiDealer_senderName').css('border', '1px solid red');
            return false;
    	} 
        else if(!re.test(uemail))
        {
              jQuery('#MultiDealer_email_error').fadeIn().delay(messageDelay).fadeOut();
              return false;
        }
  		var uname = jQuery('#MultiDealer_senderName').val();
        var umessage = jQuery('#MultiDealer_sendermessage').val();
        if(!onlyalpha (uname))
        {
           jQuery('#MultiDealer_name_error').fadeIn().delay(messageDelay).fadeOut();
           return false;     
        }
        if( ! alphanumeric(umessage) )
        {
           jQuery('#MultiDealer_message_error').fadeIn().delay(messageDelay).fadeOut();
           return false; 
        }
        //else {
			jQuery('#MultiDealer_sendingMessage').fadeIn();
			MultiDealer_contactForm.fadeOut();
            var nonce = jQuery('#_wpnonce').val();
            form_content = jQuery('#MultiDealer_contactForm').serialize();
              jQuery.ajax({
                type: "POST",
				url: ajaxformurl,
				data: form_content + '&action=md_process_form' + '&security=' + _wpnonce,
				    timeout: 20000,
                    error: function(jqXHR, textStatus, errorThrown) {
                      // alert('errorThrown');
                  		jQuery('#MultiDealer_sendingMessage').hide();
                        MultiDealer_contactForm.fadeIn();
                        alert('Fail to Connect with Data Base (9).\nPlease, try again later.');
                    }, 
                success: submitFinished
			});          
		// }
		return false;
	});
	jQuery(init_MultiDealer_form);
	function init_MultiDealer_form() {
		jQuery('#MultiDealer_contactForm').hide(); //.submit( submitForm ).addClass( 'MultiDealer_positioned' );
		jQuery('#MultiDealer_sendingMessage').hide();
		jQuery('#MultiDealer_successMessage').hide();
		jQuery('#MultiDealer_failureMessage').hide();
		jQuery('#MultiDealer_incompleteMessage').hide();
		jQuery("#MultiDealer_cform").click(function() {
			jQuery('#MultiDealer_cform').hide();
			jQuery('#MultiDealer_contactForm').addClass('MultiDealer_positioned');
			jQuery('#MultiDealer_contactForm').css('opacity', '1');
			jQuery('#MultiDealer_contactForm').fadeIn('slow', function() {
				jQuery('#MultiDealer_senderName').focus();
			})
			return false;
		});
		// When the "Cancel" button is clicked, close the form
		jQuery('#MultiDealer_cancel').click(function() {
			jQuery('#MultiDealer_contactForm').fadeOut();
			jQuery('#content2').fadeTo('slow', 1);
            jQuery("#MultiDealer_cform").fadeIn()
		});
		// When the "Escape" key is pressed, close the form
		jQuery('#MultiDealer_contactForm').keydown(function(event) {
			if (event.which == 27) {
				jQuery('#MultiDealer_contactForm').fadeOut();
				jQuery('#content2').fadeTo('slow', 1);
                jQuery("#MultiDealer_cform").fadeIn()
			}
		});
	}
	function submitFinished(response) {
		response = jQuery.trim(response);
		jQuery('#MultiDealer_sendingMessage').fadeOut();
		if (response == "success") {
			jQuery('#MultiDealer_successMessage').fadeIn().delay(messageDelay).fadeOut();
			jQuery('#MultiDealer_senderName').val("");
			jQuery('#MultiDealer_senderEmail').val("");
			jQuery('#MultiDealer_sendermessage').val("");
			jQuery('#content2').delay(messageDelay + 1000).fadeTo('slow', 1);
			jQuery('#MultiDealer_contactForm').fadeOut();
            jQuery("#MultiDealer_cform").fadeIn()
		} else {
			jQuery('#MultiDealer_failureMessage').fadeIn().delay(messageDelay).fadeOut();
			jQuery('#MultiDealer_contactForm').delay(messageDelay + 1000).fadeIn();
		}
	}
    function alphanumeric(inputtext)
    {
         if( /[^a-zA-Z0-9]/.test( inputtext ) ) {
           return false;
         }
        return true;
    }
    function onlyalpha(inputtext)
    {
     if( /[^a-zA-Z]/.test( inputtext ) ) {
       return false;
     }
      return true;
    }
}); // end jQuery ready