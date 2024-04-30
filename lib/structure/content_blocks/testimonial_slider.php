<?php

function get_testimonial_slider_block_html($content) {

        if(!empty($content['title']))
        $sub_title = sprintf('<div class="sub_title">%s</div>',$content['sub_title']);
        $title = sprintf('<h2 class="main_title">%s</h2>',$content['title']);

        $titleWrapperSection = sprintf('<div class="title_wrapper center-title">%s%s</div>',$sub_title, $title);
        
    
        $testimonialSection = '';
        $limit = (isset($content['limit']))?$content['limit']:20;
        $testimonialSection = get_testimonial_slider_post_content($limit);
        $testimonialSection = sprintf('<div class="testmonial_section_inner">%s</div>',$testimonialSection);

    
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

    $content_block = sprintf('<div class="section_container testimonial_section" %s><div class="container"><div class="row">%s</div><div class="row">%s</div></div></div>',$sectionStyle, $titleWrapperSection,$testimonialSection);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}


function get_testimonial_slider_post_content($limit=20){

    $testimonialHtml = '';

    $args = array(
        'post_type' => 'testimonial',
        // 'posts_per_page' => 10
    );

    $the_query = new WP_Query( $args );

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $testimonialLabel = get_field('testimonial_position_label');
            $featuredContent = get_the_content();
            $testimonial_title = get_the_title();
            $testimonialHtml .= sprintf('
            <div class="testimonial_featured">
                <div class="testimonial_featured__wrapper">
                    <div class="testimonial_featured__title">%s</div>
                    <div class="testimonial_featured__label">%s</div>
                    <div class="testimonial_featured__content">%s</div>
                </div>
            </div>',
            $testimonial_title, $testimonialLabel, $featuredContent);

        }
    }

    wp_reset_query();

    $testimonialHtml = sprintf('<div class="testimonial_main_wrapper text-align-center">%s</div>',$testimonialHtml);

    return $testimonialHtml;
}

function display_testimonial_slider_block($content) {
    
    echo get_testimonial_slider_block_html($content);
}

function get_testimonial_slider_content(){
    return array(
        'title' => get_sub_field('title'),
        'sub_title' => get_sub_field('sub_title'),
        'limit' => get_sub_field('limit'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>