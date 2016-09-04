<?php

namespace Roots\Sage\Titles;

/**
 * Page titles
 */
function title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return false;
    }
  } elseif (is_archive()) {
    return get_the_archive_title();
  } elseif (is_search()) {
    return sprintf(__('Search<div class="separator"><div class="dashicons dashicons-arrow-right-alt2"></div></div>%s', 'black_spots'), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', 'black_spots');
  } else {
    return get_the_title();
  }
}

add_filter( 'get_the_archive_title', function ( $title ) {
  if ( false !== strpos($title, ':') ) {
    $arrow = '<div class="separator"><div class="dashicons dashicons-arrow-right-alt2"></div></div>';
    $from = '/'.preg_quote(': ', '/').'/';
    $title = preg_replace($from, $arrow, $title, 1);
    // $title = str_replace(': ', $arrow, $title);
  }
  return $title;
});