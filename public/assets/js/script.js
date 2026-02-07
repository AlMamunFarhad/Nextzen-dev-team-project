$(document).ready(function(){
    // Mobile Menu Icon
   $('#nav-icon').click(function(){
      $(this).toggleClass('open');
      $('.header-nav nav').slideToggle();
   });

});
