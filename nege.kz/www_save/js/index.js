$(function(){
    $('.slider4').bxSlider({
        slideWidth: 210,
        minSlides: 4,
        maxSlides: 4,
        moveSlides: 1,
        slideMargin: 72
    });
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
});