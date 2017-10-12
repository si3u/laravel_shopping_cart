jQuery(document).ready(function ($) {
    "use strict";
    //Header Element Toggle
    $('.header-icon').on( "click", function(e) {
        var $this = $(this);
        var toogleId = $this.attr('data-togole');

        if ( $this.parent().parent().find('#' + toogleId).is(':hidden') ) {
            $('.header .toggle-show').removeClass('toggle-show').addClass('toggle-hidden');
            $this.parent().parent().find('#' + toogleId).slideDown('slow').addClass('toggle-show').removeClass('toggle-hidden');
            $('.header .toggle-hidden').slideUp('slow');
            $('.header-icon').removeClass('active');
            $this.addClass('active');
        }
        else{
            $this.parent().parent().find('#' + toogleId).slideUp('slow').removeClass('toggle-show').addClass('toggle-hidden');
            $this.removeClass('active');
        }
        e.preventDefault();
        e.stopPropagation();
    });
    //Close Toggle
    $(document).click(function (e) {
        var container = $('.header-element');
        if (!container.is(e.target)&& container.has(e.target).length === 0){
            $('.header-element-content').hide();
            $('.header-icon').removeClass('active');
        }
    });
    //Nav Slide hover
    $( '.slide-product-wrap' )
        .mouseover(function() {
            $(this).addClass('nav-show');
        })
        .mouseout(function() {
            $(this).removeClass('nav-show');
        });
    if($('.latest-post').hasClass('xshop-owl-carousel') && !$('.latest-post').hasClass('latest-post-style_4') && !$('.latest-post').hasClass('latest-post-style_6')  && !$('.latest-post').hasClass('latest-post-style_8') && !$('.latest-post').hasClass('latest-post-style_9')){
        $( ".latest-post" )
            .mouseover(function() {
                $(this).addClass('nav-show');
            })
            .mouseout(function() {
                $(this).removeClass('nav-show');
            });
    }
    // Menu Mobile Move Slide menu
    $('#primary-navigation').mmenu({
        extensions: ['effect-slide-menu', 'pageshadow'],
        navbar: {
            title: 'Menu'
        },
        navbars: [
            {
                position: 'top',
                content: [
                    'prev',
                    'title',
                    'close'
                ]
            }
        ]
    }, {
        // configuration
        clone: true
    });

    // Menu Header 4
    if($(window).width() > 1024) {
        if ($('.header-style_4 ').length) {
            $('.mobile-navigation').on("click", function (e) {
                $('#primary-navigation').toggleClass('nav-show');
                $(this).toggleClass('button-close');
                e.preventDefault();
                e.stopPropagation();
            });
        }
        if (($('.header-style_5 ').length) || ($('.header-style_6 ').length) || ($('.header-style_11 ').length) ) {
            $('.mobile-navigation').on("click", function (e) {
                $('#primary-navigation').slideToggle('100');
                $(this).toggleClass('button-close');
                e.preventDefault();
                e.stopPropagation();
            });
        }
    }
    if($(window).width() < 1025){
        $('.head-nav-extra ul.menu-nav').appendTo('.menu-mobile-extra');
        if (($('.header-style_12 ').length) || ($('.header-style_3').length)){
            $('.mobile-navigation').on("click", function (e) {
                $('.menu-mobile-extra').slideToggle('100');
                $(this).toggleClass('button-close');
                e.preventDefault();
                e.stopPropagation();
            });
            //MENU DROPDOW
            $( '.main-header li.menu-item-has-children,.main-header li.menu-item-has-children.megamenu-menu-item,.main-header.menu-item-object-megamenu').append( "<span class='ts-has-children'><i class='fa fa-angle-down'></i> </span>" );
            $('.main-header .menu-item-has-children  .ts-has-children').on('click',function(e){

                var $this = $(this);
                var thisLi = $this.closest('li');
                var thisUl = thisLi.closest('ul');
                var thisA = $this.closest('a');

                if ( thisLi.is('.sub-menu-open') ) {
                    thisLi.find('> .sub-menu').stop().slideUp('slow');
                    thisLi.removeClass('sub-menu-open').find('> a').removeClass('active');
                }
                else{
                    thisUl.find('> li.sub-menu-open > .sub-menu').stop().slideUp('slow');
                    thisUl.find('> li.sub-menu-open').removeClass('sub-menu-open');
                    thisUl.find('> li > a.active').removeClass('active');
                    thisLi.find('> .sub-menu').stop().slideDown('slow');
                    thisLi.addClass('sub-menu-open').find('> a').addClass('active');
                }
                e.stopPropagation();
            });
        }
    };

    $( '.price_slider' ).slider();
    //Has banner Slide
    if($('.banner-slide').length){
        $('.header-basic').addClass('has-banner');
    }

    //Scroll mini cart
    $('.content-scrollbar').scrollbar();
    //SEARCH BOX
    $('.icon-search').on( "click", function(e) {
        $('.search-box-wrap').fadeIn('500');
    });
    $('.search-box-wrap .close-search, .search-box-wrap .search-overlay').on( "click", function(e) {
        $('.search-box-wrap').fadeOut('slow');
    });

    //Popup Newsletter

    $('.popup-overlay, .popup-close').on( "click", function(e) {
        $('.newsletter-popup-wrap').fadeOut('slow');
    })
    //BACK TO TOP
    $('.backtotop').on( "click", function(e) {
        $('html,body').animate({scrollTop : 0},800);
        return false;
    })

    update_back_to_top();
});
function update_back_to_top() {
    if($(window).scrollTop() > 180) {
        $('.backtotop').show(300);
    } else {
        $('.backtotop').hide(300);
    }
}
$(window).load(function(){
    $('.newsletter-popup-wrap').fadeIn(500);
});
//Menu Sticky
$(window).scroll(function () {
    update_back_to_top();
    var scroll = $(window).scrollTop();
    if($(window).width()>1024){
        if (scroll >= 350) {
            $('.header-sticky').addClass('sticky-menu');
            $('body').addClass('list-cat-sticky');
        } else {
            $('.header-sticky').removeClass('sticky-menu');
            $('body').removeClass('list-cat-sticky');
        }
        if (scroll >= 150) {
            $('.header-sticky').addClass('sticky-icon-action');
        } else {
            $('.header-sticky').removeClass('sticky-icon-action');
        }
        if (scroll >= 10) {
            $('.header-sticky').addClass('sticky-menu-transform');
            $('body').addClass('list-cat-sticky-transfrom');
        } else {
            $('.header-sticky').removeClass('sticky-menu-transform');
            $('body').removeClass('list-cat-sticky-transfrom');
        }
    }
});
