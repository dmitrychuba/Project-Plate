<?php

namespace OS;

class WP_RestEndpoint extends \WP_REST_Controller {

	private $api_routes;
	private $ny_namespace;

	/**
	 * WP_Rest_Endpoint constructor.
	 *
	 * @param array  $api_routes
	 * @param string $namespace
	 * @param string $version
	 */
	public function __construct( array $api_routes, $namespace, $version ) {

		$this->ny_namespace = "$namespace/v{$version}";
		$this->api_routes   = $api_routes;

		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	public function register_routes() {
		foreach ( $this->api_routes as $api_route => $route_params ) {
			$api_route    = '/' . ltrim( $api_route, '/' );
			$route_params = $this->transformParams( $route_params );
			if ( empty( $route_params ) ) {
				continue;
			}
			register_rest_route( $this->ny_namespace, $api_route, $route_params );
		}

	}

	private function transformParams( array $params ) {
		if ( empty( $params ) ) return;
		$transformed = [];

		foreach ( $params as $methods => $param ) {
			if ( is_numeric( $methods ) ) {
				continue;
			}

			if ( is_array( $param ) && ! empty( $param['callback'] ) ) {
				$transformed_item = array_merge( [
					'methods' => $methods,
				], $param );

			} else {
				$transformed_item = [
					'methods'  => $methods,
					'callback' => $param,
				];
			}

			$transformed[] = $transformed_item;

		}
		return $transformed;
	}
}