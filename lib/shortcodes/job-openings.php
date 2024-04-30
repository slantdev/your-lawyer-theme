<?php

add_shortcode( 'job_openings', 'gs_job_openings_shortcode' );
function gs_job_openings_shortcode( $args ) {
    $output = '';

    $showFilter = true;
    if(isset($args['fromAjax']) && true == $args['fromAjax']){
        $showFilter = false;
    }
    

    if($showFilter){
        $output .= '<div class="flex px-gs_md md:px-0 flex-col md:flex-row">';
        $output .= '<div class="flex-auto">';
            $output .= '<h2 class="text-red">Our Openings</h2>';
        $output .= '</div>';
        $output .= '<div class="flex-none flex flex-col md:flex-row">';
            $output .= gs_position_type_select('Position type');
            $output .= gs_position_type_select('Department');
        $output .= '</div>';
        $output .= '</div>';
    }

    $defaults = array(
        'post_type' => 'jobs',
    );

    $args = wp_parse_args( $args, $defaults );
    // var_dump($args);
    // error_log(print_r($args,true));
    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {

        $output .= '<section class="mb-0 py-12 px-gs_md md:px-24">';
            $output .= '<div class="container mx-auto positiondepartmentreplacer">';

                //$output .= '<div class="grid grid-cols-3 gap-8">';

                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $post_id = get_the_ID();
                    //$thumbnail = get_the_post_thumbnail_url();
                    $title = get_the_title();
                    $excerpt = get_the_excerpt();
                    $permalink = get_the_permalink();
                    //$event_date = get_field('event_start_date');

                    $output .= '<div class="block border-b mb-12 pb-6 border-gray-300">';
                        $output .= '<h4 class="text-2xl font-medium"><a href="' . $permalink . '" class="no-underline text-body">' . $title . '</a></h4>';

                        $output .= '<div class="flex flex-col md:flex-row">';
                            $output .= '<div class="mr-16">';
                                $term_position_type = get_the_terms( get_the_ID(), 'position-type' );
                                if(!empty($term_position_type)){
                                    foreach ( $term_position_type as $term ) {
                                        $term_name = $term->name;
                                        $output .= '<p class="mb-2 text-body">' . $term_name . '</p>';
                                    }
                                }
                                $output .= '<p class="leading-normal text-body">' . $excerpt . '</p>';
                            $output .= '</div>';
                            $output .= '<div class="mb-0">';
                                $output .= '<a href="' . $permalink . '" class="text-purple whitespace-nowrap rounded-md border border-purple py-4 px-10 text-center text-xl no-underline leading-none inline-block">View Details</a>';
                            $output .= '</div>';
                        $output .= '</div>';

                    $output .= '</div>';

                }

                //$output .= '</div>';

            $output .= '</div>';
        $output .= '</section>';

    } else {
        // no posts found
        $output .= '<section class="mb-0 py-12 px-gs_md md:px-24">';
        $output .= '<div class="container mx-auto positiondepartmentreplacer">';
            $output .= '<div class="block border-b mb-12 pb-6 border-gray-300">';
                $output .= '<h4 class="text-2xl font-medium">No Post Found!</h4>';
            $output .= '</div>';
        $output .= '</div>';
        $output .= '</section>';
    }
    /* Restore original Post Data */
    wp_reset_postdata();

    return $output;

}

function gs_position_type_select($text) {
    $output = '';


    switch ($text) {
        case 'Position type':
            
            $taxonomies = get_terms( array(
                'taxonomy' => 'position-type',
                'hide_empty' => true,
            ) );

            if ( !empty($taxonomies) ) :

                $output .= '<div class="md:pl-2 pr-2">';
                $output .= '<select name="position_type_filter" id="position_type_filter" class="block">';
                $output .= '<option value="0" selected="selected">Position type</option>';
                    foreach ($taxonomies as $singlepositionOB){
                        $output .= '<option value="'. esc_attr( $singlepositionOB->term_id ) .'" >'. esc_attr( $singlepositionOB->name ) .'</option>';
                    }
                $output .= '</select>';
                $output .= '</div>';

            endif;
            break;
        case 'Department':
        
            $taxonomies = get_terms( array(
                'taxonomy' => 'department',
                'hide_empty' => true,
            ) );

            if ( !empty($taxonomies) ) :

                $output .= '<div class="md:pl-2 pr-2">';
                $output .= '<select name="department_filter" id="department_filter" class="block">';
                $output .= '<option value="0" selected="selected">Position type</option>';
                    foreach ($taxonomies as $singledepartmentOB){
                        $output .= '<option value="'. esc_attr( $singledepartmentOB->term_id ) .'" >'. esc_attr( $singledepartmentOB->name ) .'</option>';
                    }
                $output .= '</select>';
                $output .= '</div>';

            endif;
            
        default:
            # code...
            break;
    }

    // $output .= '<div class="mdc-select mdc-select--filled mb-4 w-full jobs-filter-select md:ml-4">';
    // $output .= '<div class="mdc-select__anchor" role="button" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="service-label service-selected-text">';
    //     $output .= '<span class="mdc-select__ripple"></span>';
    //     $output .= '<span id="service-label" class="mdc-floating-label">' . $text . '</span>';
    //     $output .= '<span class="mdc-select__selected-text-container">';
    //         $output .= '<span id="select-service-selected-text" class="mdc-select__selected-text"></span>';
    //     $output .= '</span>';

    //     $output .= '<span class="mdc-select__dropdown-icon">';
    //         $output .= '<svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5" focusable="false">';
    //             $output .= '<polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>';
    //             $output .= '<polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>';
    //         $output .= '</svg>';
    //     $output .= '</span>';
    //     $output .= '<span class="mdc-line-ripple"></span>';
    // $output .= '</div>';

    // $output .= '<div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">';
    //     $output .= '<ul class="mdc-list" role="listbox" aria-label="Services listbox">';

    //         $taxonomies = get_terms( array(
    //             'taxonomy' => 'service_provider_category',
    //             'hide_empty' => false,
    //         ) );

    //         if ( !empty($taxonomies) ) :
    //             $output .= '<li class="mdc-list-item mdc-list-item--selected" aria-selected="true" data-value="" role="option">';
    //                 $output .= '<span class="mdc-list-item__ripple"></span>';
    //             $output .= '</li>';

    //             foreach( $taxonomies as $category ) {

    //                 $output .= '<li class="mdc-list-item" aria-selected="false" data-value="'. esc_attr( $category->term_id ) .'" role="option">';
    //                     $output .= '<span class="mdc-list-item__ripple"></span>';
    //                     $output .= '<span class="mdc-list-item__text">'. esc_attr( $category->name ) .'</span>';
    //                 $output .= '</li>';

    //             }
    //         endif;

    //     $output .= '</ul>';
    //     $output .= '</div>';
    // $output .= '</div>';

    return $output;
}

add_action( 'wp_ajax_filter_department_positions', 'den_ajax_filter_department_positions' );
add_action( 'wp_ajax_nopriv_filter_department_positions', 'den_ajax_filter_department_positions' );

function den_ajax_filter_department_positions() {
    
    $departmentID = $positionTypeID = 0;
    
    if(isset($_POST['positionType'])){
        $positionTypeID = $_POST['positionType'];
    }

    if(isset($_POST['department'])){
        $departmentID = $_POST['department'];
    }

    $output = "";
    $args = array();
   
    $mergerAr = array();
    $args['fromAjax'] = true;

    if($departmentID != 0){
        $departmentTaxArray =  array(
            'taxonomy' => 'department',
            'field'    => 'term_id',
            'terms'    => array( $departmentID ),
        );
        array_push($mergerAr, $departmentTaxArray);
    }

    if($positionTypeID != 0){
        $positiontypeTaxArray =  array(
            'taxonomy' => 'position-type',
            'field'    => 'term_id',
            'terms'    => array( $positionTypeID ),
        );
        array_push($mergerAr, $positiontypeTaxArray);
    }

    if($positionTypeID != 0 && $departmentID != 0){
        $mergerAr['relation'] = 'AND';
    }
    
    $args['tax_query'] = $mergerAr;

    $output .= gs_job_openings_shortcode($args);

    echo $output;
    wp_die();

}

add_action( 'wp_enqueue_scripts', 'den_enqueue_scripts_for_department_filter' );
function den_enqueue_scripts_for_department_filter(){
    wp_enqueue_style('custom_filter_department_style', get_stylesheet_directory_uri() . '/assets/dist/css/filter.css', array());

    wp_enqueue_script( 'custom_filter_department_script', get_stylesheet_directory_uri( ) . '/assets/dist/js/filter.js', array('jquery'), '1.0' );
    wp_localize_script( 'custom_filter_department_script', 'userdata',
		array('theme_uri' => get_stylesheet_directory_uri(),
		      'ajax_url' => admin_url( 'admin-ajax.php' ),
		      'site_url' => site_url(),
		)
	);
}