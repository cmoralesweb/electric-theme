jQuery( document ).ready( function( $ ) {
    /**
   * Handles toggling the main navigation menu for small screens.
   */
    (function(){
        var $nav = $( '.main-navigation.site-navigation' ),
        timeout = false;
        var breakPoint = 934;
        $.fn.smallMenu = function() {
            $nav.removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
            $nav.find( 'h1' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );

            $( '.menu-toggle' ).unbind( 'click' ).click( function() {
                $nav.find( '.menu' ).toggleClass('activated');
                $( this ).toggleClass( 'toggled-on' );
            } );
        };

        // Check viewport width on first load.
        if ( $( window ).width() < breakPoint ){
            $.fn.smallMenu();
        }
        // Check viewport width when user resizes the browser window.
        $( window ).resize( function() {
            var browserWidth = $( window ).width();

            if ( false !== timeout ) {
                clearTimeout( timeout );
            }
            timeout = setTimeout( function() {
                if ( browserWidth < breakPoint ) {
                    $.fn.smallMenu();
                } else {
                    $nav.removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
                    $nav.find( 'h1' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
                }
            }, 200 );
        } );
    }());


    if($().quicksand) {    //Only run if quicksand is active
        quicksand_fire();
    }
    if($().flexslider) {    //Only run if flexslider is active
        flexslider_fire();
    }
    if($().tooltip) {    //Only run if tooltip is active
        tooltip_fire();
    }
    if($().magnificPopup) {    //Only run if magnificPopup is active
        lightboxFire();
    }

    function flexslider_fire() {
        $('.portfolio-showcase').flexslider({//Galeria inicio
            controlsContainer: ".showcase",
            manualControls:"ol.thumbs li",
            pauseOnHover: true
        });

        //Widgets cautiously fired one by one.
        //They could be fired just with "$('.flexslider').flexslider" but
        //I prefer to be more precise just in case any other .flexslider class
        //is used and cause problems
        $('.electric-recent-entries .flexslider, .electric-recent-comments .flexslider, .electric-ephemera-widget .flexslider, .related-articles .flexslider, .electric-twitter-posts .flexslider').flexslider({
            smoothHeight: true,
            directionNav: true,
            slideshow: false
        });
        //Add the arrow icons:
        var nav = $('.flex-direction-nav');
        nav.find('.flex-next').wrapInner('<span class="assistive-text" />').prepend('<span aria-hidden="true" data-icon="&#xe025;"></span>');
        nav.find('.flex-prev').wrapInner('<span class="assistive-text" />').prepend('<span aria-hidden="true" data-icon="&#xe011;"></span>');
    }

    function tooltip_fire() {
        $(".tooltip[title], .main-navigation .menu a[title]").tooltip({
            position: "top center",
            offset: [-10, 0],
            tipClass: "tooltip-container",
            effect: "fade",
            delay: 100
        }).dynamic({
            bottom: {
                direction: 'down',
                bounce: true
            }
        });
        $(".electric-availability-widget .availability").tooltip({
            position: "top center",
            offset: [-10, 0],
            relative: true,
            tipClass: "tooltip-container",
            effect: "fade",
            delay: 300
        }).dynamic({
            bottom: {
                direction: 'down',
                bounce: true
            }
        });
    }

    function lightboxFire() {
        $lightboxEl = $('[data-rel="lightbox"]');
        $lightboxEl.magnificPopup($lightboxEl.data('lightbox-options')); //Options passed via data- attribute
    }

    function quicksand_fire() {
        var $filter;
        var $container;
        var $containerClone;
        var $filterLink;
        var $filteredItems;

        $filter = $('.filter li.active a').attr('class');

        $filterLink = $('.filter li a');

        $container = $('ul.filterable-grid');

        $containerClone = $container.clone();

        // Apply our Quicksand to work on a click function
        // for each of the filter li link elements
        $filterLink.click(function(e)
        {
            $('.filter li').removeClass('active');

            // Split each of the filter elements and override our filter
            $filter = this.hash.substr(1);

            // Apply the 'active' class to the clicked link
            $(this).parent().addClass('active');

            // If 'all' is selected, display all elements
            // else output all items referenced by the data-type
            if ($filter == 'all') {
                $filteredItems = $containerClone.find('li');
            }
            else {
                $filteredItems = $containerClone.find('li[data-type~=' + $filter + ']');
            }

            // Finally call the Quicksand function
            $container.quicksand($filteredItems, {
                adjustHeight: "dynamic",
                adjustWidth: false
            });
        });
    }



    /*
     * Check notification area
     */
    var menuFixedObject;
    if(getCookie('show_notification') !== 'no') {
        $('#notification-area').slideDown();
    }

    $('#notification-area #close').click(function(){
        $(this).parent().slideUp();
        setCookie('show_notification', 'no', 7*24);
    });



    /*
     * Placeholder polyfill
     */
    //Check if placeholder is supported
    var placeholderSupported = !!( 'placeholder' in document.createElement('input') );
    if(!placeholderSupported) {
        //If it's not supported, place the content of the attribute in the input'
        $('input').not('.submit').each(function (){
            var placeholder = $(this).attr('placeholder');
            $(this).val(placeholder);
            $(this).focus(function(){
                $(this).val("");
            });
            $(this).blur(function(){
                $(this).val(placeholder);
            });
        });
    }


});
