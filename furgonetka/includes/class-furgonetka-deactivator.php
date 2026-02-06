<?php

/**
 * Fired during plugin deactivation
 *
 * @link  https://furgonetka.pl
 * @since 1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Deactivator
{
    /**
     * @since 1.0.0
     */
    public static function deactivate()
    {
        wp_clear_scheduled_hook( 'furgonetka_daily_event' );

        self::delete_integration_connection();
        Furgonetka_Options::delete_all_options();
    }

    /**
     * @return void
     */
    private static function delete_integration_connection()
    {
        try {
            Furgonetka_Admin::delete_integration_connection();
        } catch (Exception $e) {
            /** Silence exception */
        }
    }
}
