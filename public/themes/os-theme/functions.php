<?php
declare( strict_types=1 );

defined( 'DS' ) || define( 'DS', DIRECTORY_SEPARATOR );

defined( '_ASSETS' ) || define( '_ASSETS', stylesheet_url( 'assets' ) );
defined( '_TEMPLATE_DIR' ) || define( '_TEMPLATE_DIR', stylesheet_path() );
defined( '_VIEWS_DIR' ) || define( '_VIEWS_DIR', _TEMPLATE_DIR );
defined( '_SHORTCODES_DIR' ) || define( '_SHORTCODES_DIR', _VIEWS_DIR . DS . 'shortcodes' );

$includes_dir = dirname( __FILE__ ) . DS . 'includes';

require_once( $includes_dir . DS . '_theme.php' );
require_once( $includes_dir . DS . '_helpers.php' );
require_once( $includes_dir . DS . '_shortcodes.php' );
require_once( $includes_dir . DS . '_widgets.php' );
require_once( $includes_dir . DS . 'acf-config' . DS . 'acf.php' );

if ( function_exists( 'OS\wp_theme' ) ) {
	OS\wp_theme()->autoloadPlugins( $includes_dir . DS . 'plugins', [ 'plate' ] );
	OS\wp_theme()->autoloadClasses( $includes_dir . DS . 'classes' . DS . 'CPT' );
	OS\wp_theme()->autoloadClasses( $includes_dir . DS . 'classes' . DS . 'Models' );
}