<?php
/**
 * Declares a class which adds custom settings page under default Setting page in wp-admin.
 *
 * @package wp-mentions-links
 */

namespace WP_Mentions_Links\Inc\Plugin_Configs;

use WP_Mentions_Links\Inc\Traits\Singleton;

/**
 * Class Plugin_Settings
 * Adds a settings page for this plugin inside default Settings page.
 */
class Plugin_Settings {

	use Singleton;

	/**
	 * Default supported post types.
	 *
	 * @var array
	 */
	private $default_supported_post_types = array( 
		'post' => 1,
		'page' => 1,
	);

	/**
	 * Construct method.
	 */
	protected function __construct() {

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

	}

	/**
	 * Hooked to admin_menu action.
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_submenu_page(
			'options-general.php',
			'WP Mentions Links Settings',
			'WP Mentions Links',
			'manage_options',
			WP_MENTIONS_LINKS_PLUGIN_SLUG,
			[ $this, 'settings_page_html' ]
		);
	}

	/**
	 * Callback for WP Mentions Links Settings page.
	 *
	 * @return void
	 */
	public function settings_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$settings_updated = filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_STRING );
		if ( ! empty( $settings_updated ) ) {
			add_settings_error( 'wpml_messages', 'wpml_messages', __( 'Settings Saved', 'wp-mentions-links' ), 'updated' );
		}

		settings_errors( 'wpml_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( WP_MENTIONS_LINKS_PLUGIN_SLUG );
				do_settings_sections( WP_MENTIONS_LINKS_PLUGIN_SLUG );
				submit_button( __( 'Save Settings', 'wp-mentions-links' ) );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Hooked to admin_init action. Defines settings section and fields.
	 *
	 * @return void
	 */
	public function admin_init() {
		add_settings_section(
			'wpml_setting_section',
			'',
			[ $this, 'wpml_setting_section_cb' ],
			WP_MENTIONS_LINKS_PLUGIN_SLUG
		);
	
		register_setting( WP_MENTIONS_LINKS_PLUGIN_SLUG, WP_MENTIONS_LINKS_FIELD_SETTING_NAME );
		add_settings_field(
			WP_MENTIONS_LINKS_FIELD_SETTING_NAME,
			__( 'Display username or display-name', 'wp-mentions-links' ),
			[ $this, 'field_setting_cb' ],
			WP_MENTIONS_LINKS_PLUGIN_SLUG,
			'wpml_setting_section'
		);

		register_setting( WP_MENTIONS_LINKS_PLUGIN_SLUG, WP_MENTIONS_LINKS_ENABLED_CPTS_SETTING_NAME );
		add_settings_field(
			WP_MENTIONS_LINKS_ENABLED_CPTS_SETTING_NAME,
			__( 'Custom Post Types support', 'wp-mentions-links' ),
			[ $this, 'enabled_cpts_setting_cb' ],
			WP_MENTIONS_LINKS_PLUGIN_SLUG,
			'wpml_setting_section'
		);
	}

	/**
	 * Callback for wpml_setting_section section.
	 *
	 * @param Array $args Arguments passed while registering section.
	 *
	 * @return void
	 */
	public function wpml_setting_section_cb( $args ) {}

	/**
	 * Callback for wpml_user_field_to_use section.
	 *
	 * @param Array $args Arguments passed while registering section.
	 *
	 * @return void
	 */
	public function field_setting_cb( $args ) {
		$option = get_option( WP_MENTIONS_LINKS_FIELD_SETTING_NAME );
		?>
		<select id="<?php echo esc_attr( WP_MENTIONS_LINKS_FIELD_SETTING_NAME ); ?>" name="<?php echo esc_attr( WP_MENTIONS_LINKS_FIELD_SETTING_NAME ); ?>">
			<option value="displayname" <?php ( selected( $option, 'displayname' ) ); ?>><?php esc_html_e( 'Display Name', 'wp-mentions-links' ); ?></option>
			<option value="username" <?php ( selected( $option, 'username' ) ); ?>><?php esc_html_e( 'Username', 'wp-mentions-links' ); ?></option>
		</select>
		<p class="description">
			<?php esc_html_e( 'Whether to show user\'s display-name or username while mentioning them.' ); ?>
		</p>
		<?php
	}

	/**
	 * Callback for enabled_cpts_setting field.
	 *
	 * @param Array $args Arguments passed while registering section.
	 *
	 * @return void
	 */
	public function enabled_cpts_setting_cb( $args ) {
		$option = get_option( WP_MENTIONS_LINKS_ENABLED_CPTS_SETTING_NAME );
		// Convert options array in key => value to increase performance.
		if ( ! empty( $option ) && is_array( $option ) ) {
			$array = $option;
			foreach ( $array as $cpt ) {
				$option[ $cpt ] = 1;
			}
		}

		$get_post_types_args = array(
			'public'       => true,
			'show_in_rest' => true,
		);

		$is_first   = true;
		$post_types = get_post_types( $get_post_types_args, 'objects' );
		foreach ( $post_types as $key => $post_type ) {
			// The mentions are going to use rest API eventually, so we won't show CPTs which doesn't have rest_base.
			if ( empty( $post_type->rest_base ) ) {
				continue;
			}

			$checked = '';
			// Check if option value is already saved and current post type exists in the value array.
			// Else check if option value is not already saved and check default supported post types.
			if ( ! empty( $option[ $post_type->rest_base ] ) || ( ! is_array( $option ) && ! empty( $this->default_supported_post_types[ $post_type->name ] ) ) ) {
				$checked = 'checked';
			}

			if ( true === $is_first ) {
				?>
				<ul style="list-style-type: none;">
				<?php
				$is_first = false;
			}
			?>
			<li>
				<label for="<?php echo esc_attr( $post_type->rest_base ); ?>_checkbox">
					<input name="<?php echo esc_attr( WP_MENTIONS_LINKS_ENABLED_CPTS_SETTING_NAME ); ?>[]" type="checkbox" id="<?php echo esc_attr( $post_type->rest_base ); ?>_checkbox" value="<?php echo esc_attr( $post_type->rest_base ); ?>" <?php echo esc_attr( $checked ); ?>>
					<?php echo esc_html( $post_type->label ); ?>
				</label>
			</li>
			<?php
		}

		if ( false === $is_first ) {
			?>
			</ul>
			<?php
		}

		?>
		<p class="description">
			<?php esc_html_e( 'If a post type doesn\'t support REST API, then it won\'t be displayed here.' ); ?>
		</p>
		<?php
	}
}
