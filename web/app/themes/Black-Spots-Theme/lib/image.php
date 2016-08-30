<?php

namespace Roots\Sage\Image;

/**
 * Adding custom image sizes
 */
add_image_size( 'content_with_sidebar', 750, 9999 );
add_image_size( 'content_without_sidebar', 1190, 9999 );
add_image_size( 'full_screen', 1920, 9999 );
add_image_size( 'icon', 30, 30 );

function add_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
		'content_with_sidebar'    => __( 'Content with Sidebar', 'black_spots' ),
		'content_without_sidebar' => __( 'Content without Sidebar', 'black_spots' ),
		'full_screen'             => __( 'Full Screen', 'black_spots' ),
		'max_widget_width'        => __( 'Widget Width', 'black_spots' ),
    ));
}
add_filter( 'image_size_names_choose', __NAMESPACE__ . '\\add_custom_sizes' );

/**
 * Inside the loop getting any image
 * If the post has a thumbnail, we return that
 * Else we search for an image in the cotent
 */
function get ( $size = 'content_without_sidebar' ) {
	$img = '';
	$image = array(
		'id'    => 0,
		'src'   => '',
		'alt'   => '',
		'title' => ''
	);

	global $post, $posts;
	ob_start();
	ob_end_clean();

	if (has_post_thumbnail()) {
		$image['id'] = get_post_thumbnail_id();
	} else {
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', apply_filters('the_content', $post->post_content), $src_matches);

		if ( ! $output ) return false;

		$image['src'] = $src_matches [1] [0];
		$image['id'] = get_image_id_by_url( $image['src'] );
	}

	if ( $image['id'] ) {
		$img = wp_get_attachment_image( $image['id'], $size );
		return $img;
	}

	if ( preg_match_all('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $alt_matches) ) {
		$image['alt'] = $alt_matches [1] [0];
	}
	if ( preg_match_all('/<img.+title=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $title_matches) ) {
		$image['title'] = $title_matches [1] [0];
	}

	$img =
		'<img'.
		' src="'.   $image['src']   .'"'.
		' alt="'.   $image['alt']   .'"'.
		' title="'. $image['title'] .'"'.
		'>';

	return $img;
}

// retrieves the attachment ID from the file URL
function get_image_id_by_url ( $url ) {
	global $wpdb;
	$id = 0;

	/**
	 * Trying to get the id
	 */
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));

	/**
	 * We're talking about a resized image
	 */
	if ( ! count( $attachment ) ) {

		$arr  = explode( '-', $url );
		$last = array_pop( $arr );
		$safe = implode( '-', $arr);
		
		$arr  = explode( '.', $last );
		$ext  = array_pop( $arr );

		$original = $safe . '.' . $ext;

		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $original ));
	}

	if ( count( $attachment ) ) $id = $attachment[0];

    return $id; 
}

/**
 * Modifying the optional Image widget's image size to get a faster loading time
 * The point of doing this is the presentational purposes of the theme
 * May add more like this on request in the future
 */
function resize_image_in_image_widget ( $size ) {
	return 'content_with_sidebar';
}
add_filter( 'image_widget_image_size', __NAMESPACE__ . '\\resize_image_in_image_widget');

/**
 * Adding Fluidbox support to all images added to the editor
 */
update_option('image_default_link_type', 'file' );
function add_native_fluidbox_support($classes) {
	return $classes .' fluidbox';
}
add_filter('get_image_tag_class', __NAMESPACE__ . '\\add_native_fluidbox_support');

// Adding figure tag around images without caption
function html_5_image_embed ( $html, $id, $caption, $title, $align, $url, $size, $alt ) {
    if( current_theme_supports( 'html5' )  && ! $caption )
		$atts = 'id="attachment_'. $id .'" class="wp-caption align'. $align .'"';
        $html = sprintf( '<figure %s>%s</figure>', $atts, $html );

    return $html;
}
add_filter( 'image_send_to_editor', __NAMESPACE__ . '\\html_5_image_embed', 10, 8 );

// Allow SVG
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', __NAMESPACE__ . '\\cc_mime_types');