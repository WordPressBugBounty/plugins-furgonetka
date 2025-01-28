<?php

/**
 * @since      1.6.2
 * @package    Furgonetka
 * @subpackage Furgonetka/includes/api
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Map_Settings {

    public function get_zones(): WP_REST_Response
    {
        return new WP_REST_Response(
            array(
                'zones' => Furgonetka_Map::get_zones_with_shipping_methods(),
            )
        );
    }

    public function get_configuration(): WP_REST_Response
    {
        return new WP_REST_Response(
            array(
                'configuration' => Furgonetka_Map::get_configuration(),
            )
        );
    }

    public function post_configuration( WP_REST_Request $request ): WP_REST_Response
    {
        $data          = $request->get_json_params();
        $configuration = $data['configuration'] ?? null;

        if ( ! is_array( $configuration ) ) {
            return new WP_REST_Response(
                array(
                    'code'    => 'invalid_configuration',
                    'message' => 'Invalid configuration provided',
                    'data'    => array(
                        'status' => 400,
                    ),
                ),
                400
            );
        }

        Furgonetka_Map::save_configuration( $configuration );

        return $this->get_configuration();
    }

    public function validate_post_configuration( $configuration ): bool
    {
        if ( ! is_array( $configuration ) ) {
            return false;
        }

        foreach ( $configuration as $key => $value ) {
            if ( ! is_string( $key ) || ! is_string( $value ) ) {
                return false;
            }
        }

        return true;
    }
}
