<?php

// function black_spots_gallery_style ( $x ) {
	// return $x . ' alma';
// }
// add_filter('gallery_style', 'black_spots_gallery_style');

function my_gallery_shortcode( $output = '', $atts, $instance ) {
	$return = $output; // fallback

	// retrieve content of your own gallery function
	// $my_result = get_my_gallery_content( $atts );

	// boolean false = empty, see http://php.net/empty
	// if( !empty( $my_result ) ) {
		// $return = $my_result;
	// }

	return $return;
}

add_filter( 'post_gallery', 'my_gallery_shortcode', 10, 3 );