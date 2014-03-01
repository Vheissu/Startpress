<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Theme
 */

/* Function code courtesy of Brian Cray: http://briancray.com/posts/estimated-reading-time-web-design/ */
function theme_average_reading_time()
{
    global $post;
    $content = $post->post_content;

    $word = str_word_count(strip_tags($content));
    $m = floor($word / 200);
    $s = floor($word % 200 / (200 / 60));
    $est = $m . ' minute' . ($m == 1 ? '' : 's') . ', ' . $s . ' second' . ($s == 1 ? '' : 's');

    return $est;
}

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function theme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'theme_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function theme_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'theme_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function theme_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'wptheme' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'theme_wp_title', 10, 2 );

/**
 * Allows SVG files to be uploaded via the Wordpress media uploader
 */
function cc_mime_types( $mimes )
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
