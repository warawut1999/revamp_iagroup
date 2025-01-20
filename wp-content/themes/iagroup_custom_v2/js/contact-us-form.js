jQuery(document).ready(function($) {
    $('#contact-form').submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var recaptchaResponse = grecaptcha.getResponse();

        if (recaptchaResponse === "") {
            $('#responseMessage').html('Please verify that you are not a robot.');
            return;
        }

        formData += '&recaptcha_response=' + recaptchaResponse;

        $.ajax({
            url: contactFormAjax.ajaxUrl,
            type: 'POST',
            data: formData + '&action=contact_form',
            success: function(response) {
                if (response.success) {
                    $('#responseMessage').html(response.data);
                } else {
                    $('#responseMessage').html('An error occurred: ' + response.data);
                }
            },
            error: function() {
                $('#responseMessage').html('An error occurred. Please try again.');
            }
        });
    });
});
