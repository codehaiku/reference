jQuery(document).ready( function($) {
    "use strict";

    $('#reference-confirm-feedback, #reference-decline-feedback').click(function(e) {

        $.ajax({
            type: 'POST',

            dataType: 'json',

            url: reference_feedback_object.ajaxurl,

            data: {
                'action': 'reference_feedback_ajax', //calls wp_ajax_nopriv_ajaxlogin

                'reference-id': $( '#reference-feedback' ).attr('data-value'),

                'reference-confirm': reference_feedback_object.yes,

                'reference-decline': reference_feedback_object.no,

                'reference-feedback-security': $( '#reference-feedback-security' ).val()

            },

            success: function(response) {

                if (response.status == 202) {

                    $( '#confirmed_amount' ).text(response.confirmed_amount);
                    $( '#declined_amount' ).text(response.declined_amount);

                    console.log(response.message);

                } else {

                    console.log(response.message);

                }


            }

        });
        e.preventDefault();
    });

});
