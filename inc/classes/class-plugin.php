<?php
/**
 * Plugin manifest class.
 *
 * @package wp-mentions-links
 */

namespace WP_Mentions_Links\Inc;

use \WP_Mentions_Links\Inc\Traits\Singleton;

/**
 * Class Plugin
 */
class Plugin {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load plugin classes.
		Assets::get_instance();
		Plugin_Configs::get_instance();

	}

}
