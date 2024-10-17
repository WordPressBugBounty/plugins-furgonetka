<?php

/**
 * The file that defines view for public side
 *
 * @link  https://furgonetka.pl
 * @since 1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/includes/rest_api/endpoint_controller/view
 */

/**
 *  Class Furgonetka_Public_View - views for Public side
 *
 * @since      1.0.0
 * @package    Furgonetka
 * @subpackage Furgonetka/includes/rest_api/endpoint_controller/view
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Public_View
{
    /**
     * Render map
     *
     * @param mixed $plugin_name    - plugin name.
     * @param mixed $selected_point - selected point.
     *
     * @since 1.0.9
     */
    public function render_map( $plugin_name, $selected_point )
    {
        ?>
        <input
                type="hidden"
                id="furgonetkaPoint"
                name="furgonetkaPoint"
                value="<?php echo esc_html( $selected_point['code'] ); ?>"
        />
        <input
                type="hidden"
                id="furgonetkaPointName"
                name="furgonetkaPointName"
                value="<?php echo esc_html( $selected_point['name'] ); ?>"
        />
        <input
                type="hidden"
                id="furgonetkaService"
                name="furgonetkaService"
                value="<?php echo esc_html( $selected_point['service'] ); ?>"
        />
        <input
                type="hidden"
                id="furgonetkaServiceType"
                name="furgonetkaServiceType"
                value="<?php echo esc_html( $selected_point['service_type'] ); ?>"
        />
        <?php wp_nonce_field( $plugin_name . '_setPointAction', $plugin_name . '_setPoint' ); ?>
        <?php
    }

    /**
     * Render point information
     *
     * @param mixed $point_information
     *
     * @since 1.4.6
     */
    public function render_point_information( $service, $point )
    {
        ?>
        <section class="woocommerce-order-details">
            <h2 class="woocommerce-order-details__title">
                <?php esc_attr_e( 'Pickup point', 'furgonetka' ); ?>
            </h2>
            <p class="woocommerce-order-details__point">
                <strong>
                    <?php echo esc_html( $service ); ?>
                </strong>
                <br>
                <?php echo esc_html( $point ); ?>
            </p>
        </section>
        <?php
    }

    /**
     * Render package tracking link
     *
     * @param string $package_number
     * @since 1.5.1
     */
    public function render_package_tracking_link( $package_number )
    {
        $baseUrl = ! Furgonetka_Admin::get_test_mode() ? 'https://furgonetka.pl' : 'https://sandbox.furgonetka.pl';
        ?>
        <section class="woocommerce-order-details">
            <h2 class="woocommerce-order-details__title">
                <?php esc_attr_e( 'Package', 'furgonetka' ); ?>
            </h2>
            <p class="woocommerce-order-details__tracking">
                <a
                        style="text-decoration: underline;"
                        target="_blank"
                        href="<?= $baseUrl ?>/zlokalizuj/<?php echo esc_html( $package_number ); ?>"
                >
                    <?php echo esc_html( $package_number ); ?>
                </a>
                <br>
            </p>
        </section>
        <?php
    }
}
