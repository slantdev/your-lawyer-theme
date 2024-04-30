<?php

function get_featured_slider_block_html($content) {
    //create title
    // $title = get_title(array('title_text' => $content['title'], 'element_class' => 'font-semibold mb-0', 'wrapper_class' => 'mb-12'));
    // $title = sprintf('<div class="text-container">%s</div>', $title);

    // $cards = sprintf('<div class = "loan-comparison grid md:grid-cols-3 gap-8">%s</div>', $cards);

    // //arrange content
    // $content_block = sprintf('<div class="section-content container mx-auto pb-12 px-gs_md md:px-0">%s%s</div>', $title, $cards);
    
    $textSection = '';
    
    $service_category = $content['service_category']?$content['service_category']:'';

        $serviceSection = '';
        $limit = (isset($content['limit']))?$content['limit']:20;
        $serviceSection = get_service_featured_slider_content($limit, $content, $service_category);
        $serviceSection = sprintf('<div class="col-lg-12">%s</div>',$serviceSection);
    
    
    $sectionStyle = '';
    $settingArray = $content['content_block_settings'];
    if(!empty($settingArray)){
        // $sectionStyle .= sprintf("background-color:%s;",$settingArray['background_color']);
        // $sectionStyle .= sprintf("background-image:url('%s');",$settingArray['background_image']);
        // $sectionStyle .= sprintf("background-position:%s;",$settingArray['background_position']);
        // $sectionStyle .= sprintf("background-size:%s;",$settingArray['background_size']);
        // $sectionStyle .= sprintf("background-repeat:%s;",($settingArray['background_repeat']==true)?'repeat':'no-repeat');
        $sectionStyle = yl_make_style($settingArray);
        
    }


    $content_block = sprintf('<div class="section_container featured_slider_section" %s><div class="featured_slider_section_inner">%s%s</div></div>',$sectionStyle, $textSection,$serviceSection);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}


function get_service_featured_slider_content($limit=20, $content = "",$service_category=""){

    $serviceHtml = '';
    $titletextSection = '';
    if(!empty($content)){
            if(!empty($content['title']))
                $titletextSection .= sprintf('<div class="sub_title">%s</div>',$content['title']);
                $titletextSection = sprintf('<div class="title_wrapper">%s</div>',$titletextSection);
    }

    $args = array(
        'post_type' => 'services',
        'posts_per_page' => 10
    );

    if($service_category!=""){
        if(isset($service_category->slug)){
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'service_category',
                    'field'    => 'slug',
                    'terms'    => $service_category->slug,
                ),
            );
        }
    }

    $the_query = new WP_Query( $args );

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();

            //use service title if custom title hasn't been entered
            $featuredTitle = (get_field('custom_title')!="")?get_field('custom_title'):'';
            if($featuredTitle == ''){
                $featuredTitle = get_the_title();
            }

            $featuredContent = get_field('description');
            $linktoPost = get_the_permalink();
            $postID = get_the_ID();
            
            $sliderBgImage = !empty(get_field('background_image',$postID))?'background-image:url(\''.esc_url( get_field('background_image',$postID) ).'\');':'';
            $serviceHtml .= sprintf('<div class="service_featured" style="%s">
            <div class="featured_slider_section_opacity"></div>
            <div class="container">
            <div class="row">
            <div class="col-lg-12">
            %s
            </div>
            </div>
            <div class="row">
            <div class="col-lg-6">
            <h2 class="service_featured__title">%s</h2>
            <div class="service_featured__excerpt">%s</div>
            </div>
            <div class="col-lg-6 text-align-right">
            <a class="service_featured__talktolink" href="%s">Learn more</a>
            </div>
            </div>
            </div>
            </div>',$sliderBgImage,$titletextSection,$featuredTitle, $featuredContent, $linktoPost );

        }
    }

    wp_reset_query();

    $serviceHtml = sprintf('<div class="featured_slider">%s</div>',$serviceHtml);

    return $serviceHtml;
}

function display_featured_slider_block($content) {
    
    echo get_featured_slider_block_html($content);
}

function get_featured_slider_content(){
    return array(
        'title' => get_sub_field('title'),
        'limit' => get_sub_field('limit'),
        'service_category' => get_sub_field('service_category'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>