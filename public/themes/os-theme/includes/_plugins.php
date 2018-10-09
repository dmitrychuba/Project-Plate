<?php if ( ! defined( 'ABSPATH' ) ) {
	exit( 'restricted access' );
}

$plugins_dir = dirname( __FILE__ ) . DS . 'plugins';

// Auto-include all plugins
foreach ( scandir( $plugins_dir ) as $plugin_folder_file_name ) {
	if (
		in_array( $plugin_folder_file_name, [ '.', '..' ] ) ||
		( isset( $enabled_plugins ) && ! in_array( $plugin_folder_file_name, $enabled_plugins ) )
	) {
		continue;
	}

	$plugin_path = $plugins_dir . DS . $plugin_folder_file_name;

	if ( ! preg_match( '~\.php$~', $plugin_folder_file_name ) ) {
		$plugin_path .= '.php';
	}

	if ( ! file_exists( $plugin_path ) ) {
		$plugin_path = $plugins_dir . DS . $plugin_folder_file_name . DS . "{$plugin_folder_file_name}.php";
	}

	if ( ! file_exists( $plugin_path ) ) {
		continue;
	}

	include_once( $plugin_path );
}