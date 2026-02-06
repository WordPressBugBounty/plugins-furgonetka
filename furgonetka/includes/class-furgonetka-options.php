<?php

class Furgonetka_Options {

    /**
     * Integration
     */
    const OPTION_INTEGRATION_UUID = FURGONETKA_PLUGIN_NAME . '_integration_uuid';
    const OPTION_SOURCE_ID        = FURGONETKA_PLUGIN_NAME . '_source_id';
    const OPTION_TEST_MODE        = FURGONETKA_PLUGIN_NAME . '_test_mode';
    const OPTION_ACCOUNT_TYPE     = FURGONETKA_PLUGIN_NAME . '_account_type';
    const OPTION_MAP_API_KEY      = FURGONETKA_PLUGIN_NAME . '_map_api_key';

    /**
     * Auth
     */
    const OPTION_CLIENT_ID                 = FURGONETKA_PLUGIN_NAME . '_client_ID';
    const OPTION_CLIENT_SECRET             = FURGONETKA_PLUGIN_NAME . '_client_secret';
    const OPTION_ACCESS_TOKEN              = FURGONETKA_PLUGIN_NAME . '_access_token';
    const OPTION_REFRESH_TOKEN             = FURGONETKA_PLUGIN_NAME . '_refresh_token';
    const OPTION_EXPIRES_DATE              = FURGONETKA_PLUGIN_NAME . '_expires_date';
    const OPTION_AUTH_API_NONCE            = FURGONETKA_PLUGIN_NAME . '_auth_api_nonce';
    const OPTION_TEMPORARY_CONSUMER_KEY    = FURGONETKA_PLUGIN_NAME . '_key_consumer_key';
    const OPTION_TEMPORARY_CONSUMER_SECRET = FURGONETKA_PLUGIN_NAME . '_key_consumer_secret';

    /**
     * Migrations
     */
    const OPTION_VERSION = FURGONETKA_PLUGIN_NAME . '_version';

    /**
     * Map
     */
    const OPTION_DELIVERY_TO_TYPE = FURGONETKA_PLUGIN_NAME . '_deliveryToType';

    /**
     * Returns
     */
    const OPTION_RETURNS_ACTIVE = FURGONETKA_PLUGIN_NAME . '_returns_active';
    const OPTION_RETURNS_ROUTE  = FURGONETKA_PLUGIN_NAME . '_returns_route';
    const OPTION_RETURNS_TARGET = FURGONETKA_PLUGIN_NAME . '_returns_target';

    /**
     * Checkout
     */
    const OPTION_CHECKOUT_UUID                        = FURGONETKA_PLUGIN_NAME . '_checkout_uuid';
    const OPTION_CHECKOUT_ACTIVE                      = FURGONETKA_PLUGIN_NAME . '_checkout_active';
    const OPTION_CHECKOUT_TEST_MODE                   = FURGONETKA_PLUGIN_NAME . '_checkout_test_mode';
    const OPTION_CHECKOUT_PRODUCT_PAGE_BUTTON_VISIBLE = FURGONETKA_PLUGIN_NAME . '_product_page_button_visible';
    const OPTION_CHECKOUT_REPLACE_NATIVE_CHECKOUT     = FURGONETKA_PLUGIN_NAME . '_portmonetka_replace_native_checkout';
    const OPTION_CHECKOUT_PRODUCT_SELECTOR            = FURGONETKA_PLUGIN_NAME . '_portmonetka_product_selector';
    const OPTION_CHECKOUT_CART_SELECTOR               = FURGONETKA_PLUGIN_NAME . '_portmonetka_cart_selector';
    const OPTION_CHECKOUT_MINICART_SELECTOR           = FURGONETKA_PLUGIN_NAME . '_portmonetka_minicart_selector';
    const OPTION_CHECKOUT_CART_BUTTON_POSITION        = FURGONETKA_PLUGIN_NAME . '_portmonetka_cart_button_position';
    const OPTION_CHECKOUT_CART_BUTTON_WIDTH           = FURGONETKA_PLUGIN_NAME . '_portmonetka_cart_button_width';
    const OPTION_CHECKOUT_CART_BUTTON_CSS             = FURGONETKA_PLUGIN_NAME . '_portmonetka_cart_button_css';

    /**
     * All available options
     */
    const ALL_OPTIONS = array(
        self::OPTION_INTEGRATION_UUID,
        self::OPTION_MAP_API_KEY,
        self::OPTION_SOURCE_ID,
        self::OPTION_TEST_MODE,
        self::OPTION_ACCOUNT_TYPE,
        self::OPTION_CLIENT_ID,
        self::OPTION_CLIENT_SECRET,
        self::OPTION_ACCESS_TOKEN,
        self::OPTION_REFRESH_TOKEN,
        self::OPTION_EXPIRES_DATE,
        self::OPTION_AUTH_API_NONCE,
        self::OPTION_TEMPORARY_CONSUMER_KEY,
        self::OPTION_TEMPORARY_CONSUMER_SECRET,
        self::OPTION_VERSION,
        self::OPTION_DELIVERY_TO_TYPE,
        self::OPTION_RETURNS_ACTIVE,
        self::OPTION_RETURNS_ROUTE,
        self::OPTION_RETURNS_TARGET,
        self::OPTION_CHECKOUT_UUID,
        self::OPTION_CHECKOUT_ACTIVE,
        self::OPTION_CHECKOUT_TEST_MODE,
        self::OPTION_CHECKOUT_PRODUCT_PAGE_BUTTON_VISIBLE,
        self::OPTION_CHECKOUT_REPLACE_NATIVE_CHECKOUT,
        self::OPTION_CHECKOUT_PRODUCT_SELECTOR,
        self::OPTION_CHECKOUT_CART_SELECTOR,
        self::OPTION_CHECKOUT_MINICART_SELECTOR,
        self::OPTION_CHECKOUT_CART_BUTTON_POSITION,
        self::OPTION_CHECKOUT_CART_BUTTON_WIDTH,
        self::OPTION_CHECKOUT_CART_BUTTON_CSS,
    );

    /**
     * Delete all plugin's options
     *
     * @param string[] $exclude - options to exclude
     * @return void
     */
    public static function delete_all_options( array $exclude = array() ) {
        foreach ( array_diff( self::ALL_OPTIONS, $exclude ) as $option ) {
            delete_option( $option );
        }
    }
}
