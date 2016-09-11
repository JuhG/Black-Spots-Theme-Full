(function($) {

    /**
     * Global variables
     */
    var $body = $('body');
    var $win = $(window);
    var $header = $('.banner');
    var headerHeight = $header.height();
    var $headerTop = $header.find('.header-container');
    var $headerBottom = $header.find('.header-image');
    var $headerImage = $headerBottom.find('img');
    var st, pos, tr;
    var opacity = 1;

    $(document).ready(function () {

        /**
         * Fluidbox support to all image by default
         */
        $('.fluidbox').closest('a').fluidbox();

        /**
         * Owl carousel init
         */
        $('.gallery').owlCarousel({
            singleItem: true,
            autoHeight : true,
            rewindSpeed: 200,
            itemsScaleUp: true,
            navigation: true,
            rewindNav: false,
            navigationText: [
                "<i class='dashicons dashicons-arrow-left-alt2'></i>",
                "<i class='dashicons dashicons-arrow-right-alt2'></i>"
            ],
        });

        /**
         * Adding a special classname to all links with images inside
         */
        var linksWithImages = function () {
            var $as = $('a, .button');
            $as.each(function () {
                var $a = $(this);
                if ( $a.find('img, picture').length ) $a.addClass('image-inside');
            });
        }
        linksWithImages();

        /**
         * Sticky headder
         */
        if ( $body.is('.header-sticky') ) {
            var stickyHeader = function () {
                $headerBottom.css('margin-top', $headerTop.height() );
            }
            stickyHeader();
            $win.on('resize', lodashThrottle(stickyHeader, 10));
        }

        /**
         * Parallax
         */
        if ( $body.is('.header-parallax') ) {
            var headerParallax = function (e) {
                $headerBottom.css({
                    height: $headerImage.height()
                });
                st = document.body.scrollTop;
                pos = st / 2;
                posMinus = -1 * pos;
                tr = 'translateY('+ pos +'px)';
                trMinus = 'translateY('+ posMinus +'px)';
                if ( $body.is('.header-boxed') ) {
                    $headerImage.css({
                        width: $headerBottom.width()
                    });
                }
                if ( $body.is('.header-parallax-fade') ) {
                    headerHeight = $header.height();
                    opacity = Math.max( 1 - st / headerHeight, 0 );
                }
                $headerImage.css({
                    transform: trMinus,
                    webkitTransform: trMinus,
                    opacity: opacity
                });
                if ( $body.is('.header-static') ) {
                    $headerTop.css({
                        transform: tr,
                        webkitTransform: tr
                    });
                }
            };
            $win.on('scroll', lodashThrottle(headerParallax, 10));
            $win.on('resize', lodashThrottle(headerParallax, 10));
            headerParallax();
        }
    });

})(jQuery);
