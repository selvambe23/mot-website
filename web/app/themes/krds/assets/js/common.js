
export function common() {
    var isTouch = ('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0);
    $('html').addClass((isTouch) ? 'touch' : 'no-touch');

	if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0)
        $('html').addClass('safari');

    $('.mainBanner > div').addClass(($('.mediaCnt img').attr('src') == '') ? 'bg' : '');

    $('#menu-toggle').click(function (e) {
        e.preventDefault();
        $(this).removeClass('stop');
        $(this).stop().toggleClass('active');
        $('#menu').stop().slideToggle(500);
        $('.mainMenu .sub-menu').slideUp();
    });

};
