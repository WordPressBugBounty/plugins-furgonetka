<?php

require_once plugin_dir_path( __FILE__ ) . 'trait/trait-furgonetka-logger.php';

/**
 * Runs all tasks after the plug-in is updated
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Migrations_Performer
{
    use Furgonetka_Logger;

    public function run($previous_plugin_version) {
        if ( version_compare( $previous_plugin_version, '1.2.11', '<=' ) ) {
            $this->upgrade_to_1_2_11();
        }

        if ( version_compare( $previous_plugin_version, '1.2.18', '<=' ) ) {
            $this->upgrade_to_1_2_18();
        }

        if ( version_compare( $previous_plugin_version, '1.6.1', '<=' ) ) {
            $this->upgrade_to_1_6_1();
        }

        Furgonetka_Capabilities::ensure_capabilities();

        Furgonetka_Admin::update_plugin_version( FURGONETKA_VERSION );
    }

    /**
     * Remove sender data
     */
    private function upgrade_to_1_2_11() {
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_name');
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_companyName');
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_postCode');
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_city');
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_street');
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_email');
        delete_option(FURGONETKA_PLUGIN_NAME . '_sender_telephone');
        delete_option(FURGONETKA_PLUGIN_NAME . '_cod_iban');
        delete_option(FURGONETKA_PLUGIN_NAME . '_cod_accountOwner');
    }

    /**
     * Update integration UUID
     */
    private function upgrade_to_1_2_18()
    {
        if ( empty( Furgonetka_Admin::get_integration_uuid() ) ) {
            Furgonetka_Admin::update_plugin_version( FURGONETKA_VERSION );
        }
    }

    /**
     * Save account type
     */
    private function upgrade_to_1_6_1(): void
    {
        $admin = new Furgonetka_Admin( FURGONETKA_PLUGIN_NAME, FURGONETKA_VERSION );

        try {
            $admin->save_account_data();
        } catch ( Exception $e ) {
            $this->log( $e );
        }
    }
}
