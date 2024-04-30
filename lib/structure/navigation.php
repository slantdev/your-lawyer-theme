<?php
/**
 * Navigation
 *
 * @package      YourLawyer
 * @author       Slant Agency
 * @since        1.0.0
 * @license      GPL-2.0+
**/

// Don't let Genesis load menus
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/**
 * Mobile Menu
 *
 */
function gs_primary_nav() {
	//echo gs_mobile_menu_toggle();
	//echo gs_search_toggle();

    echo '<div class="site-nav hidden md:block">';
        echo '<div class="container mx-auto px-4 flex">';
            echo '<div class="relative w-full">';
                echo '<nav class="nav-menu" role="navigation">';
                if( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'container_class' => 'nav-primary' ) );
                    //wp_megamenu(array('theme_location' => 'primary'));
                }
                if( has_nav_menu( 'secondary' ) ) {
                    //wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'container_class' => 'nav-secondary' ) );
                }
                echo '</nav>';
                echo '<div class="header-search absolute top-0 right-0">' . get_search_form( array( 'echo' => false ) ) . '</div>';
            echo '</div>';
        echo '</div>';

    echo '</div>';
}
remove_action( 'genesis_after_header', 'gs_primary_nav' );



/**
 * Nav Extras
 *
 */
function gs_nav_extras( $menu, $args ) {

	if( 'primary' === $args->theme_location ) {
		$menu .= '<li class="menu-item search">' . gs_search_toggle() . '</li>';
	}

	if( 'secondary' === $args->theme_location ) {
		$menu .= '<li class="menu-item search">' . get_search_form( false ) . '</li>';
	}

	return $menu;
}
//add_filter( 'wp_nav_menu_items', 'gs_nav_extras', 10, 2 );

/**
 * Search toggle
 *
 */
function gs_search_toggle() {
	$output = '<button' . gs_amp_class( 'search-toggle', 'active', 'searchActive' ) . gs_amp_toggle( 'searchActive', array( 'menuActive', 'mobileFollow' ) ) . '>';
		$output .= gs_icon( array( 'icon' => 'search', 'size' => 24, 'class' => 'open' ) );
		$output .= gs_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Search</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Mobile menu toggle
 *
 */
function gs_mobile_menu_toggle() {
	$output = '<button' . gs_amp_class( 'menu-toggle', 'active', 'menuActive' ) . gs_amp_toggle( 'menuActive', array( 'searchActive', 'mobileFollow' ) ) . '>';
		$output .= gs_icon( array( 'icon' => 'menu', 'size' => 24, 'class' => 'open' ) );
		$output .= gs_icon( array( 'icon' => 'close', 'size' => 24, 'class' => 'close' ) );
		$output .= '<span class="screen-reader-text">Menu</span>';
	$output .= '</button>';
	return $output;
}

/**
 * Add a dropdown icon to top-level menu items.
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 * @return string Nav menu item start element.
 * Add a dropdown icon to top-level menu items
 */
function gs_nav_add_dropdown_icons( $output, $item, $depth, $args ) {

	if ( ! isset( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $output;
	}

	if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add SVG icon to parent items.
		$icon = gs_icon( array( 'icon' => 'navigate-down', 'size' => 8, 'title' => 'Submenu Dropdown' ) );

		$output .= sprintf(
			'<button' . gs_amp_nav_dropdown( $args->theme_location, $depth ) . ' tabindex="-1">%s</button>',
			$icon
		);
	}

	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'gs_nav_add_dropdown_icons', 10, 4 );
