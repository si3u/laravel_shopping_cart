jQuery(document).ready(function ($) {
    "use strict";

    function xshop_init_owl_carousel() {

        $('.xshop-owl-carousel').each(function () {
            var $this = $(this),
                $loop = $this.attr('data-loop') == 'yes',
                $numberItem = parseInt($this.attr('data-number')),
                $Nav = $this.attr('data-navControl') =='yes',
                $Dots = $this.attr('data-Dots') == 'yes',
                $autoplay = $this.attr('data-autoPlay') == 'yes',
                $autoplayTimeout = parseInt($this.attr('data-autoPlayTimeout')),
                $marginItem = parseInt($this.attr('data-margin')),
                $rtl = $this.attr('data-rtl') == 'yes',
                $resNumber; // Responsive Settings
            $numberItem = (isNaN($numberItem)) ? 1 : $numberItem;
            $autoplayTimeout = (isNaN($autoplayTimeout)) ? 4000 : $autoplayTimeout;
            $marginItem = (isNaN($marginItem)) ? 0 : $marginItem;
            switch ($numberItem) {
                case 1 :
                    $resNumber = {
                        0: {
                            items: 1
                        }
                    }
                    break;
                case 2 :
                    $resNumber = {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        992: {
                            items: $numberItem
                        }
                    }
                    break;
                case 3 :
                case 4 :
                    $resNumber = {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        992: {
                            items: 3
                        },
                        1200: {
                            items: $numberItem
                        }
                    }
                    break;
                default : // $numberItem > 4
                    $resNumber = {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        600: {
                            items: 3
                        },
                        992: {
                            items: 4
                        },
                        1200: {
                            items: $numberItem
                        }
                    }
                    break;
            } // Endswitch

            $(this).owlCarousel({
                loop: $loop,
                nav: $Nav,
                navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
                dots: $Dots,
                autoplay: $autoplay,
                autoplayTimeout: $autoplayTimeout,
                margin: $marginItem,
                //responsiveClass:true,
                rtl: $rtl,
                responsive: $resNumber,
                autoplayHoverPause: true,
                //center: true,
                onRefreshed: function () {
                    var total_active = $this.find('.owl-item.active').length;
                    var i = 0;
                    $this.find('.owl-item').removeClass('active-first active-last');
                    $this.find('.owl-item.active').each(function () {
                        i++;
                        if (i == 1) {
                            $(this).addClass('active-first');
                        }
                        if (i == total_active) {
                            $(this).addClass('active-last');
                        }
                    });
                },
                onTranslated: function () {
                    var total_active = $this.find('.owl-item.active').length;
                    var i = 0;
                    $this.find('.owl-item').removeClass('active-first active-last');
                    $this.find('.owl-item.active').each(function () {
                        i++;
                        if (i == 1) {
                            $(this).addClass('active-first');
                        }
                        if (i == total_active) {
                            $(this).addClass('active-last');
                        }
                    });
                },
                onResized: function () {
                }
            });
        });
    }

    xshop_init_owl_carousel();
    //SLide home v1
    $('.slick-slider').slick({
        dots: false,
        infinite: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 1440,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    centerPadding: '170px'
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    centerPadding: '100px'
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    centerPadding: '50px'
                }
            },
            {
                breakpoint: 559,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerPadding: '50px'
                }
            }
        ]
    });
    /*  [latest-post-style_6 ]
     - - - - - - - - - - - - - - - - - - - - */
    $('.latest-post-style_6 ').owlCarousel({
        items:2,
        margin:10,
        autoplay: true,
        nav:true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        stagePadding:0,
        smartSpeed:1000,
        loop:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            640:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:2
            }
        }
    });

    function heightColum(){
        var height_img = $('.img-signle').height();
        var height_elem = $('.newsletter-wrap').height();
        if( height_img < height_elem ){
            $('.img-signle').addClass('img-elem');
        }
    }
    //Width Dots
    var dots = $('.latest-post-style_6 .owl-dot').length;
    $('.latest-post-style_6 .owl-controls').css({
        'width' : 30*dots + 100
    })
    //Nav Dots Style
    $('.nav-number-style').each(function () {
        var dots2 = $('.nav-number-style .item-slide').length;
        $('.nav-number-style').addClass("has-" + dots2 + "number")
    });
    //Wow animate
    new WOW().init();
    // Video Lightbox
    $('.quick-install').simpleLightboxVideo();
    //Woocommerce plus and minius
    $(document).on('click', '.quantity .plus, .quantity .minus', function (e) {

        // Get values
        var $qty = $(this).closest('.quantity').find('.qty'),
            currentVal = parseFloat($qty.val()),
            max = parseFloat($qty.attr('max')),
            min = parseFloat($qty.attr('min')),
            step = $qty.attr('step');

        // Format values
        if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
        if (max === '' || max === 'NaN') max = '';
        if (min === '' || min === 'NaN') min = 0;
        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

        // Change the value
        if ($(this).is('.plus')) {

            if (max && ( max == currentVal || currentVal > max )) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }

        } else {

            if (min && ( min == currentVal || currentVal < min )) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }

        }

        // Trigger change event
        $qty.trigger('change');

        e.preventDefault();

    });
    // Chosen js
    $(".orderby,#pa_color,#pa_size,#calc_shipping_country,#color,#size,.sort-number,#calc_shipping_state").chosen({
        disable_search_threshold: 10
    });
    //Price filter
    $('.slider-range-price').each(function(){
        var min             = $(this).data('min');
        var max             = $(this).data('max');
        var unit            = $(this).data('unit');
        var value_min       = $(this).data('value-min');
        var value_max       = $(this).data('value-max');
        var label_reasult   = $(this).data('label-reasult');
        var t               = $(this);
        $( this ).slider({
            range: true,
            min: min,
            max: max,
            values: [ value_min, value_max ],
            slide: function( event, ui ) {
                var result = label_reasult +" <span>"+ unit + ui.values[ 0 ] +' </span> - <span> '+ unit +ui.values[ 1 ]+'</span>';
                t.closest('.price_slider_wrapper').find('.price_slider_amount').html(result);
            }
        });
    });
    // Switch between products listview and gridview
    $(document).on('click', '.products-sort-views .products-change-view', function (e) {

        var $this = $(this);
        if ($this.hasClass('active')) {
            return false;
        }

        if ($this.hasClass('products-grid-view')) {
            $('.products-wraps').addClass('products-grid').removeClass('products-list');
            $('.product-media').removeClass('col-sm-5');
            $('.product-info').removeClass('col-sm-7');
        }
        else {
            $('.products-wraps').removeClass('products-grid ').addClass('products-list');
            $('.product-media').addClass('col-sm-5');
            $('.product-info').addClass('col-sm-7');

        }

        $('.products-sort-views .products-change-view').removeClass('active');
        $this.addClass('active');

        e.preventDefault();

    });
    function xhop_core_init_products_list_view() {
        if ($('.products-sort-views .products-change-view.products-list-view.active').length){
            $('.products-wraps').removeClass('products-grid').addClass('products-list');
            $('.product-media').addClass('col-sm-5 ');
            $('.product-info').addClass('col-sm-7');
        }
    }
    xhop_core_init_products_list_view();
    //POssition text vertical
    function height_title() {
        var heighttitletop = $('.title-top').outerWidth();
        var heighttitlebuttom  = $('.title-bottom').outerWidth();
        var plus = $('.product-info').outerHeight();
        $('.title-top').css({
            'bottom' : heighttitletop + plus + 20,
            'left' : - heighttitletop/2

        });
        $('.title-bottom').css({
            'bottom' : heighttitlebuttom + plus,
            'right' : - heighttitlebuttom/2

        });

    }
    height_title();

    /*----------------------------
     Slide Vertical thumb
     ------------------------------ */
    if($(window).width()> 1366) {
        $('.product-thumbs').bxSlider({
            mode: 'vertical',
            slideWidth: 100,
            minSlides: 4,
            slideMargin: 20,
            pager: false
        });
    }else {
        $('.product-thumbs').owlCarousel({
            items:3,
            margin:10,
            autoplay: true,
            nav:true,
            navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
            stagePadding:0,
            smartSpeed:850,
            loop:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            dots:true,
            responsive:{
                0:{
                    items:3
                },
                480:{
                    items:4
                },
                768:{
                    items:3
                },
                992:{
                    items:4
                }
            }
        });

    }
    // CountDown
    if ($('.xshop-countdown').length) {
        $('.xshop-countdown').each(function () {
            var $this                = $(this);
            var ts_countdown_to_date = $this.attr('data-time');
            $this.countdown(ts_countdown_to_date, function (event) {
                var ts_day    = event.strftime('%-D');
                var ts_hour   = event.strftime('%-H');
                var ts_minute = event.strftime('%-M');
                var ts_second = event.strftime('%-S');
                $('.xshop-days').html(ts_day);
                $('.xshop-hours').html(ts_hour);
                $('.xshop-minutes').html(ts_minute);
                $('.xshop-seconds').html(ts_second);

            });
        });
    }
    function xshop_equal_elems() {
        $('.equal-container').each(function () {
            var $this = $(this);
            if ($this.find('.equal-elem').length) {
                $this.find('.equal-elem').css({
                    'height': 'auto'
                });
                var elem_height = 0;
                $this.find('.equal-elem').each(function () {
                    var this_elem_h = $(this).height();
                    if (elem_height < this_elem_h) {
                        elem_height = this_elem_h;
                    }
                });
                $this.find('.equal-elem').height(elem_height);
            }
        });
    }
    //Langure switcher

    $('.language-flag-switcher > .lang-switcher-li').mouseover(function(){
        $('.language-switcher-inner').addClass('lang-show');
    });
    $('.language-flag-switcher').mouseout(function(){
        $('.language-switcher-inner').removeClass('lang-show');
    });


    // Menu Categories Move menu
    if(( $(window).width() > 767) && ( $(window).width() < 1025)){
        $('.list-categories').prependTo('.main-header .header-left');
    };
    if( $(window).width() < 1025){
        $('.title-list-categories').on( "click", function(e) {
            $(this).parent().find('.product-list-categories').stop().slideToggle('500');
            e.preventDefault();
        });
    };
    //Height element product banner
    function TopProductsBanner(){
        var height_element = $('.banner-item-wrap').outerHeight() - 2;
        $('.top-products-banner').css('height', height_element);

    }
    //Call Functions
    if($(window).width()>767){
        $(window).load(function () {
            xshop_equal_elems();
        });
        heightColum();
        TopProductsBanner();
        $(window).resize(function(){
            xshop_equal_elems();
            TopProductsBanner();

        });
    }
    //Banner Block Style 4
    if($(window).width()>767) {
        $(window).load(function () {
            $('.equal-elem').each(function () {
                var pic = $(this).find("img")
                var pic_real_width = pic.width();
                var pic_real_height = $(this).height();
                if (pic_real_width < pic_real_height) {
                    $(this).addClass('img-width')
                }
            });
        });
    };
});
