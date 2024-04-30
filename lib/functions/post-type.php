<?php
/**
 * GS Post Type
 *
 * @package      YourLawyer
 * @author       Slant Agency
 * @since        1.0.0
 * @license      GPL-2.0+
**/

/**
 * Services CPT
 */
add_action( 'init', 'gs_cpt_services', 0 );
function gs_cpt_services() {
    $labels = array(
        'name' 				    => 'Services',
        'singular_name'         => 'Services',
        'menu_name'             => 'Services',
        'add_new' 			    => 'Add Services',
        'add_new_item'		    => 'Add New Services',
        'edit' 				    => 'Edit',
        'edit_item'             => 'Edit Services',
        'new_item' 			    => 'New Services',
        'view' 				    => 'View Services',
        'view_item'             => 'View Services',
        'search_items'          => 'Search Services',
        'not_found' 			=> 'No Services Found',
        'not_found_in_trash' 	=> 'No Services Found in Trash',
        'parent' 				=> 'Parent Services',
    );
    $args = array(
        'label' 			=> 'Services',
        'description' 		=> '',
        'labels'			=> $labels,
        'public'			=> true,
        'show_ui' 			=> true,
        'show_in_menu' 		=> true,
        'capability_type' 	=> 'post',
        'map_meta_cap' 		=> true,
        'hierarchical'		=> false,
        'has_archive' 		=> false,
        'rewrite' 			=> array('slug' => 'services', 'with_front' => true),
        'query_var' 		=> true,
        'menu_position' 	=> '5',
        'menu_icon' 		=> 'dashicons-star-filled',
        'supports' 			=> array('title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'author'),
    );
    register_post_type( 'services', $args );
}

/**
 * Services CPT
 */
add_action( 'init', 'gs_cpt_testimonial', 0 );
function gs_cpt_testimonial() {
    $labels = array(
        'name' 				    => 'Testimonials',
        'singular_name'         => 'Testimonial',
        'menu_name'             => 'Testimonials',
        'add_new' 			    => 'Add Testimonials',
        'add_new_item'		    => 'Add New Testimonial',
        'edit' 				    => 'Edit',
        'edit_item'             => 'Edit Testimonials',
        'new_item' 			    => 'New Testimonials',
        'view' 				    => 'View Testimonials',
        'view_item'             => 'View Testimonials',
        'search_items'          => 'Search Testimonials',
        'not_found' 			=> 'No Testimonials Found',
        'not_found_in_trash' 	=> 'No Testimonials Found in Trash',
        'parent' 				=> 'Parent Testimonials',
    );
    $args = array(
        'label' 			=> 'Testimonials',
        'description' 		=> '',
        'labels'			=> $labels,
        'public'			=> true,
        'show_ui' 			=> true,
        'show_in_menu' 		=> true,
        'capability_type' 	=> 'post',
        'map_meta_cap' 		=> true,
        'hierarchical'		=> false,
        'has_archive' 		=> false,
        'rewrite' 			=> array('slug' => 'testimonials', 'with_front' => false),
        'query_var' 		=> true,
        'menu_position' 	=> '5',
        'menu_icon' 		=> 'dashicons-star-filled',
        'supports' 			=> array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
    );
    register_post_type( 'testimonial', $args );
}


/**
 * Services Taxonomies
 */
add_action( 'init', 'gs_services_taxonomies' );
function gs_services_taxonomies() {
    $taxonomies = array(
        array(
            'slug'         => 'service_category',
            'single_name'  => 'Service Category',
            'plural_name'  => 'Service Category',
            'post_type'    => 'services',
            'rewrite'      => array( 'slug' => 'services' ),
            'hierarchical' => true,
        ),
        array(
            'slug'         => 'service_tag',
            'single_name'  => 'Service Tag',
            'plural_name'  => 'Service Tag',
            'post_type'    => 'services',
            'rewrite'      => array( 'slug' => 'service-tag' ),
            'hierarchical' => false,
        )
    );
    foreach( $taxonomies as $taxonomy ) {
        $labels = array(
            'name'                  => $taxonomy['plural_name'],
            'singular_name'         => $taxonomy['single_name'],
            'search_items'          => 'Search ' . $taxonomy['plural_name'],
            'all_items'             => 'All ' . $taxonomy['plural_name'],
            'parent_item'           => 'Parent ' . $taxonomy['single_name'],
            'parent_item_colon'     => 'Parent ' . $taxonomy['single_name'] . ':',
            'edit_item'             => 'Edit ' . $taxonomy['single_name'],
            'update_item'           => 'Update ' . $taxonomy['single_name'],
            'add_new_item'          => 'Add New ' . $taxonomy['single_name'],
            'new_item_name'         => 'New ' . $taxonomy['single_name'],
            'view_item'             => 'View ' . $taxonomy['single_name'],
            'menu_name'             => $taxonomy['plural_name'],
            'not_found'             => 'No ' . $taxonomy['plural_name'] . ' Found',
        );

        $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
        $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

        register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
            'labels'                => $labels,
            'hierarchical'          => $taxonomy['hierarchical'],
            'public'                => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'show_in_nav_menus'     => true,
            'show_tagcloud'         => false,
            'query_var'             => $taxonomy['slug'],
            'rewrite'               => $rewrite,
        ));
    }

}

// /**
//  * Service Provider CPT
//  */
// add_action( 'init', 'gs_cpt_service_provider', 0 );
// function gs_cpt_service_provider() {
//     $labels = array(
//         'name' 				    => 'Service Provider',
//         'singular_name'         => 'Service Provider',
//         'menu_name'             => 'Service Provider',
//         'add_new' 			    => 'Add Service Provider',
//         'add_new_item'		    => 'Add New Service Provider',
//         'edit' 				    => 'Edit',
//         'edit_item'             => 'Edit Service Provider',
//         'new_item' 			    => 'New Service Provider',
//         'view' 				    => 'View Service Provider',
//         'view_item'             => 'View Service Provider',
//         'search_items'          => 'Search Service Provider',
//         'not_found' 			=> 'No Service Provider Found',
//         'not_found_in_trash' 	=> 'No Service Provider Found in Trash',
//         'parent' 				=> 'Parent Service Provider',
//     );
//     $args = array(
//         'label' 			=> 'Service Provider',
//         'description' 		=> '',
//         'labels'			=> $labels,
//         'public'			=> true,
//         'show_ui' 			=> true,
//         'show_in_menu' 		=> true,
//         'capability_type' 	=> 'post',
//         'map_meta_cap' 		=> true,
//         'hierarchical'		=> false,
//         'has_archive' 		=> true,
//         'rewrite' 			=> array('slug' => 'service-provider', 'with_front' => true),
//         'query_var' 		=> true,
//         'menu_position' 	=> '5',
//         'menu_icon' 		=> 'dashicons-location',
//         'show_in_rest'      => true,
//         'supports' 			=> array('title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'author'),
//     );
//     register_post_type( 'service_provider', $args );
// }

// /**
//  * Service Provider Taxonomies
//  */
// add_action( 'init', 'gs_service_provider_taxonomies' );
// function gs_service_provider_taxonomies() {
//     $taxonomies = array(
//         array(
//             'slug'         => 'service_provider_category',
//             'single_name'  => 'Service Category',
//             'plural_name'  => 'Service Category',
//             'post_type'    => 'service_provider',
//             'rewrite'      => array( 'slug' => 'service_provider_category' ),
//             'hierarchical' => true,
//         ),
//         array(
//             'slug'         => 'service_provider_program',
//             'single_name'  => 'Service Program',
//             'plural_name'  => 'Service Program',
//             'post_type'    => 'service_provider',
//             'rewrite'      => array( 'slug' => 'service_provider_program' ),
//             'hierarchical' => true,
//         ),
//         array(
//             'slug'         => 'service_provider_area',
//             'single_name'  => 'Service Area',
//             'plural_name'  => 'Service Area',
//             'post_type'    => 'service_provider',
//             'rewrite'      => array( 'slug' => 'service_provider_area' ),
//             'hierarchical' => true,
//         ),
//         array(
//             'slug'         => 'service_provider_status',
//             'single_name'  => 'Status',
//             'plural_name'  => 'Status',
//             'post_type'    => 'service_provider',
//             'rewrite'      => array( 'slug' => 'service_provider_status ' ),
//             'hierarchical' => true,
//         )
//     );
//     foreach( $taxonomies as $taxonomy ) {
//         $labels = array(
//             'name'                  => $taxonomy['plural_name'],
//             'singular_name'         => $taxonomy['single_name'],
//             'search_items'          => 'Search ' . $taxonomy['plural_name'],
//             'all_items'             => 'All ' . $taxonomy['plural_name'],
//             'parent_item'           => 'Parent ' . $taxonomy['single_name'],
//             'parent_item_colon'     => 'Parent ' . $taxonomy['single_name'] . ':',
//             'edit_item'             => 'Edit ' . $taxonomy['single_name'],
//             'update_item'           => 'Update ' . $taxonomy['single_name'],
//             'add_new_item'          => 'Add New ' . $taxonomy['single_name'],
//             'new_item_name'         => 'New ' . $taxonomy['single_name'],
//             'view_item'             => 'View ' . $taxonomy['single_name'],
//             'menu_name'             => $taxonomy['plural_name'],
//             'not_found'             => 'No ' . $taxonomy['plural_name'] . ' Found',
//         );

//         $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
//         $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

//         register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
//             'labels'                => $labels,
//             'hierarchical'          => $taxonomy['hierarchical'],
//             'public'                => true,
//             'show_ui'               => true,
//             'show_admin_column'     => true,
//             'show_in_nav_menus'     => true,
//             'show_tagcloud'         => false,
//             'show_in_rest'          => true,
//             'query_var'             => $taxonomy['slug'],
//             'rewrite'               => $rewrite,
//         ));
//     }

// }

// /**
//  * Jobs CPT
//  */
// add_action( 'init', 'gs_cpt_jobs', 0 );
// function gs_cpt_jobs() {
//     $labels = array(
//         'name' 				    => 'Jobs',
//         'singular_name'         => 'Job',
//         'menu_name'             => 'Jobs',
//         'add_new' 			    => 'Add Job',
//         'add_new_item'		    => 'Add New Job',
//         'edit' 				    => 'Edit',
//         'edit_item'             => 'Edit Job',
//         'new_item' 			    => 'New Job',
//         'view' 				    => 'View Job',
//         'view_item'             => 'View Job',
//         'search_items'          => 'Search Jobs',
//         'not_found' 			=> 'No Jobs Found',
//         'not_found_in_trash' 	=> 'No Jobs Found in Trash',
//         'parent' 				=> 'Parent Jobs',
//     );
//     $args = array(
//         'label' 			=> 'Jobs',
//         'description' 		=> '',
//         'labels'			=> $labels,
//         'public'			=> true,
//         'show_ui' 			=> true,
//         'show_in_menu' 		=> true,
//         'capability_type' 	=> 'post',
//         'map_meta_cap' 		=> true,
//         'hierarchical'		=> false,
//         'has_archive' 		=> false,
//         'rewrite' 			=> array('slug' => 'jobs', 'with_front' => true),
//         'query_var' 		=> true,
//         'menu_position' 	=> '5',
//         'menu_icon' 		=> 'dashicons-id-alt',
//         'supports' 			=> array('title', 'excerpt', 'revisions', 'thumbnail', 'author'),
//     );
//     register_post_type( 'jobs', $args );
// }
// /**
//  * Jobs Taxonomies
//  */
// add_action( 'init', 'gs_jobs_taxonomies' );
// function gs_jobs_taxonomies() {
//     $taxonomies = array(
//         array(
//             'slug'         => 'department',
//             'single_name'  => 'Department',
//             'plural_name'  => 'Department',
//             'post_type'    => 'jobs',
//             'rewrite'      => array( 'slug' => 'jobs' ),
//             'hierarchical' => true,
//         ),
//         array(
//             'slug'         => 'position-type',
//             'single_name'  => 'Position Type',
//             'plural_name'  => 'Position Type',
//             'post_type'    => 'jobs',
//             'rewrite'      => array( 'slug' => 'jobs' ),
//             'hierarchical' => true,
//         )
//     );
//     foreach( $taxonomies as $taxonomy ) {
//         $labels = array(
//             'name'                  => $taxonomy['plural_name'],
//             'singular_name'         => $taxonomy['single_name'],
//             'search_items'          => 'Search ' . $taxonomy['plural_name'],
//             'all_items'             => 'All ' . $taxonomy['plural_name'],
//             'parent_item'           => 'Parent ' . $taxonomy['single_name'],
//             'parent_item_colon'     => 'Parent ' . $taxonomy['single_name'] . ':',
//             'edit_item'             => 'Edit ' . $taxonomy['single_name'],
//             'update_item'           => 'Update ' . $taxonomy['single_name'],
//             'add_new_item'          => 'Add New ' . $taxonomy['single_name'],
//             'new_item_name'         => 'New ' . $taxonomy['single_name'],
//             'view_item'             => 'View ' . $taxonomy['single_name'],
//             'menu_name'             => $taxonomy['plural_name'],
//             'not_found'             => 'No ' . $taxonomy['plural_name'] . ' Found',
//         );

//         $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
//         $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

//         register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
//             'labels'                => $labels,
//             'hierarchical'          => $taxonomy['hierarchical'],
//             'public'                => true,
//             'show_ui'               => true,
//             'show_admin_column'     => true,
//             'show_in_nav_menus'     => true,
//             'show_tagcloud'         => false,
//             'query_var'             => $taxonomy['slug'],
//             'rewrite'               => $rewrite,
//         ));
//     }

// }

// /**
//  * Media Coverage CPT
//  */
// add_action( 'init', 'gs_cpt_media_coverage', 0 );
// function gs_cpt_media_coverage() {
//     $labels = array(
//         'name' 				    => 'Media Coverage',
//         'singular_name'         => 'Media Coverage',
//         'menu_name'             => 'Media Coverage',
//         'add_new' 			    => 'Add Media Coverage',
//         'add_new_item'		    => 'Add New Media Coverage',
//         'edit' 				    => 'Edit',
//         'edit_item'             => 'Edit Media Coverage',
//         'new_item' 			    => 'New Media Coverage',
//         'view' 				    => 'View Media Coverage',
//         'view_item'             => 'View Media Coverage',
//         'search_items'          => 'Search Media Coverage',
//         'not_found' 			=> 'No Media Coverage Found',
//         'not_found_in_trash' 	=> 'No Media Coverage Found in Trash',
//         'parent' 				=> 'Parent Media Coverage',
//     );
//     $args = array(
//         'label' 			=> 'Media Coverage',
//         'description' 		=> '',
//         'labels'			=> $labels,
//         'public'			=> true,
//         'show_ui' 			=> true,
//         'show_in_menu' 		=> true,
//         'capability_type' 	=> 'post',
//         'map_meta_cap' 		=> true,
//         'hierarchical'		=> false,
//         'has_archive' 		=> false,
//         'rewrite' 			=> array('slug' => 'media-releases', 'with_front' => true),
//         'query_var' 		=> true,
//         'menu_position' 	=> '5',
//         'menu_icon' 		=> 'dashicons-rss',
//         'supports' 			=> array('title', 'revisions', 'excerpt', 'thumbnail', 'author'),
//     );
//     register_post_type( 'media_coverage', $args );
// }

// /**
//  * Publications CPT
//  */
// add_action( 'init', 'gs_cpt_publications', 0 );
// function gs_cpt_publications() {
//     $labels = array(
//         'name' 				    => 'Publications',
//         'singular_name'         => 'Publication',
//         'menu_name'             => 'Publications',
//         'add_new' 			    => 'Add Publication',
//         'add_new_item'		    => 'Add New Publication',
//         'edit' 				    => 'Edit',
//         'edit_item'             => 'Edit Publication',
//         'new_item' 			    => 'New Publication',
//         'view' 				    => 'View Publication',
//         'view_item'             => 'View Publication',
//         'search_items'          => 'Search Publications',
//         'not_found' 			=> 'No Publications Found',
//         'not_found_in_trash' 	=> 'No Publications Found in Trash',
//         'parent' 				=> 'Parent Publications',
//     );
//     $args = array(
//         'label' 			=> 'Publications',
//         'description' 		=> '',
//         'labels'			=> $labels,
//         'public'			=> true,
//         'show_ui' 			=> true,
//         'show_in_menu' 		=> true,
//         'capability_type' 	=> 'post',
//         'map_meta_cap' 		=> true,
//         'hierarchical'		=> false,
//         'has_archive' 		=> false,
//         'rewrite' 			=> array('slug' => 'publications', 'with_front' => true),
//         'query_var' 		=> true,
//         'menu_position' 	=> '5',
//         'menu_icon' 		=> 'dashicons-media-text',
//         'supports' 			=> array('title', 'excerpt', 'revisions', 'thumbnail', 'author'),
//     );
//     register_post_type( 'publications', $args );
// }
// /**
//  * Publications Taxonomies
//  */
// add_action( 'init', 'gs_publications_taxonomies' );
// function gs_publications_taxonomies() {
//     $taxonomies = array(
//         array(
//             'slug'         => 'publications_type',
//             'single_name'  => 'Publications Type',
//             'plural_name'  => 'Publications Type',
//             'post_type'    => 'publications',
//             'rewrite'      => array( 'slug' => 'publications' ),
//             'hierarchical' => true,
//         ),
//         array(
//             'slug'         => 'publications_tags',
//             'single_name'  => 'Publications Tag',
//             'plural_name'  => 'Publications Tags',
//             'post_type'    => 'publications',
//             'rewrite'      => array( 'slug' => 'publications' ),
//             'hierarchical' => false,
//         )
//     );
//     foreach( $taxonomies as $taxonomy ) {
//         $labels = array(
//             'name'                  => $taxonomy['plural_name'],
//             'singular_name'         => $taxonomy['single_name'],
//             'search_items'          => 'Search ' . $taxonomy['plural_name'],
//             'all_items'             => 'All ' . $taxonomy['plural_name'],
//             'parent_item'           => 'Parent ' . $taxonomy['single_name'],
//             'parent_item_colon'     => 'Parent ' . $taxonomy['single_name'] . ':',
//             'edit_item'             => 'Edit ' . $taxonomy['single_name'],
//             'update_item'           => 'Update ' . $taxonomy['single_name'],
//             'add_new_item'          => 'Add New ' . $taxonomy['single_name'],
//             'new_item_name'         => 'New ' . $taxonomy['single_name'],
//             'view_item'             => 'View ' . $taxonomy['single_name'],
//             'menu_name'             => $taxonomy['plural_name'],
//             'not_found'             => 'No ' . $taxonomy['plural_name'] . ' Found',
//         );

//         $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
//         $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

//         register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
//             'labels'                => $labels,
//             'hierarchical'          => $taxonomy['hierarchical'],
//             'public'                => false,
//             'show_ui'               => true,
//             'show_admin_column'     => true,
//             'show_in_nav_menus'     => true,
//             'show_tagcloud'         => false,
//             'query_var'             => $taxonomy['slug'],
//             'rewrite'               => $rewrite,
//         ));
//     }

// }

// /**
//  * Events CPT
//  */
// add_action( 'init', 'gs_cpt_events', 0 );
// function gs_cpt_events() {
//     $labels = array(
//         'name' 				    => 'Events',
//         'singular_name'         => 'Event',
//         'menu_name'             => 'Events',
//         'add_new' 			    => 'Add Event',
//         'add_new_item'		    => 'Add New Event',
//         'edit' 				    => 'Edit',
//         'edit_item'             => 'Edit Event',
//         'new_item' 			    => 'New Event',
//         'view' 				    => 'View Event',
//         'view_item'             => 'View Event',
//         'search_items'          => 'Search Events',
//         'not_found' 			=> 'No Events Found',
//         'not_found_in_trash' 	=> 'No Events Found in Trash',
//         'parent' 				=> 'Parent Events',
//     );
//     $args = array(
//         'label' 			=> 'Events',
//         'description' 		=> '',
//         'labels'			=> $labels,
//         'public'			=> true,
//         'show_ui' 			=> true,
//         'show_in_menu' 		=> true,
//         'capability_type' 	=> 'post',
//         'map_meta_cap' 		=> true,
//         'hierarchical'		=> false,
//         'has_archive' 		=> false,
//         'rewrite' 			=> array('slug' => 'events', 'with_front' => true),
//         'query_var' 		=> true,
//         'menu_position' 	=> '5',
//         'menu_icon' 		=> 'dashicons-calendar-alt',
//         'supports' 			=> array('title', 'excerpt', 'revisions', 'thumbnail', 'author'),
//     );
//     register_post_type( 'events', $args );
// }

/**
 * People CPT
 */
add_action( 'init', 'gs_cpt_people', 0 );
function gs_cpt_people() {
    $labels = array(
        'name' 				    => 'People',
        'singular_name'         => 'People',
        'menu_name'             => 'People',
        'add_new' 			    => 'Add People',
        'add_new_item'		    => 'Add New People',
        'edit' 				    => 'Edit',
        'edit_item'             => 'Edit People',
        'new_item' 			    => 'New People',
        'view' 				    => 'View People',
        'view_item'             => 'View People',
        'search_items'          => 'Search People',
        'not_found' 			=> 'No People Found',
        'not_found_in_trash' 	=> 'No People Found in Trash',
        'parent' 				=> 'Parent People',
    );
    $args = array(
        'label' 			=> 'People',
        'description' 		=> '',
        'labels'			=> $labels,
        'public'			=> true,
        'show_ui' 			=> true,
        'show_in_menu' 		=> true,
        'capability_type' 	=> 'post',
        'map_meta_cap' 		=> true,
        'hierarchical'		=> false,
        'has_archive' 		=> true,
        'rewrite' 			=> array('slug' => 'people', 'with_front' => true),
        'query_var' 		=> true,
        'menu_position' 	=> '5',
        'menu_icon' 		=> 'dashicons-groups',
        'show_in_rest'      => true,
        'supports' 			=> array('title', 'editor', 'thumbnail'),
    );
    register_post_type( 'people', $args );
}
/**
 * People Taxonomies
 */
add_action( 'init', 'gs_people_taxonomies' );
function gs_people_taxonomies() {
    $taxonomies = array(
        array(
            'slug'         => 'people_role',
            'single_name'  => 'People Role',
            'plural_name'  => 'People Roles',
            'post_type'    => 'people',
            'rewrite'      => array( 'slug' => 'people' ),
            'hierarchical' => true,
        ),
    );
    foreach( $taxonomies as $taxonomy ) {
        $labels = array(
            'name'                  => $taxonomy['plural_name'],
            'singular_name'         => $taxonomy['single_name'],
            'search_items'          => 'Search ' . $taxonomy['plural_name'],
            'all_items'             => 'All ' . $taxonomy['plural_name'],
            'parent_item'           => 'Parent ' . $taxonomy['single_name'],
            'parent_item_colon'     => 'Parent ' . $taxonomy['single_name'] . ':',
            'edit_item'             => 'Edit ' . $taxonomy['single_name'],
            'update_item'           => 'Update ' . $taxonomy['single_name'],
            'add_new_item'          => 'Add New ' . $taxonomy['single_name'],
            'new_item_name'         => 'New ' . $taxonomy['single_name'],
            'view_item'             => 'View ' . $taxonomy['single_name'],
            'menu_name'             => $taxonomy['plural_name'],
            'not_found'             => 'No ' . $taxonomy['plural_name'] . ' Found',
        );

        $rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
        $hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;

        register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
            'labels'                => $labels,
            'hierarchical'          => $taxonomy['hierarchical'],
            'public'                => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'show_in_nav_menus'     => true,
            'show_tagcloud'         => false,
            'show_in_rest'          => true,
            'query_var'             => $taxonomy['slug'],
            'rewrite'               => $rewrite,
        ));
    }

}

/*
 * Custom Rewrite
 *
 * New Reference (resolve pagination error)
 * https://jewelfarazi.me/fix-wordpress-custom-taxonomy-pagination-404-error/
 *
 */
add_action('generate_rewrite_rules', 'gs_generate_taxonomy_rewrite_rules');
function gs_generate_taxonomy_rewrite_rules( $wp_rewrite ) {
    $rules = array();
    $post_types = get_post_types( array( 'public' => true, '_builtin' => false ), 'objects' );
    $taxonomies = get_taxonomies( array( 'public' => true, '_builtin' => false ), 'objects' );

    foreach ( $post_types as $post_type ) {
        $post_type_name = $post_type->name;
        $post_type_slug = $post_type->rewrite['slug'];

        foreach ( $taxonomies as $taxonomy ) {
            if ( $taxonomy->object_type[0] == $post_type_name ) {
                $terms = get_categories( array( 'type' => $post_type_name, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0 ) );
                foreach ( $terms as $term ) {
                    $rules[$post_type_slug . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    $rules[$post_type_slug . '/' . $term->slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug . '&paged=' . $wp_rewrite->preg_index( 1 );
                }
            }
        }
    }
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}

//add_action( 'restrict_manage_posts', 'filter_backend_by_taxonomies' , 99, 2);