<?php

/**
 * Basic color schemes
 */
function bs_register_basic_color_scheme_customizer ( $wp_customize ) {

    /**
     * Registering the color scheme section in the customizer
     */
    $desc = __('Select your color scheme or build your own selecting the colors individually!', 'black-spots-theme');
    if ( ! BS_PREMIUM ) $desc = __('Select your color scheme! You can consider these as examples. In the premium version you can select all the colors individually.', 'black-spots-theme');
    $wp_customize->add_section( 'color-scheme-section', array(
        'title'       => __( 'Color Scheme', 'black-spots-theme' ),
        'priority'    => 30,
        'description' => $desc,
    ));

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
        'default'   => 'boxed-gold',
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
    $color_scheme = strtolower(get_theme_mod( 'color-scheme', 'boxed-gold' ));
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

            /**
             * In the admin we have to override the default styles,
             * because the inline styles are queued before them
             */
            if ( $admin ) {
                $css .= 'body#tinymce ';
                if ( 'body' === trim($selector) ) $selector = '';
            }

            $css .= $selector .'{';

            foreach ( (array)$style as $stylename ) {

                /**
                 * Modifiers
                 */
                $current_color = $colors[ $color ];
                if ( strpos($stylename, ':') ) {
                    $arr = explode(':', $stylename);
                    $stylename = $arr[0];
                    if ( 'rgba' === $arr[1] ) {
                        $current_color = hex2rgba( $current_color, $arr[2] );
                    }
                }

                $css .= $stylename .':'. $current_color .';';
            }

            $css .= '}';
        }
    }
    return $css;
}

function hex2rgba($color, $opacity = false) {

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if(empty($color))
          return $default;

    //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
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
