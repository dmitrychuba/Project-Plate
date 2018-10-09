<?php
declare( strict_types=1 );

defined( 'DS' ) || define( 'DS', DIRECTORY_SEPARATOR );

defined( '_ASSETS' ) || define( '_ASSETS', stylesheet_url('assets') );
defined( '_TEMPLATE_DIR' ) || define( '_TEMPLATE_DIR', stylesheet_path() );
defined( '_VIEWS_DIR' ) || define( '_VIEWS_DIR', _TEMPLATE_DIR );
defined( '_SHORTCODES_DIR' ) || define( '_SHORTCODES_DIR', _VIEWS_DIR . DS . 'shortcodes' );

$enabled_plugins = [
	'plate.php',
	// 'visual-editor-buttons'
];

$includes_dir = dirname( __FILE__ ) . DS . 'includes';

//require_once( $includes_dir . DS . '_models.php' );
require_once( $includes_dir . DS . '_helpers.php' );
require_once( $includes_dir . DS . '_shortcodes.php' );
require_once( $includes_dir . DS . '_widgets.php' );
require_once( $includes_dir . DS . '_plugins.php' );
require_once( $includes_dir . DS . '_theme.php' );
require_once( $includes_dir . DS . 'acf-config' . DS . 'acf.php' );