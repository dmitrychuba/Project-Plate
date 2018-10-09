<?php if ( ! defined( 'ABSPATH' ) ) {
	exit( 'restricted access' );
}

$models_dir = dirname( __FILE__ ) . DS . 'classes' . DS . 'Models';

// Auto-include all plugins
foreach ( scandir( $models_dir ) as $model ) {
	if ( in_array( $model, [ '.', '..' ] ) || ( isset( $enabled_models ) && ! in_array( preg_replace('~\.php$~', '', $model), $enabled_models ) ) ) {
		continue;
	}

	$model_path = $models_dir . DS . $model;

	if ( ! file_exists( $model_path ) ) {
		continue;
	}

	require_once( $model_path );
}