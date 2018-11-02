<?php

namespace OS;

abstract class WP_ThemeBase {

	public $ver = '1.0.2';

	private $assets_path;

	public $menus;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->menus = [
			'footer'  => 'Footer Navigation',
			'primary' => 'Primary Navigation',
		];

		$this->assets_path = _ASSETS;

		if ( ! is_admin() ) {
			$this->frontendActionsFilters();
		} else {
			$this->backendActionsFilters();
		}

		if ( session_status() == PHP_SESSION_NONE ) {
			session_start();
		}

		$this->registerMenus();
		$this->afterThemeSetup();

	}

	/**
	 *
	 */
	private function backendActionsFilters() {

		//add_action( 'admin_init', function() {
		//    remove_submenu_page( 'tools.php', 'redux-about' );
		//} );
		//
		add_action( 'admin_enqueue_scripts', function() {
			// wp_enqueue_style( 'os-admin-styles', get_bloginfo( 'template_url' ) . '/assets/css/admin.css', [], $this->ver );
			// wp_enqueue_script( 'os-scripts-manifest', get_bloginfo( 'url' ) . '/assets/js/manifest.js', [], $this->ver, true );
			// wp_enqueue_script( 'os-admin-scripts', get_bloginfo( 'url' ) . '/assets/js/admin.js', [ 'jquery', 'os-scripts-manifest' ], $this->ver, true );
		} );
	}

	/**
	 * Tweaks wp default actions
	 */
	private function afterThemeSetup() {
		add_action( 'after_setup_theme', function() {
			// Disable the admin toolbar.
			//show_admin_bar( false );

			//show_admin_bar( false );

			// Remove JPEG compression.
			add_filter( 'jpeg_quality', function() {
				return 100;
			}, 10, 2 );

			// Add post thumbnails support.
			add_theme_support( 'post-thumbnails' );

			// Add title tag theme support.
			add_theme_support( 'title-tag' );

			// Add HTML5 theme support.
			add_theme_support( 'html5', [
				'caption',
				'comment-form',
				'comment-list',
				'gallery',
				'search-form',
				'widgets',
			] );

		} );

	}

	/**
	 * Enqueues theme scripts and stylesheets.
	 */
	private function frontendActionsFilters() {
		// Auto WP Update
		add_filter( 'auto_update_plugin', '__return_true' );
		add_filter( 'auto_update_theme', '__return_true' );

		// Remove unnecessary tags from header
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		// Enqueue and register scripts the right way.
		add_action( 'wp_enqueue_scripts', function() {
			wp_deregister_script( 'wp-embed' );
			wp_deregister_script( 'jquery' );

			wp_enqueue_style( 'main', mix( 'css/main.css' ), [], $this->ver );
			wp_register_script( 'main', mix( 'js/main.js' ), [], $this->ver, true );
			wp_enqueue_script( 'main' );

		} );

		add_action( 'wp_head', function() {
			$this->metaOGTags();
		} );

		//add_action( 'wp_enqueue_scripts', function() {
		//wp_enqueue_style( 'main-styles', $this->assets_path . '/css/main.css', [], $this->ver );
		//
		//wp_deregister_script( 'jquery' );
		//wp_enqueue_script( 'theme-manifest', $this->assets_path . '/js/manifest.js', [], $this->ver, true );
		//wp_enqueue_script( 'theme-vendor', $this->assets_path . '/js/vendor.js', [ 'theme-manifest' ], $this->ver, true );
		//wp_enqueue_script( 'jquery', $this->assets_path . '/js/main.js', [ 'theme-manifest', 'theme-vendor' ], $this->ver, true );
		//
		//wp_localize_script( 'theme-scripts', 'wpTheme', [
		//	'ajax_url' => admin_url( 'admin-ajax.php' ),
		//	'base_url' => home_url(),
		//	// 'security' => wp_create_nonce( 'wah-site-secret...' ),
		//] );
		//} );

		//
		add_filter( 'excerpt_more', function() {
			return '...';
		} );

		// Use it temporary to generate all featured images
		// add_action( 'the_post', [ $this, 'autoFeaturedImageForPost' ] );
		// Used for new posts
		// add_action( 'save_post', [ $this, 'autoFeaturedImageForPost' ] );
		// add_action( 'draft_to_publish', [ $this, 'autoFeaturedImageForPost' ] );
		// add_action( 'new_to_publish', [ $this, 'autoFeaturedImageForPost' ] );
		// add_action( 'pending_to_publish', [ $this, 'autoFeaturedImageForPost' ] );
		// add_action( 'future_to_publish', [ $this, 'autoFeaturedImageForPost' ] );

	}

	/**
	 * Sets first post image as featured image
	 */
	public function autoFeaturedImageForPost() {
		global $post;

		if ( ! empty( $post->ID ) && ! has_post_thumbnail( $post->ID ) ) {

			$attached_image = (array) get_children( [
				'post_parent'    => $post->ID,
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'numberposts'    => 1,
			] );

			if ( $attached_image ) {
				foreach ( $attached_image as $attachment_id => $attachment ) {
					set_post_thumbnail( $post->ID, $attachment_id );
				}
			}
		}
	}

	/**
	 * Registers the menus
	 */
	private function registerMenus() {
		register_nav_menus( $this->menus );
	}

	/**
	 * Adds Open Graph Tags
	 */
	private function metaOGTags() {
		global $post;
		$page_image = get_bloginfo( 'url' ) . '/og.jpg';
		//
		$page_title       = get_bloginfo( 'name' );
		$page_type        = 'website';
		$page_description = get_bloginfo( 'description' );

		$page_url = get_permalink();
		$page_url = preg_match( '~/wp-json/~', $page_url ) ? null : $page_url;

		if ( ! empty( $post->ID ) ) {
			if ( has_post_thumbnail( $post ) ) {
				$page_image = get_the_post_thumbnail_url( $post );
			}
			$page_title = get_the_title( $post );
			if ( ! empty( $post->post_excerpt ) ) {
				$page_description = get_the_excerpt( $post );
			}
		}
		if ( ! empty( $page_url ) ):
			?>
			<?php /* <!--<meta property="fb:app_id" content="[app id goes here]" />--> */ ?>
            <meta property="og:url" content="<?php echo $page_url ?>" />
            <meta property="og:type" content="<?php echo $page_type ?>" />
            <meta property="og:title" content="<?php echo $page_title ?>" />

			<?php
			if ( ! empty( $page_image ) ): ?>
                <meta property="og:image" content="<?php echo $page_image ?>" />
			<?php
			endif; ?>

            <meta property="og:description" content="<?php echo sanitize_text_field( $page_description ) ?>" />
		<?php
		endif;
	}
}