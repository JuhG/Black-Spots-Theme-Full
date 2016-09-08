<?php

function custom_header_more_functionality ($wp_customize) {

    /**
     * Header Position - absulute or fixed
     */
    $wp_customize->add_setting( 'header_position', array(
        'default'        => 'static',
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'header_position', array(
        'label'    => __( 'Header Type', 'black-spots-theme' ),
        'section'  => 'header_image',
        'priority' => 0,
        'type'     => 'radio',
        'choices'  => array(
            'static' => __( 'Static', 'black-spots-theme' ),
            'Sticky' => __( 'Sticky', 'black-spots-theme' )
        ),
    ));

    /**
     * Parallax
     */
    $wp_customize->add_setting( 'bs_header_parallax', array(
        'default'   => false,
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'bs_header_parallax', array(
        'label'       => __('Parallax Header', 'black-spots-theme'),
        'section'  => 'header_image',
        'priority' => 0,
        'type'        => 'checkbox',
    ));

    function bs_is_header_parallax () {
        return get_theme_mod( 'bs_header_parallax' );
    }

    /**
     * Parallax Fade-out
     */
    $wp_customize->add_setting( 'bs_header_parallax_fade', array(
        'default'   => false,
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'bs_header_parallax_fade', array(
        'label'       => __('Fade-out Header on Scroll', 'black-spots-theme'),
        'section'  => 'header_image',
        'priority' => 0,
        'type'        => 'checkbox',
        'active_callback' => 'bs_is_header_parallax'
    ));

    /**
     * Header Only Home
     */
    $wp_customize->add_setting( 'header_only_home', array(
        'default'        => false,
        'sanitize_callback' => 'esc_html',
    ));
    $wp_customize->add_control( 'header_only_home', array(
        'label'    => __( 'Use this image only on the front page', 'black-spots-theme' ),
        'section'  => 'header_image',
        'priority' => 0,
        'type'     => 'checkbox'
    ));
}
add_action('customize_register','custom_header_more_functionality');
