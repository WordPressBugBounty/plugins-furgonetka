<?php

/**
 * @since      1.6.2
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Map {
    const SERVICES_ALIASES = [
        'kiosk' => Furgonetka_Public::SERVICE_ORLEN,
        'uap'   => Furgonetka_Public::SERVICE_UPS,
    ];

    /**
     * Get map configuration
     *
     * @return array<string,mixed> where key is shipping rate ID (id:instance_id) and value is array with courier_service and points_types
     */
    public static function get_configuration(): array
    {
        $delivery_to_type = get_option( Furgonetka_Options::OPTION_DELIVERY_TO_TYPE );

        if ( ! is_array( $delivery_to_type ) ) {
            return array();
        }

        foreach ( $delivery_to_type as $shipping => $item ) {
            if ( is_string( $item ) ) {
                $delivery_to_type[ $shipping ] = [
                    'courier_service' => self::SERVICES_ALIASES[ $item ] ?? $item,
                    'points_types'    => Furgonetka_Constants::POINTS_TYPES,
                ];
            } else if ( isset( $item[ 'courier_service' ] ) ) {
                if ( is_array( $item[ 'courier_service' ] ) ) {
                    $delivery_to_type[ $shipping ][ 'courier_service' ] = self::SERVICES_ALIASES[ $item[ 'courier_service' ][ 'courier_service' ] ] ?? $item[ 'courier_service' ][ 'courier_service' ];
                } else {
                    $delivery_to_type[ $shipping ][ 'courier_service' ] = self::SERVICES_ALIASES[ $item[ 'courier_service' ] ] ?? $item[ 'courier_service' ];
                }
            }
        }

        return $delivery_to_type;
    }

    /**
     * Save map configuration
     *
     * @param array<string,string> $configuration
     * @return void
     */
    public static function save_configuration( array $configuration )
    {
        $data = array_intersect_key( $configuration, array_flip( self::get_valid_shipping_rates_ids() ) );

        update_option( Furgonetka_Options::OPTION_DELIVERY_TO_TYPE, $data );
    }

    /**
     * Get shipping rate configuration by by the given shipping rate ID (id:instance_id)
     *
     * @return array|null
     */
    public static function get_shipping_rate_configuration(string $id)
    {
        $delivery_to_type = self::get_configuration();
        $shipping_rate_configuration = $delivery_to_type[ $id ] ?? [];

        if ( ! is_array( $shipping_rate_configuration )
            && ! array_key_exists( 'courier_service', $shipping_rate_configuration )
            && ! array_key_exists( 'points_types', $shipping_rate_configuration )
        ) {
            return null;
        }

        return $shipping_rate_configuration;
    }

    /**
     * Get configured courier service by the given shipping rate ID (id:instance_id)
     *
     * @return string|null
     */
    public static function get_service_by_shipping_rate_id( string $id )
    {
        $shipping_rate_configuration = self::get_shipping_rate_configuration( $id );

        return $shipping_rate_configuration[ 'courier_service' ] ?? null;
    }

    /**
     * Get shipping rate configuration by the currently selected shipping rate from the WooCommerce session
     *
     * @return array|null
     */
    public static function get_shipping_rate_configuration_from_session()
    {
        $chosen_method_array = WC()->session->get( 'chosen_shipping_methods' );
        $shipping_method_id  = $chosen_method_array[ 0 ] ?? null;

        if ( ! is_string( $shipping_method_id ) ) {
            return null;
        }

        return self::get_shipping_rate_configuration( $shipping_method_id );
    }

    /**
     * Get courier service by the currently selected shipping rate from the WooCommerce session
     *
     * @return string|null
     */
    public static function get_service_from_session()
    {
        $chosen_method_array = WC()->session->get( 'chosen_shipping_methods' );
        $shipping_method_id  = $chosen_method_array[0] ?? null;

        if ( ! is_string( $shipping_method_id ) ) {
            return null;
        }

        return self::get_service_by_shipping_rate_id( $shipping_method_id );
    }

    public static function get_zones_with_shipping_methods(): array
    {
        /**
         * Get real shipping zones
         */
        $zones = WC_Shipping_Zones::get_zones();

        /**
         * Add "0" zone (that contains shipping methods without assigned real zone)
         */
        $fallback_zone = WC_Shipping_Zones::get_zone( 0 );

        if ( $fallback_zone ) {
            /**
             * Get zone data & assigned shipping methods
             */
            $shipping_method_data                     = $fallback_zone->get_data();
            $shipping_method_data['shipping_methods'] = $fallback_zone->get_shipping_methods();

            /**
             * Push zone to the array
             */
            $zones[ $fallback_zone->get_id() ] = $shipping_method_data;
        }

        /**
         * Build result
         */
        $result = array();

        foreach ( $zones as $zone_data ) {
            /**
             * Prepare shipping methods
             */
            $shipping_methods = array();

            foreach ( $zone_data['shipping_methods'] as $shipping_method ) {
                /**
                 * Get shipping method data
                 */
                $shipping_method_data = null;

                if ( is_array( $shipping_method ) ) {
                    $shipping_method_data = $shipping_method;
                } elseif ( is_object( $shipping_method ) ) {
                    $shipping_method_data = get_object_vars( $shipping_method );
                }

                /**
                 * Gather public props
                 */
                if ( $shipping_method_data ) {
                    $shipping_methods[] = array_intersect_key(
                        $shipping_method_data,
                        array_flip(
                            array(
                                'id',
                                'method_title',
                                'method_description',
                                'enabled',
                                'title',
                                'rates',
                                'tax_status',
                                'fee',
                                'minimum_fee',
                                'instance_id',
                                'availability',
                                'countries',
                            )
                        )
                    );
                }
            }

            /**
             * Add zone with shipping methods
             */
            $item = array_intersect_key(
                $zone_data,
                array_flip(
                    array(
                        'id',
                        'zone_name',
                        'zone_order',
                        'zone_locations',
                    )
                )
            );

            $item['shipping_methods'] = $shipping_methods;

            $result[] = $item;
        }

        return $result;
    }

    private static function get_valid_shipping_rates_ids(): array
    {
        $result = array();

        foreach ( self::get_zones_with_shipping_methods() as $zone ) {
            $shipping_methods = $zone['shipping_methods'];

            foreach ( $shipping_methods as $shipping_method ) {
                $result[] = $shipping_method['id'] . ':' . $shipping_method['instance_id'];
            }
        }

        return $result;
    }
}
