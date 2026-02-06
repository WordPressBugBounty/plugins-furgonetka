<?php

class Furgonetka_Returns_Model
{
    public function save_rewrite_options( string $target, string $route, int $active ): bool
    {
        $success_target = update_option( Furgonetka_Options::OPTION_RETURNS_TARGET, sanitize_text_field( $target ) );
        $success_active = update_option( Furgonetka_Options::OPTION_RETURNS_ACTIVE, sanitize_text_field( $active ) );
        $success_route  = update_option( Furgonetka_Options::OPTION_RETURNS_ROUTE, sanitize_text_field( $route ) );

        return $success_target && $success_active && $success_route;
    }

    /**
     * @return void
     */
    public function delete_rewrite_options()
    {
        delete_option( Furgonetka_Options::OPTION_RETURNS_TARGET );
        delete_option( Furgonetka_Options::OPTION_RETURNS_ROUTE );
        delete_option( Furgonetka_Options::OPTION_RETURNS_ACTIVE );
    }

    public function get_rewrite_options(): array
    {
        $return = array();
        $return['target'] = get_option( Furgonetka_Options::OPTION_RETURNS_TARGET ) ?: '';
        $return['route'] = get_option( Furgonetka_Options::OPTION_RETURNS_ROUTE ) ?: '';
        $return['active'] = intval( get_option( Furgonetka_Options::OPTION_RETURNS_ACTIVE, 0 ) );

        return $return;
    }
}
