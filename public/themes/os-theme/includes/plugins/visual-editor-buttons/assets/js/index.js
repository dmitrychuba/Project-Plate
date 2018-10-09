(function () {
    tinymce.create("tinymce.plugins.button_style_plugin", {

        init : function (ed, url) {

            //add new button
            ed.addButton("button_style", {
                title   : "Insert button",
                image   : window.PLUGIN_BASE_URL + "/assets/img/button.png",
                onclick : function () {
                    // Open window
                    ed.windowManager.open({
                        title    : 'Button Properties',
                        body     : [
                            {
                                type : 'textbox', name : 'title', label : 'Title'
                            },
                            {
                                type : 'textbox', name : 'link', label : 'Link'
                            },
                            {
                                type : 'checkbox', name : 'newTab', label : 'Open in a New Tab'
                            }
                        ],
                        onsubmit : function (e) {

                            var link       = e.data.link ? ' href="' + e.data.link + '"' : '';
                            var title      = e.data.link ? e.data.title : '';
                            var target     = e.data.newTab ? ' target="_blank"' : '';
                            var buttonHtml = '<a' + link + target + ' class="button-style">' + title + '</a>';

                            ed.insertContent(buttonHtml);
                        }
                    });
                }
            });
        },
    });

    tinymce.PluginManager.add("button_style_plugin", tinymce.plugins.button_style_plugin);
})();