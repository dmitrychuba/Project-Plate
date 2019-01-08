<?php

namespace OS;

use PostTypes\PostType;
use PostTypes\Taxonomy;

/**
 * Class WP_FAQ()
 *
 * @package OS
 */
class WP_FAQ {

	protected $post_type = 'faq';
	protected $post_type_slug = 'faq';

	/**
	 * WP_FAQ() constructor.
	 */
	public function __construct() {
		//   5 - below Posts
		//  10 - below Media
		//  15 - below Links
		//  20 - below Pages
		//  25 - below comments
		//  60 - below first separator
		//  65 - below Plugins
		//  70 - below Users
		//  75 - below Tools
		//  80 - below Settings
		// 100 - below second separator

		$this->register( 30 );
	}

	private function register( $menu_position = 1 ) {
		$faq = new PostType( [
			'name'     => $this->post_type,
			'slug'     => $this->post_type_slug,
			'plural'   => 'FAQs',
			'singular' => 'FAQ',
		], [
			'supports'      => [ 'title', 'editor', 'revisions' ],
			'menu_icon'     => 'dashicons-admin-comments',
			//'show_in_menu'  => 'mass-mailing',
			'menu_position' => $menu_position,
		] );
		$faq->taxonomy( 'faq_category' );

		$faq->register();

		$faq_category = new Taxonomy( [
			'name'     => 'faq_category',
			'slug'     => 'faq_category',
			'plural'   => 'Categories',
			'singular' => 'Category',
		], [
			'hierarchical' => true,
		] );
		$faq_category->register();
	}
}

// new WP_FAQ();