<?php

namespace OS;

use JasonGrimes\Paginator;
use \WeDevs\ORM\Eloquent\Facades\DB;

/**
 * Class WP_Posts
 *
 * @package OS
 */
class WP_Posts {

	/**
	 * Contains all posts categories
	 *
	 * @var array
	 */
	private $all_categories = [];

	/**
	 * The unique instance of the plugin.
	 *
	 * @var OS/WP_Posts
	 */
	private static $instance = null;

	/**
	 * Gets an instance theme class
	 *
	 * @return static OS/WP_Posts
	 */
	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * WP_Posts constructor.
	 */
	public function __construct() {
		$this->all_categories = get_categories();
	}

	/**
	 * @return array
	 */
	public function allCategories() {
		return $this->all_categories;
	}

	/**
	 * @param $post
	 *
	 * @return array
	 */
	public function postCategories( $post = null ) {
		if ( empty( $post ) ) {
			$post = get_post();
		}

		$categories = [];
		if ( ! empty( $post->ID ) ) {
			$categories = get_the_category( $post->ID );
		}

		return $categories;
	}

	/**
	 * @param $post
	 *
	 * @return array
	 */
	public function postTags( $post ) {
		$tags = [];
		if ( ! empty( $post->ID ) ) {
			$args = [];
			$tags = wp_get_post_tags( $post->ID, $args );
		}

		return $tags;
	}

	/**
	 * @param array $args
	 *
	 * @param bool  $return_pagination
	 *
	 * @return array
	 */
	private function getPosts( $args = [], $return_pagination = false ) {
		$args = array_merge( [
			'category_name' => '',
		], $args );

		$latest_posts = new \WP_Query( $args );

		$posts = [];
		while ( $latest_posts->have_posts() ): $latest_posts->the_post();
			global $post;
			$posts[] = $post;
		endwhile;
		$pagination = null;
		if ( $return_pagination ) {
			$pagination = $this->pagination( '/posts/', $latest_posts, true );
		}
		wp_reset_query();

		if ( $return_pagination ) {
			return compact( 'posts', 'pagination' );
		}

		return $posts;
	}

	/**
	 * @param       $limit
	 *
	 * @param array $exclude_ids
	 *
	 * @return array
	 */
	public function latest( $limit, $exclude_ids = [] ) {
		$args['posts_per_page'] = $limit;
		if ( ! empty( $exclude_ids ) ) {
			$args['post__not_in'] = $exclude_ids;
		}

		return $this->getPosts( $args );
	}

	/**
	 * @param string $category_name
	 * @param int    $limit
	 *
	 * @param array  $exclude_ids
	 *
	 * @return array
	 */
	public function latestInCategory( $category_name, $limit = 3, $exclude_ids = [] ) {
		$args = [
			'category_name'  => $category_name,
			'posts_per_page' => $limit,
		];
		if ( ! empty( $exclude_ids ) ) {
			$args['post__not_in'] = $exclude_ids;
		}

		return $this->getPosts( $args );
	}

	/**
	 * @param int  $limit
	 * @param null $post
	 *
	 * @return array
	 */
	public function related( $limit = 3, $post = null ) {
		if ( empty( $post ) ) {
			$post = get_post();
		}

		$post_categories             = $this->postCategories( $post );
		$post_categories_index_count = [];
		foreach ( $post_categories as $post_category ) {
			if ( $post_category->count > 1 ) {
				$post_categories_index_count[ $post_category->count ] = $post_category->slug;
			}
		}
		// TODO:
		// Work on prioritizing by categories weights(post counts)
		// $cats = [];
		// for ( $i = 0; $i < $limit; $i ++ ) {
		//	$cats[] = weighted_rand( $post_categories_index_count );
		// }

		$cats = $post_categories_index_count;

		$posts = $this->getPosts( [
			'orderby'        => 'rand',
			'post__not_in'   => [ $post->ID ],
			'category_name'  => implode( ',', $cats ),
			'posts_per_page' => $limit,
		] );

		if ( count( $posts ) < $limit ) {
			$excluded_ids = [ $post->ID ];
			foreach ( $posts as $_post ) {
				$excluded_ids[] = $_post->ID;
			}
			$posts_add = $this->getPosts( [
				'orderby'        => 'rand',
				'post__not_in'   => $excluded_ids,
				'posts_per_page' => $limit - count( $posts ),
			] );

			$posts = array_merge( $posts, $posts_add );
		}

		return $posts;
	}

	/**
	 * @param int   $limit
	 *
	 * @param array $exclude_ids
	 *
	 * @return array
	 */
	public function mostCommented( $limit = 6, $exclude_ids = [] ) {
		$args = [
			'orderby'        => 'comment_count',
			'posts_per_page' => $limit,
		];
		if ( ! empty( $exclude_ids ) ) {
			$args['post__not_in'] = $exclude_ids;
		}

		return $this->getPosts( $args );
	}

	/**
	 * @param string $base
	 * @param bool   $query
	 * @param bool   $return
	 *
	 * @return string
	 */
	function pagination( $base = '/', $query = false, $return = false ) {

		if ( empty( $query ) ) {
			global $wp_query;
			$query = $wp_query;
		}

		$totalItems   = $query->found_posts;
		$base         = rtrim( $base, '/' ) . '/';
		$urlPattern   = home_url( $base . 'page/(:num)' );
		$currentPage  = ! empty( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1;
		$itemsPerPage = $query->query_vars['posts_per_page'];

		$query_string = preg_replace( '~page=\d+~', '', $_SERVER['QUERY_STRING'] );

		if ( ! empty( $query_string ) ) {

			$urlPattern .= '?' . $query_string;
		}

		$paginator = new Paginator( $totalItems, $itemsPerPage, $currentPage, $urlPattern );
		$paginator->setMaxPagesToShow( 6 );

		$pagination = component( 'pagination', compact( 'paginator' ), true );

		if ( $return ) {
			return $pagination;
		} else {
			echo $pagination;
		}

	}
}

