/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {
  // global variables
  var $body = $('body');
  var $win = $(window);
  var $header = $('.banner');
  var headerHeight = $header.height();
  var $headerImage = $('.header-image img');
  var $headerTop = $('.header-container');
  var st, pos, tr;
  var opacity = 1;

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
        /**
         * Fluidbox support to all image by default
         */
        $('.fluidbox').closest('a').fluidbox();
        // var $g = $('.owl-carousel');

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
         *
         */
        function linksWithImages () {
          var $as = $('a, .button');
          $as.each(function () {
            var $a = $(this);
            if ( $a.find('img, picture').length ) $a.addClass('image-inside');
          });
        }
        linksWithImages();

        /**
         * Parallax
         */
        if ( $body.is('.header-parallax') ) {
          $header.css('min-height', $headerImage.height());
          headerHeight = $header.height();
          var headerParallax = function (e) {
            st = document.body.scrollTop;
            pos = -1 * ( st / 2 );
            tr = 'translateY('+ pos +'px)';
            if ( $body.is('.header-parallax-fade') ) opacity = 1.2 - st / headerHeight;
            $headerImage.css({
              transform: tr,
              webkitTransform: tr,
              opacity: opacity
            });
            if ( $body.is('.header-static') ) {
              $headerTop.css({
                transform: -tr,
                webkitTransform: -tr
              });
            }
          }
          $win.on('scroll', lodashThrottle(headerParallax, 10));
          headerParallax();
        }

      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
