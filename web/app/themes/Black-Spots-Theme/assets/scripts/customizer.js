// colorScheme is a global object

(function($, api) {

  // Site title
  api('blogname', function(value) {
    value.bind(function(to) {
      $('.brand').text(to);
    });
  });

  var current = {
  	bg: '',
  	postBg: '',
  	text: '',
  	altText: '',
  	brand: ''
  };

  api('bg', function(value) {
    value.bind(function(to) {
    	changeBg( to );
    });
  });
  api('post-bg', function(value) {
    value.bind(function(to) {
    	changePostBg( to );
    });
  });
  api('text', function(value) {
    value.bind(function(to) {
    	changeText( to );
    });
  });
  api('alt-text', function(value) {
    value.bind(function(to) {
    	changeAltText( to );
    });
  });
  api('brand', function(value) {
    value.bind(function(to) {
			changeBrand( to );
    });
  });

  function changeBg ( to ) {
			$('body').css('background-color', to);
			checkBgAndPostBg();
			current.bg = to;
  }

  function changePostBg ( to ) {
			$('body:not(.single) .post, .single-content, .comments').css('background-color', to);
			$('.header-container').css('background-color', to);
			$('h5.widget__title').css('background-color', to);
			checkBgAndPostBg();
			current.postBg = to;
  }

  function changeText ( to ) {
			$('body').css('color', to);
			$('h1, h2, h3, h4, h5, h1 a, h2 a, h3 a, h4 a, h5 a').css('color', to);
			$('.separator').css('color', to);
			$('h5.widget__title').css('color', to);
			current.text = to;
  }

  function changeAltText ( to ) {
    	$('.btn, .btn a, .search-form .search-submit').css('color', to);
    	$('.footer-copy-container').css('color', to);
    	current.altText = to;
  }

  function changeBrand ( to ) {
			$('a').css('color', to);
			$('.master-title a').css('color', to);
			$('.btn, .btn a, .search-form .search-submit').css('background-color', to);
			$('.navbar-toggle .icon-bar').css('background-color', to);
			$('.footer-copy-container').css('background-color', to);

			$('h1 a, h2 a, h3 a, h4 a, h5 a').css('color', current.text);
    	$('.btn, .btn a').css('color', current.altText);
			current.brand = to;
  }

	function checkBgAndPostBg () {
		var $el = $('body:not(.single) .post, .single-content');
		var bg = $('body').css('background-color');
		var postBg = $el.css('background-color');
		var $img = $el.find('.entry-image');
		if ( bg == postBg ) {
			$el.css('padding', 0);
			$img.css('margin-left', 0);
			$img.css('margin-right', 0);
		} else {
			$el.css('padding', 20)
			$img.css('margin-left', -20);
			$img.css('margin-right', -20);
		}
	}
})( jQuery, wp.customize );