<?php

function custom_header_more_functionality ($wp_customize) {
	$wp_customize->add_setting( 'header_position', array(
	    'default'        => 'static',
		'sanitize_callback' => 'esc_html',
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