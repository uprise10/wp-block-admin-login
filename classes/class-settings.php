<?php

class WP_Block_Admin_Login_Settings {
	private static $instance = null;
	protected $option_name = 'wp_block_admin_settings';
	protected $options = null;


	public function __construct() {
		// Load options
		$this->options = WP_Block_Admin_Login_Core::instance()->options;

		// Initialize theme options when in WP admin
		add_action( 'admin_menu', array( $this, 'add_settings_page' ) );

		// Initialize general theme settings
		add_action( 'admin_init', array( $this, 'init_settings' ) );
	}

	/**
	 * add_settings_page - Adds Generates the settings page for the theme, with hooks for plugins to add their settings sections
	 */
	public function add_settings_page() {

		add_options_page(
			__( 'Block user logins', 'block-user-login' ),
			__( 'Block user logins', 'block-user-login' ),
			'manage_options',
			'block-login-settings.php',
			array(
				$this,
				'settings_page'
			)
		);

	}

	/**
	 * Draw the content of the settings page in WP admin
	 */
	public function settings_page() {
		?>

		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2><?php _e( 'Block user logins settings', 'block-user-login' ) ?></h2>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">

				<?php do_action( "block_login_display_settings_sections" ); ?>

				<?php submit_button(); ?>
			</form>

		</div>

		<?php
	}


	/**
	 * Initiates the settings section
	 */
	public function init_settings() {

		add_action( 'block_login_display_settings_sections', function () {
			settings_fields( 'block_login_general_settings' );
			do_settings_sections( 'block_login_general_settings' );

		} );

		# Register all these settings to the right option
		register_setting( 'block_login_general_settings', $this->option_name );

		# Initiate the section for our settings
		add_settings_section(
			$this->option_name,
			__( 'General settings', 'block-user-login' ),
			function () {
				echo '<p class="description">' . __( 'With this plugin you can directly block login attempts and redirect these attempts to just annoy them. It is our strong belief that Rickrolling will help that cause.', 'block-user-login' ) . '</p>';
			},
			'block_login_general_settings'
		);

		// Add all settings fields
		$this->add_settings_fields();

		do_action( 'block_login_general_settings_sections' );
	}

	/**
	 * add_settings_fields - Add the fields to the settings section initiated in init_settings
	 */
	public function add_settings_fields() {

		// General setting fields

		$this->add_field( 'radio', 'who_to_block', __( 'Who to block?', 'block-user-login' ), 'block_login_general_settings', array(
			'values' => array(
				'admin' => __( '"admin" user only', 'block-user-login' ),
				'everyone' => __( 'Everyone, but the current users on this website', 'block-user-login' ),
			)
		) );

		$this->add_field( 'text', 'redirect_to', __( 'After block redirect user to', 'block-user-login' ), 'block_login_general_settings', array(
			'placeholder' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
			'description' => __( 'By default the blocked user will be Rickrolled. Of course.', 'block-user-login' )
		) );

	}

	/**
	 * @param        $type
	 * @param        $key
	 * @param        $label
	 * @param string $settings_field
	 * @param array  $args
	 */
	public function add_field( $type, $key, $label, $settings_field = 'block_login_general_settings', $args = array() ) {
		$args = wp_parse_args( (array) $args, array(
			'id'          => $key,
			'option_name' => $this->option_name
		) );

		add_settings_field( $key, $label, array( $this, $type ), $settings_field, $this->option_name, $args );
	}

	/**
	 * Get the value from an option
	 *
	 * @param string $option      Name of the value in the option. When option_name is given it will get the key from the option_name array
	 * @param string $option_name of option_key.
	 *
	 * @return bool|mixed
	 * @internal param string $val name of the value in the option. When option_name is given it will get the key from the option_name array
	 */
	function get_option( $option, $option_name = null ) {
		if ( null == $option_name ) {
			$option_name = $this->option_name;
		}

		if ( $option_name != '' ) {
			$options       = get_option( $option_name );
			$return_option = ! empty( $options[ $option ] ) ? maybe_unserialize( $options[ $option ] ) : false;
		} else {
			$return_option = maybe_unserialize( get_option( $option ) );
		}

		return $return_option;
	}

	/**
	 * @param $args
	 */
	public function text( $args ) {
		$value = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );
		$type  = isset( $args['type'] ) ? $args['type'] : 'text';

		echo WP_Block_Admin_Login_Forms::text( $args['option_name'] . '[' . $args['id'] . ']', $value, array(
			'id'   => $args['option_name'] . '-' . $args['id'],
			'type' => $type,
			'placeholder' => isset( $args['placeholder'] ) ? $args['placeholder'] : ''
		) );

		if ( ! empty( $args['description'] ) ) {
			echo '<br /><small>' . $args['description'] . '</small>';
		}
	}

	/**
	 * @param $args
	 */
	public function textarea( $args ) {
		$value  = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );
		$is_rte = ! empty( $args['rte'] ) && true == $args['rte'];

		if ( $is_rte ) {
			$args['id'] = ! empty( $args['id'] ) ? $args['id'] : '';
			$args['id'] .= '-' . $this->rte_counter;
			$this->rte_counter ++;
		}

		echo WP_Block_Admin_Login_Forms::textarea( $args['option_name'] . '[' . $args['id'] . ']', $value, array(
			'id'  => $args['id'],
			'rte' => $is_rte
		) );

		if ( ! empty( $args['description'] ) ) {
			echo '<br /><small>' . $args['description'] . '</small>';
		}
	}

	/**
	 * @param $args
	 */
	public function checkbox( $args ) {
		$value = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );

		echo WP_Block_Admin_Login_Forms::checkbox( $args['option_name'] . '[' . $args['id'] . ']', $value, array(
			'id' => $args['option_name'] . '-' . $args['id'],
		) );

		if ( ! empty( $args['description'] ) ) {
			echo ' <label for="' . $args['option_name'] . '-' . $args['id'] . '">' . $args['description'] . '</label>';
		}
	}

	/**
	 * @param $args
	 */
	public function file_upload( $args ) {
		$value = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );

		echo WP_Block_Admin_Login_Forms::upload( $args['option_name'] . '[' . $args['id'] . ']', $value, array(
			'id' => $args['option_name'] . '-' . $args['id'],
		) );

	}

	/**
	 * @param $args
	 */
	public function radio( $args ) {
		$value = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );

		echo WP_Block_Admin_Login_Forms::radio( $args['option_name'] . '[' . $args['id'] . ']', $value, $args['values'], array(
			'id' => $args['option_name'] . '-' . $args['id'],
		) );

		if ( ! empty( $args['description'] ) ) {
			echo '<br /><small>' . $args['description'] . '</small>';
		}
	}

	/**
	 * @param $args
	 */
	public function select( $args ) {
		$value = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );

		echo WP_Block_Admin_Login_Forms::select( $args['option_name'] . '[' . $args['id'] . ']', $value, $args['values'], array(
			'id' => $args['option_name'] . '-' . $args['id'],
		) );

		if ( ! empty( $args['description'] ) ) {
			echo '<br /><small>' . $args['description'] . '</small>';
		}
	}

	public function pageselect( $args ) {
		$value = WP_Block_Admin_Login_Settings::instance()->get_option( $args['id'], $args['option_name'] );

		echo WP_Block_Admin_Login_Forms::page_select( $args['option_name'] . '[' . $args['id'] . ']', $value, $args['values'], array(
			'id' => $args['option_name'] . '-' . $args['id'],
		) );

		if ( ! empty( $args['description'] ) ) {
			echo '<br /><small>' . $args['description'] . '</small>';
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