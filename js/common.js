$('.whatsay-slider').slick({
         dots: true,
         infinite: true,
         arrows: false,
         speed: 500,
         slidesToShow: 2,
         autoplaySpeed: 2000,
         autoplay: true,
         responsive: [{
                 breakpoint: 767,
                 settings: {
                     slidesToShow:1
                 }
             },
             {
                 breakpoint: 575,
                 settings: {
                     slidesToShow:1
                 }
             }
         ]
     });


$(".mobile-toggle").click(function(){
  $(".menu").slideToggle();
});

// acoordian 
/* jQuery
================================================== */
$(function() {
  $('.acc__title').click(function(j) {
    
    var dropDown = $(this).closest('.acc__card').find('.acc__panel');
    $(this).closest('.acc').find('.acc__panel').not(dropDown).slideUp();
    
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
    } else {
      $(this).closest('.acc').find('.acc__title.active').removeClass('active');
      $(this).addClass('active');
    }
    
    dropDown.stop(false, true).slideToggle();
    j.preventDefault();
  });
});