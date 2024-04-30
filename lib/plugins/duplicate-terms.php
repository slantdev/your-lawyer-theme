<?php
/*
Plugin Name: ACF Duplicate taxonomy terms with all fields
Description: Duplicate any custom taxonomy term, including built-in categories and tags + all ACF fields (all values from old term will be copied to new one)
Version: 1.0.1
Author: Kresimir Pendic
Author URI: http://mk-dizajn.com
License: GPL
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/



// bail if WP is not loaded
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

// DUPLICATE CATEGORIES WITH ACF FIELDS class
if( !class_exists( 'DupTerms' ) ):

class DupTerms {
    function __construct() {
        add_action('admin_menu', array($this, 'make_duplicate') );
        add_action('current_screen', array($this, 'check_tax') );
    }

    function check_tax(){
        $cs = get_current_screen();
        if( $cs->taxonomy != '' ){
            add_filter( $cs->taxonomy . '_row_actions', array($this, 'add_duplicate_link'), 10, 2);
        }

    }

    function add_duplicate_link($actions, $term) {
        $pt = '';
        if( isset( $_REQUEST['post_type'] ) ){
            $pt = sanitize_text_field( $_REQUEST['post_type'] );
        }

        $duplicate_url = add_query_arg(
            array('term_duplicator_term' => $term->term_id,
                '_td_nonce' => wp_create_nonce('duplicate_term'),
                'taxonomy' => $term->taxonomy,
                'post_type' => $pt
            ), admin_url('edit-tags.php') );
        $actions['term_duplicator'] = "<a href='{$duplicate_url}'>" . __('Duplicate', 'term-duplicator') . "</a>";

        return $actions;
    }

    function make_duplicate() {
        if ( isset($_REQUEST['_td_nonce']) && check_admin_referer('duplicate_term', '_td_nonce') ) {
            $term_id = (int) sanitize_key( $_REQUEST['term_duplicator_term'] );
            $term_tax = sanitize_text_field( $_REQUEST['taxonomy'] );

            $oldT = get_term($term_id, $term_tax);
            // get all ACF fields
            $oldM = $newT = false;

            if( class_exists('acf') ) $oldM = get_fields( 'category_' . $term_id );
            // create new copy if we have TERM & TAX
            if( taxonomy_exists( $term_tax ) && $oldT )
                $newT = wp_insert_term( "{$oldT->name} Copy",
                    $term_tax, array('description' => $oldT->description,
                    'slug' => "{$oldT->slug}-copy",
                    'parent' =>  $oldT->parent )
                );

            // try to copy ACF fields.. only if there is any data in them
            if ( ! is_wp_error($newT) && $newT ) {
                $termID = $newT['term_id']; // new term ID
                if( $termID ){
                    try {
                        foreach ($oldM as $key => $value) {
                            update_field( $key, $value, "{$term_tax}_{$termID}" );
                        }
                    } catch (Exception $e) { } // TODO: handle error reporting to user..
                }
            }
        }
    }
}

/**
 * [Returning of the original plugin instance]
 * @return [object] [main plugin instance]
 */
function DupTerms(){
    global $DupTerms;

    if( !isset($DupTerms) ) $DupTerms = new DupTerms();

    return $DupTerms;
}

// initialize plugin
DupTerms();

endif; // class_exists check
