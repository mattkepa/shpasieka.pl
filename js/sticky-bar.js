$(document).ready(function() {
   const stickyNavTop = $('.cardbar').offset().top;

   const stickyNav = function(){
   const scrollTop = $(window).scrollTop();

   if (scrollTop > stickyNavTop) { 
      $('.cardbar').addClass('sticky');
   } else {
      $('.cardbar').removeClass('sticky');
    }
   };

   stickyNav();

   $(window).scroll(function() {
      stickyNav();
   });
});