<?php if ( ! defined( 'ABSPATH' ) ) exit( 'restricted access' );

defined( 'ACF_BASE_DIRECTORY' ) or define( 'ACF_BASE_DIRECTORY', dirname( __FILE__ ) );

//$wp_base_directory  = ABSPATH;
//$wp_base_url        = trim( home_url(), '\/' );
//
//$_acf_base_directory = preg_replace( '~\|/~', '/', ACF_BASE_DIRECTORY );
//$_wp_base_directory  = preg_replace( '~\|/~', '/', $wp_base_directory );
//
//$acf_relative_directory = trim( str_ireplace( $_wp_base_directory, '', $_acf_base_directory ), '/' );

//$acf_base_url = "$wp_base_url/$acf_relative_directory";
//$acf_pro_url  = $acf_base_url . '/advanced-custom-fields-pro/';

//defined( 'ACF_BASE_URI' ) || define( 'ACF_BASE_URI', $acf_base_url );
//defined( 'ACF_BASE_PATH' ) || define( 'ACF_BASE_PATH', ACF_BASE_DIRECTORY );

//// 1. customize ACF path
//add_filter( 'acf/settings/path', function() use ( ACF_BASE_DIRECTORY ) {
//	return ACF_BASE_DIRECTORY . DS . 'advanced-custom-fields-pro' . DS;
//} );
//
//// 2. customize ACF dir
//add_filter( 'acf/settings/dir', function() use ( $acf_pro_url ) {
//	return $acf_pro_url;
//} );

// 3. Hide ACF field group menu item
add_filter( 'acf/settings/show_admin', function() {
	global $current_user;

	return /*$current_user->user_login == 'admin' ||*/
		$current_user->user_login == 'dmitry' || $current_user->user_login == 'admin';
} );
//*
// 4. Save ACF Fields to JSON
add_filter( 'acf/settings/save_json', function() {
	return ACF_BASE_DIRECTORY . DS . 'acf-fields-json';
} );

// 5. Load ACF Fields to JSON
add_filter( 'acf/settings/load_json', function( $paths ) {

	// remove original path (optional)
	unset( $paths[0] );

	// append path
	$paths[] = ACF_BASE_DIRECTORY . DS . 'acf-fields-json';

	// return
	return $paths;
} );

add_action( 'acf/fields/post_object/query', function( $args, $field, $post ) {

	if ( $field['name'] == 'event' ) {
		$args['meta_key'] = '_wcs_timestamp';
		$args['orderby']  = 'meta_value_num';
		$args['order']    = 'DESC';
	} else {
		$args['orderby']['date'] = 'DESC';
	}

	return $args;
}, 10, 3 );

add_action( 'acf/fields/post_object/result', function( $title, $post, $field, $post_id ) {
	global $wpdb;
	if ( $field['name'] == 'event' ) {
		//$event_start = get_metadata( 'class', $post->ID, '_wcs_timestamp', true );

		$query       = "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = {$post->ID} AND meta_key = '_wcs_timestamp'";
		$event_start = $wpdb->get_var( $query );
		$event_start = date( 'M j, Y g:ia', $event_start );

		$edit_event_link = admin_url( 'post.php?post=' . $post->ID . '&action=edit' );

		$title .= " <span class=\"date-badge\">&nbsp;{$event_start}&nbsp;</span>";
		$title .= " <a class=\"edit-event\" href=\"$edit_event_link\" target=\"_blank\">edit event</a>";
	}

	return $title;
}, 10, 4 );


/*
   Debug preview with custom fields
*/

add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields){
	$fields["debug_preview"] = "debug_preview";
	return $fields;
}

add_action( 'edit_form_after_title', 'add_input_debug_preview' );
function add_input_debug_preview() {
	echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}
