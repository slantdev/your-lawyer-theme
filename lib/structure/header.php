<?php
/**
 * Site Header
 *
 * @package      YourLawyer
 * @author       Slant Agency
 * @since        1.0.0
 * @license      GPL-2.0+
**/


add_action( 'genesis_header', 'denish_genesis_do_header' );
/**
 * Echo the default header, including the #title-area div, along with #title and #description, as well as the .widget-area.
 *
 * Does the `genesis_site_title`, `genesis_site_description` and `genesis_header_right` actions.
 *
 * @since 1.0.2
 *
 * @global $wp_registered_sidebars Holds all of the registered sidebars.
 */
function denish_genesis_do_header() {

	global $wp_registered_sidebars;
    $class = "";
	//echo '<div class="custom_container">';
    echo '<div class="logo_nav">';

    echo '<div class="logo_nav__logo ">';
	genesis_markup(
		[
			'open'    => '<div %s>',
            'context' => 'logo-area',
            
		]
	);

	/**
	 * Fires inside the title area, before the site description hook.
	 *
	 * @since 2.6.0
	 */
	do_action( 'genesis_site_title' );

	/**
	 * Fires inside the title area, after the site title hook.
	 *
	 * @since 1.0.0
	 */
    do_action( 'genesis_site_description' );
    

	genesis_markup(
		[
			'close'   => '</div>',
            'context' => 'logo-area',
            
		]
    );
    
    echo '</div><div class="logo_nav__nav "><div class="mobile_menu"><i class="fa fa-bars" aria-hidden="true"></i></div><nav class="nav-menu_inner" role="navigation">';
    genesis_nav_menu(
		[
			'theme_location' => 'primary',
			'menu_class'     => $class,
		]
	);
	
	echo '
	
	<div class="search_icon_wrapper">
	<div class="search_icon"><i class="fa fa-search"></i></div>
	<div class="header-search absolute top-0 right-0">' . get_search_form( array( 'echo' => false ) ) . '</div></div>';
    
    
    echo '</nav></div>';

    echo '</div>'; //logo_nav
	//echo '</div>';
    
}

add_action( 'genesis_before_header', 'denish_top_bar', 99 );
function denish_top_bar(){
	$class = "";
	

	$telephone = get_field('top_bar_phone', 'option');
	$email = get_field('top_bar_email', 'option');
	$fbUrl = get_field('facebook_link', 'option');
	$linkedinLink = get_field('linkedin_link', 'option');
	$backStyle = !empty(get_field('background_image'))?'background-image:url(\''.esc_url( get_field('background_image') ).'\');':'';
	$headerStyle = !empty(get_field('header_style'))?get_field('header_style'):'';
	$background_opacity_color = !empty(get_field('background_opacity_color'))?"background:".get_field('background_opacity_color'):'';

	if(is_singular('post') && $backStyle == ''){
		$backStyle = 'background-image:url(\''.esc_url( wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ) ).'\');';
	}

	$html = '';
	$html .= sprintf('<section class="herosection bgimage %s" style="%s">',$headerStyle, $backStyle);
	$html .= sprintf('<div class="opacitywrapper" style="%s">%s</div>',$background_opacity_color,"");
	//$html .= '<div class="header_top_wrapper">'; // this over in following function
	$html .= '<div class="top_bar"><div class="custom_container">';
    $html .= '<div class="top_bar__left">';
	$html .= '<ul class="top_bar__contact">';
	$html .= sprintf('<li class="top_bar__email"><span>Email: </span><a href="tel:%s">%s</a></li>',$email,$email);
	$html .= sprintf('<li class="top_bar__phone"><span>Phone: </span><a href="email:%s">%s</a></li>',$telephone,$telephone);
    $html .= '</ul>';
    $html .= '</div>';
    $html .= '<div class="top_bar__right">';
    $html .= genesis_get_nav_menu(
		[
			'theme_location' => 'secondary',
			'menu_class'     => $class,
		]
	);
	$html .= sprintf('<div class="top_bar__social"><ul>
	<li><a href="%s" target = "_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>	
	<li><a href="%s" target = "_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
	</ul></div>',$fbUrl, $linkedinLink);
    $html .= '</div></div>';
	$html .= '</div>';
 

    echo  $html;
}

add_action('genesis_after_header','yl_after_header');
function yl_after_header(){

	//$html = "</div>"; // over end header_top_wrapper
	$html = "";
	$pageTitle = (get_field('custom_title')!="")?get_field('custom_title'):'';
	$page_info_title = get_field('page_info_title');
	$featured_title = get_field('featured_title');
	
{
    }
	if(is_archive() || is_search()){
		
		$pageTitle = "";
		$page_info_title = "";
		$featured_title = "";
	}

	if(is_singular('post') && $pageTitle == ''){
		$pageTitle = get_the_title();
	}
	
	
	$pageContent = get_field('description');
	$button = !empty(get_field('button_url'))?'<a class="btn" href="'.esc_attr( get_field('button_url') ).'">'.esc_html( get_field('button_label') ).'</a>':'';
	$headerStyle = !empty(get_field('header_style'))?get_field('header_style'):'';
	
	if(!empty($pageTitle)){
		$html .= '<div class="container">
		<div class="row">
	<div class="title_wrapper">
	   <div class="row">';
       if ($headerStyle!="big") {
		   if(!is_singular('services')){
			$html .=  '<div class="col-lg-12">';
		   }else{
			$html .=  '<div class="col-lg-8">';
		   }
		
       }else{
		$html .=  '<div class="col-lg-8">';
	   }
		$html .= sprintf('<h1 class="hero_main_title">%s</h1>', $pageTitle);
		$html .= '</div>';

		if(is_singular('services')){
			$html .=  '<div class="col-lg-4">';
			$html .= sprintf('<div class="service_hero_button"><div class="herobutton">%s</div></div>',$button);
			$html .= '</div>';
		}

	   $html .= '</div>
	   <div class="row">';
	   if ($headerStyle!="big") {
		$html .=  '<div class="col-lg-9">';
	}else{
		$html .=  '<div class="col-lg-6">';
	}
	   $html .= sprintf('<div class="description">%s</div>',$pageContent);
	   
       if (!is_singular('services')) {
			$html .= sprintf('<div class="herobutton">%s</div>', $button);
       }
			   $html .= '</div>
			
	   </div>
	   
	</div>
 </div>
		</div>';
	
	}

	$html .= '</section>';

  	
	$page_info_description = get_field('page_info_description');
	$page_info_button = !empty(get_field('page_info_button_url'))?'<a class="btn howcanwehelp" href="'.esc_attr( get_field('page_info_button_url') ).'">How can we help you?</a>':'';
	
    if (!empty($page_info_title)) {
        $html .= sprintf('<section class="page_info__wrapper" style="background-image:url(%s)">
	<div class="container">
	<div class="row">
	<div class="title_wrapper">
	   <div class="row">
	   <div class="col-lg-12">
	   		<h2 class="main_title">%s</h2>
		</div>
	   </div>
	   <div class="row">
	   <div class="col-lg-9">
	   		<div class="description">%s</div>
		</div>
			<div class="col-lg-3 text-align-right">%s</div>
	   </div>
	   
	</div>
 </div>
	</div>
  </section>', get_stylesheet_directory_uri()."/assets/images/Group-1411.png", $page_info_title, $page_info_description, $page_info_button);
	}
	
	
	$page_info_description = get_field('featured_content');
	$featured_label = get_field('featured_label');
	$page_info_button = !empty(get_field('page_info_button_url'))?'<a class="btn howcanwehelp" href="'.esc_attr( get_field('page_info_button_url') ).'">How can we help you?</a>':'';
	
    if (!empty($featured_title)) {
        $html .= sprintf('<section class="page_info__wrapper servicepage_info__wrapper" style="background-image:url(%s)">
	<div class="container">
	<div class="row">
	<div class="title_wrapper">
	   <div class="row">
			<div class="col-lg-9">
				<h2 class="featured_label">%s</h2>
			</div>
			<div class="col-lg-3">
				%s
			</div>
	   </div>
	   <div class="row">
		<div class="col-lg-9">
				<div class="main_title">%s</div>
				<div class="description">%s</div>
			</div>
	   </div>
	   
	</div>
 </div>
	</div>
  </section>', get_stylesheet_directory_uri()."/assets/images/backgroundImage-darkBG.png", $featured_label, $page_info_button, $featured_title,  $page_info_description);
	}

	if(is_archive() || is_search()){
		$html .=   '<div class="custom_wrapper_container"> <div class="container"><div class="row"><div class="col-lg-12">';
		
	}
	
  echo $html;

}

