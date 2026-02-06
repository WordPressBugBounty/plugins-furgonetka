<?php

class Furgonetka_Order
{
    public static function define_hooks(): void
    {
        add_action( 'woocommerce_cancel_unpaid_orders', [ self::class, 'cancel_unpaid_orders' ] );
    }

    /**
     * @param  WP_REST_Response $response
     * @return WP_REST_Response
     */
    public static function addLinkToResponse( $response )
    {
        $receivedUrl = wc_get_endpoint_url( 'order-received', $response->data['id'], wc_get_checkout_url() );

        $response->data['summary_page'] = $receivedUrl . '?' . http_build_query( array( 'key' => $response->data['order_key'] ) );

        return $response;
    }

    public function get_order_statuses(): WP_REST_Response
    {
        return new WP_REST_Response(
            array(
                'orders_statuses' => wc_get_order_statuses(),
            )
        );
    }

    public static function cancel_unpaid_orders(): void
    {
        $hold_duration = get_option( 'woocommerce_hold_stock_minutes' );

        if ( $hold_duration < 1 || 'yes' !== get_option( 'woocommerce_manage_stock' ) ) {
            return;
        }

        $data_store = WC_Data_Store::load( 'order' );

        $args = [
            'type'           => wc_get_order_types(),
            'status'         => [ 'wc-on-hold' ],
            'payment_method' => [
                Furgonetka_Gateway_Tpay::GATEWAY_ID,
                Furgonetka_Gateway_Przelewy24::GATEWAY_ID,
                Furgonetka_Gateway_Payu::GATEWAY_ID,
                Furgonetka_Gateway_Autopay::GATEWAY_ID
            ],
            'date_query'     => [
                [
                    'column' => 'post_modified_gmt',
                    'before' => gmdate( 'Y-m-d H:i:s', strtotime( '-' . absint( $hold_duration ) . ' MINUTES'))
                ],
            ],
            'return' => 'ids',
        ];
        $unpaid_orders_ids = $data_store->query( $args );

        if ( $unpaid_orders_ids ) {
            foreach ( $unpaid_orders_ids as $unpaid_order_id ) {
                $order = wc_get_order( $unpaid_order_id );
                $order->update_status( 'cancelled', __( 'Unpaid order cancelled - time limit reached.', 'woocommerce' ) );
            }
        }
    }
}