<?php

/**
 * @since      1.5.2
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
trait Furgonetka_Logger
{
    public function log( $value ): void
    {
        $logger = wc_get_logger();

        if ( ! $logger ) {
            return;
        }

        if ( ! is_string( $value ) ) {
            $value = serialize( $value );
        }

        $logger->error( $value, array( 'source' => FURGONETKA_PLUGIN_NAME ) );
    }
}