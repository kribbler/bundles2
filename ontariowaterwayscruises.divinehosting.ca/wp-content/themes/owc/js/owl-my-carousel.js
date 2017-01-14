$(document).ready(function($) {
      var owl = $(".testimonial-container");
      owl.owlCarousel({
            navigation: false,
            pagination: false,
            singleItem: false,
            items: 3,
            itemsDesktop : [1199,3],
            //itemsDesktopSmall : [979,1],
            itemsTablet :      [768,2],
            itemsMobile: [479,1],
            //navigationText: ['<','>'],
            loop: true
      });  

      /*$('.testimonial-container').prepend('<div class="testimonial_prev"></div>');
      $('.testimonial-container').append('<div class="testimonial_next"></div>');

      $('.testimonial_prev').addClass('col-lg-1');
      $('.testimonial_next').addClass('col-lg-1');
      */
      $('.testimonial-container').removeClass('container');
      
      $(".testimonial_next").click(function(){
      owl.trigger('owl.next');
      });

      $(".testimonial_prev").click(function(){
      owl.trigger('owl.prev');
      });
});