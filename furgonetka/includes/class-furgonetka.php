<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  https://furgonetka.pl
 * @since 1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka
{
    /**
     * @var Furgonetka_Public
     */
    protected $plugin_public;

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    Furgonetka_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since  1.0.0
     * @access protected
     * @var    string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Admin class
     *
     * @var Furgonetka_Admin
     */
    protected $plugin_admin;

    /**
     * Metaboxes class
     *
     * @var furgonetka_admin_metaboxes
     */
    protected $metaboxes;

    /**
     * Return class
     *
     * @var Furgonetka_Returns
     */
    protected $returns;

    /**
     * @var Furgonetka_Blocks
     */
    protected $blocks;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        if ( defined( 'FURGONETKA_VERSION' ) ) {
            $this->version = FURGONETKA_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        if ( defined( 'FURGONETKA_PLUGIN_NAME' ) ) {
            $this->plugin_name = FURGONETKA_PLUGIN_NAME;
        } else {
            $this->plugin_name = 'furgonetka';
        }

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Furgonetka_Loader. Orchestrates the hooks of the plugin.
     * - Furgonetka_i18n. Defines internationalization functionality.
     * - Furgonetka_Admin. Defines all hooks for the admin area.
     * - Furgonetka_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-furgonetka-loader.php';
        $this->loader = new Furgonetka_Loader();
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-furgonetka-i18n.php';
        /**
         * Capabilities support
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-furgonetka-capabilities.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-furgonetka-admin.php';
        $this->plugin_admin = new Furgonetka_Admin( $this->get_plugin_name(), $this->get_version() );
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-furgonetka-public.php';
        /**
         * The class responsible for managing Rest API
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/rest_api/class-furgonetka-rest-api.php';
        new Furgonetka_rest_api();
        /**
         * The class responsible for managing metaboxes
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-furgonetka-admin-metaboxes.php';
        $this->metaboxes = new furgonetka_admin_metaboxes( $this->plugin_admin );
        /**
         * The class responsible for managing returns rewrite rules
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-furgonetka-returns.php';
        $this->returns = new Furgonetka_Returns();

        /**
         * API support
         */
        require_once plugin_dir_path( __DIR__ ) . 'includes/class-furgonetka-api-keys.php';
        require_once plugin_dir_path( __DIR__ ) . 'includes/class-furgonetka-auth-api-permissions.php';
        require_once plugin_dir_path( __DIR__ ) . 'includes/class-furgonetka-rest-api-permissions.php';

        /**
         * WooCommerce Blocks support
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-furgonetka-blocks.php';

        /**
         * Furgonetka map management
         */
        require_once plugin_dir_path( __DIR__ ) . 'includes/class-furgonetka-map.php';
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Furgonetka_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since  1.0.0
     * @access private
     */
    private function set_locale()
    {
        $plugin_i18n = new Furgonetka_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     */
    private function define_admin_hooks()
    {
        $this->loader->add_action(
            'admin_enqueue_scripts',
            $this->plugin_admin,
            'enqueue_scripts_and_styles'
        );
        $this->loader->add_action(
            'admin_menu',
            $this->plugin_admin,
            'furgonetka_menu'
        );
        $this->loader->add_action(
            'add_meta_boxes',
            $this->metaboxes,
            'furgonetka_meta_boxes'
        );
        $this->loader->add_action(
            'admin_footer',
            $this->plugin_admin,
            'render_modal'
        );
        $this->loader->add_action(
            'furgonetka_daily_event',
            $this->plugin_admin,
            'furgonetka_refresh_token'
        );
        $this->loader->add_filter(
            'plugin_action_links_furgonetka/furgonetka.php',
            $this->plugin_admin,
            'plugin_action_links'
        );
        $this->loader->add_filter(
            'manage_edit-shop_order_columns',
            $this->metaboxes,
            'extra_order_column'
        );
        $this->loader->add_filter(
            'manage_shop_order_posts_custom_column',
            $this->metaboxes,
            'extra_order_column_content'
        );
        $this->loader->add_filter(
            'manage_woocommerce_page_wc-orders_columns',
            $this->metaboxes,
            'extra_order_column'
        );
        $this->loader->add_action(
            'manage_woocommerce_page_wc-orders_custom_column',
            $this->metaboxes,
            'extra_order_column_content',
            10,
            2
        );
        $this->loader->add_action(
            'wp_ajax_furgonetka_fast_shipping_init',
            $this->plugin_admin,
            'furgonetka_fast_shipping_init'
        );
        $this->loader->add_action(
            'wp_ajax_furgonetka_invoices_init',
            $this->plugin_admin,
            'furgonetka_invoices_init'
        );
        $this->loader->add_action(
            'wp_ajax_furgonetka_connect_integration',
            $this->plugin_admin,
            'furgonetka_connect_integration'
        );
        $this->loader->add_filter(
            'woocommerce_admin_billing_fields',
            $this->metaboxes,
            'add_tax_id_field_to_order_details',
            1,
            2
        );

        // Init returns route.
        $this->returns->init();

        /**
         * Define related hooks
         */
        Furgonetka_Rest_Api_Permissions::define_hooks();
        Furgonetka_Capabilities::define_hooks();
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     */
    private function define_public_hooks()
    {
        $this->plugin_public = new Furgonetka_Public( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action(
            'wp_enqueue_scripts',
            $this->plugin_public,
            'enqueue_styles'
        );
        $this->loader->add_action(
            'wp_enqueue_scripts',
            $this->plugin_public,
            'enqueue_scripts'
        );
        $this->loader->add_action(
            'woocommerce_review_order_before_submit',
            $this->plugin_public,
            'furgonetka_totals_after_shipping'
        );
        $this->loader->add_action(
            'woocommerce_after_shipping_rate',
            $this->plugin_public,
            'after_shipping_rate',
            10,
            2
        );
        $this->loader->add_action(
            'wp_ajax_nopriv_savePoint',
            $this->plugin_public,
            'save_point_to_session'
        );
        $this->loader->add_action(
            'wp_ajax_savePoint',
            $this->plugin_public,
            'save_point_to_session'
        );
        $this->loader->add_action(
            'wp_ajax_nopriv_getPointToPayment',
            $this->plugin_public,
            'get_point_to_payment'
        );
        $this->loader->add_action(
            'wp_ajax_getPointToPayment',
            $this->plugin_public,
            'get_point_to_payment'
        );
        $this->loader->add_action(
            'wp_ajax_portmonetka_clear_cart',
            $this->plugin_public,
            'clear_cart'
        );
        $this->loader->add_action(
            'wp_ajax_nopriv_portmonetka_clear_cart',
            $this->plugin_public,
            'clear_cart'
        );
        $this->loader->add_action(
            'woocommerce_checkout_create_order',
            $this->plugin_public,
            'save_point_to_order',
            20,
            2
        );
        $this->loader->add_action(
            'woocommerce_checkout_process',
            $this->plugin_public,
            'woocommerce_checkout_process',
            20,
            2
        );
        $this->loader->add_action(
            'woocommerce_order_details_after_order_table',
            $this->plugin_public,
            'add_order_information',
            20
        );
        $this->loader->add_action(
            'woocommerce_email_order_meta',
            $this->plugin_public,
            'add_point_information',
            20
        );

        if ( $this->plugin_admin::is_checkout_active() && $this->plugin_admin::get_portmonetka_replace_native_checkout() ) {
            $callback = [ $this->plugin_public, 'woocommerce_get_checkout_url_filter' ];

            $this->loader->add_filter(
                'woocommerce_get_checkout_url',
                $callback[0],
                $callback[1]
            );
        }

        $this->blocks = new Furgonetka_Blocks( $this->loader, $this->plugin_public, $this->plugin_admin );
        $this->blocks->init();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since  1.0.0
     * @return string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since  1.0.0
     * @return Furgonetka_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since  1.0.0
     * @return string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
