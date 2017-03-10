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

});
