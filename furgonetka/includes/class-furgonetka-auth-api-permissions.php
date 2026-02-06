<?php

/**
 * @since      1.6.3
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Auth_Api_Permissions
{
    /** Indicate APIs with nonce-based auth API authorization */
    const PERMISSION_CALLBACK = array( self::class, 'permission_callback' );

    /**
     * Authorization API permission callback
     *
     * NOTE: This callback is used ONLY when integration is being created.
     * This should not be used for regular API authorization.
     *
     * @param \WP_REST_Request $request
     */
    public static function permission_callback( $request ): bool
    {
        $data = $request->get_json_params();

        if ( ! isset( $data[ 'user_id' ]) ) {
            return false;
        }

        return self::verify_auth_api_nonce( $data[ 'user_id' ] );
    }

    /**
     * Generate auth API nonce to verify further requests
     */
    public static function generate_auth_api_nonce(): string
    {
        $nonce = wc_rand_hash();

        update_option( Furgonetka_Options::OPTION_AUTH_API_NONCE, $nonce );

        return $nonce;
    }

    /**
     * Verify & discard nonce with the saved one
     */
    private static function verify_auth_api_nonce( $nonce ): bool
    {
        $stored_nonce = get_option( Furgonetka_Options::OPTION_AUTH_API_NONCE );

        if ( ! $stored_nonce ) {
            return false;
        }

        delete_option( Furgonetka_Options::OPTION_AUTH_API_NONCE );

        return $nonce === $stored_nonce;
    }
}
