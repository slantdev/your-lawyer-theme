<?php
add_shortcode( 'gs_services_megamenu', 'gs_services_megamenu_shortcode' );
function gs_services_megamenu_shortcode( $atts ) {

    $atts = shortcode_atts( array(
        'menu' => '',
        'col' => 1
    ), $atts );

    $column = $atts['col'];

    $defaults = array(
        //'menu' => 'Our Services - Counselling and Support',
        'menu' => $atts['menu'],
        'menu_class' => 'grid gap-x-8 gap-y-4 grid-cols-' . $column,
        'walker' => new GS_Service_Mega_Menu_Walker
    );

    $args = wp_parse_args( $args, $defaults );

    //$output = '';
    $output = wp_nav_menu( $args );

    return $output;

}