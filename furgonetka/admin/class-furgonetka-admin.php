<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://furgonetka.pl
 * @since      1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two hooks
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/admin
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Admin
{
    const API_REST_URL      = 'https://api.furgonetka.pl';
    const TEST_API_REST_URL = 'https://api.sandbox.furgonetka.pl';

    const PATH_ACCOUNT                  = '/account';
    const PATH_CREATE_OAUTH_APPLICATION = '/ecommerce/integrations/create-oauth-application';
    const PATH_CONFIGURATIONS           = '/ecommerce/integrations/configurations';
    const PATH_PACKAGE_FORM_INIT        = '/ecommerce/packages/form/init';
    const PATH_FAST_SHIPPING_INIT       = '/ecommerce/packages/quick-action/init';
    const PATH_INVOICES_INIT            = '/ecommerce/invoices/quick-action/init';
    const PATH_APP_LINK_INIT            = '/ecommerce/app/link/init';

    const API_OAUTH_URL      = 'https://api.furgonetka.pl/oauth';
	const TEST_API_OAUTH_URL = 'https://api.sandbox.furgonetka.pl/oauth';

    const SHOP_URL      = 'https://shop.furgonetka.pl';
    const TEST_SHOP_URL = 'https://shop.sandbox.furgonetka.pl';

    const METADATA_FURGONETKA_ORDER_NUMBER = '_furgonetkaOrderNumber';

    const OPTION_CHECKOUT_UUID      = 'checkout_uuid';
    const OPTION_CHECKOUT_ACTIVE    = 'checkout_active';
    const OPTION_CHECKOUT_TEST_MODE = 'checkout_test_mode';
    const OPTION_ACCOUNT_TYPE       = 'account_type';

    const OPTION_PRODUCT_PAGE_BUTTON_VISIBLE = 'product_page_button_visible';

    const OPTION_DETAILS = [
        self::OPTION_PRODUCT_PAGE_BUTTON_VISIBLE,
    ];

    /**
     * Query params supported for admin pages
     */
    const PARAM_PAGE = 'page';
    const PARAM_ACTION = 'action';
    const PARAM_ERROR_CODE = 'error_code';
    const PARAM_ORDER_ID = 'order_id';
    const PARAM_SUCCESS = 'success';

    /**
     * Pages available within admin panel
     */
    const PAGE_FURGONETKA                                  = 'furgonetka';
    const PAGE_FURGONETKA_PANEL_SETTINGS                   = 'furgonetka_panel_settings';
    const PAGE_FURGONETKA_WAITING_PACKAGES                 = 'furgonetka_waiting_packages';
    const PAGE_FURGONETKA_ORDERED_PACKAGES                 = 'furgonetka_ordered_packages';
    const PAGE_FURGONETKA_DOCUMENTS                        = 'furgonetka_documents';
    const PAGE_FURGONETKA_RETURNS                          = 'furgonetka_returns';
    const PAGE_FURGONETKA_MAP_SETTINGS                     = 'furgonetka_map_settings';
    const PAGE_FURGONETKA_ADVANCED_INTERNAL                = 'furgonetka_advanced_internal';
    const PAGE_FURGONETKA_CHECKOUT                         = 'furgonetka_checkout';
    const PAGE_FURGONETKA_PAYMENT_METHODS                  = 'furgonetka_payment_methods';
    const PAGE_FURGONETKA_COMPLAINTS                       = 'furgonetka_complaints';
    const PAGE_FURGONETKA_ORDER_STATUS_CHANGE              = 'furgonetka_order_status_change';
    const PAGE_FURGONETKA_ORDERS_RETURNS                   = 'furgonetka_orders_returns';
    const PAGE_FURGONETKA_APPEARANCE                       = 'furgonetka_appearance';
    const PAGE_FURGONETKA_ADDRESS_BOOK                     = 'furgonetka_address_book';
    const PAGE_FURGONETKA_PACKAGE_TEMPLATES                = 'furgonetka_package_templates';
    const PAGE_FURGONETKA_PRINTING                         = 'furgonetka_printing';
    const PAGE_FURGONETKA_NOTIFICATIONS                    = 'furgonetka_notifications';
    const PAGE_FURGONETKA_OWN_AGREEMENTS                   = 'furgonetka_own_agreements';
    const PAGE_FURGONETKA_ACCOUNT_DETAILS                  = 'furgonetka_account_details';
    const PAGE_FURGONETKA_ADVANCED                         = 'furgonetka_advanced';
    const PAGE_FURGONETKA_HELP_AND_CONTACT                 = 'furgonetka_help_and_contact';
    const PAGE_FURGONETKA_TERMS_AND_CONDITIONS             = 'furgonetka_terms_and_conditions';
    const PAGE_FURGONETKA_BALANCE                          = 'furgonetka_balance';
    const PAGE_FURGONETKA_LIST_OF_TRANSFERS                = 'furgonetka_list_of_transfers';
    const PAGE_FURGONETKA_MY_PRICE_LISTS                   = 'furgonetka_my_price_lists';
    const PAGE_FURGONETKA_INVOICES_AND_FINANCIAL_DOCUMENTS = 'furgonetka_invoices_and_financial_documents';

    /**
     * Actions available for the pages above
     */
    const ACTION_CONNECT_INTEGRATION = 'connect_integration';
    const ACTION_OAUTH_COMPLETE = 'oauth_complete';
    const ACTION_GET_PACKAGE_FORM = 'get_package_form';
    const ACTION_ERROR_PAGE = 'error_page';

    const ACTION_SAVE_ADVANCED = 'save_advanced';
    const ACTION_RESET_CREDENTIALS = 'reset_credentials';

    /**
     * Error codes
     */
    const ERROR_CODE_UNKNOWN = 'unknown';
    const ERROR_CODE_INACTIVE_ACCOUNT = 'inactive_account';
    const ERROR_CODE_INVALID_CREDENTIALS = 'invalid_credentials';
    const ERROR_CODE_MISSING_REQUIRED_PARAMETERS = 'missing_required_parameters';
    const ERROR_CODE_INTEGRATION_FAILED = 'integration_failed';
    const ERROR_CODE_UNSUPPORTED_LINK = 'unsupported_link';

    const SUPPORTED_ERROR_CODES = array(
        self::ERROR_CODE_UNKNOWN,
        self::ERROR_CODE_INACTIVE_ACCOUNT,
        self::ERROR_CODE_INVALID_CREDENTIALS,
        self::ERROR_CODE_MISSING_REQUIRED_PARAMETERS,
        self::ERROR_CODE_INTEGRATION_FAILED,
        self::ERROR_CODE_UNSUPPORTED_LINK
    );

    /**
     * OAuth-related constants
     */
    const PARAM_OAUTH_ERROR = 'error';
    const ERROR_OAUTH_ACCESS_DENIED = 'access_denied';

    /**
     * Account types
     */
     const ACCOUNT_TYPE_PERSONAL = 'personal';
     const ACCOUNT_TYPE_COMPANY  = 'company';

    /**
     * Order actions
     */
    const ACTION_PACKAGE_FORM_INIT  = 'package_form_init';
    const ACTION_FAST_SHIPPING_INIT = 'fast_shipping_init';
    const ACTION_INVOICES_INIT      = 'invoices_init';

    /**
     * Modal error keys
     */
    const MODAL_ERROR_TOKEN_EXPIRED       = 'token_expired';
    const MODAL_ERROR_NO_INTEGRATION_UUID = 'no_integration_uuid';
    const MODAL_ERROR_DEFAULT             = 'default';

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Error array.
     *
     * @since    1.0.0
     * @access   public
     * @var      array $errors Array of error messages.
     */
    public $errors;

    /**
     * Messages array.
     *
     * @since    1.0.0
     * @access   public
     * @var      array $messages Array of messages.
     */
    public $messages;

    /**
     * Furgonetka_admin_metaboxes class.
     *
     *  @var furgonetka_admin_metaboxes
     *
     */
    private $furgonetka_admin_metaboxes;

    /**
     * View
     *
     * @var \Furgonetka_Admin_View
     */
    private $view;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        require_once FURGONETKA_PLUGIN_DIR . 'includes/class-furgonetka-admin-metaboxes.php';
        $this->furgonetka_admin_metaboxes = new furgonetka_admin_metaboxes( $this );

        require_once FURGONETKA_PLUGIN_DIR . 'includes/view/class-furgonetka-admin-view.php';
        $this->view = new Furgonetka_Admin_View();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts_and_styles()
    {
        /**
         * Common CSS styles
         */
        $admin_css_file_path = 'css/furgonetka-admin.css';

        wp_enqueue_style(
            "{$this->plugin_name}-admin-css",
            plugin_dir_url( __FILE__ ) . $admin_css_file_path,
            array(),
            filemtime( plugin_dir_path( __FILE__ ) . $admin_css_file_path ),
            'all'
        );

        /**
         * Modal assets
         */
        if ( $this->is_current_screen_supported( $this->get_modal_supported_screens() ) ) {
            /**
             * CSS styles
             */
            $admin_modal_css_file_path = 'css/furgonetka-admin-modal.css';

            wp_enqueue_style(
                "{$this->plugin_name}-admin-modal-css",
                plugin_dir_url( __FILE__ ) . $admin_modal_css_file_path,
                array(),
                filemtime( plugin_dir_path( __FILE__ ) . $admin_modal_css_file_path ),
                'all'
            );

            /**
             * JS files
             */
            $admin_modal_js_file_path = 'js/furgonetka-admin-modal.js';

            wp_enqueue_script(
                "{$this->plugin_name}-admin-modal-js",
                plugin_dir_url( __FILE__ ) . $admin_modal_js_file_path,
                array( 'jquery' ),
                filemtime( plugin_dir_path( __FILE__ ) . $admin_modal_js_file_path )
            );

            wp_localize_script(
                "{$this->plugin_name}-admin-modal-js",
                'furgonetka_modal',
                array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
            );
        }

        /**
         * Settings screens assets
         */
        if ( $this->is_current_screen_supported( $this->get_plugin_settings_screens() ) ) {
            /**
             * Connect integration JS files
             */
            $admin_connect_integration_js_handle = "{$this->plugin_name}-admin-connect-integration-js";
            $admin_connect_integration_js_file_path = 'js/furgonetka-admin-connect-integration.js';

            wp_enqueue_script(
                $admin_connect_integration_js_handle,
                plugin_dir_url( __FILE__ ) .  $admin_connect_integration_js_file_path,
                array( 'jquery' ),
                filemtime( plugin_dir_path( __FILE__ ) . $admin_connect_integration_js_file_path )
            );

            wp_localize_script(
                $admin_connect_integration_js_handle,
                'furgonetka_connect_integration',
                array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'furgonetka_shop_base_url' => self::get_furgonetka_shop_base_url()
                )
            );

            /**
             * Error page JS files
             */
            $admin_error_page_js_handle = "{$this->plugin_name}-admin-error-page-js";
            $admin_error_page_js_file_path = 'js/furgonetka-admin-error-page.js';

            wp_enqueue_script(
                $admin_error_page_js_handle,
                plugin_dir_url( __FILE__ ) .  $admin_error_page_js_file_path,
                array( 'jquery' ),
                filemtime( plugin_dir_path( __FILE__ ) . $admin_error_page_js_file_path )
            );

            wp_localize_script(
                $admin_error_page_js_handle,
                'furgonetka_error_page',
                array(
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'furgonetka_shop_base_url' => self::get_furgonetka_shop_base_url(),
                    'furgonetka_module_settings_page_url' => self::get_plugin_admin_url()
                )
            );
        }
    }

    /**
     * Add relevant links to plugins page.
     *
     * @since 1.0.0
     *
     * @param array $links Plugin action links.
     *
     * @return array Plugin action links
     */
    public function plugin_action_links( $links )
    {
        $plugin_links = array();

        $plugin_links[] = '<a href="' . esc_url( static::get_plugin_admin_url() ) . '">'
            . esc_html__( 'Settings', 'furgonetka' ) . '</a>';

        $plugin_links[] = '<a href="mailto:ecommerce@furgonetka.pl">' .
            esc_html__( 'Contact', 'furgonetka' ) . '</a>';

        return array_merge( $plugin_links, $links );
    }

    /**
     * Add furgonetka Page to woocommerce menu
     *
     * @since 1.0.0
     */
    public function furgonetka_menu()
    {
        global $menu;
        $menu_pos = 57;
        while ( isset( $menu[ $menu_pos ] ) ) {
            $menu_pos ++;
        }
            $icon_svg = 'data:image/svg+xml;base64, PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiPz48c3ZnIGlkPSJXYXJzdHdhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiNhN2FhYWQ7fTwvc3R5bGU+PC9kZWZzPjxwYXRoIGNsYXNzPSJjbHMtMSIgZD0ibTk3Ni41MSw0OTMuOTZWMjI5LjZMNjI5Ljg0LDMxLjMxYy03Mi44NS00MS43NC0xNjIuNzItNDEuNzQtMjM1LjU3LDBMNDcuNDksMjI5LjZ2NTI4LjYxbDkyLjMxLDUyLjgxdi0yMzcuNDFsMTU4LjQxLDkwLjA1di0xMDYuNDlsLTE1OC40MS04OS41MXYtMTMxLjhsMjY2Ljc0LDE1MS40MXYtMTA1LjcybC0yMjEuMDktMTI1LjIyLDI1NS45MS0xNDYuNDhjNDMuNzctMjQuOTgsOTcuNjEtMjQuOTgsMTQxLjM4LDBsMjU1LjE0LDE0Ni4wNC0yNTYuNDcsMTQ1Ljgydi4yMmwtNjkuMzEsMzkuNDR2MTA1LjYxbDUzLjI4LTMwLjc4LDE1LjkyLTkuMDksMTg4LjI2LTEwNy4wNCwxMTQuNDEtNjUuMDh2MzcwLjQxbC0zNzIuMjEsMjEyLjk4LTIxMy43OS0xMjIuMzctNTEuNTEtMjkuNDd2MTA1LjYxbDI2NS4zMSwxNTEuODQsNDY0LjUxLTI2NS43OHYtMjY0LjM2bC4yMi4xMVoiLz48L3N2Zz4=';

        add_menu_page(
            __('Furgonetka', 'furgonetka'),
            __('Furgonetka', 'furgonetka'),
            Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
            self::PAGE_FURGONETKA,
            array( $this, 'furgonetka_default_page' ),
            $icon_svg,
            $menu_pos
        );

        if ( self::is_account_active() ) {
            add_submenu_page(
                'furgonetka',
                __('Plugin panel', 'furgonetka'),
                __('Plugin panel', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_PANEL_SETTINGS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('To send', 'furgonetka'),
                __('To send', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_WAITING_PACKAGES,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Ordered', 'furgonetka'),
                __('Ordered', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ORDERED_PACKAGES,
                array( $this, 'get_furgonetka_iframe' )
            );

            if ( self::get_account_type() === self::ACCOUNT_TYPE_COMPANY ) {
                add_submenu_page(
                    'furgonetka',
                    __( 'Invoices', 'furgonetka' ),
                    __( 'Invoices', 'furgonetka' ),
                    Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                    self::PAGE_FURGONETKA_DOCUMENTS,
                    array( $this, 'get_furgonetka_iframe' )
                );
            }

            add_submenu_page(
                'furgonetka',
                __('Shopping returns', 'furgonetka'),
                __('Shopping returns', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_RETURNS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                '-',
                '-',
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                ''
            );

            add_submenu_page(
                'furgonetka',
                __('Checkout', 'furgonetka'),
                __('Checkout', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_CHECKOUT,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Payment methods', 'furgonetka'),
                __('Payment methods', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_PAYMENT_METHODS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Order status change', 'furgonetka'),
                __('Order status change', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ORDER_STATUS_CHANGE,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Orders returns', 'furgonetka'),
                __('Orders returns', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ORDERS_RETURNS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Map settings', 'furgonetka'),
                __('Map settings', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_MAP_SETTINGS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Appearance', 'furgonetka'),
                __('Appearance', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_APPEARANCE,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Advanced settings', 'furgonetka'),
                __('Advanced settings', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ADVANCED_INTERNAL,
                array( $this, 'get_furgonetka_advanced' )
            );

            add_submenu_page(
                'furgonetka',
                '-',
                '-',
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                ''
            );

            add_submenu_page(
                'furgonetka',
                __('Address book', 'furgonetka'),
                __('Address book', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ADDRESS_BOOK,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Package templates', 'furgonetka'),
                __('Package templates', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_PACKAGE_TEMPLATES,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Printing', 'furgonetka'),
                __('Printing', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_PRINTING,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Notifications', 'furgonetka'),
                __('Notifications', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_NOTIFICATIONS,
                array( $this, 'get_furgonetka_iframe' )
            );


            add_submenu_page(
                'furgonetka',
                __('Own agreements', 'furgonetka'),
                __('Own agreements', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_OWN_AGREEMENTS,
                array( $this, 'get_furgonetka_iframe' )
            );


            add_submenu_page(
                'furgonetka',
                __('Advanced', 'furgonetka'),
                __('Advanced', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ADVANCED,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                '-',
                '-',
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                ''
            );

            add_submenu_page(
                'furgonetka',
                __('Account details', 'furgonetka'),
                __('Account details', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_ACCOUNT_DETAILS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Help and contact', 'furgonetka'),
                __('Help and contact', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_HELP_AND_CONTACT,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Terms and Conditions', 'furgonetka'),
                __('Terms and Conditions', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_TERMS_AND_CONDITIONS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                '-',
                '-',
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                ''
            );

            add_submenu_page(
                'furgonetka',
                __('Balance', 'furgonetka'),
                __('Balance', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_BALANCE,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('My price lists', 'furgonetka'),
                __('My price lists', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_MY_PRICE_LISTS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Invoices and financial documents', 'furgonetka'),
                __('Invoices and financial documents', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_INVOICES_AND_FINANCIAL_DOCUMENTS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('List of transfers', 'furgonetka'),
                __('List of transfers', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_LIST_OF_TRANSFERS,
                array( $this, 'get_furgonetka_iframe' )
            );

            add_submenu_page(
                'furgonetka',
                __('Complaints', 'furgonetka'),
                __('Complaints', 'furgonetka'),
                Furgonetka_Capabilities::CAPABILITY_MANAGE_FURGONETKA,
                self::PAGE_FURGONETKA_COMPLAINTS,
                array( $this, 'get_furgonetka_iframe' )
            );
        }

        remove_submenu_page( 'furgonetka', 'furgonetka' );
    }

    public function furgonetka_invoices_init(): void
    {
        $this->furgonetka_handle_modal_request( self::ACTION_INVOICES_INIT );
    }

    public function furgonetka_fast_shipping_init(): void
    {
        $this->furgonetka_handle_modal_request( self::ACTION_FAST_SHIPPING_INIT );
    }

    /**
     * Furgonetka modal AJAX handler
     */
    public function furgonetka_handle_modal_request( $action ): void
    {
        /**
         * Validate permissions
         */
        if ( ! Furgonetka_Capabilities::current_user_can_manage_furgonetka() ) {
            wp_send_json_error(
                array(
                    'error_message' => self::get_permissions_error_message(),
                )
            );
        }

        /**
         * Connection with Furgonetka.pl is not configured or token has expired
         */
        if ( get_option( $this->plugin_name . '_expires_date' ) <= strtotime( 'now' ) ) {
            wp_send_json_error(
                array(
                    'redirect_url'  => self::get_plugin_admin_url(),
                    'error_message' => self::get_error_message_by_action( $action, self::MODAL_ERROR_TOKEN_EXPIRED ),
                )
            );
        }

        /**
         * Validate whether integration UUID is present
         */
        if ( empty( self::get_integration_uuid() ) ) {
            wp_send_json_error(
                array(
                    'redirect_url'  => self::get_plugin_admin_url( self::PAGE_FURGONETKA_ADVANCED_INTERNAL ),
                    'error_message' => self::get_error_message_by_action( $action, self::MODAL_ERROR_NO_INTEGRATION_UUID ),
                )
            );
        }

        /**
         * Handle request
         */
        if ( isset ( $_POST['order_id'] ) ) {
            $order_id = sanitize_text_field( wp_unslash( $_POST['order_id'] ) );

            try {
                $result = self::get_action_init_url( $order_id, $action );

                wp_send_json_success( array ( 'url' => $result ) );
            } catch ( Exception $e ) {
                /** Silence is golden */
                $this->log( $e );
            }
        }

        /**
         * Fail when something went wrong
         */
        wp_send_json_error(
            array(
                'error_message' => self::get_error_message_by_action( $action ),
            )
        );
    }

    private static function get_error_message_by_action( $action = null, $message_key = null ): string
    {
        $messages = [
            self::ACTION_FAST_SHIPPING_INIT => [
                self::MODAL_ERROR_TOKEN_EXPIRED       => __( 'Error occurred while executing fast shipping. Please connect module with Furgonetka.pl account.', 'furgonetka' ),
                self::MODAL_ERROR_NO_INTEGRATION_UUID => __( 'Error occurred while executing fast shipping. Please reconnect module with Furgonetka.pl account.', 'furgonetka' ),
                self::MODAL_ERROR_DEFAULT             => __( 'Error occurred while executing fast shipping.', 'furgonetka' ),
            ],
            self::ACTION_INVOICES_INIT      => [
                self::MODAL_ERROR_TOKEN_EXPIRED       => __( 'Error occurred while processing the invoice creation. Please connect module with Furgonetka.pl account.', 'furgonetka' ),
                self::MODAL_ERROR_NO_INTEGRATION_UUID => __( 'Error occurred while processing the invoice creation. Please reconnect module with Furgonetka.pl account.', 'furgonetka' ),
                self::MODAL_ERROR_DEFAULT             => __( 'Error occurred while processing the invoice creation.', 'furgonetka' ),
            ],
        ];

        if ( isset( $messages[$action] ) ) {
            return $messages[$action][$message_key] ?? $messages[$action][self::MODAL_ERROR_DEFAULT];
        }

        return __( 'An unexpected error occurred, please try later.', 'furgonetka' );
    }

    /**
     * Connect integration handler
     *
     * @return void
     */
    public function furgonetka_connect_integration()
    {
        /** Try to ensure capabilities when trying to connect integration */
        Furgonetka_Capabilities::ensure_capabilities();

        /**
         * Validate permissions
         */
        if ( ! Furgonetka_Capabilities::current_user_can_manage_furgonetka() ) {
            wp_send_json_error(
                array(
                    'error_message' => self::get_permissions_error_message(),
                )
            );
        }

        /**
         * Gather input params
         */
        $test_mode = false;

        if ( isset ( $_POST[ 'test_mode' ] ) && sanitize_text_field( wp_unslash( $_POST[ 'test_mode' ] ) ) ) {
            $test_mode = true;
        }

        update_option( $this->plugin_name . '_test_mode', $test_mode );

        /**
         * Edge-case when shop doesn't have SSL - flow excludes prompt and generates keys directly
         */
        if ( ! $this->is_shop_ssl_enabled() ) {
            $credentials = Furgonetka_Api_Keys::create_api_credentials();
            Furgonetka_Api_Keys::store_temporary_api_keys( $credentials['consumer_key'], $credentials['consumer_secret'] );

            $redirect_url = static::get_plugin_admin_url(
                self::PAGE_FURGONETKA,
                self::ACTION_CONNECT_INTEGRATION,
                array( self::PARAM_SUCCESS => 1 )
            );

            wp_send_json_success( array ( 'redirect_url' => $redirect_url ) );
        }

        /**
         * Regular authorization flow with prompt
         */
        $return_url = static::get_plugin_admin_url( self::PAGE_FURGONETKA, self::ACTION_CONNECT_INTEGRATION );

        $query_string = http_build_query(
            array(
                'app_name' => __( 'Furgonetka', 'furgonetka' ),
                'scope' => 'read_write',
                'user_id' => Furgonetka_Auth_Api_Permissions::generate_auth_api_nonce(),
                'return_url' => $return_url,
                'callback_url' => get_home_url() . '/wp-json/furgonetka/v1/authorize/callback'
            )
        );

        $result = get_home_url() . '/wc-auth/v1/authorize?' . $query_string;

        wp_send_json_success( array ( 'redirect_url' => $result ) );
    }

    /**
     * Detect whether shop has SSL enabled
     */
    protected function is_shop_ssl_enabled()
    {
        $url = urldecode( get_home_url() );

        return ( strpos( $url, '://' ) === false ) || ( stripos( $url, 'https://' ) === 0 );
    }

    /**
     * Return plugin name
     *
     * @return string
     */
    public function get_plugin_name(): string
    {
        return $this->plugin_name;
    }

    public static function get_checkout_uuid()
    {
        return self::get_plugin_option( self::OPTION_CHECKOUT_UUID );
    }

    /**
     * @return string|false
     */
    public static function get_account_type()
    {
        return self::get_plugin_option( self::OPTION_ACCOUNT_TYPE );
    }

    public static function is_checkout_active()
    {
        return (bool) self::get_plugin_option( self::OPTION_CHECKOUT_ACTIVE );
    }

    public static function is_checkout_test_mode()
    {
        return (bool) self::get_plugin_option( self::OPTION_CHECKOUT_TEST_MODE );
    }

    public static function is_product_page_button_visible()
    {
        return (bool) self::get_plugin_option( self::OPTION_PRODUCT_PAGE_BUTTON_VISIBLE, true );
    }

    private static function get_plugin_option( $option_name, $default_value = false )
    {
        return get_option( FURGONETKA_PLUGIN_NAME . '_' . $option_name, $default_value );
    }

    public static function get_checkout_details()
    {
        return array(
            'product_page_button_visible' => self::is_product_page_button_visible(),
        );
    }

    public static function get_checkout_rest_urls()
    {
        $checkout_paths = [
            'all_in_one',
            'cart',
            'cart/add_coupon',
            'cart/remove_coupons',
            'shippings',
            'payments',
            'coupons',
            'totals'
        ];

        $checkout_rest_urls = [];

        foreach ( $checkout_paths as $path ) {
            $checkout_rest_urls[$path] = get_rest_url( null, FURGONETKA_REST_NAMESPACE . '/checkout/' . $path );
        }

        return $checkout_rest_urls;
    }

    public function update_checkout_options( $uuid, $active, $test_mode, $details )
    {
            update_option( $this->plugin_name . '_' . self::OPTION_CHECKOUT_UUID, sanitize_text_field( strval( $uuid ) ) );
            update_option( $this->plugin_name . '_' . self::OPTION_CHECKOUT_ACTIVE, (int) $active );
            update_option( $this->plugin_name . '_' . self::OPTION_CHECKOUT_TEST_MODE, (int) $test_mode );

            foreach ( $details as $key => $detail ) {
                if ( in_array( $key, self::OPTION_DETAILS, true ) ) {
                    update_option( $this->plugin_name . '_' . $key, $detail );
                }
            }
    }

    public static function is_hpos_enabled()
    {
        return class_exists( \Automattic\WooCommerce\Utilities\OrderUtil::class ) &&
            method_exists( \Automattic\WooCommerce\Utilities\OrderUtil::class, 'custom_orders_table_usage_is_enabled' ) &&
            \Automattic\WooCommerce\Utilities\OrderUtil::custom_orders_table_usage_is_enabled();
    }

    /**
     * Furgonetka default settings page
     *
     * @since 1.0.0
     */
    public function furgonetka_default_page()
    {
        /**
         * Validate permissions
         */
        if ( ! Furgonetka_Capabilities::current_user_can_manage_furgonetka() ) {
            wp_die( self::get_permissions_error_message() );
        }

        /**
         * Handle actions
         */
        $action = $this->get_sanitized_query_param( self::PARAM_ACTION );

        switch ($action) {
            case self::ACTION_CONNECT_INTEGRATION:
                $this->connect_integration();
            case self::ACTION_OAUTH_COMPLETE:
                $this->oauth_complete();
            case self::ACTION_GET_PACKAGE_FORM:
                $this->get_package_form();
            case self::ACTION_ERROR_PAGE:
                $this->error_page();
        }

        /**
         * No action is given & account is not active = render welcome screen
         */
        if ( ! self::is_account_active() ) {
            $this->welcome_screen();
        }

        /**
         * No action is given & account is active = redirect to settings panel
         */
        $this->redirect_to_plugin_admin_page( self::PAGE_FURGONETKA_PANEL_SETTINGS );
    }

    /**
     * Get package form action
     *
     * @return never
     */
    private function get_package_form()
    {
        /**
         * Get & validate order_id
         */
        $order_id = $this->get_sanitized_query_param( self::PARAM_ORDER_ID );

        if ( $order_id === null ) {
            $this->redirect_to_error_page( self::ERROR_CODE_MISSING_REQUIRED_PARAMETERS );
        }

        if ( ! static::is_account_active() ) {
            $this->redirect_to_plugin_admin_page();
        }

        /**
         * Render iframe
         */
        try {
            $this->render_view(
                'partials/furgonetka-admin-getpackageform.php',
                [
                    'furgonetka_package_form_url' =>
                        self::get_action_init_url( (int) $order_id, self::ACTION_PACKAGE_FORM_INIT )
                ]
            );
        } catch ( Exception $e ) {
            $this->log( $e );
        }

        $this->redirect_to_error_page( self::ERROR_CODE_UNKNOWN );
    }

    /**
     * Render view with the given params
     *
     * @param $view_path
     * @param $variables
     * @return never
     */
    private function render_view( $view_path, $variables = array() )
    {
        /** Default view variables */
        $furgonetka_form_url = static::get_plugin_admin_url();
        $furgonetka_errors   = $this->errors;
        $furgonetka_messages = $this->messages;

        /** Additional view variables */
        foreach ( $variables as $key => $value ) {
            ${$key} = $value;
        }

        /** Require view */
        require $view_path;

        /**
         * End execution
         */
        exit;
    }

    /**
     * Render error page
     *
     * @return never
     */
    private function error_page()
    {
        /**
         * Get error
         */
        $error = $this->get_sanitized_query_param( self::PARAM_ERROR_CODE );

        if ( ! in_array($error, self::SUPPORTED_ERROR_CODES, true ) ) {
            $error = self::ERROR_CODE_UNKNOWN;
        }

        /**
         * Build URL
         */
        $error_screen_url = Furgonetka_Admin::get_furgonetka_shop_base_url();
        $error_screen_url .= '/ecommerce/app/error_screen?';
        $error_screen_url .= http_build_query(
            array(
                'origin' => get_home_url(),
                'type' => 'woocommerce',
                'error' => $error,
            )
        );

        /**
         * Render URL inside iframe
         */
        $this->render_iframe( $error_screen_url );
    }

    /**
     * Redirect to error page with given error
     *
     * @param string $error_code
     * @return never
     */
    private function redirect_to_error_page( $error_code )
    {
        $this->redirect_to_plugin_admin_page(
            self::PAGE_FURGONETKA,
            self::ACTION_ERROR_PAGE,
            array( self::PARAM_ERROR_CODE => $error_code )
        );
    }

    /**
     * Render welcome screen
     *
     * @return never
     */
    private function welcome_screen()
    {
        $welcome_screen_url = Furgonetka_Admin::get_furgonetka_shop_base_url();
        $welcome_screen_url .= '/ecommerce/app/welcome_screen?';
        $welcome_screen_url .= http_build_query(
            array(
                'origin' => get_home_url(),
                'type' => 'woocommerce',
            )
        );

        $this->render_iframe( $welcome_screen_url );
    }

    /**
     * Render iframe view for the given URL
     *
     * @param $url
     * @return never
     */
    private function render_iframe( $url )
    {
        $this->render_view(
            plugin_dir_path( __DIR__ ) . 'includes/view/furgonetka-iframe.php',
            array( 'url' => $url )
        );
    }

    /**
     * Get sanitized query param from $_GET superglobal
     *
     * @param $name
     * @return string|null
     */
    private function get_sanitized_query_param( $name )
    {
        if ( isset( $_GET[ $name ] ) ) {
            return sanitize_text_field( wp_unslash( $_GET[ $name ] ) );
        }

        return null;
    }

    public function get_furgonetka_advanced()
    {
        $additional_data = [
            'position_options' => [
                __('To left', 'furgonetka') => 'left',
                __('Center', 'furgonetka') => 'center',
                __('To right', 'furgonetka') => 'right'
            ],
            'width_options' => [
                __('Automatic', 'furgonetka') => 'auto',
                __('Half width', 'furgonetka') => 'half',
                __('Full width', 'furgonetka') => 'full'
            ]
        ];

        $this->render_simple_form( 'includes/view/furgonetka-advanced.php', $additional_data );
    }

    /**
     * @param $viewPath
     * @param $additional_data
     * @return never
     */
    public function render_simple_form( $viewPath, $additional_data = null )
    {
        if ( ! Furgonetka_Capabilities::current_user_can_manage_furgonetka() ) {
            wp_die( self::get_permissions_error_message() );
        }

        if ( ! self::is_account_active() ) {
            $this->redirect_to_plugin_admin_page();
        }

        /**
         * Get action
         */
        $action = null;

        if (
            isset( $_POST['_wpnonce'], $_POST['furgonetkaAction'] )
            && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ) )
        ) {
            $action = sanitize_text_field( wp_unslash( $_POST['furgonetkaAction'] ) );
        }

        /**
         * Handle action
         */
        switch ($action) {
            case self::ACTION_SAVE_ADVANCED:
                $this->save_advanced_settings();
                break;
            case self::ACTION_RESET_CREDENTIALS:
                $this->reset_credentials();
                $this->redirect_to_plugin_admin_page();
        }

        /**
         * Render view
         */
        $this->render_view(
            plugin_dir_path( __DIR__ ) . $viewPath,
            array( 'additional_data' => $additional_data )
        );
    }

    public function get_furgonetka_iframe()
    {
        $full_page_name = $this->get_sanitized_query_param( self::PARAM_PAGE );
        $this->render_furgonetka_app_link( $full_page_name );
    }

    /**
     * @param $full_page_name
     * @return never
     */
    private function render_furgonetka_app_link( $full_page_name )
    {
        if ( ! Furgonetka_Capabilities::current_user_can_manage_furgonetka() ) {
            wp_die( self::get_permissions_error_message() );
        }

        if ( ! self::get_integration_uuid() || ! self::is_account_active() ) {
            $this->redirect_to_plugin_admin_page();
        }

        /**
         * Remove prefix from full page name to get proper, common name
         */
        $page = str_replace( 'furgonetka_', '', $full_page_name );

        try {
            $url = self::get_app_link_url( $page );

            $this->render_iframe( $url );
        } catch (Exception $e) {
            $this->log( 'Error occurred while getting app link.' );

            $this->redirect_to_error_page( self::ERROR_CODE_UNSUPPORTED_LINK );
        }
    }

    /**
     * Validate user by code and save
     *
     * @since 1.0.0
     * @throws Exception
     */
    private function save_credentials_code()
    {
        $code  = isset( $_GET['code'] ) ? urldecode( sanitize_text_field( wp_unslash( $_GET['code'] ) ) ) : null;
        $state = isset( $_GET['state'] ) ? urldecode( sanitize_text_field( wp_unslash( $_GET['state'] ) ) ) : null;

        if ( ! wp_verify_nonce( $state, 'furgonetka_csrf' ) ) {
            throw new Exception( 'Incorrect CSRF' );
        }

        $test                = self::get_test_mode();
        $key_consumer_key    = Furgonetka_Api_Keys::get_temporary_consumer_key();
        $key_consumer_secret = Furgonetka_Api_Keys::get_temporary_consumer_secret();

        try {
            $this->grant_code_access($code, self::get_client_id(), self::get_client_secret(), $test );

            $integration_identifiers = $this->add_integration_source(
                $key_consumer_key,
                $key_consumer_secret
            );
            $source_id               = $integration_identifiers->sourceId ?? null;
            $integration_uuid        = $integration_identifiers->integrationUuid ?? null;

            if ( is_numeric( $source_id ) && is_string( $integration_uuid ) ) {
                update_option( $this->plugin_name . '_source_id', $source_id );
                update_option( $this->plugin_name . '_integration_uuid', $integration_uuid );
            } else {
                throw new Exception( 'Invalid source_id or integration_uuid' );
            }
        } catch ( Exception $e ) {
            $this->log( $e );

            throw $e;
        }
    }

    /**
     * Delete credentials data.
     *
     * @return void
     */
    private function delete_credentials_data()
    {
        delete_option( $this->plugin_name . '_source_id' );
        delete_option( $this->plugin_name . '_integration_uuid' );
        delete_option( $this->plugin_name . '_access_token' );
        delete_option( $this->plugin_name . '_refresh_token' );
        delete_option( $this->plugin_name . '_expires_date' );

        Furgonetka_Api_Keys::remove_temporary_api_keys();
    }

    /**
     * @throws Exception
     */
    public function save_account_data(): void
    {
        $account_data = self::send_rest_api_request(
            'GET',
            self::PATH_ACCOUNT,
            array_merge( self::authorization_headers(), self::furgonetka_api_v2_headers() )
        );

        if ( isset( $account_data->account_type ) ) {
            update_option( $this->plugin_name . '_' . self::OPTION_ACCOUNT_TYPE, $account_data->account_type );
        }
    }

    private function delete_account_data(): void
    {
        delete_option( $this->plugin_name . '_' . self::OPTION_ACCOUNT_TYPE );
    }

    /**
     * Reset credentials
     *
     * @since 1.0.0
     */
    private function reset_credentials()
    {
        delete_option( $this->plugin_name . '_client_ID' );
        delete_option( $this->plugin_name . '_client_secret' );
        delete_option( $this->plugin_name . '_test_mode' );
        delete_option( $this->plugin_name . '_email' );

        $this->delete_credentials_data();
    }

    /**
     * Get product html selector to put Furgonetka Koszyk button in
     *
     * @since 1.2.2
     */
    public static function get_portmonetka_product_selector()
    {
        return self::get_plugin_option( 'portmonetka_product_selector' );
    }

    /**
     * Get cart html selector to put portmonetka button in
     *
     * @since 1.2.2
     */
    public static function get_portmonetka_cart_selector()
    {
        return self::get_plugin_option( 'portmonetka_cart_selector' );
    }

    /**
     * Get cart html selector to put portmonetka button in
     *
     * @since 1.2.2
     */
    public static function get_portmonetka_minicart_selector()
    {
        return self::get_plugin_option( 'portmonetka_minicart_selector' );
    }

    /**
     * Get cart button position selector
     *
     * @since 1.2.4
     */
    public static function get_portmonetka_cart_button_position()
    {
        return self::get_plugin_option( 'portmonetka_cart_button_position' );
    }

    /**
     * Get cart button width
     *
     * @since 1.2.4
     */
    public static function get_portmonetka_cart_button_width()
    {
        return self::get_plugin_option( 'portmonetka_cart_button_width' );
    }

    /**
     * Get cart button css
     *
     * @since 1.2.4
     */
    public static function get_portmonetka_cart_button_css()
    {
        return self::get_plugin_option( 'portmonetka_cart_button_css' );
    }

    /**
     * Get whether Portmonetka should replace native checkout
     */
    public static function get_portmonetka_replace_native_checkout()
    {
        return (bool) self::get_plugin_option( 'portmonetka_replace_native_checkout' );
    }

    /**
     * Save advanced settings
     *
     * @since 1.2.2
     */
    private function save_advanced_settings()
    {
        $product_selector  = '';
        $cart_selector     = '';
        $minicart_selector = '';

        $button_position   = '';
        $button_width      = '';
        $button_css        = '';

        $open_in_new_tab   = '';

        if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ) ) ) {
            $product_selector  = isset( $_POST['portmonetka_product_selector'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_product_selector'] ) ) : '';
            $cart_selector     = isset( $_POST['portmonetka_cart_selector'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_cart_selector'] ) ) : '';
            $minicart_selector = isset( $_POST['portmonetka_minicart_selector'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_minicart_selector'] ) ) : '';

            $button_position = isset( $_POST['portmonetka_cart_button_position'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_cart_button_position'] ) ) : '';
            $button_width = isset( $_POST['portmonetka_cart_button_width'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_cart_button_width'] ) ) : '';
            $button_css = isset( $_POST['portmonetka_cart_button_css'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_cart_button_css'] ) ) : '';
            $open_in_new_tab = isset( $_POST['portmonetka_replace_native_checkout'] ) ?
                sanitize_text_field( wp_unslash( $_POST['portmonetka_replace_native_checkout'] ) ) : '';
        }

        update_option( $this->plugin_name . '_portmonetka_product_selector', $product_selector );
        update_option( $this->plugin_name . '_portmonetka_cart_selector', $cart_selector );
        update_option( $this->plugin_name . '_portmonetka_minicart_selector', $minicart_selector );

        update_option( $this->plugin_name . '_portmonetka_cart_button_position', $button_position );
        update_option( $this->plugin_name . '_portmonetka_cart_button_width', $button_width );
        update_option( $this->plugin_name . '_portmonetka_cart_button_css', $button_css );

        update_option( $this->plugin_name . '_portmonetka_replace_native_checkout', $open_in_new_tab );

        $this->messages[] = esc_html__( 'Configuration saved successfully.', 'furgonetka' );
    }

    /**
     * Create integration based on given consumer key and consumer secret
     *
     * @param $ck
     * @param $cs
     * @return never
     * @throws Exception
     */
    private function create_integration_internal( $ck, $cs )
    {
        if ( empty( $ck ) || empty( $cs ) ) {
            $this->log( 'Empty consumer key or consumer secret' );

            throw new Exception(  __( 'Add integration source problem', 'furgonetka' ) );
        }

        $api_data = array(
            'type' => 'woocommerce',
            'url'              => self::get_redirect_uri(),
            'data' => array(
                'shopUrl'          => get_home_url(),
                'consumerKey'      => $ck,
                'consumerSecret'   => $cs
            )
        );

        $result = self::send_rest_api_request('POST', self::PATH_CREATE_OAUTH_APPLICATION, array(), $api_data);

        if ( empty( $result->client_id ) ) {
            $this->log( $result );

            throw new Exception(  __( 'Add integration source problem', 'furgonetka' ) );
        }

        $test_mode = self::get_test_mode() ? true : false;
        update_option( $this->plugin_name . '_client_ID', $result->client_id );
        update_option( $this->plugin_name . '_client_secret', $result->client_secret );

        /**
         * Save wp access api data in db
         */
        Furgonetka_Api_Keys::store_temporary_api_keys( $ck, $cs );

        update_option( $this->plugin_name . '_test_mode', $test_mode );

        $url   = self::get_test_mode() ? self::TEST_API_OAUTH_URL : self::API_OAUTH_URL;
        $query = http_build_query(
            array(
                'client_id'    => $result->client_id,
                'redirect_uri' => self::get_redirect_uri(),
                'state'        => self::get_oauth_state(),
            )
        );
        $url  .= '/authorize?response_type=code&' . $query;
        header( 'Location: ' . $url );
        die();
    }

    /**
     * Handle oAuth complete
     *
     * @return never
     */
    private function oauth_complete()
    {
        /**
         * Redirect to welcome screen when user denied access
         */
        if ( $this->get_sanitized_query_param( self::PARAM_OAUTH_ERROR ) === self::ERROR_OAUTH_ACCESS_DENIED ) {
            $this->delete_credentials_data();

            $this->redirect_to_plugin_admin_page();
        }

        /**
         * Create integration
         */
        try {
            $this->save_credentials_code();
            $this->save_account_data();
        } catch (Exception $e) {
            $this->delete_credentials_data();
            $this->delete_account_data();
            $this->log( $e );

            $this->redirect_to_error_page( self::ERROR_CODE_INTEGRATION_FAILED );
        }

        /**
         * Redirect to default page for connected account
         */
        $this->redirect_to_plugin_admin_page();
    }

    /**
     * Create integration based on stored options
     *
     * @return never
     */
    private function connect_integration()
    {
        $success = $this->get_sanitized_query_param( self::PARAM_SUCCESS );

        /**
         * Edge-case: few shops are removing "success" parameter after redirect.
         *
         * To overcome this issue we are assuming that only success === '0' prevents us from integration.
         *
         * When success parameter is not defined, we're expecting to fail further (keys should not be generated),
         * thus integration would not be added when user did not agreed to create integration.
         */
        if ( $success !== null && ! $success ) {
            $this->log( 'User denied integration in native WooCommerce prompt.' );

            $this->delete_credentials_data();
            $this->redirect_to_plugin_admin_page();
        }

        $ck = Furgonetka_Api_Keys::get_temporary_consumer_key();
        $cs = Furgonetka_Api_Keys::get_temporary_consumer_secret();

        try {
            $this->create_integration_internal($ck, $cs);
        } catch (Exception $e) {
            $this->delete_credentials_data();

            $this->redirect_to_error_page( self::ERROR_CODE_INTEGRATION_FAILED );
        }
    }

    public static function update_plugin_version( $version )
    {
        if ( ! self::is_account_active() ) {
            return;
        }

        $token = self::get_access_token();

        if ( ! $token ) {
            return;
        }

        $integration_uuid = self::get_integration_uuid();
        $source_id        = self::get_source_id();

        if ( ! $integration_uuid && ! $source_id ) {
            return;
        }

        $body_params = array( 'version' => $version );

        if ( $integration_uuid ) {
            $path = '/e-commerce/integrations/' . $integration_uuid . '/plugin';
        } elseif ( $source_id ) {
            $path = '/e-commerce/integrations/plugin';

            $body_params['sourceId'] = $source_id;
        }

        if ( ! empty ( $path ) ) {
            try {
                $result = self::send_rest_api_request('PATCH', $path, self::authorization_headers(), $body_params);

                if ( ! $integration_uuid && ! empty( $result->integrationUuid ) ) {
                    update_option( FURGONETKA_PLUGIN_NAME . '_integration_uuid', $result->integrationUuid );
                }
            } catch (\Exception $e) {
                /** Do nothing */
            }
        }
    }

    /**
     * Get access token by code
     *
     * @since 1.0.0.
     * @param  mixed $code          - code.
     * @param  mixed $client_id     - client id.  - id of the client.
     * @param  mixed $client_secret - client secret.  - client secret.
     * @param  mixed $test_mode     - set test mode. - set if in test mode.
     * @throws Exception - curl errors.
     */
    private function grant_code_access( $code, $client_id, $client_secret, $test_mode = null )
    {
        //phpcs:ignore
        $auth = base64_encode( $client_id . ':' . $client_secret );
        $url  = self::get_test_mode() ? self::TEST_API_OAUTH_URL : self::API_OAUTH_URL;
        $url .= '/token';

        $args     = array(
            'headers'    => array(
                'Authorization' => 'Basic ' . $auth,
                'content-type'  => 'application/x-www-form-urlencoded',
            ),
            'method'     => 'POST',
            'body'       => http_build_query(
                array(
                    'grant_type'   => 'authorization_code',
                    'code'         => $code,
                    'redirect_uri' => self::get_redirect_uri(),
                )
            ),
            'user-agent' => self::get_request_user_agent(),
        );
        $response = wp_remote_request( $url, $args );

        if ( is_wp_error( $response ) ) {
            throw new Exception( 'Curl error: ' . $response->get_error_message() );
        } else {
            $http_status   = wp_remote_retrieve_response_code( $response );
            $server_output = trim( wp_remote_retrieve_body( $response ) );
            if ( $http_status >= 400 ) {
                $error = json_decode( $server_output );
                throw new Exception( 'HTTP STATUS: ' . $http_status . ' - Message: ' . $error->message );
            } else {
                if ( 200 === $http_status ) {
                    $response = json_decode( $server_output );
                    if ( isset( $response->access_token ) ) {
                        update_option( $this->plugin_name . '_access_token', $response->access_token );
                    }
                    if ( isset( $response->refresh_token ) ) {
                        update_option( $this->plugin_name . '_refresh_token', $response->refresh_token );
                    }
                    if ( isset( $response->expires_in ) ) {
                        $expires_date = strtotime( 'now' ) + $response->expires_in;
                        update_option( $this->plugin_name . '_expires_date', $expires_date );
                    }
                    $test_mode = $test_mode ? true : false;
                    update_option( $this->plugin_name . '_test_mode', $test_mode );
                } else {
                    throw new Exception( 'BAD HTTP STATUS: ' . $http_status );
                }
            }
        }
    }

    /**
     * Add integration source
     *
     * @since 1.0.0
     *
     * @param  mixed $key_consumer_key    - consumer key.
     * @param  mixed $key_consumer_secret - secret key.
     * @throws \Exception - integration source error.
     */
    private function add_integration_source( $key_consumer_key, $key_consumer_secret )
    {
        $api_data = array(
            'type' => 'woocommerce',
            'version' => $this->version,
            'data' => array(
                'shopUrl'          => get_home_url(),
                'consumerKey'      => $key_consumer_key,
                'consumerSecret'   => $key_consumer_secret
            )
        );

        Furgonetka_Api_Keys::remove_temporary_api_keys();

        $result = self::send_rest_api_request('POST', self::PATH_CONFIGURATIONS, self::authorization_headers(), $api_data );

        if ( empty ( $result->sourceId ) ) {
            if ( ! empty( $result->errors ) ) {
                $first_error = reset( $result->errors );

                throw new \Exception( $first_error->path . ': ' . $first_error->message );
            }

            throw new \Exception( __( 'Add integration source problem', 'furgonetka' ) );
        }

        return $result;
    }

    /**
     * Refresh furgonetka token
     *
     * @since 1.0.0
     */
    public function furgonetka_refresh_token()
    {
        /** Break if expires date > 7 days */
        if ( get_option( $this->plugin_name . '_expires_date' ) > strtotime( '+7 day' ) ) {
            return;
        }

        $test_mode     = get_option( $this->plugin_name . '_test_mode' );
        $client_id     = get_option( $this->plugin_name . '_client_ID' );
        $client_secret = get_option( $this->plugin_name . '_client_secret' );
        $refresh_token = get_option( $this->plugin_name . '_refresh_token' );

        try {
            $this->refresh_token( $client_id, $client_secret, $test_mode, $refresh_token );
        } catch ( Exception $e ) {
            /** Silence is golden */
            $this->log( $e );
        }
    }

    /**
     * Refresh user token
     *
     * @since 1.0.0
     *
     * @param mixed $client_id     - client id.
     * @param mixed $client_secret - client secret.
     * @param mixed $test_mode     - set test mode.
     * @param mixed $refresh_token - refresh token.
     *
     * @throws Exception - http status.
     */
    private function refresh_token( $client_id, $client_secret, $test_mode, $refresh_token )
    {
        if ( empty( $refresh_token ) ) {
            throw new Exception( 'Refresh token: is empty, refreshing canceled' );
        }

        //phpcs:ignore
        $auth = base64_encode( $client_id . ':' . $client_secret );
        $url  = $test_mode ? self::TEST_API_OAUTH_URL : self::API_OAUTH_URL;
        $url .= '/token';

        $args = array(
            'headers'    => array(
                'Authorization' => 'Basic ' . $auth,
                'content-type'  => 'application/x-www-form-urlencoded',
            ),
            'method'     => 'POST',
            'body'       => http_build_query(
                array(
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $refresh_token,
                )
            ),
            'user-agent' => self::get_request_user_agent(),
        );

        $response = wp_remote_request( $url, $args );

        if ( is_wp_error( $response ) ) {
            throw new Exception( 'Curl error: ' . $response->get_error_message() );
        } else {
            $http_status   = wp_remote_retrieve_response_code( $response );
            $server_output = trim( wp_remote_retrieve_body( $response ) );

            if ( $http_status >= 400 ) {
                $error = json_decode( $server_output );
                throw new Exception( 'HTTP STATUS: ' . $http_status . ' - Message: ' . $error->message );
            } else {
                if ( 200 === $http_status ) {
                    $response = json_decode( $server_output );
                    if ( isset( $response->access_token ) ) {
                        update_option( $this->plugin_name . '_access_token', $response->access_token );
                    }
                    if ( isset( $response->refresh_token ) ) {
                        update_option( $this->plugin_name . '_refresh_token', $response->refresh_token );
                    }
                    if ( isset( $response->expires_in ) ) {
                        $expires_date = strtotime( 'now' ) + $response->expires_in;
                        update_option( $this->plugin_name . '_expires_date', $expires_date );
                    }
                } else {
                    throw new Exception( 'BAD HTTP STATUS: ' . $http_status );
                }
            }
        }
    }

    /**
     * Get user balance from API
     *
     * @throws \Exception - Get balance problem.
     *
     * @return string
     */
    public static function get_balance()
    {
        $response = self::send_rest_api_request('GET', self::PATH_ACCOUNT, array_merge( self::authorization_headers(), self::furgonetka_api_v2_headers() ) );

        if ( ! isset( $response->user->balance ) ) {
            if ( ! empty( $response->message ) ) {
                throw new \Exception( $response->message );
            }

            throw new \Exception( __( 'Balance GET problem', 'furgonetka' ) );
        }

        return $response->user->balance;
    }

    /**
     * @param mixed $order_id - order ID
     * @param string $action  - action
     * @throws \Exception     - error
     */
    public static function get_action_init_url($order_id, $action ): string
    {
        /**
         * Get order number
         */
        $order_data = wc_get_order( $order_id );

        if ( ! $order_data ) {
            throw new \Exception( self::get_error_message_by_action( $action ) );
        }

        $reference = $order_data->get_order_number();

        if ( empty( $reference ) ) {
            $reference = $order_id;
        }

        /**
         * Initialize
         */
        $data = array(
            'integrationUuid' => self::get_integration_uuid(),
            'sourceOrderId'   => $reference,
            'shopOrderId'     => $order_id
        );

        if ( $action === self::ACTION_PACKAGE_FORM_INIT ) {
            $path = self::PATH_PACKAGE_FORM_INIT;
        } elseif ( $action === self::ACTION_FAST_SHIPPING_INIT ) {
            $path = self::PATH_FAST_SHIPPING_INIT;
        } elseif ( $action === self::ACTION_INVOICES_INIT ) {
            $path = self::PATH_INVOICES_INIT;
        } else {
            throw new \Exception( self::get_error_message_by_action() );
        }

        $path .= '?' . http_build_query( $data );

        $result = self::send_rest_api_request('POST', $path, self::authorization_headers() );

        if ( empty ( $result->url )) {
            if ( ! empty( $result->errors ) ) {
                $first_error = reset( $result->errors );

                throw new \Exception( $first_error->path . ': ' . $first_error->message );
            }

            throw new \Exception( self::get_error_message_by_action( $action ) );
        }

        /**
         * Store order number in metadata
         */
        if ( $order_data->get_order_number() !== ( (string) $order_data->get_id() ) ) {
            $order_data->update_meta_data( self::METADATA_FURGONETKA_ORDER_NUMBER, $order_data->get_order_number() );
            $order_data->save();
        }

        return $result->url;
    }

    public static function get_app_link_url(string $page)
    {
        $data = array(
            'integrationUuid' => self::get_integration_uuid(),
            'page'            => $page,
        );

        $path = self::PATH_APP_LINK_INIT . '?' . http_build_query( $data );

        $response = self::send_rest_api_request('POST', $path, self::authorization_headers() );

        if ( empty( $response->url ) ) {
            throw new Exception();
        }

        return $response->url;
    }

    /**
     * Get email
     *
     * @since 1.0.0.
     */
    public static function get_email()
    {
        return self::check_nonce_and_get_data( 'email', '_email' );
    }

    /**
     * Get client ID
     *
     * @since 1.0.0.
     */
    public static function get_client_id()
    {
        return self::check_nonce_and_get_data( 'clientID', '_client_ID' );
    }

    /**
     * Get client balance
     *
     * @since 1.0.0.
     */
    public static function get_client_balance()
    {
        try {
            return self::get_balance();
        } catch ( Exception $e ) {
            return $e->getMessage();
        }
    }

    /**
     * Get client service
     *
     * @since 1.0.0.
     */
    public static function get_client_secret()
    {
        return self::check_nonce_and_get_data( 'clientSecret', '_client_secret' );
    }

    /**
     * Get test mode
     *
     * @since 1.0.0.
     */
    public static function get_test_mode()
    {
        return get_option( FURGONETKA_PLUGIN_NAME . '_test_mode' );
    }

    /**
     * Check nonce and get data from options table
     *
     * @param  string $post_field_name - field name from POST table.
     * @param  string $option_name     - option name in DB.
     * @return mixed
     */
    public static function check_nonce_and_get_data( $post_field_name, $option_name )
    {
        return (
            isset( $_POST['_wpnonce'], $_POST[ $post_field_name ] )
            && wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ) )
        ) ? sanitize_text_field( wp_unslash( $_POST[ $post_field_name ] ) )
            : get_option( FURGONETKA_PLUGIN_NAME . $option_name );
    }

    /**
     * Get source id
     *
     * @since 1.0.0.
     */
    public static function get_source_id()
    {
        return get_option( FURGONETKA_PLUGIN_NAME . '_source_id' );
    }

    /**
     * Get access token
     *
     * @since    1.2.0.
     */
    public static function get_access_token()
    {
        return get_option( FURGONETKA_PLUGIN_NAME . '_access_token' );
    }

    /**
     * Get integration uuid
     *
     * @since    1.2.0.
     */
    public static function get_integration_uuid()
    {
        return get_option( FURGONETKA_PLUGIN_NAME . '_integration_uuid' );
    }

    /**
     * Get redirect Uri
     *
     * @since 1.0.0.
     */
    public static function get_redirect_uri()
    {
        return static::get_plugin_admin_url( self::PAGE_FURGONETKA, self::ACTION_OAUTH_COMPLETE );
    }

    /**
     * Get Oauth state
     *
     * @since 1.0.0.
     */
    public static function get_oauth_state()
    {
        return wp_create_nonce( 'furgonetka_csrf' );
    }

    /**
     * Admin print messages
     *
     * @param mixed $messages - message.
     * @param mixed $type     - message type.
     *
     * @since 1.0.0.
     */
    public static function print_messages( $messages, $type )
    {
        if ( ! $messages ) {
            return;
        }

        if ( ! $type ) {
            $type = 'message';
        }

        if ( ! is_array( $messages ) ) {
            return;
        }

        foreach ( $messages as $message ) {
            echo sprintf(
                '<div id="message" class="updated woocommerce-%1$s inline">
                        <p>%2$s</p>
                    </div>',
                esc_html( $type ),
                esc_html( $message )
            );
        }
    }

    /**
     * Render modal
     *
     * @return void
     */
    public function render_modal()
    {
        if ( $this->is_current_screen_supported( $this->get_modal_supported_screens() ) ) {
            $this->view->render_modal();
        }
    }

    private function get_modal_supported_screens(): array
    {
        $supported_screens   = array();
        $supported_screens[] = self::is_hpos_enabled() ? wc_get_page_screen_id( 'shop-order' ) : 'shop_order';
        $supported_screens[] = self::is_hpos_enabled() ? wc_get_page_screen_id( 'edit-shop-order' ) : 'edit-shop_order';

        return $supported_screens;
    }

    /**
     * Get plugin settings screens
     *
     * @return array
     */
    private function get_plugin_settings_screens()
    {
        return array(
            $this->plugin_name . '_page_furgonetka',
            'toplevel_page_furgonetka'
        );
    }

    /**
     * Check whether current screen is supported
     *
     * @return bool
     */
    private function is_current_screen_supported( array $supported_screens )
    {
        $current_screen    = get_current_screen();
        $current_screen_id = $current_screen ? $current_screen->id : '';

        return in_array( $current_screen_id, $supported_screens, true );
    }

    /**
     * Get woocommerce version
     *
     * @since 1.0.0
     */
    private static function get_wc_version()
    {
        if ( function_exists( 'WC' ) ) {
            return WC()->version;
        }
    }

    /**
     * Check if account is active and enabled
     *
     * @since 1.0.0
     */
    public static function is_account_active()
    {
        if ( ! get_option( FURGONETKA_PLUGIN_NAME . '_expires_date' ) ) {
            return false;
        }
        if ( get_option( FURGONETKA_PLUGIN_NAME . '_expires_date' ) < strtotime( 'now' ) ) {
            return false;
        }
        if ( ! self::get_integration_uuid() && ! self::get_source_id() ) {
            return false;
        }

        return true;
    }

    /**
     * Get user agent
     *
     * @return string
     */
    private static function get_request_user_agent()
    {
        return 'woocommerce_' . self::get_wc_version() . '_plugin_' . FURGONETKA_VERSION;
    }

    public static function get_rest_api_url()
    {
        return self::get_test_mode() ? self::TEST_API_REST_URL : self::API_REST_URL;
    }

    /**
     * Send request to REST API
     *
     * @param string $method
     * @param string $path
     * @param array $headers
     * @param mixed $body
     * @return mixed
     * @throws Exception
     */
    private static function send_rest_api_request( $method, $path, $headers = array(), $body = null ) {
        $args = array(
            'headers'    => array(
                'Accept'        => 'application/vnd.furgonetka.v1+json',
                'Cache-Control' => 'no-cache',
            ),
            'method'     => $method,
            'user-agent' => self::get_request_user_agent(),
            'timeout'    => 10
        );

        if ( $body !== null ) {
            $args['headers']['Content-Type'] = 'application/json';
            $args['body'] = json_encode( $body );
        }

        if ( !empty( $headers ) ) {
            $args['headers'] = array_merge( $args['headers'], $headers );
        }

        $wp_response = wp_remote_request( self::get_rest_api_url() . $path , $args );

        if ( is_wp_error( $wp_response ) ) {
            throw new Exception( $wp_response->get_error_message() );
        }

        $server_output = trim( wp_remote_retrieve_body( $wp_response ) );

        return json_decode( $server_output, false );
    }

    private static function authorization_headers()
    {
        return array(
            'Authorization' => 'Bearer ' . self::get_access_token()
        );
    }

    private static function furgonetka_api_v2_headers()
    {
        return array(
            'Accept' => 'application/vnd.furgonetka.v2+json',
        );
    }

    /**
     * Get Furgonetka base URL form shop subdomain
     *
     * @return string
     */
    public static function get_furgonetka_shop_base_url()
    {
        return FURGONETKA_DEBUG ? self::TEST_SHOP_URL : self::SHOP_URL;
    }

    /**
     * Get plugin admin page URL
     *
     * @param $page
     * @param $action
     * @param $params
     * @return string
     */
    public static function get_plugin_admin_url( $page = self::PAGE_FURGONETKA, $action = null, $params = array() )
    {
        /**
         * Build query params
         */
        $query_params = array(
            self::PARAM_PAGE => $page
        );

        if ( $action ) {
            $query_params[self::PARAM_ACTION] = $action;
        }

        $query_params_string = http_build_query(
            array_merge( $query_params, $params )
        );

        /**
         * Build target URL
         */
        return get_admin_url( null, '/admin.php?' . $query_params_string );
    }

    /**
     * Redirect to plugin admin page
     *
     * @param $page
     * @param $action
     * @param $params
     * @return never
     */
    private function redirect_to_plugin_admin_page( $page = self::PAGE_FURGONETKA, $action = null, $params = array() )
    {
        wp_redirect( static::get_plugin_admin_url( $page, $action, $params ) );

        exit;
    }

    /**
     * Get message that indicates insufficient permissions for the current user
     */
    private static function get_permissions_error_message(): string
    {
        return __( 'You do not have sufficient permissions to access this page.', 'furgonetka' );
    }

    /**
     * Error log
     *
     * @param $value
     * @return void
     */
    private function log( $value )
    {
        $logger = wc_get_logger();

        if ( ! $logger ) {
            return;
        }

        if ( ! is_string( $value ) ) {
            $value = serialize( $value );
        }

        $logger->error( $value, array( 'source' => $this->plugin_name ) );
    }
}
