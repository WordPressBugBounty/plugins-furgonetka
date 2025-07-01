<?php

class Furgonetka_Order
{

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
}