jQuery(document).ready( function($) {
    "use strict";

    $( '.reference-menu-container ol li ol.sub-menu li.menu-item-has-children > a' ).after( '<span id="thrive_nav_btn" class="pages-menu-toggle"></span>' );

    $('.pages-menu-toggle').on('click', function(e) {

        e.preventDefault();

        if ( $( this ).parent().hasClass( 'active' ) ) {

            $( this ).parent().removeClass( 'active' );

        } else {

            $( this ).parent().addClass( 'active' );

        }

    });

    $('#reference-confirm, #reference-decline').click(function() {

        // $.ajax({
        //     type: 'POST',
        //
        //     dataType: 'json',
        //
        //     url: reference_feedback_object.ajaxurl,
        //
        //     data: {
        //         'action': 'reference_feedback_ajax', //calls wp_ajax_nopriv_ajaxlogin
        //
        //         'yes': $('#reference-confirm').data('value'),
        //
        //         'no': $('#reference-decline').data('value'),
        //
        //         'reference-feedback-security': $( '#reference-feedback-security' ).val()
        //
        //     },
        //
        //     success: function( response ) {
        //
        //         if (response.type == "success") {
        //
        //             alert("success");
        //
        //         } else {
        //
        //             alert('fail');
        //
        //         }
        //
        //
        //     }
        //
        // });
    });

});
