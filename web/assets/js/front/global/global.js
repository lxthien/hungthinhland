'use strict';

//require('bxslider/dist/jquery.bxslider');
require('@fancyapps/fancybox');
require('jquery-validation');
require('../../../libs/lightslider/js/lightslider.js');
require('../../../libs/jquery/jquery.cookie.js');
require('jquery-bootstrap-scrolling-tabs/dist/jquery.scrolling-tabs.min.js');

function initProtectedContent() {
    $('body').bind('cut copy', function (e) {
        e.preventDefault();
    });
}

function initGoToTop() {
    var $goToTop = $('.go-to-top');

    $goToTop.click(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
}

function initFixedMenu() {
    $(window).scroll(function() {
        var $nav = $("#nav");
        var $scrollUp = $('.td-scroll-up');
        var scroll = $(window).scrollTop();
    
        if (scroll >= 139) {
            $nav.addClass("navbar-fixed-top");
            $scrollUp.removeClass("hidden");
        } else {
            $nav.removeClass("navbar-fixed-top");
            $scrollUp.addClass("hidden");
        }
    });
}

function initFancybox() {
    var $nhandongia = $('.nhan-bao-gia');
    var visited = $.cookie('visited');

    $nhandongia.click(function(e) {
        e.preventDefault();

        $.fancybox.open({
            src: '#nhanbaogia',
            touch : false
        });

        return false;
    });
}

function intHandleFormContact() {
    window.dataLayer = window.dataLayer || [];
    
    var $formComment = $('#nhanbaogia #form-contact');

    $formComment.on('click', '#form_send', function(e) {
        if ($formComment.valid()) {
            $.ajax({
                type: "POST",
                url: $formComment.attr('action'),
                data: $formComment.serialize(),
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status === 'success') {
                        $('#contact-form-message').html(response.message).show();
                        $('#nhanbaogia form').hide();

                        window.dataLayer.push({
                            'event': 'subscriber'
                        });
                        
                        // Clear form comment
                        $formComment[0].reset();
                    } else {
                        $('#contact-form-message').html(response.message);
                    }
                }
            });
        }
    })
}

function initFlickity() {
    $('#image-gallery-3').lightSlider({
        item: 3,
        loop: true,
        slideMove: 1,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed: 600,
        responsive : [
            {
                breakpoint: 800,
                settings: {
                    item: 2,
                    slideMove: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: 1,
                    slideMove: 1
                }
            }
        ]
    });
}

function initScrollingTabs() {
    $('.nav-tabs').scrollingTabs();
}

exports.init = function () {
    initProtectedContent();
    initGoToTop();
    initFixedMenu();
    //initFancybox();
    //intHandleFormContact();
    //initFlickity();
    initScrollingTabs();
};