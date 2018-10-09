<?php
/*
Plugin Name: Visual Editor Buttons
Description: Adds a button to visual editor.
Author: OS
*/

add_action( 'admin_footer', function() {
    ?>
    <script>
        window.BASE_URL       = '<?php bloginfo( 'url' ) ?>';
        window.THEME_BASE_URL = '<?php bloginfo( 'template_url' ) ?>';
        window.PLUGIN_BASE_URL = '<?php bloginfo( 'template_url' ) ?>/includes/plugins/visual-editor-buttons';
    </script>
    <?php
} );

add_action( 'admin_init', function() {
    add_editor_style( get_bloginfo( 'template_url' ) . '/includes/plugins/visual-editor-buttons/assets/css/button.css' );
} );

add_filter( "mce_external_plugins", function( $plugin_array ) {
    //enqueue TinyMCE plugin script with its ID.

    $plugin_array["button_style_plugin"] = get_bloginfo( 'template_url' ) . '/includes/plugins/visual-editor-buttons/assets/js/index.js';

    return $plugin_array;
} );

add_filter( "mce_buttons", function( $buttons ) {
    //register buttons with their id.
    array_push( $buttons, "button_style" );

    return $buttons;
} );