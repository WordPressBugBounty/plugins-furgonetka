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

        /**
         * Disable Nonce check for Store API (Cart & Checkout)
         */
        add_filter( 'woocommerce_store_api_disable_nonce_check', [ self::class, 'woocommerce_store_api_disable_nonce_check' ] );

        /**
         * Register cookie-based authorization for custom REST API endpoints
         */
        add_filter( 'rest_authentication_errors', [ self::class, 'rest_authentication_errors' ] );
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
        return self::is_current_request_supported(
            [
                'furgonetka/v1/',
            ]
        );
    }

    /**
     * Filter that enables cookie-based authorization for custom REST API endpoints.
     *
     * @param mixed $result
     * @return mixed|true
     */
    public static function rest_authentication_errors( $result )
    {
        if ( ! empty( $result ) ) {
            return $result;
        }

        return self::is_current_request_supported(
            [
                'furgonetka/v1/checkout/v3/create-cart',
            ]
        );
    }

    /**
     * This filter enables requests to Store API without Nonce header.
     *
     * NOTE: This is a workaround for WooCommerce versions < 9.3.0
     * @see https://github.com/woocommerce/woocommerce/pull/50025
     */
    public static function woocommerce_store_api_disable_nonce_check( $already_disabled )
    {
        /**
         * Do nothing when nonce check is already disabled
         */
        if ( $already_disabled ) {
            return true;
        }

        /**
         * Check WooCommerce version
         */
        if ( version_compare( WC()->version, '9.3.0', '>=' ) ) {
            return false;
        }

        /**
         * Check whether Cart-Token is provided
         */
        if ( empty( getallheaders()[ 'Cart-Token' ] ) ) {
            return false;
        }

        /**
         * Check whether request is directed to Store API (Cart & Checkout endpoints)
         */
        return self::is_current_request_supported(
            [
                'wc/store/v1/cart',
                'wc/store/v1/checkout',
            ]
        );
    }

    /**
     * Returns whether path of the current is present in the given list
     */
    private static function is_current_request_supported( array $supported_endpoints ): bool
    {
        if ( empty( $_SERVER[ 'REQUEST_URI' ] ) ) {
            return false;
        }

        $rest_prefix = trailingslashit( rest_get_url_prefix() );
        $request_uri = esc_url_raw( wp_unslash( $_SERVER[ 'REQUEST_URI' ] ) );

        /**
         * Check supported endpoints
         */
        foreach ( $supported_endpoints as $endpoint ) {
            if ( strpos( $request_uri, $rest_prefix . $endpoint ) !== false ) {
                return true;
            }
        }

        return false;
    }
}
