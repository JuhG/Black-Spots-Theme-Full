<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  } else {
    $classes[] = 'no-sidebar';
  }

  if ( get_header_image() ) {
    $classes[] = 'custom-header';
  }

  if ( $pos = get_theme_mod( 'header_position' ) ) {
    $classes[] = 'header-' . $pos;
  }

  // TODO: actual check
  // if ( get_theme_mod( 'header_parallax' ) ) {
    $classes[] = 'header-parallax';
    $classes[] = 'header-parallax-fade';
  // }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function SearchFilter($query) {
  if ($query->is_search) {
    $query->set('post_type', 'post');
  }
  return $query;
}
add_filter('pre_get_posts', __NAMESPACE__ . '\\SearchFilter');