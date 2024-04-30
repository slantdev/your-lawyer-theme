<?php
/**
 * Site Footer
 *
 * @package      YourLawyer
 * @author       Slant Agency
 * @since        1.0.0
 * @license      GPL-2.0+
**/

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'gs_site_footer' );
function gs_site_footer() {

   if(is_archive() || is_search()){
		echo  '</div></div></div></div>';
		// return;
	}

   $fbUrl = get_field('facebook_link', 'option');
   $linkedinLink = get_field('linkedin_link', 'option');
   $footer_phone = get_field('footer_phone', 'option');
   $footer_fax = get_field('footer_fax', 'option');
   $ringwood_office = get_field('ringwood_office', 'option');
   $mailing_address = get_field('mailing_address', 'option');
   $business_hours = get_field('business_hours', 'option');
   $footer_description = get_field('footer_form_description', 'option');
   $footer_shortcode = get_field('footer_form_shortcode', 'option');
   
   echo '<div class="footer_wrapper">
   
   <div class="footer_wrapper__brand">

      <div class="footer_wrapper__logo">';
       echo sprintf('<a href="%s" class="custom-logo-link" rel="home" aria-current="page"><img src="%s" class="custom-logo" alt="yourlawyer"></a>',esc_url(home_url()),get_field('footer_logo','option'));
      echo '</div>';

      echo sprintf('<div class="row">
         <div class="col-lg-6">
            <div class="footer_wrapper__address">
               <div class="footer_wrapper__address_title">
                  Ringwood Office 
               </div>   
               <div class="footer_wrapper__address_content">
                  %s
               </div>   

               <div class="footer_wrapper__address_title">
               Mailing Address
               </div>   
               <div class="footer_wrapper__address_content">
                  %s
               </div>   

            </div>
         </div>
         <div class="col-lg-6">
         <div class="footer_wrapper__contact">
            <div class="footer_wrapper__contact_number">
               <span class="bold">Phone: </span>%s
               </div>
               <div class="footer_wrapper__contact_number">
               <span class="bold">Fax: </span>%s
               </div>
         </div>
         <div class="footer_wrapper__bhrs">
         <div class="footer_wrapper__address_title">
            Business Hours
         </div>   
         <div class="footer_wrapper__address_content">
            <div class="times">%s</div>
         </div>   
         </div>
         </div>
      </div>

   </div>
   <div class="footer_wrapper__navigation">
   <div class="footer_wrapper__widget_title">QUICK LINKS</div>
   ',$ringwood_office, $mailing_address, '<a href="tel:'.$footer_phone.'">'.$footer_phone.'</a>', $footer_fax, $business_hours);
   echo '<nav class="nav-menu" role="navigation">';
                if( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'container_class' => 'nav-footer' ) );
                }
   echo '</nav>';
   echo '</div>
   <div class="footer_wrapper__social">
   <div class="footer_wrapper__widget_title">SOCIAL MEDIA</div>
   ';
   echo sprintf('<div class="top_bar__social"><ul>
	<li><a href="%s" target = "_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>	
	<li><a href="%s" target = "_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
	</ul></div>',$fbUrl, $linkedinLink);
   echo '</div>
   <div class="footer_wrapper__newsletter">
   <div class="footer_wrapper__widget_title">SUBSCRIBE TO OUR NEWSLETTER</div>';
   echo sprintf('<div class="footer_wrapper__form_description">%s</div>',$footer_description);
   echo sprintf('<div class="footer_wrapper__form_shortcode">%s</div>',do_shortcode($footer_shortcode));
   echo '</div>
   </div>';

   
   echo '<div class="copyright_wrapper">
   <div class="container">
   <div class="row">

   <div class="copyright_wrapper__nav col-lg-6 col-md-6">';
      if( has_nav_menu( 'primary' ) ) {
         wp_nav_menu( array( 'theme_location' => 'copyrightbarmenu', 'menu_id' => 'copyrightbarmenu-menu', 'container_class' => 'nav-copyrightbarmenu' ) );
   }
   echo '</div>
   <div class="copyright_wrapper__copy col-lg-6 col-md-6">
   ©'. date("Y") .' by YOURLAWYER P/L
   </div>

   </div>
   </div>
   </div>';

}