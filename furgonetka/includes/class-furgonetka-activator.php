<?php

/**
 * Fired during plugin activation
 *
 * @link  https://furgonetka.pl
 * @since 1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Activator
{
    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @throws Exception
     * @since 1.0.0
     */
    public static function activate()
    {
        if ( ! wp_next_scheduled( 'furgonetka_daily_event' ) ) {
            wp_schedule_event( time(), 'daily', 'furgonetka_daily_event' );
        }

        $admin = new Furgonetka_Admin( FURGONETKA_PLUGIN_NAME, FURGONETKA_VERSION );

        if ( Furgonetka_Admin::is_account_active() ) {
            $admin->save_account_data();
        }

        Furgonetka_Capabilities::ensure_capabilities();
    }
}
