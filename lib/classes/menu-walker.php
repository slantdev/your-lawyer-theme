<?php

class GS_Service_Mega_Menu_Walker extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        //$output .= '<pre>' . print_r($item) . '</pre>';
        //$output .= print_r($item);

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
        $item_output .= '<a'. $attributes .' style="padding: 0">';
        $item_output .= '<div class="flex rounded-lg border items-center overflow-hidden mb-0 text-gray-700 no-underline img-greyscale">';
        //$item_output .= $item->object_id;
        $image = get_field('menu_image', $item);
        if ($image ) {
            $item_output .= '<img class="object-cover w-28 h-28 m-0 rounded-l-lg transition-all" src="' . $image . '" width="112" height="112" alt="' . $item->title . '">';
        }
        $item_output .= '<span class="text-lg py-4 px-6 font-normal">';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</span>';
        //$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
        $item_output .= '</div>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}