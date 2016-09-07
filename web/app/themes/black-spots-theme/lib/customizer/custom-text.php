<?php

/**
 * Basic color schemes
 */
function bs_register_text_options ( $wp_customize ) {

    /**
     * Registering the text section in the customizer
     */
    $wp_customize->add_section( 'text-section', array(
        'title'       => __( 'Text', 'black-spots-theme' ),
        'priority'    => 61,
        'description' => ''
    ) );

    /**
     * Read more text
     */
    $wp_customize->add_setting( 'bs_read_more', array(
        'default'   => __('Continue', 'black-spots-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control( 'bs_read_more', array(
        'label'       => __('Read more Text', 'black-spots-theme'),
        'section'     => 'text-section',
        'type'        => 'text',
    ));

    /**
     * Footer text
     */
    $wp_customize->add_setting( 'bs_footer_text', array(
        'default'   => __('Change or remove this in the Customizer - Text section', 'black-spots-theme'),
        'sanitize_callback' => 'force_balance_tags',
    ));
    $wp_customize->add_control( 'bs_footer_text', array(
        'label'       => __('Footer Text', 'black-spots-theme'),
        'section'     => 'text-section',
        'type'        => 'textarea',
    ));
}
add_action('customize_register', 'bs_register_text_options');
