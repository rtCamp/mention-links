<?php
/**
 * Declares a class which adds custom settings page under default Setting page in wp-admin.
 *
 * @package wp-mention-links
 */

namespace Mention_Links\Inc\Plugin_Configs;

use Mention_Links\Inc\Traits\Singleton;

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
		add_action( 'admin_notices', [ $this, 'admin_notices' ] );

	}

	/**
	 * Show notice after Mention Link option are saved.
	 */
	public function admin_notices() {

		global $current_screen;

		if ( ! empty( $current_screen ) && 'settings_page_wp-mention-links' === $current_screen->id ) {

			$option = get_option( MENTION_LINKS_ENABLED_CPTS_SETTING_NAME );

			if ( empty( $option ) && 'true' === filter_input( INPUT_GET, 'settings-updated', FILTER_SANITIZE_FULL_SPECIAL_CHARS ) ) {
				add_settings_error( MENTION_LINKS_ENABLED_CPTS_SETTING_NAME, 'blank_settings_updated', __( 'If no options for Custom Post Types support is selected, Posts and Pages will be used for Mention Links.', 'mention-links' ), 'notice' );
			}
		}
	}

	/**
	 * Hooked to admin_menu action.
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_submenu_page(
			'options-general.php',
			'Mention Links Settings',
			'Mention Links',
			'manage_options',
			MENTION_LINKS_PLUGIN_SLUG,
			[ $this, 'settings_page_html' ]
		);
	}

	/**
	 * Callback for Mention Links Settings page.
	 *
	 * @return void
	 */
	public function settings_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( MENTION_LINKS_PLUGIN_SLUG );
				do_settings_sections( MENTION_LINKS_PLUGIN_SLUG );
				submit_button( __( 'Save Settings', 'mention-links' ) );
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
			MENTION_LINKS_PLUGIN_SLUG
		);

		register_setting( MENTION_LINKS_PLUGIN_SLUG, MENTION_LINKS_FIELD_SETTING_NAME );
		add_settings_field(
			MENTION_LINKS_FIELD_SETTING_NAME,
			__( 'Display username or display-name', 'mention-links' ),
			[ $this, 'field_setting_cb' ],
			MENTION_LINKS_PLUGIN_SLUG,
			'wpml_setting_section',
			[ 'label_for' => MENTION_LINKS_FIELD_SETTING_NAME ]
		);

		register_setting( MENTION_LINKS_PLUGIN_SLUG, MENTION_LINKS_ENABLED_CPTS_SETTING_NAME );
		add_settings_field(
			MENTION_LINKS_ENABLED_CPTS_SETTING_NAME,
			__( 'Custom Post Types support', 'mention-links' ),
			[ $this, 'enabled_cpts_setting_cb' ],
			MENTION_LINKS_PLUGIN_SLUG,
			'wpml_setting_section',
			[ 'label_for' => MENTION_LINKS_ENABLED_CPTS_SETTING_NAME ]
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
		$option = get_option( MENTION_LINKS_FIELD_SETTING_NAME );
		?>
		<select id="<?php echo esc_attr( MENTION_LINKS_FIELD_SETTING_NAME ); ?>" name="<?php echo esc_attr( MENTION_LINKS_FIELD_SETTING_NAME ); ?>">
			<option value="displayname" <?php ( selected( $option, 'displayname' ) ); ?>><?php esc_html_e( 'Display Name', 'mention-links' ); ?></option>
			<option value="username" <?php ( selected( $option, 'username' ) ); ?>><?php esc_html_e( 'Username', 'mention-links' ); ?></option>
		</select>
		<p class="description">
			<?php esc_html_e( 'Whether to show user\'s display-name or username while mentioning them.', 'mention-links' ); ?>
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

		$option = get_option( MENTION_LINKS_ENABLED_CPTS_SETTING_NAME );

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
			if ( 'attachment' === $key ) {
				continue;
			}

			$rest_base = $post_type->name;
			// The mentions are going to use rest API eventually, so we won't show CPTs which doesn't have rest_base.
			if ( ! empty( $post_type->rest_base ) ) {
				$rest_base = $post_type->rest_base;
			}

			$checked = '';

			// Check if option value is already saved and current post type exists in the value array.
			// Else check if option value is not already saved and check default supported post types.
			if ( ! empty( $option[ $rest_base ] ) || ( ! is_array( $option ) && ! empty( $this->default_supported_post_types[ $post_type->name ] ) ) ) {
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
				<label for="<?php echo esc_attr( $rest_base ); ?>_checkbox">
					<input name="<?php echo esc_attr( MENTION_LINKS_ENABLED_CPTS_SETTING_NAME ); ?>[]" type="checkbox" id="<?php echo esc_attr( $rest_base ); ?>_checkbox" value="<?php echo esc_attr( $rest_base ); ?>" <?php echo esc_attr( $checked ); ?>>
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
			<?php esc_html_e( 'If a post type doesn\'t support REST API, then it won\'t be displayed here.', 'mention-links' ); ?>
		</p>
		<?php
	}
}
