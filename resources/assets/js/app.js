// window._ = import('lodash');

import $ from 'jquery';
window.$ = window.jQuery = $;

import('./bootstrap');

import swal from "sweetalert2";
window.swal = swal;

import('./image-uploader');
import('./video-uploader');

+(function ($) {
    'use strict';

    $(window).on('load resize', function () {
        $('#content-area').css('min-height', $(window).height() - ($('header').height() + $('footer').height() + 80) + 'px');
    });

    /*/ Tooltip
    $('[data-toggle="tooltip"]').tooltip({'container': 'body'});

    // Popover
    $('[data-toggle="popover"]').popover();*/
})(jQuery);
