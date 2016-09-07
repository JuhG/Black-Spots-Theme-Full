<?php

use BlackSpots\Assets;

function bs_ajax_load_more() {
    check_ajax_referer( 'bs-load-more-nonce', 'nonce' );

    $args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
    $args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
    $args['paged'] = esc_attr( $_POST['page'] );
    $args['post_status'] = 'publish';
    ob_start();
    $loop = new WP_Query( $args );
    if( $loop->have_posts() ):
        while( $loop->have_posts() ):
            $loop->the_post();
            get_template_part('templates/content');
        endwhile;
    endif;
    wp_reset_postdata();
    $data = ob_get_clean();
    wp_send_json_success($data);
    wp_die();
}
add_action( 'wp_ajax_bs_ajax_load_more', 'bs_ajax_load_more' );
add_action( 'wp_ajax_nopriv_bs_ajax_load_more', 'bs_ajax_load_more' );

function bs_load_more_js() {
    global $wp_query;

    $args = array(
        'nonce'        => wp_create_nonce( 'bs-load-more-nonce' ),
        'url'          => admin_url( 'admin-ajax.php' ),
        'query'        => $wp_query->query,
        'loadingText'  => __('Loading', 'black-spots-theme'),
        'next_link'    => get_pagenum_link( 9999 ),
        'page'         => get_query_var('paged') ? get_query_var('paged') : 1
    );

    wp_enqueue_script( 'bs/load-more', Assets\asset_path('scripts/load-more.js'), array( 'jquery' ), BS_VERSION, true );
    wp_localize_script( 'bs/load-more', 'bsloadmore', $args );

}
add_action( 'wp_enqueue_scripts', 'bs_load_more_js' );
