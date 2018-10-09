/*!
 * Html5 dynamic url
 *
 * Copyright 2018 Dmitry Chuba
 * Released under the MIT license
 */

var Url = {
    get val() {
        return window.location.href;
    },

    set val(url) {
        history.pushState({data : url}, url, url);
        //window.location.hash = hash;
    },
};

module.exports = Url;