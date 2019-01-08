<?php

namespace OS;

if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

$classes_dir = dirname( __FILE__ ) . DS . 'classes';

require_once( $classes_dir . DS . 'WP_ThemeBase.php' );
require_once( $classes_dir . DS . 'WP_Theme.php' );
require_once( $classes_dir . DS . 'WP_Posts.php' );
require_once( $classes_dir . DS . 'WP_RestEndpoint.php' );
//require_once( $classes_dir . DS . 'WP_Bootstrap_Comments_Walker.php' );

/**
 * @return WP_Posts
 */
function wp_posts() {
	return WP_Posts::getInstance();
}

/**
 * @return WP_Theme
 */
function wp_theme() {
	return WP_Theme::getInstance();
}

wp_theme();

/*
// Create API routes : /wp-json/wmm/v1/tpl-layout/, /wp-json/wmm/v1/latest-posts/, ...
new WP_RestEndpoint( [
	// 'route1' => [ \WP_REST_Server::READABLE => function() { return $class->function1(); }, ],
	// 'route2' => [ \WP_REST_Server::CREATABLE => 'function2', ],
], 'wmm', '1' );
//*/