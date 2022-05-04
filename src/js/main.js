// Gallery carousel (uses the Owl Carousel library)
$(".gallery-carousel").owlCarousel({
  autoplay: true,
  dots: true,
  loop: true,
  responsive: {
    0: {
      items: 1
    },
    200: {
      items: 1
    },
    768: {
      items: 2
    },
    900: {
      items: 3
    }
  }
});

// Toggle icon on mobile nav
$('#nav-icon').click(function () {
  $(this).toggleClass("bx-menu bx-x");
});

// Closes responsive menu when a scroll trigger link is clicked
$('.nav-link').click(function() {
  $('.navbar-collapse').collapse('hide');
  if($('#nav-icon').hasClass("bx-x")){
    $('#nav-icon').removeClass("bx-x");
    $('#nav-icon').addClass("bx-menu");
  }
});

$(window).scroll(function () {
  if ($(this).scrollTop() > 100) {
    $('.navbar').addClass('navbar-scrolled');
  } else {
    $('.navbar').removeClass('navbar-scrolled');
  }
});

// Init AOS
function aos_init() {
  AOS.init({
    duration: 1000,
    easing: "ease-in-out",
    once: true,
    mirror: false
  });
}
$(window).on('load', function () {
  aos_init();
});

// Back to top button 
$(window).scroll(function () {
  if ($(this).scrollTop() > 100) {
    $('.back-to-top').fadeIn('slow');
  } else {
    $('.back-to-top').fadeOut('slow');
  }
});

$('.back-to-top').click(function () {
  $('html, body').animate({
    scrollTop: 0
  }, 1000, 'easeInOutExpo');
  return false;
});

// Smooth scroll for the navigation menu and links with .scrollto classes
var scrolltoOffset = $('nav').outerHeight() - 1;
$(document).on('click', '.nav-item a, .scrollto', function(e) {
  if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
    var target = $(this.hash);
    if (target.length) {
      e.preventDefault();

      var scrollto = target.offset().top - scrolltoOffset;

      if ($(this).attr("href") == '#hero') {
        scrollto = 0;
      }

      $('html, body').animate({
        scrollTop: scrollto
      }, 1000, 'easeInOutExpo');

      if ($(this).parents('.nav-item').length) {
        $('.nav-item .active').removeClass('active');
        $(this).closest('.nav-link').addClass('active');
      }

      return false;
    }
  }
});

// Cars isotope and filter
$(window).on('load', function () {
  var portfolioIsotope = $('.cars-container').isotope({
    itemSelector: '.cars-item',
    layoutMode: 'fitRows'
  });

  $('#cars-flters li').on('click', function () {
    $("#cars-flters li").removeClass('filter-active');
    $(this).addClass('filter-active');

    portfolioIsotope.isotope({
      filter: $(this).data('filter')
    });
    aos_init();
  });
});
