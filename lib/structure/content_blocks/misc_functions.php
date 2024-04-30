<?php

function wrap_content($content_block, $section_class = '') {
    $section_styles = get_section_styles();
    $section_id = get_section_id();
    $content_block = sprintf('<section %s class = "relative %s %s">%s</section>', $section_id, $section_styles, $section_class, $content_block);
    return $content_block;
}

function get_section_id() {

    if(get_sub_field('section_id')) {
        return $id = sprintf('id = "%s" attr="has_anchor"', get_sub_field('section_id'));
    } else {
        return;
    }
}

function get_section_styles() {

    $block_color = (get_sub_field('block_colour')) ? get_sub_field('block_colour') : 'white';
    $bg_color = get_block_color($block_color);
    $text_color = get_block_text_color($block_color);
    $spacing_top = (get_sub_field('spacing_top')) ? get_sub_field('spacing_top') : 'pt-12';
    $spacing_bottom = (get_sub_field('spacing_bottom')) ? get_sub_field('spacing_bottom') : 'pb-12';

    return sprintf('%s %s %s %s', $bg_color, $text_color, $spacing_top, $spacing_bottom);
}

function get_block_color($style_name) {

    //block color
    switch ($style_name) {
        case 'purple':
            return 'bg-gs_purple';
            break;
        case 'red':
            return 'bg-gs_red';
            break;
        case 'black':
            return 'bg-off_black';
            break;
        case 'white':
            return 'bg-white';
            break;
        case 'light_grey':
            return 'bg-light_grey';
            break;
        case 'off_white':
            return 'bg-off_white';
            break;
        default:
            return 'bg-transparent';
    }
}

function get_block_text_color($style_name) {
    //block color
    switch ($style_name) {
        case 'purple':
            return 'text-white';
            break;
        case 'red':
            return 'text-white';
            break;
        case 'black':
            return 'text-white';
            break;
        case 'white':
            return 'text-default';
            break;
        case 'light_grey':
            return 'text-default';
            break;
        case 'off_white':
            return 'text-default';
            break;
        default:
            return 'text-default';
    }
}

?>