<?php

/**
 * @since      1.5.0
 * @package    Furgonetka
 * @subpackage Furgonetka/includes
 * @author     Furgonetka.pl <woocommerce@furgonetka.pl>
 */
class Furgonetka_Capabilities
{
    /**
     * User role capabilities
     */
    const CAPABILITY_MANAGE_FURGONETKA = 'manage_furgonetka';

    /**
     * Check whether current user can manage plugin
     */
    public static function current_user_can_manage_furgonetka(): bool
    {
        return current_user_can( self::CAPABILITY_MANAGE_FURGONETKA );
    }

    /**
     * Define capabilities hooks
     *
     * @return void
     */
    public static function define_hooks()
    {
        /**
         * Define capabilities registration hooks for "Members" module
         *
         * This creates translated menu item for this module
         *
         * @see https://wordpress.org/plugins/members
         */
        add_action( 'members_register_cap_groups', array( self::class, 'members_register_cap_groups' ) );
        add_action( 'members_register_caps', array( self::class, 'members_register_caps' ) );
        add_filter( 'members_get_capabilities', array( self::class, 'members_get_capabilities' ) );

        /**
         * Define capabilities registration hooks for "User Role Editor" module
         *
         * @see https://wordpress.org/plugins/user-role-editor
         */
        add_filter( 'ure_capabilities_groups_tree', array( self::class, 'ure_capabilities_groups_tree' ) );
        add_filter( 'ure_custom_capability_groups', array( self::class, 'ure_custom_capability_groups' ), 10, 2 );
    }

    /**
     * Apply furgonetka capabilities when administrator does not have them
     *
     * @return void
     */
    public static function ensure_capabilities()
    {
        if ( ! self::can_administrator_role_manage_furgonetka() ) {
            self::add_furgonetka_capabilities_to_woocommerce_management_roles();
        }
    }

    /**
     * Check whether administrator role has "manage_furgonetka" capability
     */
    private static function can_administrator_role_manage_furgonetka(): bool
    {
        $wp_roles = self::get_wp_roles();

        if ( ! $wp_roles ) {
            return false;
        }

        $role_object = $wp_roles->get_role( 'administrator' );

        return $role_object && $role_object->has_cap( self::CAPABILITY_MANAGE_FURGONETKA );
    }

    /**
     * Add plugin management capabilities to all users currently permitted to manage WooCommerce
     *
     * @return void
     */
    private static function add_furgonetka_capabilities_to_woocommerce_management_roles()
    {
        $wp_roles = self::get_wp_roles();

        if ( ! $wp_roles ) {
            return;
        }

        /**
         * Get roles with "manage_woocommerce" capability
         */
        $roles = [];

        foreach ( array_keys( $wp_roles->get_names() ) as $role ) {
            $role_object = $wp_roles->get_role( $role );

            if ( $role_object && $role_object->has_cap( 'manage_woocommerce' ) ) {
                $roles[] = $role;
            }
        }

        /**
         * Add "manage_furgonetka" capability to those roles
         */
        foreach ( $roles as $role ) {
            $wp_roles->add_cap( $role, self::CAPABILITY_MANAGE_FURGONETKA );
        }
    }

    /**
     * "Members" plugin
     *
     * Action: register capabilities groups
     *
     * @return void
     */
    public static function members_register_cap_groups()
    {
        if ( function_exists( 'members_register_cap_group' ) ) {
            members_register_cap_group( 'furgonetka', array(
                    'label' => __( 'Furgonetka', 'furgonetka' ),
                    'caps' => array( self::CAPABILITY_MANAGE_FURGONETKA ),
                    'icon' => 'dashicons-admin-plugins'
                )
            );
        }
    }

    /**
     * "Members" plugin
     *
     * Action: register capabilities
     *
     * @return void
     */
    public static function members_register_caps()
    {
        if ( function_exists( 'members_register_cap' ) ) {
            members_register_cap( self::CAPABILITY_MANAGE_FURGONETKA, array(
                    'label' => __( 'Manage Furgonetka module', 'furgonetka' ),
                    'group' => 'furgonetka'
                )
            );
        }
    }

    /**
     * "Members" plugin
     *
     * Filter: register capabilities
     *
     * NOTE: This filter is also used by "User Role Editor" to show available capabilities
     *
     * @return mixed
     */
    public static function members_get_capabilities( $caps )
    {
        if ( is_array( $caps ) && ! in_array( self::CAPABILITY_MANAGE_FURGONETKA, $caps, true ) ) {
            $caps[] = self::CAPABILITY_MANAGE_FURGONETKA;
        }

        return $caps;
    }

    /**
     * "User Role Editor" plugin
     *
     * Filter: register capabilities groups tree
     *
     * @param array $groups
     * @return array
     */
    public static function ure_capabilities_groups_tree( $groups )
    {
        $groups[ 'furgonetka' ] = array(
            'caption' => __( 'Furgonetka', 'furgonetka' ),
            'parent' => 'custom',
            'level' => 2
        );

        return $groups;
    }

    /**
     * "User Role Editor" plugin
     *
     * Filter: register capabilities groups
     *
     * @param array $groups
     * @param string $cap_id
     * @return array
     */
    public static function ure_custom_capability_groups( $groups, $cap_id )
    {
        if ( $cap_id === self::CAPABILITY_MANAGE_FURGONETKA ) {
            $groups[] = 'custom';
            $groups[] = 'furgonetka';
        }

        return $groups;
    }

    /**
     * Get WP_Roles instance
     *
     * When user is not logged in, global $wp_roles is not initialized, then try to create new instance of WP_Roles
     *
     * @return WP_Roles|null
     */
    private static function get_wp_roles()
    {
        global $wp_roles;

        if ( ! class_exists( 'WP_Roles' ) ) {
            return null;
        }

        if ( ! isset( $wp_roles ) ) {
            return new WP_Roles();
        }

        return $wp_roles;
    }
}
