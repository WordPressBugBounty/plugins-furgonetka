<?php

require_once plugin_dir_path( __FILE__ ) . '../trait/trait-furgonetka-store-api-request.php';
require_once plugin_dir_path( __FILE__ ) . '../../admin/class-furgonetka-admin.php';

abstract class Furgonetka_Gateway_Abstract extends \WC_Payment_Gateway
{
    use Furgonetka_Store_Api_Request;

    const CHECKOUT_BRANDING = 'Furgonetka Koszyk';

    /** @var string */
    public $provider;

    public function __construct()
    {
        $this->id         = static::GATEWAY_ID;
        $this->title      = self::get_furgonetka_gateway_title();
        $this->has_fields = false;
        $this->provider   = static::GATEWAY_PROVIDER;
    }

    public function init_form_fields()
    {
        $this->form_fields = [];
    }

    public function init_settings() {
        parent::init_settings();
        $this->enabled = Furgonetka_Admin::is_checkout_active();
    }

    public function process_payment( $order_id )
    {
        $order = wc_get_order( $order_id );

        $order->update_status( 'on-hold' );

        WC()->cart->empty_cart();

        return [
            'result' => 'success',
        ];
    }

    public function is_available()
    {
        return self::is_current_store_api_request_with_furgonetka_checkout_context();
    }

    private static function get_furgonetka_gateway_title(): string
    {
        return self::CHECKOUT_BRANDING . ' - ' . static::GATEWAY_LABEL;
    }
}
