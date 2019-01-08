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
		$classes = is_front_page() ? 'home' : ( ! empty( $post ) ? $post->post_name : null );
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

if ( ! function_exists( 'weighted_rand' ) ) {
	/**
	 * This function expects an array with weights
	 * as its array indices. You should not use a
	 * simple array — e.g. array('a', 'b', 'c'). Since
	 * the first item in an array like this has index 0,
	 * it will never be selected.
	 *
	 * It will return a randomly selected value.
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	function weighted_rand( $data ) {
		$total_weight = array_sum( array_keys( $data ) );
		$rand         = rand( 1, $total_weight );

		$current_weight = 0;
		foreach ( $data as $i => $val ) {
			$current_weight += $i;
			if ( $current_weight >= $rand ) {
				return $val;
			}
		}

		return end( $data );
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

if ( ! function_exists( 'get_item' ) ) {
	function get_item( array $array, $key ) {
		return isset( $array[ $key ] ) ? $array[ $key ] : false;
	}
}

if ( ! function_exists( 'get_repeater_row' ) ) {
	function get_repeater_row( $data, $key = null ) {
		$result = [];
		if ( is_array( $data ) && ! empty( $data[0] ) ) {
			$result = $data[0];
			if ( $key && ! empty( $result[ $key ] ) ) {
				$result = $result[ $key ];
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'the_repeater_row' ) ) {
	function the_repeater_row( $data, $key = null ) {
		echo get_repeater_row( $data, $key );
	}
}

if ( ! function_exists( 'get_image_url' ) ) {
	function get_image_url( $image_array_src, $size = 'medium_large' ) {
		$image_url = null;
		if ( ! empty( $image_array_src['sizes'] ) && ! empty( $image_array_src['sizes'][ $size ] ) ) {
			$image_url = $image_array_src['sizes'][ $size ];
		} else if ( ! empty( $image_array_src['url'] ) ) {
			$image_url = $image_array_src['url'];
		} else if ( ! empty( $image_array_src['src'] ) ) {
			$image_url = $image_array_src['src'];
		} else if ( is_string( $image_array_src ) ) {
			$image_url = $image_array_src;
		}

		return $image_url;
	}
}

if ( ! function_exists( 'get_image' ) ) {
	function get_image( $image_id_array_src, $attrs = [], $size = '' ) {

		if ( is_array( $image_id_array_src ) && ! empty( $image_id_array_src['ID'] ) ) {
			$attachment_id = $image_id_array_src['ID'];
		} elseif ( is_numeric( $image_id_array_src ) ) {
			$attachment_id = $image_id_array_src;
		} elseif ( is_string( $image_id_array_src ) ) {
			$default_attr = [
				'src'   => $image_id_array_src,
				'class' => "attachment-full size-full",
			];

			$attr = wp_parse_args( $attrs, $default_attr );

			return '<img src="' . $attr['src'] . '"' .
			       ' class="' . $attr['class'] . '"' .
			       ( ! empty( $attr['alt'] ) ? 'alt="' . $attr['alt'] . '"' : null ) .
			       ">";
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
	function get_the_link( $link_array_url, $attrs = [] ) {
		if ( ! empty( $attrs['text'] ) || ( isset( $attrs['text'] ) && $attrs['text'] === false ) ) {
			$link_title = $attrs['text'];
			unset( $attrs['text'] );
		} else if ( ! empty( $link_array_url['title'] ) ) {
			$link_title = $link_array_url['title'];
			unset( $link_array_url['title'] );
		} else if ( is_string( $link_array_url ) ) {
			$link_title     = false;
		}

		if ( is_string( $link_array_url ) ) {
			$link_array_url = [
				'url' => $link_array_url,
			];
		}

		if ( empty( $link_array_url['url'] ) && empty( $link_title ) ) {
			return null;
		}

		$html = '<a' . get_link_attrs( $link_array_url, $attrs ) . '>';
		if ( ! empty( $link_title ) || ( isset( $link_title ) && $link_title === false ) ) {
			$html .= $link_title;
		} else {
			$html .= $link_array_url['url'];
		}
		$html .= '</a>';

		return $html;
	}
}

if ( ! function_exists( 'the_link' ) ) {
	function the_link( $link_array_url, $attrs = [] ) {
		echo get_the_link( $link_array_url, $attrs );
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
if ( ! function_exists( 'content' ) ) {
	function content( $more_link_text = null, $strip_teaser = false )
	{
		$content = get_the_content( $more_link_text, $strip_teaser );

		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $content;
	}
}

if ( ! function_exists( 'attrs_arr_to_str' ) ) {
	function attrs_arr_to_str( array $attrs_array ) {
		foreach ( $attrs_array as $attribute => $value ) {
			$attrs_array[] = $attribute . '="' . $value . '"';
			unset( $attrs_array[ $attribute ] );
		}

		return implode( ' ', $attrs_array );
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

if ( ! function_exists( 'social' ) && function_exists( 'OS\wp_social' ) ) {
	function social() {
		return OS\wp_social();
	}
}

if ( ! function_exists( 'posts' ) && function_exists( 'OS\wp_posts' ) ) {
	function posts() {
		return OS\wp_posts();
	}
}

if ( ! function_exists( 'theme' ) && function_exists( 'OS\wp_theme' ) ) {
	function theme() {
		return OS\wp_theme();
	}
}