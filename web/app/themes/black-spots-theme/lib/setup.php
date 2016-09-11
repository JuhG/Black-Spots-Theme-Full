<?php

namespace BlackSpots\Setup;

use BlackSpots\Assets;

/**
 * Theme setup
 */
function setup() {

    /**
     * Making it translation ready
     */
    load_theme_textdomain('black-spots-theme', get_template_directory() . '/languages');

    /**
     * Adding the necessary theme supports
     */
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
    // add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'woocommerce' );
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'black-spots-theme')
    ]);
    if ( ! isset( $content_width ) ) $content_width = 900;
    // add_theme_support( 'custom-background' );
    // add_theme_support( 'custom-logo', array(
    //     'height'      => 100,
    //     'width'       => 400,
    //     'flex-height' => true,
    //     'flex-width'  => true,
    //     'header-text' => array( 'site-title', 'site-description' ),
    // ));

    /**
     * Use the same styles in the editor too
     */
    add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {

    $before_widget = '<section class="widget %1$s %2$s">';
    $after_widget = '</section>';
    $before_title = '<h5 class="widget-title panel panel-default">';
    $after_title = '</h5>';

    register_sidebar([
        'name'          => __('Primary', 'black-spots-theme'),
        'id'            => 'sidebar-primary',
        'before_widget' => $before_widget,
        'after_widget'  => $after_widget,
        'before_title'  => $before_title,
        'after_title'   => $after_title
    ]);

    register_sidebar([
        'name'          => __('Alternative', 'black-spots-theme'),
        'id'            => 'sidebar-alternative',
        'before_widget' => $before_widget,
        'after_widget'  => $after_widget,
        'before_title'  => $before_title,
        'after_title'   => $after_title
    ]);

    register_sidebar([
        'name'          => __('Footer Left', 'black-spots-theme'),
        'id'            => 'sidebar-footer-left',
        'before_widget' => $before_widget,
        'after_widget'  => $after_widget,
        'before_title'  => $before_title,
        'after_title'   => $after_title
    ]);

    register_sidebar([
        'name'          => __('Footer Middle', 'black-spots-theme'),
        'id'            => 'sidebar-footer-middle',
        'before_widget' => $before_widget,
        'after_widget'  => $after_widget,
        'before_title'  => $before_title,
        'after_title'   => $after_title
    ]);

    register_sidebar([
        'name'          => __('Footer Right', 'black-spots-theme'),
        'id'            => 'sidebar-footer-right',
        'before_widget' => $before_widget,
        'after_widget'  => $after_widget,
        'before_title'  => $before_title,
        'after_title'   => $after_title
    ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {

    if ( !is_active_sidebar('sidebar-primary') ) return false;

    static $display;

    isset($display) || $display = !in_array(true, [
        // The sidebar will NOT be displayed if ANY of the following return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        // is_404(),
        sidebar_no_home(),
        is_page_template( 'template-no-sidebar.php' )
    ]);

    return apply_filters('bs/display_sidebar', $display);
}

/**
 *
 */
function alternative_template () {
    return is_page_template( 'template-alternative.php' );
}

/**
 *
 */
function sidebar_no_home () {
    return is_home() && get_theme_mod( 'bs_sb_no_home' );
}

/**
 *
 */
function show_sidebar_only_on_home ( $display ) {
    if ( get_theme_mod( 'bs_sb_only_home' ) ) {
        return is_home();
    }
    return $display;
}
add_filter('bs/display_sidebar', __NAMESPACE__ . '\\show_sidebar_only_on_home');

/**
 * Theme assets
 */
function assets() {
    wp_enqueue_style('bs/css', Assets\asset_path('styles/main.css'), array( 'dashicons' ), BS_VERSION);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('bs/jquery-throttle-debounce', Assets\asset_path('scripts/throttle-debounce.min.js'), ['jquery'], BS_VERSION, true);
    wp_enqueue_script('bs/js', Assets\asset_path('scripts/main.js'), ['jquery'], BS_VERSION, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 98);

/**
 * Adds additional styles to the login screen.
 */
function bs_login() {
    wp_enqueue_style( 'bs/login', Assets\asset_path('styles/login.css'), array(), BS_VERSION );
}
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\bs_login' );
