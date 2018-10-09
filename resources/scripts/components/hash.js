/*!
 * Work with url hash
 *
 * Copyright 2018 Dmitry Chuba
 * Released under the MIT license
 */
var Hash = {
    get val() {
        var hash = window.location.hash.substring(1), res = {};


        if (hash.match(/=|&/)) {
            hash.split('&').map(function (item) {
                res[item.split('=')[0]] = item.split('=')[1] || true;
            });

            hash = res;
        }

        return hash;
    },

    set val(hash) {
        var res = [];
        if (this.isObject(hash)) {
            for (var i in hash) {
                if (i.match(/^\d+$/)) {
                    res.push(hash[i]);
                } else {
                    res.push(i + '=' + hash[i]);
                }
            }

            hash = res.join('&');

        }

        window.location.hash = hash;
    },

    isObject : function (obj) {
        var type = typeof obj;
        return type === 'function' || type === 'object' && !!obj;
    },

    remove : function () {
        if (typeof window.history.replaceState === 'function') {
            history.replaceState({}, '', window.location.href.substr(0, window.location.href.indexOf('#')));
        } else {
            window.location.replace("#");
        }
    }
};

module.exports = Hash;