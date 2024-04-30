<?php

function get_contact_section_block_html($content) {
    //create title
    // $title = get_title(array('title_text' => $content['title'], 'element_class' => 'font-semibold mb-0', 'wrapper_class' => 'mb-12'));
    // $title = sprintf('<div class="text-container">%s</div>', $title);

    // $cards = sprintf('<div class = "loan-comparison grid md:grid-cols-3 gap-8">%s</div>', $cards);

    // //arrange content
    // $content_block = sprintf('<div class="section-content container mx-auto pb-12 px-gs_md md:px-0">%s%s</div>', $title, $cards);
    
    $textSection = $textSection2 = $image_section = '';
    
    if(!empty($content)){

        if(!empty($content)){
        $textContent = !empty($content['contact_section'])?do_shortcode($content['contact_section']):'';
        $textContent2 = !empty($content['contact_section2'])?do_shortcode($content['contact_section2']):'';
        $textSection = sprintf('
        <div class="col-lg-6 px-3">
            <div class="title">%s</div>
            <div class="contact_section_left">%s</div>
        </div>
        <div class="col-lg-6 px-3">
            <div class="title">%s</div>
            <div class="contact_section_inner">%s</div>
        </div>
        ',$content['title'],$textContent,$content['title2'],$textContent2);
        }

    }

    $sectionStyle = '';
    $settingArray = $content['content_block_settings'];
    if(!empty($settingArray)){
        $sectionStyle = yl_make_style($settingArray);   
    }

    $content_block = sprintf('
    <div class="section_container contact_section" %s>
        <div class="container">
            <div class="row gx-5">
                %s
            </div>
        </div>
    </div>',$sectionStyle, $textSection);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}


function display_contact_section_block($content) {
    echo get_contact_section_block_html($content);
}

function get_contact_section_content(){
    return array(
        'title' => get_sub_field('title'),
        'title2' => get_sub_field('title2'),
        'contact_section' => get_sub_field('contact_section'),
        'contact_section2' => get_sub_field('contact_section2'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>