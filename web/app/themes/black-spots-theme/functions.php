<?php

/**
 * Theme constants
 */
define( 'BS_VERSION', '0.6.1' );
define( 'BS_PREMIUM', true );

$theme_includes = [
  'lib/assets.php',
  'lib/data/color-schemes.php',
  'lib/customizer/custom-basic.php',
  'lib/customizer/custom-header-basic.php',
  'lib/customizer/custom-styles.php',
  'lib/customizer/custom-color-basic.php',
  'lib/customizer/custom-text.php',
  'lib/extras.php',     // Custom functions
  'lib/setup.php',      // Theme setup
  'lib/titles.php',     // Page titles
  'lib/wrapper.php',    // Theme wrapper class
  'lib/image.php',
  'lib/comment.php',
  'lib/load-more.php',
  'lib/editor.php',
  'lib/ext/wp_bootstrap_navwalker.php'
];

if ( BS_PREMIUM ) {
    $theme_includes[] = 'lib/premium/custom.php';
    $theme_includes[] = 'lib/premium/custom-color.php';
    $theme_includes[] = 'lib/premium/custom-header.php';
    $theme_includes[] = 'lib/premium/custom-sidebar.php';
}

if ( get_option( 'bs_demo' ) ) {
    $theme_includes[] = 'lib/demo.php';
}

foreach ($theme_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'black-spots-theme'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

// remove emojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
