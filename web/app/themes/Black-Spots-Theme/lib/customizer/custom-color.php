<?php

function colorpalette_theme_customizer( $wp_customize ) {

	$wp_customize->add_section( 'color-scheme-section', array(
		'title'       => __( 'Color Scheme', 'black_spots' ),
		'priority'    => 30,
		'description' => __('Select your color scheme or build your own selecting the colors individually', 'black_spots'),
	) );

	/**
	 * Color scheme
	 */
	$wp_customize->add_setting( 'color-scheme', array(
		'default'   => 'default',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'color-scheme', array(
		'label'       => __('Color scheme', 'black_spots'),
		// 'description' => __('Choose this first! Changing this will overwrite the individual color choices!', 'black_spots'),
		'section'     => 'color-scheme-section',
		'type'        => 'select',
		'choices'     => array(
			'default' => __( 'Default', 'black_spots' ),
			'gold'    => __( 'Gold', 'black_spots' ),
			// 'red'     => __( 'Red', 'black_spots' ),
			// 'green'   => __( 'Green', 'black_spots' ),
			// 'gray'    => __( 'Gray', 'black_spots' ),
		),
	));
	$wp_customize->add_setting( 'color-scheme-reset', array(
		'default'   => false,
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'color-scheme-reset', array(
		'label'    => __('Reset colors on changing a scheme! If unchecked, it only changes the Default button\'s target color.','black_spots'),
		'section'  => 'color-scheme-section',
		'type'     => 'checkbox'
	));

	$color_scheme_colors = get_color_scheme_colors();
	/**
	 * Allowing to pick individual colors
	 */
	foreach ( $color_scheme_colors as $name => $details ) {
		$wp_customize->add_setting( $name, array(
			'default'           => $details[ 'color' ],
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage'
		));
		$wp_customize->add_control( 
			new WP_Customize_Color_Control( 
			$wp_customize,
			$name, 
			array(
				'label'   => $details[ 'name' ],
				'section' => 'color-scheme-section',
				'settings' => $name
			) ) 
		);
	}
}
add_action('customize_register', 'colorpalette_theme_customizer');

function get_every_color_schemes () {
	return array(
		'default' => array(
			'text'     => array( 'color' => '#333' ),
			'alt-text' => array( 'color' => '#fff' ),
			'brand'    => array( 'color' => '#111' ),
			'bg'       => array( 'color' => '#fff' ),
			'post-bg'  => array( 'color' => '#fff' )
		),
		'gold' => array(
			'text'     => array( 'color' => '#333' ),
			'alt-text' => array( 'color' => '#fff' ),
			'brand'    => array( 'color' => '#AB977A' ),
			'bg'       => array( 'color' => '#f7f7f7' ),
			'post-bg'  => array( 'color' => '#fff' )
		),
	);
}

function get_color_scheme_colors () {
	$names = array(
		'text'     => array( 'name' => __( 'Normal Text Color', 'black_spots' ) ),
		'alt-text' => array( 'name' => __( 'Alternative Text Color', 'black_spots' ) ),
		'brand'    => array( 'name' => __( 'Brand Color', 'black_spots' ) ),
		'bg'       => array( 'name' => __( 'Background Color', 'black_spots' ) ),
		'post-bg'  => array( 'name' => __( 'Post Background Color', 'black_spots' )	)
	);
	$colors = get_every_color_schemes();
	$color_scheme = strtolower(get_theme_mod( 'color-scheme', 'default' ));
	$result = array();
	foreach ($names as $name => $value) {
		$result[ $name ] = array_merge( $names[ $name ], $colors[ $color_scheme ][ $name ]);
	}
	return $result;
}

function get_final_colors () {
	$color_scheme_colors = get_color_scheme_colors();

	$custom_colors = array(
		'text'     => get_theme_mod( 'text' ),
		'alt-text' => get_theme_mod( 'alt-text' ),
		'brand'    => get_theme_mod( 'brand' ),
		'bg'       => get_theme_mod( 'bg' ),
		'post-bg'  => get_theme_mod( 'post-bg' )
	);

	return array_merge( $color_scheme_colors, $custom_colors );
}

function get_final_customizer_css_array () {
	return array(
		'bg' =>  array(
			'body' => 'background-color'
		),
		'post-bg' => array(
			'body:not(.single) .post' => 'background-color',
			// '.single-content'   	  => 'background-color',
			// '.comments'        		  => 'background-color',
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
			'.button.button-primary'                   => 'color',
			'.search-form .search-submit' => 'color',
			'.footer-copy-container'      => 'color',
			'.navbar-toggle .icon-bar'    => 'color',
			'.comment-form input[type=submit]' => 'color',
			'.nav-next'                   => 'color',
			'.nav-previous'               => 'color',
			'.owl-theme .owl-controls .owl-page span' => 'color',
			'.owl-theme .owl-controls .owl-buttons div' => 'color',
			'.calendar_wrap table tbody a' => 'color',
			'.if-author' => 'color'
		),
		'brand' => array(
			'a'                           => array( 'color', 'border-color' ),
			'a:hover'                           => array( 'color', 'border-color' ),
			'.button.button-secondary'          => array( 'color', 'border-color' ),
			'.title-container' => 'border-color',
			'.button.button-primary'                => 'background-color',
			'.search-form .search-submit' => 'background-color',
			'.footer-copy-container'      => 'background-color',
			'.navbar-toggle .icon-bar'    => 'background-color',
			'.comment-form input[type=submit]' => 'background-color',
			'.nav-next'                   => 'background-color',
			'.nav-previous'               => 'background-color',
			'.owl-theme .owl-controls .owl-page span' => 'background-color',
			'.owl-theme .owl-controls .owl-buttons div' => 'background-color',
			'.calendar_wrap table tbody a' => 'background-color',
			'.if-author' => 'background-color'
		)

	);
}

function get_final_customizer_css ( $admin = false ) {
	$colors = get_final_colors();
	$css_array = get_final_customizer_css_array();
	$css = '';
	foreach ($css_array as $color => $styles) {
		foreach ($styles as $selector => $style) {
			if ( $admin ) {
				$css .= 'body#tinymce ';
				if ( 'body' === trim($selector) ) $selector = '';
			}
			$css .= $selector .'{';
			foreach ( (array)$style as $stylename ) {
				$css .= $stylename .':'. $colors[ $color ] .';';
			}
			$css .= '}';
		}
	}
	return $css;
}

function colorpalette_add_customizer_css() {
	$css = get_final_customizer_css();
	$colors = get_final_colors();
	if ( $colors['bg'] === $colors['post-bg'] ) {
		$css .= "body:not(.single) .post {
			padding: 0;
		}
		body:not(.single) .post .entry-image {
			margin-left: 0;
			margin-right: 0;
		}";
	}
	wp_add_inline_style( 'sage/css', $css );
}
add_action( 'wp_enqueue_scripts', 'colorpalette_add_customizer_css', 100 );

function colorpalette_add_customizer_css_to_admin ( $settings ) {
	$css = get_final_customizer_css( true );
	if ( ! isset( $settings['content_style'] ) ) $settings['content_style'] = '';
	$settings['content_style'] .= preg_replace( "/\r|\n/", "", $css );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'colorpalette_add_customizer_css_to_admin' );