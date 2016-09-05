<?php

/**
 * 
 */
function custom_header_setup () {
	$defaults = array(
		'default-image'          => '',
		'width'					 => 1920,
		'flex-height'            => true,
		'flex-width'             => true,
		'header-text'            => false,
	);
	add_theme_support( 'custom-header', $defaults );
}
add_action( 'after_setup_theme', 'custom_header_setup');

/**
 * 
 */
function bs_custom_header_width ($wp_customize) {
	$wp_customize->add_setting( 'header_width', array(
	    'default'        => 'full',
		'sanitize_callback' => 'esc_html',
	));
	$wp_customize->add_control( 'header_width', array(
		'label'    => __( 'Header Type', 'black_spots' ),
		'section'  => 'header_image',
		'settings' => 'header_width',
		'priority' => 0,
		'default'  => 'full',
		'type'     => 'radio',
		'choices'    => array(
			'full'  => __( 'Full', 'black_spots' ),
			'boxed' => __( 'Boxed', 'black_spots' )
		),
	));
}
add_action('customize_register','bs_custom_header_width');

/**
 * 
 */
function header_type_add_customizer_css() {
	$type = get_theme_mod( 'header_width' );
	if ( $type !== 'full' ) return;
	$custom_css = "
		.header-image, .header-container {
			width: 100%;
		}";
	wp_add_inline_style( 'sage/css', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'header_type_add_customizer_css', 100 );