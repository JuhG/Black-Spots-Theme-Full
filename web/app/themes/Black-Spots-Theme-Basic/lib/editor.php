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
        __( 'Paragraph', 'black_spots' )    => 'p',
        __( 'Heading 2', 'black_spots' )    => 'h2',
        __( 'Heading 3', 'black_spots' )    => 'h3',
        __( 'Heading 4', 'black_spots' )    => 'h4',
        __( 'Preformatted', 'black_spots' ) => 'pre',
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
            'title'   => __( 'Cite', 'black_spots' ),
            'block'  => 'cite'
        ),
        array(
            'title'   => __( 'Two columns', 'black_spots' ),
            'block'  => 'p',
            'classes' => 'columns-2'
        ),
        array(
            'title'   => __( 'Three columns', 'black_spots' ),
            'block'  => 'p',
            'classes' => 'columns-3'
        ),
        array(
            'title' => __( 'Button Primary', 'black_spots' ),
            'block' => 'div',
            'classes' => array( 'button', 'button-primary' )
        ),
        array(
            'title' => __( 'Button Secondary', 'black_spots' ),
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
