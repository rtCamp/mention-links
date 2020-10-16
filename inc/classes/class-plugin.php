<?php
/**
 * Plugin manifest class.
 *
 * @package wp-mention-links
 */

namespace Mention_Links\Inc;

use \Mention_Links\Inc\Traits\Singleton;

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
