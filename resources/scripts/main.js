window.jQuery = require('jquery');

// require('bootstrap');
require('bootstrap/js/dist/modal');
//require('owl.carousel');

jQuery(function ($) {

    // Hero Slider
    // {
    //     $('#heroSlider').owlCarousel({
    //         items             : 1,
    //         navText           : [ '<', '>' ],
    //         navClass          : [ 'button-arrow prev-slide', 'button-arrow next-slide' ],
    //         navElement        : 'div role="presentation"',
    //         navContainerClass : 'slider-nav',
    //     });
    // }

    // Scroll class
    {
        $(window).on('scroll', function () {
            if ($(this).scrollTop() > 300) {
                $('body').addClass('scroll');
            } else {
                $('body').removeClass('scroll');
            }
        }).trigger('scroll');

        $('.back-to-top').on('click', function () {
            $("html, body").animate({
                scrollTop : 0
            }, 500);
        });
    }
});
