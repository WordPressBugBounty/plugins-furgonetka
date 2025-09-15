<?php

class Furgonetka_Blocks {

	/**
	 * Fields
	 */
	const FIELD_SELECTED_POINT     = 'selected_point';
	const FIELD_SELECTED_POINT_COD = 'selected_point_cod';
	const FIELD_TAX_ID             = 'tax_id';

	const FIELD_SERVICE      = 'service';
	const FIELD_SERVICE_TYPE = 'service_type';
	const FIELD_CODE         = 'code';
	const FIELD_NAME         = 'name';

	/**
	 * Extension cart update fields & actions
	 */
	const FIELD_ACTION  = 'action';
	const FIELD_PAYLOAD = 'payload';

	const ACTION_SET_POINT     = 'set_point';
	const ACTION_SET_POINT_COD = 'set_point_cod';
	const ACTION_SET_TAX_ID    = 'set_tax_id';

	/**
	 * @var Furgonetka_Loader
	 */
	private $loader;

	/**
	 * @var Furgonetka_Public
	 */
	private $public;

	/**
	 * @var Furgonetka_Admin
	 */
	private $admin;

	/**
	 * @var Furgonetka_Loader $loader
	 * @var Furgonetka_Public $public
	 * @var Furgonetka_Admin $admin
	 */
	public function __construct( $loader, $public, $admin ) {
		$this->loader = $loader;
		$this->public = $public;
		$this->admin  = $admin;
	}

	/**
	 * Initialize blocks backend (Store API)
	 *
	 * @return void
	 */
	public function init() {
		/**
		 * Register WooCommerce Blocks checkout integration
		 */
		$this->add_action( 'woocommerce_blocks_checkout_block_registration', array( $this, 'register_checkout_integrations' ) );

		/**
		 * Register WooCommerce Blocks cart integration
		 */
		$this->add_action( 'woocommerce_blocks_cart_block_registration', array( $this, 'register_cart_integrations' ) );

		/**
		 * Register WooCommerce Blocks integration extension data/endpoint
		 */
		$this->add_action( 'woocommerce_blocks_loaded', array( $this, 'register_extension' ) );

		/**
		 * Remove session data while order is processed
		 */
		$this->add_action( 'woocommerce_store_api_checkout_order_processed', array( $this, 'remove_tax_id_from_session' ) );

		/**
		 * Save point when payment method has changed since last Cart API request
		 */
		$this->add_action( 'woocommerce_store_api_checkout_order_processed', array( $this, 'save_point_to_order' ) );

		/**
		 * Checkout order validation
		 */
		$this->add_action( 'woocommerce_store_api_checkout_order_processed', array( $this, 'checkout_validation' ) );

		/**
		 * Update order draft metadata
		 */
		$this->add_action( 'woocommerce_store_api_checkout_update_order_meta', array( $this, 'save_point_to_order' ) );
		$this->add_action( 'woocommerce_store_api_checkout_update_order_meta', array( $this, 'save_tax_id_to_order' ) );
	}

	/**
	 * Register checkout integrations instances
	 *
	 * @param \Automattic\WooCommerce\Blocks\Integrations\IntegrationRegistry $integration_registry
	 * @return void
	 */
	public function register_checkout_integrations( $integration_registry ) {
		if ( ! interface_exists( \Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface::class ) ) {
			/**
			 * Blocks integration is not supported
			 */
			return;
		}

		require_once __DIR__ . '/class-furgonetka-pickup-point-block-integration.php';

		$integration_registry->register( new Furgonetka_Pickup_Point_Block_Integration() );
	}

	/**
	 * Register cart integration instances
	 *
	 * @param \Automattic\WooCommerce\Blocks\Integrations\IntegrationRegistry $integration_registry
	 * @return void
	 */
	public function register_cart_integrations( $integration_registry ) {
		if ( ! $this->admin::is_checkout_active() ) {
			return;
		}

		if ( ! $this->admin::get_portmonetka_replace_native_checkout() ) {
			return;
		}

		if ( ! interface_exists( \Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface::class ) ) {
			return;
		}

		require_once __DIR__ . '/class-furgonetka-checkout-filters-integration.php';

		$integration_registry->register( new Furgonetka_Checkout_Filters_Integration() );
	}

	/**
	 * Register extension data callbacks
	 *
	 * @return void
	 */
	public function register_extension() {
		if (
			! function_exists( 'woocommerce_store_api_register_update_callback' ) ||
			! function_exists( 'woocommerce_store_api_register_endpoint_data' ) ||
			! class_exists( \Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema::class )
		) {
			/**
			 * Store API is not supported
			 */
			return;
		}

		woocommerce_store_api_register_update_callback(
			array(
				'namespace' => 'furgonetka',
				'callback'  => array( $this, 'set_extension_data' ),
			)
		);

		woocommerce_store_api_register_endpoint_data(
			array(
				'endpoint'        => \Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema::IDENTIFIER,
				'namespace'       => 'furgonetka',
				'data_callback'   => array( $this, 'get_extension_data' ),
				'schema_callback' => array( $this, 'get_extension_schema' ),
				'schema_type'     => ARRAY_A,
			)
		);
	}

	/**
	 * Get schema returned via extension
	 *
	 * @return array[]
	 */
	public function get_extension_schema() {
		$selected_point_schema = array(
			self::FIELD_SERVICE => array(
				'description' => __( 'Pickup point service', 'furgonetka' ),
				'type'        => 'string',
				'readonly'    => true,
			),
			self::FIELD_SERVICE_TYPE => array(
				'description' => __( 'Pickup point service type', 'furgonetka' ),
				'type'        => 'string',
				'readonly'    => true,
			),
			self::FIELD_CODE    => array(
				'description' => __( 'Pickup point code', 'furgonetka' ),
				'type'        => 'string',
				'readonly'    => true,
			),
			self::FIELD_NAME    => array(
				'description' => __( 'Pickup point name', 'furgonetka' ),
				'type'        => 'string',
				'readonly'    => true,
			),
		);

		return array(
			self::FIELD_SELECTED_POINT     => array(
				'description' => __( 'Selected point', 'furgonetka' ),
				'type'        => 'object',
				'readonly'    => true,
				'properties'  => $selected_point_schema,
			),
			self::FIELD_SELECTED_POINT_COD => array(
				'description' => __( 'Selected point (COD)', 'furgonetka' ),
				'type'        => 'object',
				'readonly'    => true,
				'properties'  => $selected_point_schema,
			),
			self::FIELD_TAX_ID             => array(
				'description' => __( 'Tax ID', 'furgonetka' ),
				'type'        => 'string',
				'readonly'    => true,
			),
		);
	}

	/**
	 * Get data to return via extension
	 *
	 * @return array
	 */
	public function get_extension_data() {
		/**
		 * Get session data
		 */
		$service = $this->get_selected_service();

		$current_selection_by_service     = WC()->session->get( FURGONETKA_PLUGIN_NAME . '_pointTo' );
		$current_selection_by_service_cod = WC()->session->get( FURGONETKA_PLUGIN_NAME . '_pointToCod' );
		$current_tax_id                   = WC()->session->get( FURGONETKA_PLUGIN_NAME . '_taxId' );

		/**
		 * Parse session data
		 */
		$data     = $current_selection_by_service[ $service ] ?? [];
		$data_cod = $current_selection_by_service_cod[ $service ] ?? [];

		return [
			self::FIELD_SELECTED_POINT     => $this->get_point_extension_data( $data ),
			self::FIELD_SELECTED_POINT_COD => $this->get_point_extension_data( $data_cod ),
			self::FIELD_TAX_ID             => $current_tax_id,
		];
	}

	/**
	 * Get currently selected point extension data
	 */
	private function get_point_extension_data( array $data ): array {
		return [
			self::FIELD_SERVICE        => $data[ self::FIELD_SERVICE ] ?? '',
			self::FIELD_SERVICE_TYPE   => $data[ self::FIELD_SERVICE_TYPE ] ?? '',
			self::FIELD_CODE           => $data[ self::FIELD_CODE ] ?? '',
			self::FIELD_NAME           => $data[ self::FIELD_NAME ] ?? '',
		];
	}

	/**
	 * Set extension data
	 *
	 * @param mixed $actions
	 * @return void
	 */
	public function set_extension_data( $actions ) {
		if ( ! is_array( $actions ) ) {
			return;
		}

		foreach ( $actions as $data ) {
			$action  = $data[ self::FIELD_ACTION ] ?? null;
			$payload = $data[ self::FIELD_PAYLOAD ] ?? null;

			switch ( $action ) {
				case self::ACTION_SET_POINT:
					$this->set_point( $payload, false );
					break;
				case self::ACTION_SET_POINT_COD:
					$this->set_point( $payload, true );
					break;
				case self::ACTION_SET_TAX_ID:
					$this->set_tax_id( $payload );
					break;
			}
		}
	}

	/**
	 * Set point to session
	 *
	 * @param mixed $data
	 * @return void
	 */
	private function set_point( $data, bool $cod ) {
		$this->public->save_point_to_session_internal(
			$this->sanitize_string( $data[ self::FIELD_SERVICE ] ?? '' ),
			$this->sanitize_string( $data[ self::FIELD_SERVICE_TYPE ] ?? '' ),
			$this->sanitize_string( $data[ self::FIELD_CODE ] ?? '' ),
			$this->sanitize_string( $data[ self::FIELD_NAME ] ?? '' ),
			$cod
		);
    }

    /**
     * Save tax ID to session
     *
     * @param mixed $tax_id
     * @return void
     */
    private function set_tax_id( $tax_id ) {
		WC()->session->set( FURGONETKA_PLUGIN_NAME . '_taxId', $this->sanitize_string( $tax_id ) );
    }

	/**
	 * Validate selected point
	 *
	 * @param WC_Order $order
	 * @return void
	 * @throws \Automattic\WooCommerce\StoreApi\Exceptions\RouteException
	 */
	public function checkout_validation( $order ) {
		$service        = $this->get_selected_service();
		$extension_data = $this->get_extension_data();
		$data           = $order->get_payment_method() !== 'cod' ?
			$extension_data[ self::FIELD_SELECTED_POINT ] : $extension_data[ self::FIELD_SELECTED_POINT_COD ];

		if ( ! empty( $service ) && empty( $data['code'] ) ) {
			throw new \Automattic\WooCommerce\StoreApi\Exceptions\RouteException(
				'furgonetka_missing_pickup_point',
				__( 'Please select delivery point.', 'furgonetka' ),
				400,
				array()
			);
		}
	}

	/**
	 * Save point from session into the order
	 *
	 * @param WC_Order $order
	 * @return void
	 */
	public function save_point_to_order( $order ) {
		$extension_data = $this->get_extension_data();
		$data           = $order->get_payment_method() !== 'cod' ?
			$extension_data[ self::FIELD_SELECTED_POINT ] : $extension_data[ self::FIELD_SELECTED_POINT_COD ];

		/**
		 * Remove point data when assigned service is invalid or empty
		 */
		$order_service = $this->public->get_order_shipping_method_service( $order );
		$furgonetka_service = $this->sanitize_string( $data['service'] );

		if ( $order_service !== $furgonetka_service ) {
			$order->delete_meta_data( '_furgonetkaPoint' );
			$order->delete_meta_data( '_furgonetkaPointName' );
			$order->delete_meta_data( '_furgonetkaService' );
			$order->delete_meta_data( '_furgonetkaServiceType' );

			return;
		}

		/**
		 * Update order
		 */
		$order->update_meta_data( '_furgonetkaPoint', $this->sanitize_string( $data[ self::FIELD_CODE ] ) );
		$order->update_meta_data( '_furgonetkaPointName', $this->sanitize_string( $data[ self::FIELD_NAME ] ) );
		$order->update_meta_data( '_furgonetkaService', $this->sanitize_string( $data[ self::FIELD_SERVICE ] ) );
		$order->update_meta_data( '_furgonetkaServiceType', $this->sanitize_string( $data[ self::FIELD_SERVICE_TYPE ] ) );
	}

	/**
	 * Save tax ID from session into the order
	 *
	 * @param WC_Order $order
	 * @return void
	 */
	public function save_tax_id_to_order( WC_Order $order ) {
		$extension_data = $this->get_extension_data();
		$tax_id	 = $this->sanitize_string( $extension_data[ self::FIELD_TAX_ID ] );

		if ( ! empty( $tax_id ) ) {
			$order->update_meta_data( '_billing_furgonetkaTaxId', $tax_id );
		} else {
			$order->delete_meta_data( '_billing_furgonetkaTaxId' );
		}
	}

	/**
	 * Remove tax ID from the session
	 *
	 * @return void
	 */
	public function remove_tax_id_from_session() {
		$this->set_tax_id( null );
	}

	/**
	 * Add callback to the action
	 *
	 * @param $hook
	 * @param $callback
	 * @return void
	 */
	private function add_action( $hook, $callback ) {
		$this->loader->add_action( $hook, $callback[0], $callback[1] );
	}

	/**
	 * Get currently selected service
	 *
	 * @return string|null
	 */
	private function get_selected_service() {
		return Furgonetka_Map::get_service_from_session();
	}

	/**
	 * Sanitize given value (and cast to string when necessary)
	 *
	 * @param mixed $value
	 * @return string
	 */
	private function sanitize_string( $value ): string {
		if ( ! is_string( $value ) ) {
			return '';
		}

		return sanitize_text_field( wp_unslash( $value ) );
	}
}
