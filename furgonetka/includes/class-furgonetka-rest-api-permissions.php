<?php

/**
 * @since      1.6.3
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Rest_Api_Permissions
{
    /** Indicate APIs with regular, WooCommerce REST API-based authorization */
    const PERMISSION_CALLBACK = array( self::class, 'permission_callback' );

    /** Indicate APIs without authorization */
    const PERMISSION_CALLBACK_NO_AUTHORIZATION = '__return_true';

    /**
     * Define API authorization hooks
     *
     * @return void
     */
    public static function define_hooks()
    {
        /**
         * Register WooCommerce-based REST API authorization
         */
        add_filter( 'woocommerce_rest_is_request_to_rest_api', array ( self::class, 'is_request_to_furgonetka_api' ) );
    }

    /**
     * Module REST API permission callback
     *
     * This callback should be used for module REST API (outside authorization)
     */
    public static function permission_callback(): bool
    {
        /**
         * If the current endpoint is allowed within WooCommerce authorization system, this should determine API user
         */
        apply_filters( 'determine_current_user', get_current_user_id() );

        /**
         * Check whether current user have required capabilities
         */
        return Furgonetka_Capabilities::current_user_can_manage_furgonetka();
    }

    /**
     * This method allows to add custom endpoints to WooCommerce authorization system.
     *
     * By applying this filter we're allowing WooCommerce module to determine user by the current request.
     */
    public static function is_request_to_furgonetka_api( $access_granted ): bool
    {
        /**
         * Pass already authorized user
         */
        if ( $access_granted ) {
            return true;
        }

        /**
         * Check access to Furgonetka API
         */
        if ( empty( $_SERVER['REQUEST_URI'] ) ) {
            return false;
        }

        $rest_prefix = trailingslashit( rest_get_url_prefix() );
        $request_uri = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );

        /**
         * Check supported endpoints
         */
        $supported_endpoints = array(
            'furgonetka/v1/',
        );

        foreach ( $supported_endpoints as $endpoint ) {
            if ( strpos( $request_uri, $rest_prefix . $endpoint ) !== false ) {
                return true;
            }
        }

        return false;
    }
}
