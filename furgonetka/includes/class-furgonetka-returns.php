<?php

/**
 * Manage registering custom return route
 *
 * @link  https://furgonetka.pl
 * @since 1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 */

/**
 * Class Furgonetka_Returns - Manage registering custom return route
 *
 * @since      1.0.0
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Returns
{
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        if ( get_option( Furgonetka_Options::OPTION_RETURNS_ACTIVE ) ) {
            add_action( 'init', array( $this, 'add_rewrite_route' ) );
            add_action( 'parse_request', array( $this, 'redirect' ) );
        }
    }

    /**
     * Redirect to url assign to option
     *
     * @return void
     */
    public function redirect(): void
    {
        global $wp;
        if ( get_option( Furgonetka_Options::OPTION_RETURNS_ROUTE ) === $wp->request ) {
            header( 'Location: ' . get_option( Furgonetka_Options::OPTION_RETURNS_TARGET ) );
            exit();
        }
    }

    /**
     * Check if route exist
     *
     * @param  string $route_name - route name.
     * @return boolean
     */
    public function check_if_route_exists( $route_name ): bool
    {
        $rules = get_option( 'rewrite_rules' );
        $regex = "\b{$route_name}\b";

        if ( ! isset( $rules[ $regex ] ) && ! is_page( $route_name ) ) {
            return false;
        }
        return true;
    }

    /**
     * Add rewrite rules, flush rewrite rules
     *
     * @return void
     */
    public function add_rewrite_route()
    {
        add_rewrite_rule( '\b' . get_option( Furgonetka_Options::OPTION_RETURNS_ROUTE ) . '\b', 'index.php', 'top' );
        flush_rewrite_rules();
    }
}
