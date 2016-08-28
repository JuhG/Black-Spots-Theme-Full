jQuery(function($){

	var $list = $('.post-listing');

	// Next posts
	var $next = $('.nav-next');
	$list.prepend( $next );

	var $nav = $('.posts-navigation');
	var $button = $('.nav-previous');
	var $link = $button.find('a');

	if ( ! $button.length ) return;

	var page = get_page_number($link) || 2;
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
			$link.text( text )
			$list.append( data.html ).append( $nav );
			$('.type-post').addClass('post');
			page++;
			console.log(  bsloadmore.next_link );
			// document.getElementById("content").innerHTML = response.html;
			// document.title = response.pageTitle;
			window.history.pushState(null, null, $link.attr('href'));
			// window.location.href = data.next;
		});

	});

	function get_page_number ( $a ) {
		var href = $a.attr('href');
		var split = href.split('/');
		return split[ split.length - 2 ];
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