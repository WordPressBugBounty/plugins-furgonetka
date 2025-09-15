<?php

require_once plugin_dir_path( __FILE__ ) . '../trait/trait-furgonetka-logger.php';

class Furgonetka_Cart
{
    use Furgonetka_Logger;

    private static $session;

    /**
     * @return array|null
     */
    private function get_session()
    {
        if ( ! self::$session ) {
            $this->load_session_for_current_user();
        }

        return self::$session;
    }

    /**
     * @return void
     */
    private function load_session_for_current_user()
    {
        self::$session = WC()->session->get_session_data();
    }

    /**
     * @param mixed $cartId
     * @return void
     */
    private function load_session_for_cart( $cartId )
    {
        self::$session = ( new WC_Session_Handler() )->get_session( $cartId );
    }

    /**
     * Get cart items for WP Rest
     *
     * @return WP_REST_Response
     */
    public function get_cart_items()
    {
        return $this->response( $this->internal_get_cart_items() );
    }

    /**
     * Internal get cart items
     *
     * @return array
     */
    private function internal_get_cart_items()
    {
        $cart_items = array();

        if ( ! empty( $this->get_session()['cart'] ) ) {
            $cart_items = (array) maybe_unserialize( $this->get_session()['cart'] );
        }

        $items = array();

        foreach ( $cart_items as $key => $cart_item ) {
            $is_variation = ( $cart_item['variation_id'] !== 0 );
            $product      = wc_get_product( $is_variation ? $cart_item['variation_id'] : $cart_item['product_id'] );

            $attributes = array();
            foreach ( $product->get_attributes() as $name => $attribute ) {
                if ( is_string( $attribute ) ) {
                    $attributes[] = array(
                        'name'   => $name,
                        'label'  => wc_attribute_label( $name ),
                        'values' => array( $attribute ),
                    );
                } else {
                    $attributes[] = array(
                        'name'   => $attribute->get_name(),
                        'label'  => wc_attribute_label( $attribute->get_name() ),
                        'values' => explode( ', ', $product->get_attribute( $attribute->get_name() ) ),
                    );
                }
            }
            $dimensions = $product->get_dimensions( false );
            if ( ! is_array( $dimensions ) ) {
                $dimensions = null;
            }

            $items[] = array(
                'id'                     => $key,
                'product_id'             => $product->get_ID(),
                'product_parent_id'      => $product->get_parent_id(),
                'product_name'           => $product->get_name(),
                'product_title'          => $product->get_title(),
                'product_virtual'        => $product->is_virtual(),
                'product_downloadable'   => $product->is_downloadable(),
                'product_price'          => (float) ( $product->get_sale_price() ?: $product->get_regular_price() ),
                'product_price_with_tax' => wc_get_price_including_tax($product, array( 'price' => $product->get_sale_price() ?: $product->get_regular_price() ) ),
                'product_image'          => wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ),
                'currency'               => get_woocommerce_currency(),
                'quantity'               => $cart_item['quantity'],
                'total'                  => $cart_item['line_total'],
                'tax'                    => $cart_item['line_tax'],
                'variation'              => count( $cart_item['variation'] ) ? $cart_item['variation'] : false,
                'attributes'             => $attributes,
                'dimensions'             => $dimensions,
                'weight'                 => (float) $product->get_weight(),
            );
        }

        return array(
            'items'   => $items,
            'cart_id' => $this->get_customer_id_from_session()
        );
    }

    /**
     * Get shipping types for WP Rest
     *
     * @return WP_REST_Response
     */
    public function get_shipping()
    {
        return $this->response( $this->internal_get_shipping() );
    }

    /**
     * Internal get shipping types
     *
     * @return array
     */
    private function internal_get_shipping()
    {
        $shipping = array();

        if ( !empty( $this->get_session()['shipping_for_package_0']) ) {
            $shipping = (array) maybe_unserialize( $this->get_session()['shipping_for_package_0'] );
        }

        $shipping_methods = array();

        if ( !empty( $shipping['rates'] ) ) {
            /**
             * Gather assigned payments
             *
             * - enable all shipping methods for non-COD payment
             * - enable selected shipping methods for COD payment
             */
            $payments             = array();
            $payments_without_cod = array();

            $cod_payment_shipping_methods = array();

            foreach ( $this->get_payments()->get_data() as $payment ) {
                /**
                 * Add every payment
                 */
                $payments[] = $payment;

                /**
                 * Gather shipping methods enabled for COD payment
                 */
                if ( ( $payment['id'] === 'cod' ) && ! empty( $payment['enable_for_methods'] ) ) {
                    $cod_payment_shipping_methods = $payment['enable_for_methods'];
                }

                /**
                 * Add non-COD payment to separate list
                 */
                if ( $payment['id'] !== 'cod' ) {
                    $payments_without_cod[] = $payment;
                }
            }

            /** @var WC_Shipping_Rate $shipping_method */
            foreach ( $shipping['rates'] as $shipping_method ) {
                $description = '';
                $metadata    = $shipping_method->get_meta_data();
                if ( isset( $metadata['description'] ) ) {
                    $description = $metadata['description'];
                }

                /**
                 * Filter payment methods for COD
                 */
                $shipping_payment_methods = $payments;

                if ( ! empty( $cod_payment_shipping_methods ) ) {
                    $instance_id = $shipping_method->instance_id;
                    $method_id   = $shipping_method->method_id;

                    /**
                     * Check method_id and method_id:instance_id presence in COD payment shipping methods
                     */
                    if ( ! in_array( $method_id, $cod_payment_shipping_methods, true ) &&
                        ! in_array( "{$method_id}:{$instance_id}", $cod_payment_shipping_methods, true ) ) {
                        $shipping_payment_methods = $payments_without_cod;
                    }
                }

                $method             = array(
                    'id'                => $shipping_method->instance_id,
                    'method_id'         => $shipping_method->method_id,
                    'name'              => $shipping_method->label,
                    'price'             => $shipping_method->cost,
                    'shipping_tax'      => $shipping_method->get_shipping_tax(),
                    'currency'          => get_woocommerce_currency(),
                    'payments'          => $shipping_payment_methods,
                    'description'       => $description,
                    'furgonetkaMapType' => Furgonetka_Map::get_service_by_shipping_rate_id( $shipping_method->id ),
                );
                $shipping_methods[] = $method;
            }
        }

        return array(
            'shipping_methods' => $shipping_methods,
            'cart_needs_shipping' => WC()->cart ? WC()->cart->needs_shipping() : null,
        );
    }

    /**
     * Get payment types for WP Rest
     *
     * @return WP_REST_Response
     */
    public function get_payments()
    {
        return $this->response( $this->internal_get_payments() );
    }

    /**
     * Internal get payment types
     *
     * @return array
     */
    private function internal_get_payments()
    {
        $woocommerce  = WC();
        $payments_raw = $woocommerce->payment_gateways->get_available_payment_gateways();
        $payments     = array();

        /**
         * Add COD payment when it's not present in available payment gateways
         */
        if ( ! isset( $payments_raw['cod'] ) ) {
            $all_payment_gateways_raw = $woocommerce->payment_gateways->payment_gateways();

            if ( isset( $all_payment_gateways_raw['cod'] ) ) {
                $payments_raw['cod'] = $all_payment_gateways_raw['cod'];
            }
        }

        foreach ( $payments_raw as $key => $payment ) {
            if ( $payment->enabled !== 'yes' ) {
                continue;
            }

            $data = array(
                'id'           => $key,
                'title'        => $payment->title,
                'btn_text'     => $payment->order_button_text,
                'method_title' => $payment->method_title,
                'description'  => $payment->method_description,
            );

            if ( $payment instanceof WC_Gateway_COD ) {
                $data['enable_for_methods'] = $payment->get_option( 'enable_for_methods' );
            }

            $payments[] = $data;
        }

        return $payments;
    }

    /**
     * Get coupons for WP Rest
     *
     * @return WP_REST_Response
     */
    public function get_coupons()
    {
        return $this->response( $this->internal_get_coupons() );
    }

    /**
     * Internal get coupons
     *
     * @return array
     */
    private function internal_get_coupons()
    {
        $session = $this->get_session();

        if ( ! isset( $session['coupon_discount_totals'] ) ) {
            return [];
        }

        $coupons_raw = (array) maybe_unserialize( $session['coupon_discount_totals'] );
        $coupons     = array();

        foreach ( $coupons_raw as $code => $discount ) {
            $coupons[] = array(
                'code'     => $code,
                'discount' => $discount,
                'currency' => get_woocommerce_currency(),
            );
        }

        return $coupons;
    }

    /**
     * Get totals (prices) for WP Rest
     *
     * @return WP_REST_Response
     */
    public function get_totals()
    {
        return $this->response( $this->internal_get_totals() );
    }

    /**
     * Internal get totals (prices)
     *
     * @return array
     */
    private function internal_get_totals()
    {
        // Gather raw cart totals
        $cart_totals_raw = (array) maybe_unserialize( $this->get_session()['cart_totals'] );

        // Define available cart totals
        $cart_totals = array(
            'subtotal'            => null,
            'subtotal_tax'        => null,
            'shipping_total'      => null,
            'shipping_tax'        => null,
            'discount_total'      => null,
            'discount_tax'        => null,
            'cart_contents_total' => null,
            'cart_contents_tax'   => null,
            'fee_total'           => null,
            'fee_tax'             => null,
            'total'               => null,
            'total_tax'           => null,
        );

        // Assign each value from raw cart, if given key exists
        foreach ( array_keys( $cart_totals ) as $key ) {
            if ( isset( $cart_totals_raw[ $key ] ) ) {
                $cart_totals[ $key ] = (float) $cart_totals_raw[ $key ];
            }
        }

        // Add currency
        $cart_totals['currency'] = get_woocommerce_currency();

        return $cart_totals;
    }

    /**
     * Get cart shipping method for WP Rest
     *
     * @return WP_REST_Response|WP_Error
     */
    public function get_cart_shipping_method()
    {
        if ( $shippingMethod = $this->internal_get_cart_shipping_method() ) {
            return $this->response( $shippingMethod );
        }

        return new WP_Error( 'furgonetka_invalid_resource_id', __( 'Invalid resource ID.', 'furgonetka' ), array( 'status' => 404 ) );
    }

    /**
     * Internal get cart shipping method
     *
     * @return array|false
     */
    private function internal_get_cart_shipping_method()
    {
        $_POST      = array_merge( $_POST, json_decode( file_get_contents( 'php://input' ), true ) );
        $cartId     = $this->get( 'cartId' );
        $instanceId = (int) $this->get( 'instanceId' );

        $this->load_session_for_cart( $cartId );

        $shippingMethods = $this->get_shipping()->get_data()['shipping_methods'];

        foreach ( $shippingMethods as $shippingMethod ) {
            if ( $shippingMethod['id'] === $instanceId ) {
                return $shippingMethod;
            }
        }

        return false;
    }

    /**
     * Get all-in-one (Cart, Totals, Coupons, Shipping, Payments) for WP Rest
     *
     * @return WP_REST_Response
     */
    public function get_all_in_one()
    {
        return $this->response( $this->internal_get_all_in_one() );
    }

    /**
     * Internal get all data: Cart, Totals, Coupons, Shipping, Payments
     *
     * @return array
     */
    private function internal_get_all_in_one()
    {
        $all_in_one = array(
            'cart'        => $this->internal_get_cart_items(),
            'cart_totals' => $this->internal_get_totals(),
            'coupons'     => $this->internal_get_coupons(),
            'shipping'    => $this->internal_get_shipping(),
            'payments'    => $this->internal_get_payments()
        );

        return $all_in_one;
    }

    /**
     * Get value from $_POST by key
     *
     * @param string $key      $_POST[$key]
     * @param mixed  $default  default return value if $_POST value does not exist
     * @param bool   $sanitize if to sanitize return value
     *
     * @return mixed
     */
    private function get( $key, $default = '', $sanitize = true )
    {
        if ( isset( $_POST[ $key ] ) ) {
            if ( $sanitize ) {
                return filter_var( $_POST[ $key ], FILTER_SANITIZE_STRING );
            } else {
                return filter_var( $_POST[ $key ], FILTER_SANITIZE_EMAIL );
            }
        }

        return $default;
    }

    /**
     * Get uncached wordpress REST response
     *
     * @param mixed $data    data to be passed to response
     * @param int   $status  http status of response
     * @param array $headers headers to be set on response
     *
     * @return WP_REST_Response
     */
    private function response( $data, $status = 200, $headers = array() )
    {
        /**
         * Apply no-cache headers
         */
        nocache_headers();

        /**
         * Disable litespeed cache
         */
        do_action( 'litespeed_control_set_nocache', 'REST API should be non-cacheable' );

        /**
         * Return WordPress REST response
         */
        return new WP_REST_Response( $data, $status, $headers );
    }

    /**
     * Internal method to get unique customer id from Woocommerce session
     *
     * @return string|null
     */
    private function get_customer_id_from_session()
    {
        /**
         * Get customer ID
         */
        $session_handler = WC()->session;

        if ( $session_handler && $session_handler->has_session() && $session_handler->get_customer_id() ) {
            return (string) $session_handler->get_customer_id();
        }

        if ( is_user_logged_in() ) {
            return (string) get_current_user_id();
        }

        return null;
    }

    public function maybe_add_coupon()
    {
        $_POST  = array_merge( $_POST, json_decode( file_get_contents( 'php://input' ), true ) );
        $coupon = $this->get( 'coupon' );
        $email = $this->get( 'email' );

        $addCouponResult = Furgonetka_rest_helper::validate_and_add_coupon( $coupon, $email );

        return ( is_wp_error($addCouponResult) ) ? $addCouponResult : $this->response( [] );
    }

    public function remove_coupons()
    {
        global $woocommerce;

        $woocommerce->cart->remove_coupons();

        return $this->response( [] );
    }

    /**
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function create_cart( $request )
    {
        /**
         * Get data from cart
         */
        $response = $this->get_store_api_cart_response( $request );
        $parsed = $this->parse_store_api_cart( $response->get_data(), $this->get_authorization_headers( $response ) );

        /**
         * Send request
         */
        try {
            $createdCart = Furgonetka_Admin::create_checkout_cart(
                array_merge(
                    [
                        'integrationUuid' => Furgonetka_Admin::get_integration_uuid(),
                    ],
                    $parsed
                )
            );
        } catch ( Exception $e ) {
            $this->log( $e );

            return new WP_Error(
                'furgonetka_cart_create_error',
                __( 'Error occurred while creating cart.', 'furgonetka' ),
                [
                    'status' => 500,
                ]
            );
        }

        /**
         * Return parsed response
         */
        return $this->response( $createdCart );
    }

    /**
     * @return WP_REST_Response|WP_Error
     * @throws Exception
     */
    public function get_cart( WP_REST_Request $request )
    {
        /**
         * Allow authorization via Cart-Token only
         */
        $cart_token = $request->get_header( 'Cart-Token' );
        $cookie     = $request->get_header( 'Cookie' );

        if ( empty( $cart_token ) || ! empty( $cookie ) ) {
            return new WP_Error( 'furgonetka_invalid_authorization', __( 'You do not have sufficient permissions to access this page.', 'furgonetka' ), array( 'status' => 400 ) );
        }

        /**
         * Get data from cart
         */
        $response = $this->get_store_api_cart_response( $request );
        $parsed   = $this->parse_store_api_cart( $response->get_data(), $this->get_authorization_headers( $response )  );

        /**
         * Return parsed response
         */
        return $this->response( $parsed );
    }

    /**
     * @throws Exception
     */
    private function get_store_api_cart_response( WP_REST_Request $request ): WP_REST_Response
    {
        $new_request = new WP_REST_Request( 'GET' );
        $new_request->set_headers( $request->get_headers() );

        /** @var \Automattic\WooCommerce\Blocks\Registry\Container $container */
        $container = \Automattic\WooCommerce\StoreApi\StoreApi::container();

        /** @var \Automattic\WooCommerce\StoreApi\RoutesController $controller */
        $controller = $container->get( \Automattic\WooCommerce\StoreApi\RoutesController::class );

        /** @var \Automattic\WooCommerce\StoreApi\Routes\V1\Cart $route */
        $route = $controller->get( \Automattic\WooCommerce\StoreApi\Routes\V1\Cart::IDENTIFIER );

        return $route->get_response( $new_request );
    }

    private function get_authorization_headers(WP_REST_Response $response ): array
    {
        return array_intersect_key(
            $response->get_headers(),
            array_flip(
                [
                    'Cart-Token',
                ]
            )
        );
    }

    private function parse_store_api_cart( array $data, array $authorization_data ): array
    {
        /**
         * Prepare data
         */
        $totals = get_object_vars( $data[ 'totals' ] );

        /**
         * Prepare currency formatter
         */
        $divider      = 10 ** $totals[ 'currency_minor_unit' ];
        $format_price = static function ($price) use ($divider) { return $price / $divider; };

        /**
         * Get configured payment gateways
         */
        $payment_gateways = $this->get_payment_gateways();

        $payment_gateways_pay_by_link = $payment_gateways[ 'payByLink' ];
        $payment_gateway_cod          = $payment_gateways[ 'cod' ];

        /**
         * Parse basic cart data
         */
        $cart = [
            'id'            => WC()->session->get_customer_id(),
            'currency'      => $totals[ 'currency_code' ],
            'totalGross'    => $format_price( $totals[ 'total_items' ] + $totals[ 'total_items_tax' ] ),
            'products'      => [],
        ];

        if (!empty($data[ 'coupons' ])) {
            $discountCodes = array_column( $data['coupons'], 'code' );

            if (!empty($discountCodes)) {
                $cart[ 'discountCodes' ] = $discountCodes;
                $cart[ 'discountGross' ] = $format_price( $totals[ 'total_discount' ] + $totals[ 'total_discount_tax' ] );
            }
        }
        /**
         * Parse products
         */
        foreach ($data[ 'items' ] ?? [] as $product_data) {
            $product_object = wc_get_product( $product_data[ 'id' ] );
            $product_totals = get_object_vars( $product_data[ 'totals' ] );

            /**
             * Base product data
             */
            $product = [
                'id'        => $product_data[ 'id' ],
                'name'      => $product_data[ 'name' ],
                'quantity'  => $product_data[ 'quantity' ],
                'imageUrl'  => $product_data[ 'images' ][ 0 ]->src ?? null,
                'isDigital' => $product_object && $product_object->get_virtual(),
                'unit'      => 'pc',
            ];

            if ( $product_data[ 'quantity' ] > 0 ) {
                $total_price_with_tax = (float) ( $product_totals[ 'line_subtotal' ] ?? 0 ) + (float) ( $product_totals[ 'line_subtotal_tax' ] ?? 0 );
                $price_with_tax_per_item = round( $total_price_with_tax / (float) $product_data[ 'quantity' ], 2 );

                $product[ 'priceGross' ] = $format_price( $price_with_tax_per_item );
            } else {
                $product[ 'priceGross' ] = 0;
            }

            /**
             * Attributes
             */
            $attributes = [];

            if ( ! empty( $product_data[ 'variation' ] ) ) {
                foreach ( $product_data[ 'variation' ] as $attribute_data) {
                    $attributes[] = [
                        'name' =>  $attribute_data[ 'attribute' ],
                        'value' => $attribute_data[ 'value' ],
                    ];
                }
            }

            $product[ 'attributes' ] = $attributes;

            /**
             * Add parsed product
             */
            $cart[ 'products' ][] = $product;
        }

        /**
         * Parse shipping methods
         */
        $shipping_methods = [];

        if ( $data[ 'needs_shipping' ] ) {
            $furgonetka_map_configuration = Furgonetka_Map::get_configuration();

            foreach ($data[ 'shipping_rates' ][ 0 ][ 'shipping_rates' ] as $shipping_method_data) {
                /**
                 * Basic shipping method data
                 */
                $rate_id = $shipping_method_data[ 'rate_id' ];
                $shipping_method = [
                    'id'         => $rate_id,
                    'name'       => $shipping_method_data[ 'name' ],
                    'priceGross' => $format_price( (float) $shipping_method_data[ 'price' ] + (float) $shipping_method_data[ 'taxes' ] ),
                ];

                /**
                 * Map configuration
                 */
                if ( ! empty( $furgonetka_map_configuration[ $rate_id ] ) ) {
                    $shipping_method[ 'mapConfig' ] = [
                        'courierService' => $furgonetka_map_configuration[ $rate_id ],
                    ];
                }

                /**
                 * Payment methods available for the current shipping method
                 */
                $shipping_method_payment_gateways = array_map(
                    static function ( $payment_gateway ) {
                        return $payment_gateway->id;
                    },
                    $payment_gateways_pay_by_link
                );

                if ( $payment_gateway_cod instanceof WC_Gateway_COD ) {
                    /** @var string[] $enable_for_methods */
                    $enable_for_methods = $payment_gateway_cod->get_option( 'enable_for_methods', [] );

                    if ( in_array( $rate_id, $enable_for_methods, true ) ) {
                        $shipping_method_payment_gateways[] = $payment_gateway_cod->id;
                    }
                }

                $shipping_method[ 'paymentMethods' ] = [];

                foreach ( $shipping_method_payment_gateways as $payment_gateway ) {
                    $shipping_method[ 'paymentMethods' ][] = [
                        'paymentMethodId' => $payment_gateway,
                        'surchargeGross'  => 0,
                    ];
                }

                /**
                 * Add parsed shipping method
                 */
                $shipping_methods[] = $shipping_method;
            }
        }

        /**
         * Parse payment methods
         */
        $payment_methods = [];

        /** @var Furgonetka_Gateway_Abstract $payment_gateway */
        foreach ( $payment_gateways_pay_by_link as $payment_gateway ) {
            $payment_methods[] = [
                'id'       => $payment_gateway->id,
                'name'     => $payment_gateway->title,
                'provider' => $payment_gateway->provider,
                'type'     => 'payByLink',
            ];
        }

        if ( $payment_gateway_cod instanceof WC_Gateway_COD ) {
            $payment_methods[] = [
                'id'       => $payment_gateway_cod->id,
                'name'     => $payment_gateway_cod->title,
                'type'     => 'cod',
            ];
        }

        /**
         * Send request
         */
        return [
            'authorization'   => $authorization_data,
            'cart'            => $cart,
            'shippingMethods' => $shipping_methods,
            'paymentMethods'  => $payment_methods,
        ];
    }

    /**
     * Get payment gateways grouped by type
     */
    private function get_payment_gateways(): array
    {
        return [
            'cod'       => $this->get_payment_gateway_cod(),
            'payByLink' => [
                new Furgonetka_Gateway_Autopay(),
                new Furgonetka_Gateway_Payu(),
                new Furgonetka_Gateway_Przelewy24(),
                new Furgonetka_Gateway_Tpay(),
            ],
        ];
    }

    /**
     * @return WC_Gateway_COD|null
     */
    private function get_payment_gateway_cod()
    {
        foreach ( WC()->payment_gateways()->payment_gateways() as $payment_gateway ) {
            if ( $payment_gateway instanceof WC_Gateway_COD ) {
                return $payment_gateway;
            }
        }

        return null;
    }
}
