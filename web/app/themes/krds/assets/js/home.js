
export function home() {
    //swiperInspiration
    var getinspired = new Swiper('#getinspired', {
        slidesPerView: 4,
        slidesPerColumn: 1,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        spaceBetween: 0,
        loop: false,
        breakpoints: {
            1000: {
                slidesPerView: 2,
                slidesPerColumn: 2
            }
        }
    });

    $(window).on('resize orientationchange', function(){
        if($(window).width() < 1001) {
            getinspired.params.slidesPerView = 2;
            getinspired.params.slidesPerColumn = 2;
            getinspired.container.addClass('swiper-container-multirow');
            getinspired.update();
        } else {
            getinspired.params.slidesPerView = 4;
            getinspired.params.slidesPerColumn = 1;
            getinspired.container.removeClass('swiper-container-multirow');
            getinspired.update();
        }
    });

    // swiperItinerary
   $('.itinerarySlider').each(function () {
        var id = $(this).prop('id');
        var settings = {
            effect: 'fade',
            speed: 1000,
            initialSlide: 0,
            nextButton: '#' + id + ' .swiper-button-next',
            prevButton: '#' + id + ' .swiper-button-prev',
            loop: false,
            observer: true,
            observeParents: true,
  },
        itinerary = new Swiper('#' + id, settings);

   });

    //Itinerary section tab
    $(".tabHead:first").addClass('active');
    $(".tabSection:first").show();

    $('.tabHead').on('click', function (e) {
        var sec_id = $(this).data('tab_id');
        var settings = {
            effect: 'fade',
            speed: 1000,
            nextButton: '#itinerarySlider_'+sec_id+' .swiper-button-next',
            prevButton: '#itinerarySlider_'+sec_id+' .swiper-button-prev',
            loop: false,
            observer: true,
            observeParents: true,
        },
        tab_itinerary = new Swiper('#itinerarySlider_'+sec_id, settings);
        e.preventDefault();
        $('.tabHead').removeClass('active');
        $(this).addClass('active');
        $('.tabSection').hide();
        $('.tabSection[data-section_id="' + sec_id + '"]').show();
        tab_itinerary.update();
    });

    //swiperOffers
    $('.special-slider').each(function () {
        var id = $(this).prop('id');
        var specialslider = new Swiper('#' + id, {
            effect: 'fade',
            speed: 800,
            loop: true,
            autoHeight: true,
            nextButton: '#' + id + ' .swiper-button-next',
            prevButton: '#' + id + ' .swiper-button-prev'
        });
    });

    //svg click

    var classname = document.getElementsByClassName("svgClick");

    // $(".tabHead:first").addClass('active');
    $(".map-slide[data-discover_id=85]").show();

    var myFunction = function () {

        var elems = document.getElementsByClassName("svgClick");

        [].forEach.call(elems, function (el) {
             el.setAttribute("class", "svgClick in-active");
        });
        var id_section = this.getAttribute("id");
        var d = document.getElementById(id_section);
        d.setAttribute("class", "svgClick active");
        $('.map-slide').hide();
        $('.map-slide[data-discover_id="' + id_section + '"]').show();
    };

    for (var i = 0; i < classname.length; i++) {
        classname[i].addEventListener('click', myFunction, false);
    }

    var whatonslider = new Swiper('#whaton-slider', {
        effect: 'fade',
        speed: 1000,
        loop: true,
        autoHeight: true,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev'
    });

    var eventplan = new Swiper('#event-plan', {
        effect: 'fade',
        speed: 1000,
        loop: true,
        pagination: '.swiper-pagination',
        paginationClickable: true
    });

    /*Cookies Kdialog open*/
        function loadCookiepopup(){
            var x	=	checkCookie('cookiepopup');
            if(x)
                return;

            var popupOffset = 0;
            $('#cookies_kidalogBox').kdialog('open', {
                easyClose		:	true,
                wrapperClass	:	'cookieDialog',
                position		:	["auto", "auto"],
                watchForResize	:	true,
                beforeOpen      : function(){
                    popupOffset = window.pageYOffset;
                    $('html').addClass('oh');
                },
                beforeClose     : function(){
                    document.cookie = "cookiepopup=1";
                    $('html').removeClass('oh');
                }
            });
        }

    	function checkCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');
			for(var i = 0; i <ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) == 0) {
					return c.substring(name.length,c.length);
				}
			}
			return "";
        }

        loadCookiepopup();
};
