<?php

namespace OS;

if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

$classes_dir = dirname( __FILE__ ) . DS . 'classes';

require_once( $classes_dir . DS . 'WP_ThemeBase.php' );
require_once( $classes_dir . DS . 'WP_Theme.php' );
require_once( $classes_dir . DS . 'WP_Posts.php' );
require_once( $classes_dir . DS . 'WP_RestEndpoint.php' );
require_once( $classes_dir . DS . 'WP_Bootstrap_Comments_Walker.php' );

function wp_posts() {
	return WP_Posts::getInstance();
}

function wp_theme() {
	return WP_Theme::getInstance();
}

wp_theme();
