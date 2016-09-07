<?php

/**
 * Basic color schemes
 */
function bs_register_sidebar_options ( $wp_customize ) {

    /**
     * Registering the sidebar section in the customizer
     */
    $wp_customize->add_section( 'sidebar-section', array(
        'title'       => __( 'Sidebar', 'black-spots-theme' ),
        'priority'    => 60,
    ) );

    /**
     * Sidebar on the left side
     */
    $wp_customize->add_setting( 'bs_sb_left', array(
        'default'   => false,
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'bs_sb_left', array(
        'label'       => __('Sidebar on the Left', 'black-spots-theme'),
        'section'     => 'sidebar-section',
        'type'        => 'checkbox',
    ));

    /**
     * Sidebar variants
     */
    $wp_customize->add_setting( 'bs_sb_no_home', array(
        'default'   => false,
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'bs_sb_no_home', array(
        'label'       => __('No Sidebar on the Homepage', 'black-spots-theme'),
        'section'     => 'sidebar-section',
        'type'        => 'checkbox',
    ));

    /**
     * Sidebar variants
     */
    $wp_customize->add_setting( 'bs_sb_only_home', array(
        'default'   => false,
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'bs_sb_only_home', array(
        'label'       => __('Sidebar only on the Homepage', 'black-spots-theme'),
        'section'     => 'sidebar-section',
        'type'        => 'checkbox',
    ));
}
add_action('customize_register', 'bs_register_sidebar_options');
