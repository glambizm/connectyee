/*
 * connectyee.common.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
$(function() {
    'use strict';

/*
    var loader = new SVGLoader(document.getElementById('loader'), { speedIn: 100, speedOut: 800, easingIn: mina.easeinout });
    loader.show();
    $('#over-lay').fadeOut(500, function() {
        loader.hide();
        $('#loader').css({ 'display': 'none' });
    });

    function preLoad() {
        var loader = new SVGLoader(document.getElementById('loader'), { speedIn: 800, easingIn: mina.easeinout });
        loader.show();
        $(window).on('pageshow', function() {
            loader.hide();
            $('#loader').css({ 'display': 'none' });
        });
    }


    $('form').on('submit', function() {
        var agent = navigator.userAgent;
        if (agent.search(/iPhone/) === -1 && agent.search(/iPad/) === -1 && agent.search(/iPod/) === -1 && agent.search(/Android/) === -1) {
	        $('[data-toggle="tooltip"]').tooltip('hide');
        }
        preLoad();
    });

    $('a').on('click', function() {
        if (($(this).attr('href') === '#') || ($(this).attr('href') === '')) {
            return false;
        }

        var agent = navigator.userAgent;
        if (agent.search(/iPhone/) === -1 && agent.search(/iPad/) === -1 && agent.search(/iPod/) === -1 && agent.search(/Android/) === -1) {
	        $('[data-toggle="tooltip"]').tooltip('hide');
        }
        preLoad();
    });
*/

    /*
     * tooltip
     */
    var agent = navigator.userAgent;
    if (agent.search(/iPhone/) === -1 && agent.search(/iPad/) === -1 && agent.search(/iPod/) === -1 && agent.search(/Android/) === -1) {
	    $('[data-toggle="tooltip"]').tooltip();
    }

    /*
     * menu open/close
     */
    $('#menu-btn-wrapper').on('click', function() {
        $('.menu-btn').toggleClass('open');

        if ($('.menu-btn').hasClass('open') === true) {
            $('#side-bar-desktop-wrapper').hide();
            $('#side-bar-desktop-wrapper').removeClass('hidden-xs').removeClass('hidden-sm');
            $("#side-bar-desktop-wrapper").show(200);
        } else {
            $('#side-bar-desktop-wrapper').hide(200, function() {
                $('#side-bar-desktop-wrapper').css('display', '');
                $('#side-bar-desktop-wrapper').addClass('hidden-xs').addClass('hidden-sm');
            });
        }
    });

    $(window).resize(function() {
        if ($('.menu-btn').hasClass('open') === true) {
            $('.menu-btn').removeClass('open');
            $('#side-bar-desktop-wrapper').addClass('hidden-xs').addClass('hidden-sm');
        }
    });

    /*
     * child-menu open/close
     */
    $('[data-menu-child]').hide();
    $('[data-menu-parent]').removeClass('side-bar-item-open');
    $('.side-bar-collapse-icon').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');

    $('[data-menu-parent]').on('click', function(e) {
        var parent_id = $(this).data('menu-parent');
        $('[data-menu-parent=' + parent_id + ']').toggleClass('side-bar-item-open');
        $('[data-menu-child=' + parent_id + ']').slideToggle();
        $(this).find('.side-bar-collapse-icon').toggleClass('glyphicon-chevron-up').toggleClass('glyphicon-chevron-down');
    });

    /*
     * ripple
     */
    $('.side-bar-item').on('mousedown', function(e) {
        var _self = this;

        var x = e.clientX;
        var y = e.offsetY + 12;

        var $effect = $(_self).find('.ripple-effect');
        var w = $effect.width();
        var h = $effect.height();

        $effect.css({
            left: x - w / 2,
            top: y - h / 2
        });

        if ($effect.hasClass('is-show') === false) {
            $effect.addClass('is-show');

            setTimeout(function() {
                $effect.removeClass('is-show');
            }, 750);
        }

        return false;
    });
});
