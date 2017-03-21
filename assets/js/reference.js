jQuery(document).ready( function($) {
    "use strict";

    // Syntax Highlighting
    $('pre code').each(function(i, block) {
        if($(this).parent().hasClass('reference-highlighter')) {
            hljs.highlightBlock(block);
        }
    });

    // reference single breadcrumb
    var $ancestors = $('.current-menu-item').parentsUntil( '#reference-menu').toArray().reverse();
    var count  = 0;
    var $separator = '';
    // if (reference_breadcrumb_separator_object != null) {
    // if (reference_breadcrumb_separator_object  && typeof reference_breadcrumb_separator_object !== 'undefined') {
    if (typeof reference_breadcrumb_separator_object !== 'undefined' && reference_breadcrumb_separator_object !== null) {
        $separator = reference_breadcrumb_separator_object.separator;
    }

    var current_menu_name = $( '#reference-menu .current-menu-item >a:first-child').text();
    var current_menu_link = $( '#reference-menu .current-menu-item >a:first-child').attr('href');
    var current_breadcrumb = '<a href="'+current_menu_link+'" title="'+current_menu_name+'">'+$separator+current_menu_name+'</a>';

    if ( $ancestors.length >= 1 ) {

        $('#breadcrumbs-wrap').html('');

        $.each( $ancestors, function( key, node ){

            count++;

            if ( $(this).hasClass('menu-item') ) {


                var text = $(' > a', $(this)).html();
                var link = $(' > a', $(this)).attr('href');

                var trail = '<a href="'+link+'" title="'+text+'">'+text+'</a>';

                //console.log( count + 1 + ' is eq? ' + $ancestors.length )
                if ( count + 1 < $ancestors.length ) {
                    trail += $separator;
                }

                $('#breadcrumbs-wrap').append( trail );
            }

        });

        $( current_breadcrumb ).insertAfter( "#breadcrumbs-wrap > a:last-child" );

    }

    /**
     * Sticky Table of Content
     **/
    var $sticky_kit = '';
    var offset_top = 10, margin = 15;

    if (typeof reference_sticky_kit_object !== 'undefined' && reference_sticky_kit_object !== null) {
        $sticky_kit = parseInt(reference_sticky_kit_object.sticky_kit);
    }

    if ($sticky_kit === 1) {
        if ( $('#wpadminbar').length > 0 ) {

            offset_top = parseInt( $('#wpadminbar').height() );
        } else {
            margin = 5;
        }

        offset_top += margin;

        $( '.reference-menu-wrap' ).stick_in_parent({
            offset_top: offset_top,
            parent: '#content'
        }).on('sticky_kit:bottom', function(e) {
            $(this).parent().parent().css('position', 'static');
        }).on('sticky_kit:unbottom', function(e) {
            $(this).parent().parent().css('position', 'relative');
        })

        $(window).scroll(function() {

            var masthead_height = $( '#masthead' ).innerHeight();

            var sidebar_width = $( '#content' ).outerWidth();

            if ( $( this ).scrollTop() > masthead_height ) {

                $( '.reference-menu-wrap' ).trigger("sticky_kit:recalc");

                $( '.reference-menu-wrap' ).addClass('reference_nav_is_sticky');

                $( '.reference-menu-wrap' ).removeClass('reference_nav_is_not_sticky');

            } else {

                $( '.reference-menu-wrap' ).trigger("sticky_kit:recalc");

                $( '.reference-menu-wrap' ).removeClass('reference_nav_is_sticky');

                $( '.reference-menu-wrap' ).addClass('reference_nav_is_not_sticky');

            }

        }); //w.scroll

        $( window ).load(function() {

            // Gets the width of the device.
            var device_width = $( window ).width();

            if ( ( device_width <= 991 ) ) {

                $( '.reference-menu-wrap' ).trigger("sticky_kit:detach");

            }

        });
    }

    $( '.reference-menu-container ol li ol.sub-menu li.menu-item-has-children > a' ).after( '<span id="thrive_nav_btn" class="pages-menu-toggle"></span>' );

    $('.pages-menu-toggle').on('click', function(e) {

        e.preventDefault();

        if ( $( this ).parent().hasClass( 'active' ) ) {

            $( this ).parent().removeClass( 'active' );

        } else {

            $( this ).parent().addClass( 'active' );

        }
        if ($sticky_kit === 1) {
            $( '.reference-menu-wrap' ).trigger("sticky_kit:recalc");
        }

    });

});
