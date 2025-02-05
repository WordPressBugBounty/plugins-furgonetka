<?php

/**
 * @since      1.6.3
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Api_Keys
{
    /**
     * API keys options
     */
    const OPTION_TEMPORARY_CONSUMER_KEY = FURGONETKA_PLUGIN_NAME . '_key_consumer_key';
    const OPTION_TEMPORARY_CONSUMER_SECRET = FURGONETKA_PLUGIN_NAME . '_key_consumer_secret';

    /**
     * Store API keys temporarily into database
     *
     * @return void
     */
    public static function store_temporary_api_keys(string $consumer_key, string $consumer_secret )
    {
        update_option( self::OPTION_TEMPORARY_CONSUMER_KEY, $consumer_key );
        update_option( self::OPTION_TEMPORARY_CONSUMER_SECRET, $consumer_secret );
    }

    /**
     * Remove temporary API keys from the database
     *
     * @return void
     */
    public static function remove_temporary_api_keys()
    {
        delete_option( self::OPTION_TEMPORARY_CONSUMER_KEY );
        delete_option( self::OPTION_TEMPORARY_CONSUMER_SECRET );
    }

    /**
     * Get (temporary) consumer key
     *
     * @return string|null
     */
    public static function get_temporary_consumer_key()
    {
        $value = get_option( self::OPTION_TEMPORARY_CONSUMER_KEY );

        return is_string( $value ) ? $value : null;
    }

    /**
     * Get (temporary) consumer secret
     *
     * @return string|null
     */
    public static function get_temporary_consumer_secret()
    {
        $value = get_option( self::OPTION_TEMPORARY_CONSUMER_SECRET );

        return is_string( $value ) ? $value : null;
    }

    /**
     * Create API credentials
     *
     * This method is used as fallback when website is not protected with SSL/TLS.
     */
    public static function create_api_credentials(): array
    {
        global $wpdb;

        $app_name = __( 'Furgonetka', 'furgonetka' );

        $description = sprintf(
            '%s - API (%s)',
            wc_trim_string( wc_clean( $app_name ), 170 ),
            gmdate( 'Y-m-d H:i:s' )
        );
        $user        = wp_get_current_user();

        // Created API keys.
        $permissions     = 'read_write';
        $consumer_key    = 'ck_' . wc_rand_hash();
        $consumer_secret = 'cs_' . wc_rand_hash();

        $wpdb->insert(
            $wpdb->prefix . 'woocommerce_api_keys',
            array(
                'user_id'         => $user->ID,
                'description'     => $description,
                'permissions'     => $permissions,
                'consumer_key'    => wc_api_hash( $consumer_key ),
                'consumer_secret' => $consumer_secret,
                'truncated_key'   => substr( $consumer_key, -7 ),
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
            )
        );

        return array(
            'key_id'          => $wpdb->insert_id,
            'consumer_key'    => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'key_permissions' => $permissions,
        );
    }

}
