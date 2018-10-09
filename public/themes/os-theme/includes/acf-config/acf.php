<?php if ( ! defined( 'ABSPATH' ) ) {
	exit( 'restricted access' );
}

defined( 'ACF_BASE_DIRECTORY' ) or define( 'ACF_BASE_DIRECTORY', dirname( __FILE__ ) );

require_once ACF_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'acf-helpers.php';
require_once ACF_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'acf-actions-filters.php';
/*
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page( [
		'icon_url'        => 'dashicons-slides',
		'position'        => 24,
		//'page_title' => 'Ads',
		'menu_title'      => 'Ads',
		'update_button'   => __( 'Save', 'acf' ),
		'updated_message' => __( "Ads Saved", 'acf' ),
	] );
	acf_add_options_sub_page( [
		//'page_title'  => 'Social Media Icons',
		'menu_title'  => 'Social Media Icons',
		'parent_slug' => 'themes.php',
	] );
}
*/



