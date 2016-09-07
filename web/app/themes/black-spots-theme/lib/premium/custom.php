<?php

use BlackSpots\Assets;

/**
 * Register customizer JS files
 */
function customize_preview_js() {
    wp_enqueue_script('bs/customizer', Assets\asset_path('scripts/customizer.js'), array('customize-preview'), BS_VERSION, true);
    wp_localize_script( 'bs/customizer', 'bsStyleList', get_final_customizer_css_array() );
}
add_action('customize_preview_init', 'customize_preview_js');
function customize_controls_js() {
    wp_enqueue_script('bs/customizer-control', Assets\asset_path('scripts/customizer-controls.js'), array('customize-controls'), BS_VERSION, true);
    wp_localize_script( 'bs/customizer-control', 'bsColorScheme', get_basic_color_schemes() );
}
add_action('customize_controls_enqueue_scripts', 'customize_controls_js');
