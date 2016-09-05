<?php

/**
 * Theme constants
 */
define( 'BS_VERSION', 0.2 );
define( 'BS_PREMIUM', false );

/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',
  'lib/demo/basic.php',
  'lib/data/color-schemes.php',
  'lib/customizer/custom-basic.php',
  'lib/customizer/custom-header-basic.php',
  'lib/customizer/custom-styles.php',
  'lib/customizer/custom-color-basic.php',
  // 'lib/premium/custom.php',
  // 'lib/premium/custom-color.php',
  // 'lib/premium/custom-header.php',
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

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'black_spots'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

// remove emojis
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );