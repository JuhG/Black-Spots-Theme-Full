<?php

function colorpalette_theme_customizer( $wp_customize ) {

	/**
	 * Reset button for color scheme changing
	 */
	$wp_customize->add_setting( 'color-scheme-reset', array(
		'default'   => false,
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_html',
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
			)) 
		);
	}
}
add_action('customize_register', 'colorpalette_theme_customizer');

/**
 * Adding the custom styles
 */
function colorpalette_add_customizer_css() {
	$css = get_final_customizer_css();
	$css = check_if_bg_and_postbg_different( $css );
	wp_add_inline_style( 'sage/css', $css );
}
add_action( 'wp_enqueue_scripts', 'colorpalette_add_customizer_css', 100 );

/**
 * Adding the same styles to the ediror too
 */
function colorpalette_add_customizer_css_to_admin ( $settings ) {
	$css = get_final_customizer_css( true );
	if ( ! isset( $settings['content_style'] ) ) $settings['content_style'] = '';
	$settings['content_style'] .= preg_replace( "/\r|\n/", "", $css );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'colorpalette_add_customizer_css_to_admin' );
