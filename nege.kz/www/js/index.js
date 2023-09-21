$(function(){
    $('.player .player-menu').click(function() {
        $(this).toggleClass('opened');
        $('.player .play-list').toggleClass('opened');
        $('.player .name').toggleClass('none');
        $('.player .scale').toggleClass('opened');
    });
    $('.main-news-right-items .last-news').customScroll();
    $('.js-burger').click(function () {
        $('.header').toggleClass('menu-opened');
    });

    var $slider;

    function buildSliderConfiguration() {
        var windowWidth = $(window).width();
        var numberOfVisibleSlides;

        if (windowWidth < 420) {
            numberOfVisibleSlides = 1;
        }
        else if (windowWidth < 768) {
            numberOfVisibleSlides = 2;
        }
        else if (windowWidth < 1152) {
            numberOfVisibleSlides = 3;
        }
        else {
            numberOfVisibleSlides = 4;
        }

        return {
            adaptiveHeight: true,
            slideMargin: 0,
            slideWidth: 0,
            minSlides: numberOfVisibleSlides,
            maxSlides: numberOfVisibleSlides,
            responsive: true
        };
    }

    function configureSlider() {
        var config = buildSliderConfiguration();

        if ($slider && $slider.reloadSlider) {
            $slider.reloadSlider(config);
        }
        else {
            $slider = $('.slider4').bxSlider(config);
        }
    }
    
    $(window).on("orientationchange resize", configureSlider);

    configureSlider();
   
});