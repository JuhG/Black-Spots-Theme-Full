jQuery(function($){

	var $list = $('.post-listing');

	// Next posts
	var $next = $('.nav-next');
	$list.prepend( $next );

	var $nav = $('.posts-navigation');
	var $button = $('.nav-previous');
	var $link = $button.find('a');

	if ( ! $button.length ) return;

	var page = parseInt(bsloadmore.page) + 1;
	var cache_version = page;
	var loading = false;
	var cached = false;
	var text = $link.text();
	var loadingText = bsloadmore.loadingText;

	var next_page = '';

	var data = {
		action: 'bs_ajax_load_more',
		nonce: bsloadmore.nonce,
		page: page,
		query: bsloadmore.query
	};

	$(window).load(function () {
		setTimeout( function () {
			cache_next_page();
		}, 1000);
	});

	$button.click(function (e) {
		e.preventDefault();
		if ( loading ) return;
		loading = true;
		$link.text( loadingText );

		get_next_page(function ( data ) {
			$list.append( data ).append( $nav );
			$('.type-post').addClass('post');
			window.history.pushState( null, null, get_next_url( page ) );
			page++;
			$link.text( text ).attr( 'href', get_next_url( page ) )
		});

	});

	function get_next_url ( p ) {
		return bsloadmore.next_link.replace( '9999', p );
	}

	function get_next_page ( cb ) {

		if ( cached && cache_version == page ) {
			cb( next_page );
			cached = false;
			loading = false;
			cache_next_page();
			return;
		}

		data.page = page;
		$.post(bsloadmore.url, data, function(res) {
			if( res.success) {
				cb( res.data );
				loading = false;
			} else {
				cb('');
				// console.log(res);
			}
		}).fail(function(xhr, textStatus, e) {
			cb('');
			// console.log(xhr.responseText);
		});
	}

	function cache_next_page () {
		cache_version = page;
		get_next_page(function ( data ) {
			if ( data ) {
				next_page = data;
				cached = true;
			} else {
				$button.remove();
			}
		});
	}

});