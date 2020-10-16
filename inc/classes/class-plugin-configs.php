<?php
/**
 * To load all classes of third party plugin configuration.
 *
 * @package wp-mention-links
 */

namespace Mention_Links\Inc;

use Mention_Links\Inc\Traits\Singleton;
use Mention_Links\Inc\Plugin_Configs\Plugin_Settings;

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
