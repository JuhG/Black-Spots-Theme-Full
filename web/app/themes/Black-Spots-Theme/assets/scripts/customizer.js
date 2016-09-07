// bsStyleList is a global object

(function($, api) {


    $.each(bsStyleList, function ( type, styles ) {
        api(type, function (value) {
            value.bind(function (to) {
                $.each(styles, function ( selector, attrs ) {
                    var arr = [];
                    if ( ! $.isArray( attrs ) ) {
                        arr.push( attrs );
                    } else arr = attrs;
                    arr.forEach(function ( attr ) {
                        $(selector).css(attr, to);
                    });
                });
                if ( type === 'bg' || type === 'post-bg' ) {
                    checkBgAndPostBg();
                }
            });
        });
    });

	function checkBgAndPostBg () {
		var $el = $('body:not(.single) .post, .single-content');
		var bg = $('body').css('background-color');
		var postBg = $el.css('background-color');
		var $img = $el.find('.entry-image');
		if ( bg == postBg ) {
            $('body').addClass( 'bg-no-diff' );
		} else {
            $('body').removeClass( 'bg-no-diff' );
        }
	}

})( jQuery, wp.customize );
