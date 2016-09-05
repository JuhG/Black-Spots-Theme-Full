<?php

use Roots\Sage\Assets;

/**
 * Add postMessage support to blogname
 */
function customize_register( $wp_customize ) {
  $wp_customize->get_setting('blogname')->transport = 'postMessage';
}
add_action('customize_register', 'customize_register');

/**
 * Register customizer JS files
 */
function customize_preview_js() {
	wp_enqueue_script('sage/customizer-basic', Assets\asset_path('scripts/customizer-basic.js'), array('customize-preview'), BS_VERSION, true);
}
add_action('customize_preview_init', 'customize_preview_js');

