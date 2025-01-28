<?php

/**
 * @since      1.6.2
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Map {

    /**
     * Get map configuration
     *
     * @return array<string,string> where key is shipping rate ID (id:instance_id) and value is courier service
     */
    public static function get_configuration(): array
    {
        $delivery_to_type = get_option( FURGONETKA_PLUGIN_NAME . '_deliveryToType' );

        if ( ! is_array( $delivery_to_type ) ) {
            return array();
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

        update_option( FURGONETKA_PLUGIN_NAME . '_deliveryToType', $data );
    }

    /**
     * Get configured courier service by the given shipping rate ID (id:instance_id)
     *
     * @return string|null
     */
    public static function get_service_by_shipping_rate_id( string $id )
    {
        $delivery_to_type = self::get_configuration();
        $service          = $delivery_to_type[ $id ] ?? null;

        if ( ! is_string( $service ) ) {
            return null;
        }

        return $service;
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
