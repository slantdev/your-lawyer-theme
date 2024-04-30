<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')) :
	function chld_thm_cfg_locale_css($uri)
	{
		if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
			$uri = get_template_directory_uri() . '/rtl.css';
		return $uri;
	}
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

// END ENQUEUE PARENT ACTION

add_action('wp_enqueue_scripts', 'den_add_assets');
function den_add_assets()
{
	wp_enqueue_style('bootstrap-grid-css', get_stylesheet_directory_uri("") . '/assets/css/bootstrap-grid.min.css');

	wp_enqueue_style('fontawesome-css', get_stylesheet_directory_uri("") . '/assets/css/font-awesome.min.css');
	wp_enqueue_style('slick-css', get_stylesheet_directory_uri("") . '/lib/slick/slick.css');
	wp_enqueue_style('slick-theme-css', get_stylesheet_directory_uri("") . '/lib/slick/slick-theme.css');
	wp_enqueue_script('slick-theme-js', get_stylesheet_directory_uri("") . '/lib/slick/slick.min.js', array('jquery'), false, true);
	wp_enqueue_style('main-css', get_stylesheet_directory_uri("") . '/assets/css/main.css');

	wp_enqueue_script('main-theme-js', get_stylesheet_directory_uri("") . '/assets/js/main.js', array('jquery'), false, true);
	wp_localize_script(
		'main-theme-js',
		'userdata',
		array(
			'theme_uri' => get_stylesheet_directory_uri(),
			'ajax_url' => admin_url('admin-ajax.php'),
			'site_url' => site_url(),
		)
	);
}


add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');

add_action('widgets_init', 'den_register_sidebars');
function den_register_sidebars()
{
	/* Register the 'primary' sidebar. */
	register_sidebar(
		array(
			'id'            => 'blog_sidebar',
			'name'          => __('Blog Sidebar'),
			'description'   => __('Single blog post sidebar.'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	/* Repeat register_sidebar() code for additional sidebars. */
}

/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function gs_child_theme_setup()
{

	define('CHILD_THEME_VERSION', filemtime(get_stylesheet_directory() . '/assets/css/main.css'));

	// General cleanup
	include_once(get_stylesheet_directory() . '/lib/general/wordpress-cleanup.php');
	include_once(get_stylesheet_directory() . '/lib/general/genesis-changes.php');

	// Classes
	//include_once( get_stylesheet_directory() . '/lib/classes/menu-walker.php' );

	// Functions
	include_once(get_stylesheet_directory() . '/lib/functions/helper-functions.php');
	include_once(get_stylesheet_directory() . '/lib/functions/post-type.php');
	include_once(get_stylesheet_directory() . '/lib/functions/gs-functions.php');
	include_once(get_stylesheet_directory() . '/lib/functions/service-locator.php');

	// Plugins
	include_once(get_stylesheet_directory() . '/lib/plugins/acf.php');
	include_once(get_stylesheet_directory() . '/lib/plugins/duplicate-terms.php');

	// Shortcodes
	//include_once( get_stylesheet_directory() . '/lib/shortcodes/job-openings.php' );
	include_once(get_stylesheet_directory() . '/lib/shortcodes/services-megamenu.php');

	// Theme
	include_once(get_stylesheet_directory() . '/lib/structure/markup.php');
	include_once(get_stylesheet_directory() . '/lib/structure/layouts.php');
	include_once(get_stylesheet_directory() . '/lib/structure/header.php');
	include_once(get_stylesheet_directory() . '/lib/structure/navigation.php');
	//include_once( get_stylesheet_directory() . '/lib/structure/loop.php' );
	//include_once( get_stylesheet_directory() . '/lib/structure/template-tags.php' );
	include_once(get_stylesheet_directory() . '/lib/structure/footer.php');
	//include_once( get_stylesheet_directory() . '/lib/structure/site-footer.php' );
	include_once(get_stylesheet_directory() . '/lib/structure/content-blocks.php');
	include_once(get_stylesheet_directory() . '/lib/structure/page_renderer.php');


	// Image Sizes
	add_image_size('gs_featured', 600, 400, true);
}
add_action('genesis_setup', 'gs_child_theme_setup', 15);

if (function_exists('acf_add_options_page')) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Theme Header Settings',
	// 	'menu_title'	=> 'Header',
	// 	'parent_slug'	=> 'theme-general-settings',
	// ));

	// acf_add_options_sub_page(array(
	// 	'page_title' 	=> 'Theme Footer Settings',
	// 	'menu_title'	=> 'Footer',
	// 	'parent_slug'	=> 'theme-general-settings',
	// ));

}

function yl_create_book_tax_rewrite()
{
	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x('Insights', 'taxonomy general name', 'textdomain'),
		'singular_name'              => _x('Insight', 'taxonomy singular name', 'textdomain'),
		'search_items'               => __('Search Insights', 'textdomain'),
		'popular_items'              => __('Popular Insights', 'textdomain'),
		'all_items'                  => __('All Insights', 'textdomain'),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __('Edit Insight', 'textdomain'),
		'update_item'                => __('Update Insight', 'textdomain'),
		'add_new_item'               => __('Add New Insight', 'textdomain'),
		'new_item_name'              => __('New Insight Name', 'textdomain'),
		'separate_items_with_commas' => __('Separate Insights with commas', 'textdomain'),
		'add_or_remove_items'        => __('Add or remove Insights', 'textdomain'),
		'choose_from_most_used'      => __('Choose from the most used Insights', 'textdomain'),
		'not_found'                  => __('No Insights found.', 'textdomain'),
		'menu_name'                  => __('Insights', 'textdomain'),
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'public'                => true,
		'show_ui'               => true,
		'show_admin_column'     => true,
		// 'show_in_nav_menus'     => true,
		'query_var'             => 'insight',
		'rewrite'               => array('slug' => 'insight'),
	);
	register_taxonomy('insight', 'post', $args);
}
add_action('init', 'yl_create_book_tax_rewrite', 0);

add_action('wp_ajax_filter_insight_positions', 'den_ajax_filter_insight_positions');
add_action('wp_ajax_nopriv_filter_insight_positions', 'den_ajax_filter_insight_positions');

function den_ajax_filter_insight_positions()
{

	if (isset($_POST['insightid']) && is_numeric($_POST['insightid'])) {
		$insightid = $_POST['insightid'];
		$show_insight_only = true;
		$limit = 8;
		$term_new_ar = array(
			$insightid => $_POST['insighttext']
		);
		$testimonialSection = get_blog_grid_post_content($limit, $show_insight_only, $term_new_ar, true);
		echo $testimonialSection;
	}

	wp_die();
}

add_action('wp_ajax_filter_about_positions', 'den_ajax_filter_about_positions');
add_action('wp_ajax_nopriv_filter_about_positions', 'den_ajax_filter_about_positions');

function den_ajax_filter_about_positions()
{

	if (isset($_POST['positionID']) && is_numeric($_POST['positionID'])) {
		$positionID = $_POST['positionID'];
		$limit = 12;
		$peopleSection = get_peoplelist_content($limit, array($positionID));
		echo $peopleSection;
	}

	wp_die();
}

function get_peoplelist_content($limit = 12, $termID = array())
{

	$args = array(
		'post_type' => 'People',
		'order'   => 'ASC',
		'orderby' => 'title',
		'posts_per_page' => $limit,
		'ignore_custom_sort' => true, //bypass plugin parameter injections
	);

	if (!empty($termID) && $termID[0] != 0) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'people_role',
				'field'    => 'term_id',
				'terms'    => $termID,
			),
		);
	}

	$the_query = new WP_Query($args);

	// The Loop
	if ($the_query->have_posts()) {

		$serviceHtml = "";
		$serviceHtml .= '<div class="people_list__container_wraper">';
		$serviceHtml .= '<div class="people_list__container container">';

		$serviceHtml .= '<div class="people_list">';
		$serviceHtml .= '<div class="people_list__row row">';

		while ($the_query->have_posts()) {
			$the_query->the_post();
			$title = get_the_title();
			$feat_image = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
			if (!empty($feat_image))
				$feat_image = sprintf('<img src="%s" alt="%s" />', $feat_image, "Image of " . $title);

			$post_insight = wp_get_post_terms((int)get_the_ID(), 'people_role', array('fields' => 'names'));
			$position = '';
			$blogCat = '';

			if (!empty($post_insight)) {
				$insightArray = array();
				foreach ($post_insight as $c) {

					//list person details
					if (class_exists('WPSEO_Primary_Term')) { //use YOASTS primary checkbox for terms
						// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
						$wpseo_primary_term = new WPSEO_Primary_Term('people_role', get_the_id());
						$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
						$term = get_term($wpseo_primary_term);

						if (is_wp_error($term)) {

							// Default to first category (not Yoast) if an error is returned
							$category = get_the_terms(get_the_ID(), 'people_role')[0];

							$position = $category->name ?? '';
							$category_slug = $category->slug ?? '';
						} else {

							// Set variables for category_display & category_slug based on Primary Yoast Term
							$primary_term_id = $term->term_id;
							$category_term = get_category($primary_term_id);
							$position = $term->name;
							$category_slug = $term->slug;
						}
					} else {
						if ($c == 'Lawyer' || $c == 'Director' || $c == 'General Manager' || $c == 'Administrative Assistant') {
							if (!$position)
								$position .= $c;
							else
								$position .= ', ' . $c;
						}
						//  else {
						// 	$insightArray[] = '<div class = "people_list__cat__detail">'. $c . '</div>';
						// }
					}
					if (!$position) {
						$position = $c;
					}

					if ($c != $position) {
						$insightArray[] = '<div class = "people_list__cat__detail">' . $c . '</div>';
					}
				}
				$blogCat = join('', $insightArray);
			}

			$serviceHtml .= '<div class="col-lg-4 col-md-6">';
			$serviceHtml .= '<div class="people_list__inner">';
			$serviceHtml .= sprintf('<div class="people_list__media">%s</div>', $feat_image);
			$serviceHtml .= '<div class="people_list__content_wrapper" dataid="' . get_the_ID() . '">';
			$serviceHtml .= sprintf('<div class="people_list__title">%s</div>', get_the_title());
			$serviceHtml .= sprintf('<div class="people_list__position">%s</div>', $position);
			$serviceHtml .= sprintf('<div class="people_list__cat">%s</div>', $blogCat);
			$serviceHtml .= sprintf('<div class="people_list__icon">&nbsp;</div>', $blogCat);
			$serviceHtml .= sprintf('<div class="people_list__description">%s</div>', get_the_content());
			$serviceHtml .= '</div>';
			$serviceHtml .= '</div>';
			$serviceHtml .= '</div>';
		}
		$serviceHtml .= '</div>';
		$serviceHtml .= '</div>';
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();

	return $serviceHtml;
}

function get_form_shortcode()
{
	$service_shortcode  = trim(get_field('service_form_shortcode', 'option'));
	return do_shortcode($service_shortcode);
}

function yl_admin_enqueues($hook)
{

	global $pagenow;

	if (($pagenow == 'post.php')  || ($pagenow == 'post-new.php') || ($pagenow == 'term.php') || ($pagenow == 'edit-tags.php') || ($pagenow == 'edit.php')) {
		wp_enqueue_style('admin-bootstrap-grid-css', get_stylesheet_directory_uri("") . '/assets/css/bootstrap-grid.min.css');
		wp_enqueue_style('admin_gs', get_stylesheet_directory_uri() . '/assets/css/admin.css', array(), filemtime(get_stylesheet_directory() . '/assets/css/admin.css'));
	}
}
add_action('admin_enqueue_scripts', 'yl_admin_enqueues');
