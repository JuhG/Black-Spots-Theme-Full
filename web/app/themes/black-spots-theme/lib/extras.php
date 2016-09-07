<?php

namespace BlackSpots\Extras;

use BlackSpots\Setup;

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
    if ( Setup\alternative_template() ) {
        $classes[] = 'sidebar-alternative';
    }
    if ( get_theme_mod('bs_sb_left') ) {
        $classes[] = 'sidebar-left';
    }
  } else {
    $classes[] = 'no-sidebar';
  }

  if ( get_header_image() ) {
    $classes[] = 'custom-header';
  }

  if ( $pos = get_theme_mod( 'header_position' ) ) {
    $classes[] = 'header-' . strtolower( $pos );
  }

  if ( $width = get_theme_mod( 'header_width' ) ) {
    $classes[] = 'header-' . strtolower( $width );
  }

  /**
   *
   */
  $colors = get_final_colors();
  if ( $colors['bg'] === $colors['post-bg'] ) {
    $classes[] = 'bg-no-diff';
  }

  /**
   * Parallax classes
   */
  if ( get_theme_mod( 'bs_header_parallax' ) ) {
    $classes[] = 'header-parallax';
    if ( get_theme_mod( 'bs_header_parallax_fade' ) ) {
        $classes[] = 'header-parallax-fade';
    }
  }

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

/**
 * Changing the date format to a twitterlike format
 */
function convert_to_time_ago( $date_function, $classes = array() ) {

  $datetime = call_user_func( $date_function, 'c', true );
  $title_date = call_user_func( $date_function, get_option('date_format') );
  $title_time = call_user_func( $date_function, get_option('time_format') );
  $title = $title_date . ' ' . $title_time;
  $timestamp = call_user_func( $date_function, 'U' );
  $class = implode( ' ', (array) $classes );
  $diff = human_time_diff( $timestamp, current_time( 'timestamp' ) );

  if ( strpos(get_locale(), 'en') !== false ) {
    $text = $diff . ' ago';
  } else {
    $text = $title_date;
  }

  return sprintf(
    '<time class="%s" datetime="%s" title="%s" itemprop="datePublished">%s</time>',
    $class, $datetime, $title, $text
  );
}
