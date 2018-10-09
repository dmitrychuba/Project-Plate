<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

if ( ! function_exists( 'get_bg_image' ) ) {
	function get_bg_image( $src, $style_attribute = true ) {
		if ( empty( $src ) ) {
			return null;
		}

		return $style_attribute ? 'style="background-image: url(' . $src . ')"' : 'background-image: url(' . $src . ');';
	}
}

if ( ! function_exists( 'bg_image' ) ) {
	function bg_image( $src, $style_attribute = true ) {
		echo ! empty( $src ) ? get_bg_image( $src, $style_attribute ) : '';
	}
}

if ( ! function_exists( 'vd' ) ) {
	function vd( $var, ...$moreVars ) {
		dump( $var );

		foreach ( $moreVars as $var ) {
			dump( $var );
		}

		if ( 1 < func_num_args() ) {
			return func_get_args();
		}
	}
}

if ( ! function_exists( 'the_page_class' ) ) {
	function the_page_class( $additional_classes = null ) {
		global $post;
		$classes = is_front_page() ? 'home' : $post->post_name;
		if ( is_single() ) {
			$classes .= ' post';
		}
		if ( is_page() ) {
			$classes .= ' page';
		}
		if ( is_search() ) {
			$classes .= ' search-results-page';
		}
		if ( $additional_classes ) {
			$classes .= " $additional_classes";
		}

		echo $classes;
	}
}

if ( ! function_exists( '_get_views' ) ) {
	function _get_views( $_dir = null ) {
		$views_dir    = $_dir ? $_dir : _TEMPLATE_DIR;
		$views_result = [];

		if ( is_dir( $views_dir ) ) {
			$views = scandir( $views_dir );
			foreach ( array_splice( $views, 2 ) as $item ) {
				if ( is_dir( $views_dir . DS . $item ) ) {
					$views_result = array_merge( $views_result, array_map( function( $sub_item ) use ( $item ) {
						return $item . DS . str_ireplace( '.php', '', $sub_item );
					}, _get_views( $views_dir . DS . $item ) ) );
				}

				$views_result[] = str_ireplace( '.php', '', $item );
			}
		}

		return $views_result;
	}
}

if ( ! function_exists( 'the_asset' ) ) {
	function the_asset( $asset = null ) {
		asset_url( $asset,  true);
	}
}

if ( ! function_exists( 'asset_url' ) ) {
	function asset_url( $asset = null, $echo = false ) {
		if ( ! empty( $asset ) ) {
			$asset = '/' . ltrim( $asset, '/' );
		}

		if ( $echo ) {
			echo _ASSETS . $asset;
		} else {
			return _ASSETS . $asset;
		}
	}
}

if ( ! function_exists( 'str_unslug' ) ) {
	function str_unslug( $slug, $separator = null ) {
		if ( $separator ) {
			$slug = explode( $separator, $slug );
		} else {
			$slug = preg_split( '~-|_~', $slug );
		}

		$slug = implode( ' ', $slug );

		return ucwords( $slug );
	}
}

if ( ! function_exists( 'get_array' ) ) {
	function get_array( $data ) {
		return ! empty( $data ) && is_array( $data ) ? $data : [];
	}
}

if ( ! function_exists( 'truncate' ) ) {
	function truncate( $text, $chars = 25 ) {
		if ( strlen( $text ) <= $chars ) {
			return $text;
		}
		$text = $text . " ";
		$text = substr( $text, 0, $chars );
		$text = substr( $text, 0, strrpos( $text, ' ' ) );
		$text = $text . "...";

		return $text;
	}
}

if ( ! function_exists( 'layout' ) ) {
	function layout( $name, $data = [], $return = false ) {
		return OS\wp_theme()->layout( $name, $data, $return );
	}
}

if ( ! function_exists( 'component' ) ) {
	function component( $name, $data = [], $return = false ) {
		return OS\wp_theme()->component( $name, $data, $return );
	}
}

if ( ! function_exists( 'template' ) ) {
	function template( $name, $data = [], $return = false ) {
		return OS\wp_theme()->template( $name, $data, $return );
	}
}

if ( ! function_exists( 'posts' ) ) {
	function posts() {
		return OS\wp_posts();
	}
}

if ( ! function_exists( 'theme' ) ) {
	function theme() {
		return OS\wp_theme();
	}
}