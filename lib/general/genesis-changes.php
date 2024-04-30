<?php
/**
 * Genesis Changes
 *
 * @package      YourLawyer
 * @author       Slant Agency
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Theme Supports
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-structural-wraps', array( 'header', 'menu-secondary', 'content-area', 'footer-widgets' ) );
add_theme_support( 'genesis-menus', array( 'primary' => 'Primary Navigation Menu', 'secondary' => 'Secondary Navigation Menu',
					'footer' => 'Footer Menu', 'copyrightbarmenu' => 'Copyright Menu' ) );
add_theme_support( 'genesis-footer-widgets', 3 );
add_theme_support(
    'genesis-custom-logo',
    [
        'height'      => 74,
        'width'       => 368,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array(),
    ]
);

// Adds support for accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
	//	'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
		'screen-reader-text',
	)
);



// h1 on home
add_filter( 'genesis_site_title_wrap', function( $wrap ) { return is_front_page() ? 'h1' : $wrap; } );

// Remove admin bar styling
add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

// Don't enqueue child theme stylesheet
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

// Remove Edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

// Remove Genesis Favicon (use site icon instead)
remove_action( 'wp_head', 'genesis_load_favicon' );

// Remove Header Description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Remove post info and meta
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

// Remove unused sidebars
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );

// Remove Taxonomy Archive Options
remove_action( 'admin_init', 'genesis_add_taxonomy_archive_options' );

// Remove Genesis SEO settings from post/page editor
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );

// Remove Genesis SEO settings option page
remove_theme_support( 'genesis-seo-settings-menu' );

// Remove Genesis SEO settings from taxonomy editor
remove_action( 'admin_init', 'genesis_add_taxonomy_seo_options' );

//* Remove all layouts from edit post/page screens
remove_theme_support( 'genesis-inpost-layouts' );

//* Remove Genesis in-post Scripts Settings
remove_action( 'admin_menu', 'genesis_add_inpost_scripts_box' );

remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_header', 'genesis_do_header' );

/**
 * Remove Genesis Templates
 *
 */
function gs_remove_genesis_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'gs_remove_genesis_templates' );

/**
 * Custom search form
 *
 */
// function gs_search_form() {
// 	ob_start();
// 	get_template_part( 'searchform' );
// 	return ob_get_clean();
// }
// add_filter( 'genesis_search_form', 'gs_search_form' );

/**
 * Disable customizer theme settings
 *
 */
function gs_disable_customizer_theme_settings( $config ) {
	$remove = [ 'genesis_header', 'genesis_single', 'genesis_archives', 'genesis_footer' ];
	foreach( $remove as $item ) {
		unset( $config['genesis']['sections'][ $item ] );
	}
	return $config;
}
add_filter( 'genesis_customizer_theme_settings_config', 'gs_disable_customizer_theme_settings' );
