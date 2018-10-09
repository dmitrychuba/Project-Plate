<?php if ( !defined( 'ABSPATH' ) ) exit( 'restricted access' );

$shortcodes = _get_views( _SHORTCODES_DIR );
foreach ( $shortcodes as $shortcode ) {
    $view_file = _SHORTCODES_DIR . DS . "$shortcode.php";
    if ( file_exists( $view_file ) ) {

        add_shortcode( $shortcode, function( $atts ) use ( $shortcode, $view_file ) {
            // $a = shortcode_atts( [ ... ], $atts );
            if ( is_array( $atts ) ) {
                extract( $atts );
            }
            ob_start();
            include $view_file;

            return ob_get_clean();
        } );
    }
}