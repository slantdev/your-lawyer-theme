<?php

function get_blog_grid_block_html($content) {
    
    $textSection = $filterSection = "";

    
    $textSection .= '<div class="row"><div class="col-lg-8">';

    if(!empty($content['sub_title']))
    $textSection .= sprintf('<div class="sub_title">%s</div>',$content['sub_title']);

    if(!empty($content['title']))
    $textSection .= sprintf('<h2 class="main_title">%s</h2>',$content['title']);

    if(!empty($content['description']))
    $textSection .= sprintf('<div class="description">%s</div>',$content['description']);

    
    $textSection .= '</div><div class="col-lg-4 text-align-right">';

    if( $content['talk_to_us'] && !empty($content['talk_to_us_link'])  )
    $textSection .= sprintf('<a href="%s" class="btn talktous">%s</a>',$content['talk_to_us_link'],'Talk To Us');

    
    $textSection .= '</div></div>';    

        $titleWrapperSection = sprintf('<div class="title_wrapper">%s</div>',$textSection);

        if ($content['show_filter']) {
            
            $filterSection = sprintf('<div class="blog_grid_filter_wrapper">%s</div>', $filterSection);
        }
        
    
        $testimonialSection = '';
        $limit = (isset($content['limit']))?$content['limit']:20;
        $term_new_ar = array();
        $show_insight_only = (false === $content['show_insight_only'])?false:true;
        if($show_insight_only){
            $temp = get_terms( 'insight' );
            if(!empty($temp)){
                foreach($temp as $single_term){
                    $term_new_ar[$single_term->term_id] = $single_term->name;
                }
            }
            // $term_ids = wp_list_pluck(  , 'term_id' );
        }
        
        $testimonialSection = get_blog_grid_post_content($limit,$show_insight_only,$term_new_ar,false,$content['show_filter']);
        $testimonialSection = sprintf('<div class="blog_grid_section_inner">%s</div>',$testimonialSection);

        $show_view_all_button_content = "";
        if($content['show_view_all_button']){
            $show_view_all_button_content = sprintf('<div class="show_view_all_button_wrapper"><a href="/insight" class="btn show_view_all_button"><i class="fa fa-eye"></i>VIEW ALL</a></div');
        }
    
    $sectionStyle = '';
    $settingArray = $content['content_block_settings'];
    if(!empty($settingArray)){
        $sectionStyle = yl_make_style($settingArray);
    }
    $section_style_type = isset($settingArray['section_style_type'])?$settingArray['section_style_type'].'section':'lightsection';

    $content_block = sprintf('<div class="section_container blog_grid_section %s" %s><div class="container"><div class="row">%s</div>%s%s</div></div>',$section_style_type, $sectionStyle, $titleWrapperSection,$testimonialSection,$show_view_all_button_content);
    //wrap in section element
    $content_block = wrap_content($content_block);
    
    return $content_block;
}


function get_blog_grid_post_content($limit=20,$insightOnly=false,$insightCats=array(),$isAjax=false,$show_filter=false){

    $serviceHtml = $filterHTML = $filterFinalHTML = '';
    unset($args);
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'order_by' => 'date',
        'order'   => 'DESC',
        'ignore_custom_sort' => true,
    );

    if($insightOnly){

           // get all terms in the taxonomy

    if(!empty($insightCats) && !$isAjax){
        if($show_filter){
            $filterHTML .= sprintf('<li class="selectedinsightfilter" data-id="%s">%s</li>',"0","All");
            foreach($insightCats as $insightID => $insightCat){
                $filterHTML .= sprintf('<li data-id="%s">%s</li>',$insightID,$insightCat);
            }
            $filterFinalHTML = sprintf('<ul class="insight_filter">%s</ul>',$filterHTML);
        }
    }

    
        if(isset($insightCats[0]) && $insightCats[0]=="All"){

            // get all terms in the taxonomy
            $terms = get_terms( 'insight' ); 
            // convert array of term objects to array of term IDs
            $term_ids = wp_list_pluck( $terms, 'term_id' );


            $args['tax_query'] = array(
                array(
                    // 'operator' => 'NOT IN',
                    'taxonomy' => 'insight',
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                ),
            );
        }else{
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'insight',
                    'field'    => 'term_id',
                    'terms'    => array_keys($insightCats),
                ),
            );
        }
    }else{
        
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'insight',
                'operator' => 'NOT EXISTS'
            )
        );
        
        
    }

    
    
    $the_query = new WP_Query( $args );

    if ($the_query->have_posts()) {
        
        $serviceHtml .= '<div class="blog_featured_row row">';
        while ($the_query->have_posts()) {

            
            $the_query->the_post();


            $post_id = get_the_ID();
            $featuredTitle = get_the_title();
            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
            
            if (!$insightOnly) {
                // $catArray = array();
                // $post_categories = wp_get_post_categories( $post_id );
                // foreach ($post_categories as $c) {
                //     $cat = get_category($c);
                //     $catArray[] = $cat->name;
                // }
                // $blogCat = join(',', $catArray);
                $blogCat = get_the_date( 'd/m/Y' );
            }else{
                $post_insight = wp_get_post_terms( (int)get_the_ID(), 'insight', array( 'fields' => 'names' ) );
                $blogCat = '';
                if (!empty($post_insight)) {
                    $insightArray = array();
                    foreach ($post_insight as $c) {
                        $insightArray[] = $c;
                    }
                    $blogCat = join(',', $insightArray);
                }
            }
            $link = get_the_permalink();
            $feat_image_link = !empty($feat_image)?sprintf('<img src="%s" alt="%s" />',$feat_image, "Image of ".$featuredTitle):'';
            
            $serviceHtml .= sprintf('
            <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="blog_featured">
                    <div class="blog_featured__media">
                        %s
                    </div>
                    <div class="blog_featured__contentw" style = "display:flex; flex-direction: column;">
                        <div class="blog_featured__title">%s</div>
                        <div class="blog_featured__cat">%s</div>
                        <a href="%s" class="blog_featured__link" style = "justify-self: end;"><div class="lmr"><i class="fa fa-arrow-right"></i>LEARN MORE</div></a>
                    </div>
                
                </div>
            </div>',
            $feat_image_link, $featuredTitle, $blogCat,$link);

        }
        $serviceHtml .= '</div>';
    }

    wp_reset_query();

    $serviceHtml = sprintf('%s<div class="blog_grid_wrapper">%s</div>',$filterFinalHTML,$serviceHtml);

    return $serviceHtml;
}

function display_blog_grid_block($content) {
    
    echo get_blog_grid_block_html($content);
}

function get_blog_grid_content(){
    return array(
        'title' => get_sub_field('title'),
        'sub_title' => get_sub_field('sub_title'),
        'description' => get_sub_field('description'),
        'show_view_all_button' => get_sub_field('show_view_all_button'),
        'show_insight_only' => get_sub_field('show_insight_only'),
        'talk_to_us' => get_sub_field('talk_to_us'),
        'talk_to_us_link' => get_sub_field('talk_to_us_link'),
        'show_filter' => get_sub_field('show_filter'),
        'show_pagination' => get_sub_field('show_pagination'),
        'limit' => get_sub_field('limit'),
        'content_block_settings' => get_sub_field('content_block_settings'),
        // 'image_alt' => get_sub_field('image_alt'),
        // 'image_side' => get_sub_field('image_side'),
    );
}

?>