<?php

function get_text_with_services_block_html($content) {
    
    
    $titleArray = $content['title'];
    $servicesArray = $content['services'];
    $service_style = isset($servicesArray['service_style'])?$servicesArray['service_style']:'service_style2';
    $textSection = "";
    
    if(!empty($titleArray)){

        if ($service_style=="service_style2")
        $textSection .= '<div class="row"><div class="col-lg-8">';

        if(!empty($titleArray['sub_title']))
        $textSection .= sprintf('<div class="sub_title">%s</div>',$titleArray['sub_title']);

        if(!empty($titleArray['main_title']))
        $textSection .= sprintf('<h2 class="main_title">%s</h2>',$titleArray['main_title']);

        if(!empty($titleArray['description']))
        $textSection .= sprintf('<div class="description">%s</div>',$titleArray['description']);

        if ($service_style=="service_style2")
        $textSection .= '</div><div class="col-lg-4 text-align-right">';

        if( isset($content['button']['button_url']) && !empty($content['button']['button_url']) )
        $textSection .= sprintf('<a href="%s" class="btn talktous">%s</a>',$content['button']['button_url'],$content['button']['button_label']);

        if ($service_style=="service_style2") 
        $textSection .= '</div></div>';    

    }

    $servicesArray = $content['services'];
    $serviceSection = '';
    $service_category = $servicesArray['service_category']?$servicesArray['service_category']:'';
    // error_log(print_r($service_category,true));
    if(!empty($servicesArray)){
        
        $serviceSection = get_service_section($service_style,$service_category);
        
    }

    if ($service_style=="service_style1") {
        $textSection = sprintf('<div class="col-lg-4"><div class="title_wrapper %s">%s</div></div>', $titleArray['title_style'], $textSection);
        $serviceSection = sprintf('<div class="col-lg-8">%s</div>', $serviceSection);
    }else{
        $textSection = sprintf('<div class="col-lg-12"><div class="title_wrapper %s">%s</div></div>',$titleArray['title_style'],$textSection);
        $serviceSection = sprintf('<div class="col-lg-12">%s</div>',$serviceSection);
    }

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


    $content_block = sprintf('<div class="section_container service_section %s" %s><div class="container"><div class="row">%s%s</div></div></div>',$service_style, $sectionStyle, $textSection,$serviceSection);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}



function get_service_section($service_style,$service_category=""){

    $serviceHtml = '';
    $limit = 12;
    if($service_style=="service_style1"){
        $limit = 8;
    }

    $args = array(
        'post_type' => 'services',
        'posts_per_page' => $limit
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
            
            $serviceHtml .= sprintf('<div class="service_box__wrapper"><div class="service_box__dtitle">&nbsp;</div><div class="service_box__title">%s</div><a href="%s" class="service_box__link">%s</a></div>',get_the_title(),get_permalink(),'Learn More >');

        }
    }

    wp_reset_query();

    if ($service_style=="service_style1") {
        $serviceHtml .= sprintf('<div class="service_box__wrapper dark_last"><a href="%s" class="service_box__link_entire">%s</a></div>', get_permalink(), 'View all<br/>services');
    }
    $serviceHtml = sprintf('<div class="services_main_wrapper %s">%s</div>',$service_style,$serviceHtml);

    return $serviceHtml;
}


function display_text_with_services_block($content) {
    
    echo get_text_with_services_block_html($content);
}

function get_text_with_services_content(){
    return array(
        'title' => get_sub_field('title'),
        'button' => get_sub_field('button'),
        'services' => get_sub_field('services'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>