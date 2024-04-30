<?php
/**
 *
 * Template Name: ACF Content Blocks
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_filter( 'body_class', 'genesis_sample_landing_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_sample_landing_body_class( $classes ) {

	$classes[] = '';
	return $classes;

}

// Removes Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

add_action( 'wp_enqueue_scripts', 'genesis_sample_dequeue_skip_links' );
/**
 * Dequeues Skip Links Script.
 *
 * @since 1.0.0
 */
function genesis_sample_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

/* Add ACF Page Header */
//add_action( 'genesis_before_loop', 'gs_page_header' );

// Removes site header elements.
//remove_action( 'genesis_header', 'genesis_do_header' );

// Removes navigation.
//remove_theme_support( 'genesis-menus' );

// Removes div.site-inner's div.wrap
add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );

// Removes site footer elements.
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
remove_action( 'genesis_entry_content', 'genesis_entry_content', 5 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_before_entry_content', 'slant_before_content' );

//remove side navigation
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
unregister_sidebar( 'sidebar' );

function slant_before_content() { ?>

<?php }

add_action( 'genesis_entry_content', 'slant_content' );

function slant_content() { ?>

	<?php gs_content_management(); ?>

<?php

}

// Runs the Genesis loop.
genesis();