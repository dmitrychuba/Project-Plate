<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

if ( ! function_exists( 'get_acf_field_group_id' ) ) {
	function get_acf_field_group_id( $group_name ) {
		global $wpdb;

		$query    = "SELECT ID FROM $wpdb->posts WHERE post_type = 'acf-field-group' AND post_title = '$group_name'";
		$group_id = $wpdb->get_var( $query );

		return $group_id;
	}
}

if ( ! function_exists( 'get_acf_field_key' ) ) {
	function get_acf_field_key( $field_name, $group_name_parent_id ) {
		global $wpdb;
		$result = null;

		if ( ! is_numeric( $group_name_parent_id ) ) {
			$group_name_parent_id = get_acf_field_group_id( $group_name_parent_id );

			if ( empty( $group_name_parent_id ) ) {
				return null;
			}
		}

		if ( stristr( $field_name, '.' ) ) {
			$field_names       = explode( '.', $field_name );
			$parent_field_name = array_shift( $field_names );
			$field_name        = implode( '.', $field_names );

			$query     = "SELECT ID FROM $wpdb->posts WHERE post_type = 'acf-field' AND post_excerpt = '$parent_field_name' AND post_parent = $group_name_parent_id";
			$parent_id = $wpdb->get_var( $query );

			if ( ! empty( $parent_id ) ) {
				return get_acf_field_key( $field_name, $parent_id );
			}

		} else {


			$query   = "SELECT post_name FROM $wpdb->posts WHERE post_type = 'acf-field' AND post_excerpt = '$field_name' AND post_parent = $group_name_parent_id";
			$results = $wpdb->get_results( $query );

			if ( count( $results ) == 1 ) {
				$result = $results[0]->post_name;
			}
		}

		return $result;
	}
}
if ( ! function_exists( 'get_acf_field_key' ) ) {
	function get_acf_field_key( $field_name, $group_name_parent_id ) {
		global $wpdb;
		$result = null;

		if ( ! is_numeric( $group_name_parent_id ) ) {
			$group_name_parent_id = get_acf_field_group_id( $group_name_parent_id );

			if ( empty( $group_name_parent_id ) ) {
				return null;
			}
		}

		if ( stristr( $field_name, '.' ) ) {
			$field_names       = explode( '.', $field_name );
			$parent_field_name = array_shift( $field_names );
			$field_name        = implode( '.', $field_names );

			$query     = "SELECT ID FROM $wpdb->posts WHERE post_type = 'acf-field' AND post_excerpt = '$parent_field_name' AND post_parent = $group_name_parent_id";
			$parent_id = $wpdb->get_var( $query );

			if ( ! empty( $parent_id ) ) {
				return get_acf_field_key( $field_name, $parent_id );
			}

		} else {
			$query   = "SELECT post_name FROM $wpdb->posts WHERE post_type = 'acf-field' AND post_excerpt = '$field_name' AND post_parent = $group_name_parent_id";
			$results = $wpdb->get_results( $query );

			if ( count( $results ) == 1 ) {
				$result = $results[0]->post_name;
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'get_acf_field_keys_chain' ) ) {
	function get_acf_field_keys_chain( $field_name, $group_name ) {
		$result = [];

		if ( stristr( $field_name, '.' ) ) {
			$field_names_chain = [];
			foreach ( explode( '.', $field_name ) as $chain_link ) {
				$field_names_chain[] = $chain_link;

				$result[] = get_acf_field_key( implode( '.', $field_names_chain ), $group_name );
			}

		} else {
			$result[] = get_acf_field_key( $field_name, $group_name );
		}

		return $result;
	}
}

if ( ! function_exists( 'get_acf_post_value' ) ) {
	function get_acf_post_value( $field_name, $group_name ) {


		if ( empty( $_POST['acf'] ) ) {
			return null;
		}
		$result = $_POST['acf'];

		$keys_chain = get_acf_field_keys_chain( $field_name, $group_name );

		foreach ( $keys_chain as $key ) {
			if ( array_key_exists( $key, $result ) ) {
				$result = $result[ $key ];
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'get_acf_field_name' ) ) {
	function get_acf_field_name( $field_key ) {
		global $wpdb;

		$query = "SELECT post_excerpt FROM $wpdb->posts WHERE post_type = 'acf-field' AND post_name = '$field_key'";

		return $wpdb->get_var( $query );
	}
}