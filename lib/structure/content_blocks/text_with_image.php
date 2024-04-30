<?php

function get_text_with_image_block_html($content) {
    //create title
    // $title = get_title(array('title_text' => $content['title'], 'element_class' => 'font-semibold mb-0', 'wrapper_class' => 'mb-12'));
    // $title = sprintf('<div class="text-container">%s</div>', $title);

    // $cards = sprintf('<div class = "loan-comparison grid md:grid-cols-3 gap-8">%s</div>', $cards);

    // //arrange content
    // $content_block = sprintf('<div class="section-content container mx-auto pb-12 px-gs_md md:px-0">%s%s</div>', $title, $cards);
    
    $textSection = $image_section = '';
    
    if(!empty($content)){

        if(!empty($content['sub_title']))
        $textSection .= sprintf('<div class="sub_title">%s</div>',$content['sub_title']);

        if(!empty($content['title']))
        $textSection .= sprintf('<h2 class="main_title">%s</h2>',$content['title']);

        if(!empty($content['description']))
        $textSection .= sprintf('<div class="description">%s</div>',$content['description']);

        $textSection = sprintf('<div class="col-lg-7"><div class="title_wrapper">%s</div></div>',$textSection);

        if(!empty($content['main_image']))
        $image_section = sprintf('<div class="col-lg-5"><div class="text_with_image_wrapper"><img src="%s" alt="%s" /></div></div>',$content['main_image'],$content['main_image_alt']);
        
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

    $content_block = sprintf('
    <div class="section_container" %s>
        <div class="container">
            <div class="row">
                %s%s
            </div>
        </div>
    </div>',$sectionStyle, $textSection, $image_section);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}


function display_text_with_image_block($content) {
    echo get_text_with_image_block_html($content);
}

function get_text_with_image_content(){
    return array(
        'title' => get_sub_field('title'),
        'sub_title' => get_sub_field('sub_title'),
        'description' => get_sub_field('description'),
        'main_image' => get_sub_field('main_image1'),
        'main_image_alt' => get_sub_field('main_image_alt'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>