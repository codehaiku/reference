jQuery(document).ready( function($) {
    "use strict";

    $('pre code').each(function(i, block) {
        if($(this).parent().hasClass('reference-highlighter')) {
            hljs.highlightBlock(block);
        }
    });

    $( '.reference-menu-container ol li ol.sub-menu li.menu-item-has-children > a' ).after( '<span id="thrive_nav_btn" class="pages-menu-toggle"></span>' );

    $('.pages-menu-toggle').on('click', function(e) {

        e.preventDefault();

        if ( $( this ).parent().hasClass( 'active' ) ) {

            $( this ).parent().removeClass( 'active' );

        } else {

            $( this ).parent().addClass( 'active' );

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

});
