jQuery(document).ready(function($){

jQuery(".mobile_menu").click(function(){
  jQuery(".logo_nav__nav ").toggleClass("menuclose");
  jQuery(".nav-primary").slideToggle("slow");
});

$('.featured_slider').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1
});
			
$('.testimonial_main_wrapper').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: true, 
});
      
jQuery(".insight_filter li").click(function() {
  jQuery(".positioninsightreplacer").prepend("<div class='denloader'></div>");
  $this = jQuery(this);
  const searchboxdata = {
      'action': 'filter_insight_positions',
      'insightid': $this.attr("data-id"),
      'insighttext': $this.text()
  };

  jQuery.post({
      url: userdata.ajax_url,
      data: searchboxdata,
      //dataType: "json",
      success: function( data ) {
      console.log(data);
      $this.closest(".blog_grid_section").find(".blog_grid_wrapper").replaceWith(data);
      jQuery(".denloader").remove();
      },
      error: function(xhr, status, error) {
          // process status && error
          console.log(error);
      }
  });
});

jQuery(".people_select").change(function() {

  jQuery(".positiondepartmentreplacer").prepend("<div class='denloader'></div>");

  const searchboxdata = {
      'action': 'filter_about_positions',
      'positionID': jQuery(".people_select option:selected").val()
  };

  jQuery.post({
      url: userdata.ajax_url,
      data: searchboxdata,
      //dataType: "json",
      success: function( data ) {
      // console.log(data);
        jQuery(".people_list__container_wraper").replaceWith(data);
        jQuery(".denloader").remove();
      },
      error: function(xhr, status, error) {
          // process status && error
          console.log('Error:');
          console.log(error);
      }
  });

});

jQuery(".search_icon_wrapper i").click(function(){

  $this = jQuery(this);

  $this.closest(".search_icon_wrapper").toggleClass("showsearch");

});

jQuery(".entry-content").on("click", ".people_list__inner", function() {

  console.log("Modal Activate!!!");

  $this = jQuery(this);

    $(".people_popup_media_container").html($this.find(".people_list__media").html());
    $(".people_popup_content_container .people_list__title").html($this.find(".people_list__title").html());
    $(".people_popup_content_container .people_list__cat").html($this.find(".people_list__cat").html());
    $(".people_popup_content_container .people_list__description").html($this.find(".people_list__description").html());


    $('.contact').addClass('is-visible');
});

jQuery(".close_popup").click(function(){
  $('.contact').removeClass('is-visible');
});

});