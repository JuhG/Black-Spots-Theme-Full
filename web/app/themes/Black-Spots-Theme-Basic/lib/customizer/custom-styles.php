<?php

/**
 * List of elements affected by color scheme changes
 */
function get_final_customizer_css_array () {
	return array(
		'bg' =>  array(
			'body' => 'background-color'
		),
		'post-bg' => array(
			'body:not(.single) .post' => 'background-color',
			'.single-content'   	  => 'background-color',
			'.header-container' 	  => 'background-color',
			'h5.widget-title'  	      => 'background-color',
		),
		'text' => array(
			'body'            => 'color',
			'h1'              => 'color',
			'h2'              => 'color',
			'h3'              => 'color',
			'h4'              => 'color',
			'h5'              => 'color',
			'h1 a'            => 'color',
			'h2 a'            => 'color',
			'h3 a'            => 'color',
			'h4 a'            => 'color',
			'h5 a'            => 'color',
			'.separator'      => 'color',
			'h5.widget-title' => 'color',
			'.master-title'   => 'color',
			'.nav-container'  => 'color',
		),
		'alt-text' => array(
			'.button.button-primary'                    => 'color',
			'.search-form .search-submit'               => 'color',
			'.footer-copy-container'                    => 'color',
			'.navbar-toggle .icon-bar'                  => 'color',
			'.comment-form input[type=submit]' 			=> 'color',
			'.nav-next'                                 => 'color',
			'.nav-previous'                             => 'color',
			'.owl-theme .owl-controls .owl-page span'   => 'color',
			'.owl-theme .owl-controls .owl-buttons div' => 'color',
			'.calendar_wrap table tbody a'              => 'color',
			'.if-author'                                => 'color'
		),
		'brand' => array(
			'a'                                         => array( 'color', 'border-color' ),
			'a:hover'                           		=> array( 'color', 'border-color' ),
			'.button.button-secondary'                  => array( 'color', 'border-color' ),
			'.title-container'                          => 'border-color',
			'.button.button-primary'                    => 'background-color',
			'.search-form .search-submit'               => 'background-color',
			'.footer-copy-container'                    => 'background-color',
			'.navbar-toggle .icon-bar'                  => 'background-color',
			'.comment-form input[type=submit]' 			=> 'background-color',
			'.nav-next'                                 => 'background-color',
			'.nav-previous'                             => 'background-color',
			'.owl-theme .owl-controls .owl-page span'   => 'background-color',
			'.owl-theme .owl-controls .owl-buttons div' => 'background-color',
			'.calendar_wrap table tbody a'              => 'background-color',
			'.if-author'                                => 'background-color',
			'blockquote'                                => 'border-color',
			'hr'                                        => 'border-color',
		)

	);
}

/**
 * Some paddings are different, if the postBg and bg colors are different
 * We don't need this check in the editor, since there's no post liting there
 */
function check_if_bg_and_postbg_different ( $css ) {
	$colors = get_final_colors();
	if ( $colors['bg'] === $colors['post-bg'] ) {
		$css .= "body:not(.single) .post .entry-content {
			padding-left: 0;
			padding-right: 0;
			padding-top: 0;
		}
		body:not(.single) .post .entry-image {
			padding-bottom: 20px;
		}
		body.single .post .single-content {
			padding: 0;
		}
		body.single .post .single-content figure {
			margin-left: -5vw;
			margin-right: -5vw;
		}
		.owl-carousel {
			margin-left: -5vw;
			margin-right: -5vw;
		}";
	}
	return $css;
}