<?php

/**
 * @since      1.7.3
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
trait Furgonetka_Store_Api_Request
{
    /**
     * Returns whether current Store API request is sent from the furgonetka checkout
     */
    protected static function is_current_store_api_request_with_furgonetka_checkout_context(): bool
    {
        $_POST = array_merge( $_POST, json_decode( file_get_contents( 'php://input' ), true ) ?? [] );

        return filter_var(
            $_POST['extensions']['furgonetka']['checkout_context'] ?? null,
            FILTER_VALIDATE_BOOLEAN
        );
    }
}
