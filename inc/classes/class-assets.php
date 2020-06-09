<?php
/**
 * Assets class.
 *
 * @package wp-mentions-links
 */

namespace WP_Mentions_Links\Inc;

use WP_Mentions_Links\Inc\Traits\Singleton;

/**
 * Class Assets
 */
class Assets {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {
		$this->setup_hooks();
	}

	/**
	 * To setup action/filter.
	 *
	 * @return void
	 */
	protected function setup_hooks() {

		/**
		 * Action
		 */
		add_action( 'enqueue_block_editor_assets', [ $this, 'block_enqueue_scripts' ] );

	}

	/**
	 * To enqueue scripts and styles.
	 *
	 * @return void
	 */
	public function block_enqueue_scripts() {
		$time = time();
		$file = path_join( WP_MENTIONS_LINKS_PATH, 'assets/build/js/main.min.js' );
		if ( file_exists( $file ) ) {
			$time = filemtime( $file );
		}

		wp_enqueue_script(
			'wp-mentions-hook-js',
			WP_MENTIONS_LINKS_URL . '/assets/build/js/main.min.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			$time,
			true
		);
		$localize_data = array();

		$supported_cpts = get_option( WP_MENTIONS_LINKS_ENABLED_CPTS_SETTING_NAME );
		if ( ! empty( $supported_cpts ) && is_array( $supported_cpts ) ) {
			$localize_data['supportedCPTs'] = $supported_cpts;
		}
		
		$selected_field = get_option( WP_MENTIONS_LINKS_FIELD_SETTING_NAME );
		if ( ! empty( $selected_field ) ) {
			$localize_data['selectedUserField'] = $selected_field;
		}

		wp_localize_script( 'wp-mentions-hook-js', 'wpMentionsLinks', $localize_data );
	}
}
