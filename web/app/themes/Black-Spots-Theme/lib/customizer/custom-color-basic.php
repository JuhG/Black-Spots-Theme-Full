<?php

/**
 * Basic color schemes
 */
function bs_register_basic_color_scheme_customizer ( $wp_customize ) {

    /**
     * Registering the color scheme section in the customizer
     */
    $wp_customize->add_section( 'color-scheme-section', array(
        'title'       => __( 'Color Scheme', 'black-spots-theme' ),
        'priority'    => 30,
        'description' => __('Select your color scheme or build your own selecting the colors individually', 'black-spots-theme'),
    ) );

    /**
     * Color scheme changing
     */
    $color_schemes = get_basic_color_schemes();
    $color_scheme_names = array();
    foreach ($color_schemes as $name => $details) {
        $color_scheme_names[ $name ] = $details[ 'name' ];
    }
    asort( $color_scheme_names );
    $wp_customize->add_setting( 'color-scheme', array(
        'default'   => 'default',
        'transport' => BS_PREMIUM ? 'postMessage' : 'refresh',
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'color-scheme', array(
        'label'       => __('Color scheme', 'black-spots-theme'),
        'section'     => 'color-scheme-section',
        'type'        => 'select',
        'choices'     => $color_scheme_names
    ));
}
add_action('customize_register', 'bs_register_basic_color_scheme_customizer');

/**
 *
 */
function get_color_scheme_colors () {
    $names = array(
        'text'     => array( 'name' => __( 'Normal Text Color', 'black-spots-theme' ) ),
        'alt-text' => array( 'name' => __( 'Alternative Text Color', 'black-spots-theme' ) ),
        'brand'    => array( 'name' => __( 'Link Color', 'black-spots-theme' ) ),
        'bg'       => array( 'name' => __( 'Background Color', 'black-spots-theme' ) ),
        'post-bg'  => array( 'name' => __( 'Content Background Color', 'black-spots-theme' ) )
    );
    $colors = get_basic_color_schemes();
    $color_scheme = strtolower(get_theme_mod( 'color-scheme', 'default' ));
    $result = array();
    foreach ($names as $name => $value) {
        $result[ $name ] = array_merge( $names[ $name ], $colors[ $color_scheme ][ 'colors' ][ $name ]);
    }
    return $result;
}

/**
 *
 */
function get_final_colors () {
    $color_scheme_colors = get_color_scheme_colors();

    if ( ! BS_PREMIUM ) return array(
        'text' => $color_scheme_colors['text']['color'],
        'alt-text' => $color_scheme_colors['alt-text']['color'],
        'brand' => $color_scheme_colors['brand']['color'],
        'bg' => $color_scheme_colors['bg']['color'],
        'post-bg' => $color_scheme_colors['post-bg']['color'],
    );

    $custom_colors = array(
        'text'     => get_theme_mod( 'text', $color_scheme_colors['text']['color'] ),
        'alt-text' => get_theme_mod( 'alt-text', $color_scheme_colors['alt-text']['color'] ),
        'brand'    => get_theme_mod( 'brand', $color_scheme_colors['brand']['color'] ),
        'bg'       => get_theme_mod( 'bg', $color_scheme_colors['bg']['color'] ),
        'post-bg'  => get_theme_mod( 'post-bg', $color_scheme_colors['post-bg']['color'] ),
    );

    return $custom_colors;
}

/**
 * Looping through the array of styles
 */
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

if ( ! BS_PREMIUM ) {
    /**
     * Adding the custom styles
     */
    function bs_add_customizer_css_basic() {
        $css = get_final_customizer_css();
        wp_add_inline_style( 'bs/css', $css );
    }
    add_action( 'wp_enqueue_scripts', 'bs_add_customizer_css_basic', 100 );

    /**
     * Adding the same styles to the ediror too
     */
    function bs_add_customizer_css_to_admin_basic ( $settings ) {
        $css = get_final_customizer_css( true );
        if ( ! isset( $settings['content_style'] ) ) $settings['content_style'] = '';
        $settings['content_style'] .= preg_replace( "/\r|\n/", "", $css );
        return $settings;
    }
    add_filter( 'tiny_mce_before_init', 'bs_add_customizer_css_to_admin_basic' );
}
