<?php

function bs_add_styles_to_the_editor($buttons) {
    array_unshift($buttons, $buttons[0]);
    $buttons[1] = 'styleselect';
    return $buttons;
}
add_filter('mce_buttons_2', 'bs_add_styles_to_the_editor');

function bs_mce_toolbars( $settings ) {

    /**
     * Removing H1 and H6
     */
    $block_formats_arr = array(
        __( 'Paragraph', 'black-spots-theme' )    => 'p',
        __( 'Heading 2', 'black-spots-theme' )    => 'h2',
        __( 'Heading 3', 'black-spots-theme' )    => 'h3',
        __( 'Heading 4', 'black-spots-theme' )    => 'h4',
        __( 'Preformatted', 'black-spots-theme' ) => 'pre',
    );

    // Convert the array to strings
    $block_formats = array();
    foreach( $block_formats_arr as $title => $tag ) {
        $block_formats[] = "$title=$tag";
    }

    /**
     * Adding column and button styles
     */
    $style_formats = array(
        array(
            'title'   => __( 'Cite', 'black-spots-theme' ),
            'block'  => 'cite'
        ),
        array(
            'title'   => __( 'Two columns', 'black-spots-theme' ),
            'block'  => 'p',
            'classes' => 'columns-2'
        ),
        array(
            'title'   => __( 'Three columns', 'black-spots-theme' ),
            'block'  => 'p',
            'classes' => 'columns-3'
        ),
        array(
            'title' => __( 'Button Primary', 'black-spots-theme' ),
            'block' => 'div',
            'classes' => array( 'button', 'button-primary' )
        ),
        array(
            'title' => __( 'Button Secondary', 'black-spots-theme' ),
            'block' => 'div',
            'classes' => array( 'button', 'button-secondary' )
        ),
    );

    $settings = array_merge( $settings, array(
        'block_formats'       => implode( ';', $block_formats ),
        'style_formats'       => json_encode( $style_formats )
    ));

    return $settings;
}
add_filter( 'tiny_mce_before_init', 'bs_mce_toolbars' );
