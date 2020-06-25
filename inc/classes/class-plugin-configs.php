<?php
/**
 * To load all classes of third party plugin configuration.
 *
 * @package wp-mentions-links
 */

namespace WP_Mentions_Links\Inc;

use WP_Mentions_Links\Inc\Traits\Singleton;
use WP_Mentions_Links\Inc\Plugin_Configs\Plugin_Settings;

/**
 * Class Plugin_Configs
 */
class Plugin_Configs {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Load all plugin configs classes.
		Plugin_Settings::get_instance();

	}
}
