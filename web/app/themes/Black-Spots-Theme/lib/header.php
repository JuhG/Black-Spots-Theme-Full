<?php

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


function custom_header_more_functionality ($wp_customize) {
	$wp_customize->add_setting( 'header_width', array(
	    'default'        => 'full',
	    // 'type'           => 'option',
	    // 'capability'     => 'edit_theme_options',
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
	$wp_customize->add_setting( 'header_position', array(
	    'default'        => 'static',
	    // 'type'           => 'option',
	    // 'capability'     => 'edit_theme_options',
	));
	$wp_customize->add_control( 'header_position', array(
		'label'    => __( 'Header Type', 'black_spots' ),
		'section'  => 'header_image',
		'settings' => 'header_position',
		'priority' => 0,
		'default'  => 'static',
		'type'     => 'radio',
		'choices'  => array(
			'static' => __( 'Static', 'black_spots' ),
			'Sticky' => __( 'Sticky', 'black_spots' )
		),
	));
}
add_action('customize_register','custom_header_more_functionality');

function header_type_add_customizer_css() {
	$type = get_theme_mod( 'header_width' );
	if ( $type !== 'full' ) return;
	$custom_css = "
		.header-image {
			width: 100%;
			padding: 0;
		}";
	wp_add_inline_style( 'sage/css', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'header_type_add_customizer_css', 100 );

function header_position_add_customizer_css() {
	$position = get_theme_mod( 'header_position' );
	if ( $position !== 'sticky' ) return;
	$custom_css = "
		.header-container {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
		}";
	wp_add_inline_style( 'sage/css', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'header_position_add_customizer_css', 100 );

// remove emojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );