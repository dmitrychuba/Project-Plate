<?php

namespace OS;

/**
 * Class WP_Theme
 *
 * @package PC
 */
class WP_Theme extends WP_ThemeBase {

	/**
	 * The unique instance of the plugin.
	 *
	 * @var PC/WP_Theme
	 */
	private static $instance = null;

	/**
	 * Gets an instance theme class
	 *
	 * @return PC/WP_Theme
	 */
	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Returns WP Menu
	 *
	 * @param array $params
	 */

	public function menu( array $params = [] ) {

		$defaults = [
			'id'         => null,
			'name'       => null,
			'class'      => null,
			'item_class' => null,
		];

		$params = array_merge( $defaults, $params );

		$menu_name = $params['name'];

		if ( ! is_null( $menu_name ) && array_key_exists( $menu_name, $this->menus ) ) {
			$location = $menu_name;
			$name     = $this->menus[ $menu_name ];
		} else {
			reset( $this->menus );
			$location = key( $this->menus );
			$name     = current( $this->menus );
		}

		$args = [
			'menu'           => $name,
			'depth'          => 2,
			'container'      => false,
			'link_after'     => '</span>',
			'link_before'    => '<span class="menu-item-text">',
			'theme_location' => $location,
		];

		if ( ! empty( $params['id'] ) ) {
			$args['menu_id'] = $params['id'];
		}
		if ( ! empty( $params['class'] ) ) {
			$args['menu_class'] = $params['class'];
		}
		if ( ! empty( $params['item_class'] ) ) {
			add_filter( 'wp_nav_menu', function( $item ) use ( $params ) {
				return preg_replace( '/<a/', '<a class="' . $params['item_class'] . '"', $item, - 1 );
			} );
		}

		wp_nav_menu( $args );
	}

	/**
	 * @param        $post
	 * @param string $link_class
	 *
	 * @param string $separator
	 *
	 * @return string
	 */
	public function getPostCategoriesLinks( $post, $link_class = '', $separator = ', ' ) {
		$categories_html_links = [];

		$categories = wp_posts()->postCategories( $post );

		foreach ( $categories as $category ) {
			$categories_html_links[] = '<a href="' . get_category_link( $category->term_id ) . '" class="' . $link_class . '">' . $category->name . '</a>';
		}

		return implode( $separator, $categories_html_links );
	}

	/**
	 * @param        $post
	 * @param string $link_class
	 * @param string $separator
	 */
	public function postCategoriesLinks( $post, $link_class = '', $separator = ', ' ) {
		echo $this->getPostCategoriesLinks( $post, $link_class, $separator );
	}

	/**
	 * @param        $post
	 * @param string $link_class
	 *
	 * @param string $separator
	 *
	 * @return string
	 */
	public function getPostTagsLinks( $post, $link_class = '', $separator = ', ' ) {
		$tags_html_links = [];

		$tags = wp_posts()->postTags( $post );

		foreach ( $tags as $tag ) {
			$tags_html_links[] = '<a href="' . get_term_link( $tag->term_id ) . '" class="' . $link_class . '">' . $tag->name . '</a>';
		}

		return implode( $separator, $tags_html_links );
	}

	/**
	 * @param        $post
	 * @param string $link_class
	 * @param string $separator
	 */
	public function postTagsLinks( $post, $link_class = '', $separator = ', ' ) {
		echo $this->getPostTagsLinks( $post, $link_class, $separator );
	}

	/**
	 *  Loads page template, passes data
	 *
	 * @param       $template_path
	 * @param array $data
	 *
	 * @param bool  $return
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function template( $template_path, array $data = [], $return = false ) {
		$ds       = DIRECTORY_SEPARATOR;
		$base_dir = _TEMPLATE_DIR;

		$template_file = null;

		$bd = rtrim( $base_dir, $ds ) . $ds . 'page-templates' . $ds;

		if ( file_exists( $bd . $template_path ) ) {
			$template_file = $bd . $template_path;

		} elseif ( file_exists( $bd . $template_path . ".php" ) ) {
			$template_file = $bd . $template_path . ".php";

		} elseif ( file_exists( $bd . str_replace( '.', $ds, $template_path ) . ".php" ) ) {
			$template_file = $bd . str_replace( '.', $ds, $template_path ) . ".php";
		}

		if ( $template_file ) {
			extract( $data );
			ob_start();
			include $template_file;
			$result = ob_get_clean();
		} else {
			throw new \Exception( "Template file \"$bd . $template_path\" was not found" );
		}

		if ( $return ) {
			return $result;
		}

		echo $result;
	}

	/**
	 *  Loads component template, passes data
	 *
	 * @param       $component_path
	 * @param array $data
	 *
	 * @param bool  $return
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function component( $component_path, array $data = [], $return = false ) {
		$ds             = DIRECTORY_SEPARATOR;
		$component_path = 'components' . $ds . trim( $component_path, $ds );

		return $this->template( $component_path, $data, $return );
	}

	/**
	 *  Loads layout template, passes data
	 *
	 * @param       $layout_path
	 * @param array $data
	 *
	 * @param bool  $return
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function layout( $layout_path, array $data = [], $return = false ) {
		$ds          = DIRECTORY_SEPARATOR;
		$layout_path = 'layout' . $ds . trim( $layout_path, $ds );

		return $this->template( $layout_path, $data, $return );
	}

}