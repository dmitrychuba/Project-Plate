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
		asset_url( $asset, true );
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

if ( ! function_exists( 'get_image_url' ) ) {
	function get_image_url( $image_array, $size = 'medium_large' ) {
		$image_url = null;
		if ( ! empty( $image_array['sizes'] ) && ! empty( $image_array['sizes'][ $size ] ) ) {
			$image_url = $image_array['sizes'][ $size ];
		} else if ( $image_array['url'] ) {
			$image_url = $image_array['url'];
		}

		return $image_url;
	}
}

if ( ! function_exists( 'get_image' ) ) {
	function get_image( $image_id_array, $attrs = [], $size = '' ) {

		if ( is_array( $image_id_array ) && ! empty( $image_id_array['ID'] ) ) {
			$attachment_id = $image_id_array['ID'];
		} elseif ( is_numeric( $image_id_array ) ) {
			$attachment_id = $image_id_array;
		} else {
			return null;
		}

		return wp_get_attachment_image( $attachment_id, $size, false, $attrs );
	}
}

if ( ! function_exists( 'the_image' ) ) {
	function the_image( $image_array, $attrs = [], $size = '' ) {
		echo get_image( $image_array, $attrs, $size );
	}

}

if ( ! function_exists( 'get_link_attrs' ) ) {
	function get_link_attrs( $link_array, $attrs = [] ) {
		$attrs_def = [];

		if ( ! empty( $link_array['url'] ) ) {
			$attrs_def['href'] = $link_array['url'];
			unset( $link_array['url'] );
		}

		if ( ! empty( $link_array['target'] ) ) {
			$attrs_def['target'] = $link_array['target'];
		}

		$attrs_def = array_merge( $attrs_def, $attrs );

		$attrs_str = '';
		foreach ( $attrs_def as $attr => $val ) {
			$attrs_str .= ' ' . $attr . '="' . $val . '"';
		}

		return ! empty( $attrs_str ) ? $attrs_str : null;
	}
}

if ( ! function_exists( 'get_the_link' ) ) {
	function get_the_link( $link_array, $attrs = [] ) {
		if ( ! empty( $attrs['text'] ) ) {
			$link_title = $attrs['text'];
			unset( $attrs['text'] );
		} else if ( ! empty( $link_array['title'] ) ) {
			$link_title = $link_array['title'];
			unset( $link_array['title'] );
		}

		if ( empty( $link_array['url'] ) && empty( $link_title ) ) {
			return null;
		}

		$html = '<a' . get_link_attrs( $link_array, $attrs ) . '>';
		if ( ! empty( $link_title ) ) {
			$html .= $link_title;
		} else {
			$html .= $link_array['url'];
		}
		$html .= '</a>';

		return $html;
	}
}

if ( ! function_exists( 'the_link' ) ) {
	function the_link( $link_array, $attrs = [] ) {
		echo get_the_link( $link_array, $attrs );
	}
}

if ( ! function_exists( 'get_the_text' ) ) {
	function get_the_text( $text, $bt = true ) {
		return $bt ? nl2br( $text ) : $text;
	}
}

if ( ! function_exists( 'the_text' ) ) {
	function the_text( $text ) {
		echo get_the_text( $text );
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