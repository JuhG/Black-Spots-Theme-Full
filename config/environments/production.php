<?php
/** Production */
ini_set('display_errors', 0);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', false);
/** Disable all file modifications including updates and update notifications */

define( 'WP_CACHE', true );
define('WPCACHEHOME', $webroot_dir . '/app/plugins/wp-super-cache/');