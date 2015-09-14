<?php

/**
 * Base class for plugin
 */
class WP_Block_Admin_Login_Core {

    private static $instance = null;
    public $options;
    public $option_name = 'wp_block_admin_settings';
    protected $test_mode = true;

    /**
     * Constructor function, adds hooks for WP integration
     */
    public function __construct() {

        $this->options = get_option( $this->option_name );

        add_action( 'wp_authenticate', array( $this, 'check_login' ) );

    }

    public function check_login( $username ) {

        if ( empty( $username ) ) {
            return;
        }

        $block_user   = false;
        $who_to_block = WP_Block_Admin_Login_Settings::instance()->get_option( 'who_to_block' );
        if ( empty( $who_to_block ) ) {
            $who_to_block = 'admin';
        }
        $redirect_to = WP_Block_Admin_Login_Settings::instance()->get_option( 'redirect_to' );
        if ( empty( $redirect_to ) ) {
            $redirect_to = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        }

        $blocked_users = apply_filters( 'wpbal_blocked_users', array( 'admin' ) );

        if ( 'admin' == $who_to_block && in_array( $username, $blocked_users ) ) {
            $block_user = true;
        } elseif ( 'everyone' == $who_to_block ) {
            $usernames = array();
            foreach ( get_users() as $user ) {
                $usernames[] = $user->data->user_login;
            }

            if ( ! in_array( $username, $usernames ) ) {
                $block_user = true;
            }
        }

        if ( true == $block_user ) {
            header( 'Location: ' . esc_url( $redirect_to ), 301 );
            exit();
        }
    }


    /**
     * @return null
     */
    public static function instance() {

        # Check if we already have an instance alive
        if ( ! isset( static::$instance ) ) {
            static::$instance = new static;
        }

        return static::$instance;
    }

}

?>