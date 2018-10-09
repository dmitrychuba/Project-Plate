/*!
 * jQuery Customer Popup
 *
 * Copyright 2017 Dmitry Chuba
 * Released under the MIT license
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    'use strict';

    function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
        var dualScreenTop  = window.screenTop != undefined ? window.screenTop : window.screenY;

        var width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left      = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top       = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }

    $.fn.customerPopup = function (intWidth, intHeight) {

        $(this).on("click", function (e) {
            var url = $(this).attr('href');
            if (typeof url !== 'undefined' && url !== false) {

                intWidth  = intWidth || '500';
                intHeight = intHeight || '400';

                e.preventDefault();

                var title = ((typeof $(this).attr('title') !== 'undefined') ? $(this).attr('title') : 'Social Share');

                PopupCenter(url, title, intWidth, intHeight);
            }

        });

        return this;
    };

}));