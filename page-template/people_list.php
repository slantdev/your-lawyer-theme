<?php
/**
 *
 * Template Name: Peoples List
 *
 * @package Genesis Sample
 * @author  Denish Patel
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

add_action( 'genesis_entry_content', 'slant_content' );

function slant_content() { ?>

	<?php gs_content_management(); ?>

<?php

}

// remove_action( 'genesis_entry_content', 'genesis_entry_content', 5 );
add_action( 'genesis_entry_content', 'yl_people_print' );
if (!function_exists('yl_people_print')) {
    function yl_people_print()
    {

		$subtitleAbout = get_field('our_team_sub_title');
		$descriptionAbout = get_field('our_team_description');

		$dropdownHtml = '<select name="people_select" class="people_select">';
		$dropdownHtml .= '<option value="0">Filter by</option>';
		$dropdownHtml .= '<option value="0">All</option>';
		$post_insight = get_terms( array(
			'taxonomy' => 'people_role',
			'hide_empty' => false,
		) );
		// wp_get_post_terms( (int)get_the_ID(), 'people_role', array( 'fields' => 'all' ) );
		if(!empty($post_insight)){
			foreach($post_insight as $single_term){
				$dropdownHtml .= sprintf('<option value="%s">%s</option>', $single_term->term_id, $single_term->name);
			}
		}
		$dropdownHtml .= '</select>';

		echo '
		<div class="cd-popup contact" role="alert">
			<div class="cd-popup-container" style="">
			 <div class="row">
				 <div class="col-lg-6 col-md-6 col-sm-6">
				 <div class="close_popup"></div>
				 <div class="people_popup_media_container">
					
				 </div>
				 </div>
				 <div class="col-lg-6 col-md-6 col-sm-6">
					<div class="people_popup_content_container">
						<div class="people_list__title"></div>
						<div class="people_list__cat"></div>
						<div class="people_list__description">&nbsp;</div>
					</div>
				 </div>
			 </div>
			</div>
		</div>';


		echo sprintf('
		<section class="people_header_background" style="background:url(%s)">
		<div class="container">
				<div class="row">
					<div class="title_wrapper">
						<div class="row">
							<div class="col-lg-12">
									<div class="sub_title">%s</div>
									
							</div>
							<div class="col-lg-12">
									<div class="row">
										<div class="col-lg-8">
											<h2 class="main_title">%s</h2>
										</div>
										<div class="col-lg-4 text-align-right">
											%s
										</div>
									</div>
							</div>
						</div>
					</div>
			</div>
		</div>
		</section>
		',get_stylesheet_directory_uri()."/assets/images/people_background.png",$subtitleAbout,$descriptionAbout,$dropdownHtml);

		$peopleHtml = get_peoplelist_content(12);
		
		echo $peopleHtml;

		echo '</div>';
		echo '</div>';
    }
}
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );


//remove side navigation
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
unregister_sidebar( 'sidebar' );



// Runs the Genesis loop.
genesis();