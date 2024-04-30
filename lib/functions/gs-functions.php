<?php

function yl_make_style($rowArray){
    $style = '';
    if(!empty($rowArray)){
        foreach($rowArray as $key=>$singleRow){
            if ( is_bool($singleRow) || !empty($singleRow)) {
                switch ($key) {
                    case 'background-repeat':
                        $style .= sprintf("%s:%s;",$key,($singleRow==false)?'no-repeat':'repeat');
                        break;
                    case 'background-image':
                        $style .= sprintf("%s:url('%s');",$key, $singleRow);
                        break;
                    default:
                        $style .= sprintf("%s:%s;", $key, $singleRow);
                        break;
                }   
            }  
        }

        $style = sprintf('style="%s"',$style);
    }

    return $style;
}

function gs_page_header() {

    if (is_archive()) {
        $term = get_queried_object();
        //print_r($term);
        $header_title = get_field('header_title', $term);
        $header_description = get_field('header_description', $term);
        $header_image = get_field('header_image', $term);
        $background_color = get_field('background_color', $term);
        $page_navigation = get_field('page_navigation', $term);
        $header_breadcrumbs = get_field('header_breadcrumbs', $term);
    } else {
        $header_title = get_field('header_title');
        $header_description = get_field('header_description');
        $header_image = get_field('header_image');
        $background_color = get_field('background_color');
        $page_navigation = get_field('page_navigation');
        $header_breadcrumbs = get_field('header_breadcrumbs');
    }

    if ($background_color) {
        $background_color = 'background-color:' . $background_color;
    } else {
        $background_color = 'background-color:#000;';
    }

    if ($header_image) {
        $header_image = 'background-image: url(' . esc_url($header_image['url']) . ');';
    }

    if ($header_title) {
        $header_title = '<h1 class="text-5xl leading-tight">' . $header_title . '</h1>';
    } else {
        if (is_archive()) {
            $object = get_queried_object();
            $title = $object->name;
            $header_title = '<h1 class="text-5xl leading-tight">' . $title . '</h1>';
        } else if ( is_singular('publications') ) {
            $header_title = '<h1 class="text-3xl leading-relaxed">' . get_the_title() . '</h1>';
        } else {
            $header_title = '<h1 class="text-5xl leading-tight">' . get_the_title() . '</h1>';
        }
    }

    if ($header_description) {
        $header_description = '<p class="text-xl">' . $header_description . '</p>';
    }

    $output = '<div class="page-header" style="' . $background_color . '">';
        $output .= '<div class="container mx-auto px-4 flex items-center" style="' . $header_image . '">';
            $output .= '<div class="hero-content text-white w-1/2">';
                $output .= $header_title;
                $output .= $header_description;
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';

    echo $output;

    if ($page_navigation) {
        if (is_archive()) {
            $object = get_queried_object();
            $post_id = $object->taxonomy.'_'.$object->term_id;
        } else {
            $post_id = get_the_ID();
        }
        echo gs_page_anchor_nav($post_id);
    }

    if ($header_breadcrumbs) {
        echo gs_breadcrumbs();
    }

}

function gs_page_anchor_nav($post_id) {

    $output = '';

    // Check value exists.
    if( have_rows('content_management', $post_id) ):

        $output .= '<div class="page-anchor-nav">';
        $output .= '<div class="container mx-auto px-4">';
            $output .= '<div class="max-w-screen-md mx-auto">';

            $output .= '<div class="mdc-select mdc-select--filled jump-section">
                <div class="mdc-select__anchor" role="button" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="jump-section-label jump-section-selected-text">
                    <span class="mdc-select__ripple"></span>
                    <span id="jump-section-label" class="mdc-floating-label">On this page</span>
                    <span class="mdc-select__selected-text-container">
                        <span id="jump-section-selected-text" class="mdc-select__selected-text"></span>
                    </span>
                    <span class="mdc-select__dropdown-icon">
                        <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5" focusable="false">
                            <polygon class="mdc-select__dropdown-icon-inactive" stroke="none" fill-rule="evenodd" points="7 10 12 15 17 10"></polygon>
                            <polygon class="mdc-select__dropdown-icon-active" stroke="none" fill-rule="evenodd" points="7 15 12 10 17 15"></polygon>
                        </svg>
                    </span>
                    <span class="mdc-line-ripple"></span>
                </div>

                <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">
                    <ul class="mdc-list" role="listbox" aria-label="Jump Section List">
                        <li class="mdc-list-item mdc-list-item--selected" aria-selected="true" data-value="" role="option">
                            <span class="mdc-list-item__ripple"></span>
                        </li>';

                        // Loop through rows.
                while ( have_rows('content_management', $post_id) ) : the_row();
                    $page_anchor = get_sub_field('page_anchor');
                    if ($page_anchor) {
                        $section_id = get_sub_field('section_id');
                        $title = get_sub_field('title');
                        $output .= '<li class="mdc-list-item" aria-selected="false" data-value="' . $section_id . '" role="option">
                            <span class="mdc-list-item__ripple"></span>
                            <span class="mdc-list-item__text">' . $title . '</span>
                        </li>';
                    }

                // End loop.
                endwhile;

            $output .= '</ul>
                    </div>
                </div>';

            $output .= '<script type="text/javascript">
                const MDCSelect = mdc.select.MDCSelect;
                const select = new MDCSelect(document.querySelector(".jump-section"));

                select.listen("MDCSelect:change", () => {
                    document.getElementById(`${select.value}`).scrollIntoView(true);
                    //alert(`Selected option at index ${select.selectedIndex} with value "${select.value}"`);
                });

            </script>';

            $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

    // No value.
    else :
        // Do something...
    endif;

    return $output;
}

function gs_breadcrumbs() {

    $home = '<a href="' . get_home_url() . '" class="no-underline text-body inline-block hover:text-red">Home</a>';
    $separator = '<span class="inline-block mx-2">/</span>';
    $parent = '';
    $current_page = '<span class="inline-block"><a class="text-body no-underline hover:text-red hover:underline" href="' . get_the_permalink() . '">' . get_the_title() . '</a></span>';

    if ( is_tax( array( 'service_category', 'service_tag' ) ) ) {
        $term = get_queried_object();
        $term_name =  $term->name;
        $parent = '<span class="inline-block">Our Services</span>';
        $current_page = '<span class="inline-block"><a class="text-body no-underline hover:text-red hover:underline" href="' . get_term_link($term) . '">' . $term_name . '</a></span>';
    } else if ( is_singular('services') ) {
        $parent = '<span class="inline-block">Our Services</span>';
    } else if ( is_singular('jobs') ) {
        $parent = '<span class="inline-block">Get Involved</span>' . $separator . '<span class="inline-block"><a class="text-body no-underline hover:text-red hover:underline" href="/careers-with-us/">Careers with Us</a></span>';
    } else if ( is_page_template( 'page-template/media-coverage.php' ) ) {
        $parent = '<span class="inline-block">News and Events</span>';
    } else if ( is_page_template( 'page-template/publications.php' ) ) {
        //$current_page = '<span class="inline-block">' . get_the_title() . '</span>';
    } else if ( is_singular('publications') ) {
        $current_page = '<span class="inline-block">Our Research</span>';
    } else if ( is_singular('events') ) {
        $parent = '<span class="inline-block">Events</span>';
    } else if ( is_singular('media_coverage') ) {
        $parent = '<span class="inline-block">Media Releases</span>';
    } else {
    }

    $output = '<div class="breadcrumbs"><div class="container mx-auto px-4 py-8">';
        $output .= $home;
        $output .= $separator;

        if ($parent) {
            $output .= $parent;
            $output .= $separator;
        }

        $output .= $current_page;
    $output .= '</div></div>';

    echo $output;
}

function gs_content_management() {
    if (is_archive()) {
        $object = get_queried_object();
        $post_id = $object->taxonomy.'_'.$object->term_id;
    } else {
        $post_id = get_the_ID();
    }
    
	page_renderer('item_builder', $post_id);
}

function gs_archive_loop_card($post_type, $taxonomy) {

    $term = get_queried_object();
    $term_id =  $term->term_id;
    $term_slug =  $term->slug;

    $args = array(
        'post_type' => $post_type,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => array($term_slug),
            ),
        ),
    );

    // The Query
    $the_query = new WP_Query( $args );

    // echo '<pre>';
    // print_r($args);
    // echo '</pre>';

    // The Loop
    if ( $the_query->have_posts() ) {

        echo '<section class="py-20 bg-gray-50">';
        echo '<div class="container mx-auto px-gs_md md:px-0">';
            echo '<h2 class="text-red font-semibold mb-12">Here are some ways we can help</h2>';

            echo '<div class="grid lg:grid-cols-3 gap-8">';

                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $post_id = get_the_ID();
                    $term_obj = get_the_terms($post_id, 'service_category');
                    $term_id = $term_obj[0]->term_id;
                    $term_icon_obj = get_field('service_category_icon', 'service_category_' . $term_id);
                    $term_icon = $term_icon_obj['url'];
                    $thumbnail = get_the_post_thumbnail_url();
                    $title = get_the_title();
                    $excerpt = get_the_excerpt();
                    $permalink = get_the_permalink();

                    $output = '<div class="flex flex-col rounded-2xl shadow-xl h-full overflow-hidden transition-shadow hover:shadow-2xl">';
                        $output .= '<div class="h-64 relative">';
                            $output .= '<a href="' . $permalink . '" class="block"><img class="object-cover h-64 w-full" src="' . $thumbnail . '" alt="' . $title . '"></a>';
                            $output .= '<div class="absolute flex items-center justify-center h-20 w-20 bg-purple rounded-full bottom-0 right-0 p-5 -mb-10 mr-8">';
                                $output .= '<img class="category-icon" src="' . $term_icon . '">';
                            $output .= '</div>';
                        $output .= '</div>';
                        $output .= '<div class="pt-14 px-8 pb-8 flex flex-col flex-grow">';
                            $output .= '<h3 class="text-3xl font-semibold mb-6"><a href="' . $permalink . '" class="no-underline text-current">' . $title . '</a></h3>';
                            $output .= '<div class="leading-loose mb-8">' . $excerpt . '</div>';
                            $output .= '<div class="text-base uppercase mt-auto mb-0"><a href="' . $permalink . '" class="text-red no-underline tracking-wider text-base uppercase leading-none inline-block font-medium"><span class="inline-block leading-none">LEARN MORE</span>' . gs_icon( array( 'icon' => 'navigate-right', 'group' => 'utility', 'size' => 10, 'class' => 'inline-block fill-current text-red ml-1' ) ) . '</a></div>';
                        $output .= '</div>';
                    $output .= '</div>';

                    echo $output;
                }

            echo '</div>';

        echo '</div>';
        echo '</section>';

    } else {
        // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();

}

function gs_events_cards_loop($param) {

    $output = '';

    $today = date('Ymd');

    $defaults = array(
        'post_type' => 'events',
    );

    if ($param == 'upcoming') {
        $args = array(
            'meta_query' => array(
                array(
                    'key'     => 'event_start_date',
                    'compare' => '>=',
                    'value'   => $today,
                )
            ),
            'orderby'   => 'meta_value_num',
            'order'     => 'ASC',
        );
        $heading_text = 'Upcoming Events';
    }

    if ($param == 'past') {
        $args = array(
            'meta_query' => array(
                array(
                    'key'     => 'event_start_date',
                    'compare' => '<',
                    'value'   => $today,
                )
            ),
            'orderby'   => 'meta_value_num',
            'order'     => 'DESC',
        );
        $heading_text = 'Past Events';
    }

    $args = wp_parse_args( $args, $defaults );

    $the_query = new WP_Query( $args );

    // The Loop
    if ( $the_query->have_posts() ) {

        $output .= '<section class="mb-0 py-16 bg-off_white">';
            $output .= '<div class="container mx-auto px-gs_md md:px-0">';
                $output .= '<h2 class="mb-12">' . $heading_text . '</h2>';

                $output .= '<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">';

                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $post_id = get_the_ID();
                    $thumbnail = get_the_post_thumbnail_url();
                    $title = get_the_title();
                    $excerpt = get_the_excerpt();
                    $permalink = get_the_permalink();
                    $event_date = get_field('event_start_date');

                    $output .= '<div class="rounded-2xl shadow-xl h-full overflow-hidden transition-shadow hover:shadow-2xl md:grid md:grid-cols-3 lg:block md:gap-gs_lg lg:gap-0">';
                        $output .= '<div class="h-64 relative">';
                            $output .= '<a href="' . $permalink . '" class="block"><img class="object-cover h-64 w-full" src="' . $thumbnail . '" alt="' . $title . '"></a>';
                            $output .= '<div class="absolute h-20 w-20 bg-purple rounded-full bottom-0 right-0 p-5 -mb-10 mr-8 md:mb-2 md:-mr-10 lg:-mb-10 lg:mr-8">';
                                //$output .= $term_icon;
                                $output .= gs_icon( array( 'icon' => 'event-white', 'group' => 'custom', 'size' => 40, 'class' => 'fill-current text-white' ) );
                            $output .= '</div>';
                        $output .= '</div>';
                        $output .= '<div class="pt-8 pb-8 px-8 md:col-span-2">';
                            $output .= '<p class="mb-3 text-base text-grey">' . $event_date . '</p>';
                            $output .= '<h4 class="text-2xl font-medium"><a href="' . $permalink . '" class="no-underline text-current">' . $title . '</a></h4>';
                            $output .= '<p class="leading-normal">' . $excerpt . '</p>';
                            $output .= '<p class="mb-0"><a href="' . $permalink . '" class="text-red no-underline tracking-wider text-base uppercase leading-none inline-block"><span class="inline-block leading-none">LEARN MORE</span>' . gs_icon( array( 'icon' => 'navigate-right', 'group' => 'utility', 'size' => 10, 'class' => 'inline-block fill-current text-red ml-1' ) ) . '</a></p>';
                        $output .= '</div>';
                    $output .= '</div>';

                }

                $output .= '</div>';

            $output .= '</div>';
        $output .= '</section>';

    } else {
        // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();

    return $output;
}