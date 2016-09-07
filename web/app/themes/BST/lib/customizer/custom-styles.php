<?php

/**
 * List of elements affected by color scheme changes
 */
function get_final_customizer_css_array () {
	return array(
		'bg' =>  array(
			'body' => 'background-color',
            '.background-wrapper' => 'background-color'
		),
		'post-bg' => array(
			'body:not(.single) .post' => 'background-color',
			'.single-content'   	  => 'background-color',
			'.header-container' 	  => 'background-color',
			'h5.widget-title'  	      => 'background-color',
            '.woocommerce div.product .woocommerce-tabs .panel' => 'background-color',
            '.mch-widget' => 'background-color'
		),
		'text' => array(
			'body'            => 'color',
			'h1'              => 'color',
			'h2'              => 'color',
			'h3'              => 'color',
			'h4'              => 'color',
			'h5'              => 'color',
			'.separator'      => 'color',
			'h5.widget-title' => 'color',
			'.master-title'   => 'color',
			'.nav-container'  => 'color',
		),
		'alt-text' => array(
			'.button.button-primary'                    => 'color',
			'.search-form .search-submit'               => 'color',
			'.footer-copy-container'                    => array('color', 'border-color'),
			'.navbar-toggle .icon-bar'                  => 'color',
			'.comment-form input[type=submit]' 			=> 'color',
			'.nav-next'                                 => 'color',
			'.nav-previous'                             => 'color',
			'.owl-theme .owl-controls .owl-page span'   => 'color',
			'.owl-theme .owl-controls .owl-buttons div' => 'color',
			'.calendar_wrap table tbody a'              => 'color',
			'.if-author'                                => 'color',
            '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button' => 'color'

		),
		'brand' => array(
			'a:not(.button):not(.button-primary)'       => array( 'color', 'border-color' ),
			'a:not(.button):not(.button-primary):hover' => array( 'color', 'border-color' ),
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
            '.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button' => 'background-color'
		)

	);
}
