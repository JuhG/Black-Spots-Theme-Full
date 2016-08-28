<?php

namespace Roots\Sage\Customizer;

use Roots\Sage\Assets;

/**
 * Add postMessage support
 */
function customize_register($wp_customize) {
  $wp_customize->get_setting('blogname')->transport = 'postMessage';
}
add_action('customize_register', __NAMESPACE__ . '\\customize_register');

/**
 * Customizer JS
 */
function customize_preview_js() {
	wp_enqueue_script('sage/customizer', Assets\asset_path('scripts/customizer.js'), array('customize-preview'), BS_VERSION, true);
	wp_localize_script( 'sage/customizer', 'colorScheme', get_every_color_schemes() );
}
add_action('customize_preview_init', __NAMESPACE__ . '\\customize_preview_js');

function customize_controls_js() {
	wp_enqueue_script('sage/customizer-control', Assets\asset_path('scripts/customizer-controls.js'), array('customize-controls'), BS_VERSION, true);
	wp_localize_script( 'sage/customizer-control', 'colorScheme', get_every_color_schemes() );
}
add_action('customize_controls_enqueue_scripts', __NAMESPACE__ . '\\customize_controls_js');
