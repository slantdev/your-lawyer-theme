<?php

function get_text_editor_block_html($content) {
    //create title
    // $title = get_title(array('title_text' => $content['title'], 'element_class' => 'font-semibold mb-0', 'wrapper_class' => 'mb-12'));
    // $title = sprintf('<div class="text-container">%s</div>', $title);

    // $cards = sprintf('<div class = "loan-comparison grid md:grid-cols-3 gap-8">%s</div>', $cards);

    // //arrange content
    // $content_block = sprintf('<div class="section-content container mx-auto pb-12 px-gs_md md:px-0">%s%s</div>', $title, $cards);
    
    $textSection = $image_section = '';
    
    if(!empty($content)){

        if(!empty($content)){
        $textContent = !empty($content['text_editor'])?do_shortcode($content['text_editor']):'';
        $textSection .= sprintf('<div class="col-lg-12"><h2 class="main_title">%s</h=?></div><div class="col-lg-12"><div class="text_editor">%s</div></div>',$content['title'],$textContent);
        }

    }

    
    $sectionStyle = '';
    $settingArray = $content['content_block_settings'];
    if(!empty($settingArray)){
        $sectionStyle = yl_make_style($settingArray);   
    }

    $content_block = sprintf('
    <div class="section_container" %s>
        <div class="container">
            <div class="row">
                %s
            </div>
        </div>
    </div>',$sectionStyle, $textSection);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}


function display_text_editor_block($content) {
    echo get_text_editor_block_html($content);
}

function get_text_editor_content(){
    return array(
        'title' => get_sub_field('title'),
        'text_editor' => get_sub_field('text_editor'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>