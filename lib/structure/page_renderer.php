<?php

    /**
     * Function: Page Renderer
     * Displays page content from the ACF form content
     *
     * @param String $flex_content	ID of flexible row form created in ACF
     *
     */

    function page_renderer($flex_content, $post_id)
    {
        
        // Check value exists.
        if (have_rows($flex_content, $post_id)):

            // Loop through rows.
            while (have_rows($flex_content, $post_id)) : the_row();
            

                $selected_layout = get_row_layout();
                
                switch ($selected_layout) {

                    /* -- format example -- /
                    case "section_name":
                        echo get_layout_function();
                        break;
                    /* -- example end -- */

                    // text_with_button  style1 style2
                    // services_list  full width/less width
                    // featured_slider
                    // testimonial slider
                    // blog_grid
                    // insight_grid
                    // team_listing
                    // image

                    case "text_with_services":
                        display_text_with_services_block(get_text_with_services_content());
                        break;
                    case "featured_slider":
                        display_featured_slider_block(get_featured_slider_content());
                        break;
                    case "testimonial_slider":
                        display_testimonial_slider_block(get_testimonial_slider_content());
                        break;
                    case "blog_grid":
                        display_blog_grid_block(get_blog_grid_content());
                        break;
                    case "text_with_image":
                        display_text_with_image_block(get_text_with_image_content());
                        break;
                    case "team_listing":
                        display_team_listing_block(get_team_listing_content());
                        break;
                    case "text_editor":
                        display_text_editor_block(get_text_editor_content());
                        break;
                    case "contact_section":
                        display_contact_section_block(get_contact_section_content());
                        break;

                    // case "text_and_image":
                    //     display_image_with_text_block(get_image_with_text_block_content());
                    //     break;

                    // case "wide_text_and_image":
                    //     display_wide_image_with_text_block(get_wide_image_with_text_block_content());
                    //     break;

                    case "color_text_block_with_image":
                        display_color_text_block_with_image(get_color_text_block_with_image_content());
                        break;

                    // case "color_text_block":
                    //     display_color_text_block(get_color_text_block_content());
                    //     break;

                    // case "text_with_large_quotes":
                    //     display_block_with_large_quote(get_block_with_large_quote_content());
                    //     break;

                    // // CTAS

                    // case "subscribe_to_newsletter":
                    //     display_subscribe_to_newsletter(get_subscribe_to_newsletter_content());
                    //     break;

                    // case "two_line_cta":
                    //     display_two_line_ctas(get_two_line_ctas_content());
                    //     break;

                    // case "solid_color_cta":
                    //     display_solid_color_cta(get_solid_color_cta_content());
                    //     break;

                    // case "cta_with_image":
                    //     display_cta_with_image(get_cta_with_image_content());
                    //     break;

                    // case "three_card_cta":
                    //     display_three_cta_cards(get_three_cta_cards_content());
                    //     break;

                    // case "download_pdf_block":
                    //     display_download_pdf_block(get_download_pdf_block_content());
                    //     break;

                    // case "contact_form":
                    //     display_contact_form_block(get_contact_form_block_content());
                    //     break;

                    // case "loan_comparison_cards":
                    //     display_loan_comparison(get_loan_comparison_content());
                    //     break;

                    // case "icon_block_cards":
                    //     display_icon_blocks(get_icon_blocks_content());
                    //     break;

                    // case "text_block_cards":
                    //     display_text_block_cards(get_text_block_cards_content());
                    //     break;

                    // case "image_and_icon_cards":
                    //     display_photo_and_icon_cards(get_photo_and_icon_cards_content());
                    //     break;

                    // case "news_archive":
                    //     display_photo_and_icon_cards(get_news_content());
                    //     break;

                    // case "small_photo_cards":
                    //     display_small_photo_cards(get_small_photo_cards_content());
                    //     break;

                    // case "testimonial_cards":
                    //     display_testimonial_cards(get_testimonial_cards_content());
                    //     break;

                    // case "contact_details_cards":
                    //     display_contact_details_block(get_contact_details_block_content());
                    //     break;

                    // case "donate_now_form":
                    //     display_donate_now_form(get_donate_now_form_content());
                    //     break;

                    // case "page_form":
                    //     display_form(get_form_content());
                    //     break;

                    // case "two_card_block":
                    //     display_two_card_block(get_two_card_block_content());
                    //     break;

                    // case "shortcut_blocks":
                    //     display_shortcut_blocks(get_shortcut_block_content());
                    //     break;

                    // case "full_black_image":
                    //     display_full_black_image();
                    //     break;

                    // case "twitter_feed":
                    //     display_twitter_feed(get_twitter_feed_content());
                    //     break;

                    // case "gallery_block_01":
                    //     display_gallery_block(get_gallery_block_content());
                    //     break;

                    // case "gallery_block_02":
                    //     display_gallery_block_02(display_gallery_block_02_content());
                    //     break;

                    // case "tick_block":
                    //     display_tick_block(get_tick_block_content());
                    //     break;

                    // case "step_block_cards":
                    //     display_steps_block(get_step_block_content());
                    //     break;

                    // case "frequently_asked_questions":
                    //     display_faq(get_faq_content());
                    //     break;

                    // case "our_board":
                    //     display_our_board_block(get_our_board_block_content());
                    //     break;

                    // case "key_contacts":
                    //     display_key_contact_block(get_key_contact_block_content());
                    //     break;

                    // case "gallery_slider":
                    //     display_gallery_slider(get_gallery_slider_content());
                    //     break;

                    // case "four_card_block":
                    //     display_four_card_block(get_four_card_block_content());
                    //     break;

                    // case "html_block":
                    //     display_html_block(get_html_block_content());
                    //     break;

                    // case "people_blocks":
                    //     display_people_block(get_people_block_content());
                    //     break;



                    default:
                        break;
                }

            // End loop.
            endwhile;

        // No value.
        else :
            // Invalid ACF form ID
        endif;
    }
