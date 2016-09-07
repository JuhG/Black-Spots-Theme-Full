<?php

/**
 *
 */
function custom_header_setup () {
    $defaults = array(
        'default-image'          => '',
        'width'                  => 1920,
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
        'default'        => 'boxed',
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'header_width', array(
        'label'    => __( 'Header Type', 'black-spots-theme' ),
        'section'  => 'header_image',
        'priority' => 0,
        'type'     => 'radio',
        'choices'    => array(
            'full'  => __( 'Full', 'black-spots-theme' ),
            'boxed' => __( 'Boxed', 'black-spots-theme' )
        ),
    ));
}
add_action('customize_register','bs_custom_header_width');
