<?php
/**
 * Theme functions and definitions
 *
 * @package Theme
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
    $content_width = 640; /* pixels */

if ( ! function_exists( 'theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function theme_setup()
{

    /**
     * The admin bar is friggen' annoying, this removes it from the front-end
     * If you're a weirdo and like the bar, remove the below code.
     */
    add_filter('show_admin_bar', '__return_false');

    /**
     * Make theme available for translation
     * Translations can be filed in the /languages/ directory
     * If you're building a theme based on Theme, use a find and replace
     * to change 'wptheme' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'wptheme', get_template_directory() . '/languages' );

    /**
     * Add default posts and comments RSS feed links to head
     */
    add_theme_support( 'automatic-feed-links' );

    /**
     * Enable support for Post Thumbnails on posts and pages
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    /**
     * This theme uses wp_nav_menu() in one location.
     */
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'wptheme' ),
    ) );

    /**
     * Enable support for Post Formats
     */
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

    /**
     * Clean up junk and security issues from header
     *
     * Wordpress sometimes reveals far too much and adds
     * unneeded junk, this removes it. Remove anything you want.
     */
    remove_action( 'wp_head', 'rel_canonical' );
    remove_action( 'wp_head', 'index_rel_link' );
    remove_action( 'wp_head', 'start_post_rel_link' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'template_redirect', 'wp_shortlink_header' );
}
endif; // theme_setup
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function theme_widgets_init()
{
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'wptheme' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );
}
add_action( 'widgets_init', 'theme_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function theme_scripts()
{
    global $post;

    wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
    wp_enqueue_style( 'theme-mainstyle', get_template_directory_uri() . '/css/theme.css' );

    wp_enqueue_script( 'theme-modernizr', get_template_directory_uri() . '/js/libs/modernizr.js', array(), "2.7.1", false );

    wp_enqueue_script( 'response-js', get_template_directory_uri() . '/js/libs/response-0.7.12.min.js', array("jquery"), "0.7.12", true );
    wp_enqueue_script( 'theme-mainscript', get_template_directory_uri() . '/js/theme.js', array('jquery'), null, true );

    $post_id        = (isset($post->ID)) ? $post->ID : 0;
    $post_name  = (isset($post->post_name )) ? $post->post_name  : null;
    $post_author = (isset($post->post_author)) ? $post->post_author : 0;
    $post_type    = (isset($post->post_type)) ? $post->post_type : null;
    $post_status  = (isset($post->post_status )) ? $post->post_status  : null;
    $post_date     = (isset($post->post_date )) ? $post->post_date  : null;

    $localise_this_mate = array(
        'ajaxurl'          => admin_url( 'admin-ajax.php' ),
        'nonce'          => wp_create_nonce( 'theme-nonce' ),
        'post_id'        => $post_id,
        'post_name'  => $post_name,
        'post_author' => $post_author,
        'post_type'    => $post_type,
        'post_status' => $post_status,
        'post_date'    => $post_date,
    );

    // Localize script so we can make AJAX calls in Wordpress
    wp_localize_script( 'theme-mainscript', 'wptheme', $localise_this_mate);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Wordpress AJAX requests functionality
 */
require get_template_directory() . '/inc/ajax.php';

/**
 * An in-built API into the theme that spits out JSON without plugins.
 * Can I get a fuck yeah!?
 */
require get_template_directory() . '/inc/theme-api.php';

/**
 * Define custom post types in here cowboy/cowgirl
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Define custom taxonomies in here, head honcho!
 */
require get_template_directory() . '/inc/taxonomies.php';
