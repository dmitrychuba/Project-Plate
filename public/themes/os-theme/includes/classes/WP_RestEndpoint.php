<?php

namespace OS;

use WP_REST_Server;

class WP_RestEndpoint extends \WP_REST_Controller {

	var $my_namespace = 'os/v';

	var $my_version = '1';

	/**
	 * WP_Rest_Endpoint constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes() {
		$namespace = $this->my_namespace . $this->my_version;
		register_rest_route( $namespace, '/posts', [
			[
				'methods'  => WP_REST_Server::READABLE,
				'callback' => [ $this, 'getPosts' ],
			],
		] );
	}

	public function getPosts() {
		$result = posts()->getPosts();

		return $result;
	}

}

new WP_RestEndpoint();