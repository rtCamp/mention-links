<?php
/**
 * Plugin Name: Mention Links
 * Description: Gutenberg autocomplete for posts and users. Type <code>@</code> to link to an author or <code>#</code> to link to a post, page, or custom post type.
 * Plugin URI:  https://github.com/rtCamp/mention-links
 * Author:      rtCamp
 * Author URI:  https://rtcamp.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0.4
 * Text Domain: mention-links
 *
 * @package wp-mention-links
 */

define( 'MENTION_LINKS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'MENTION_LINKS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

// phpcs:disable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once MENTION_LINKS_PATH . '/inc/helpers/autoloader.php';
// phpcs:enable WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

// Defining settings constants.
define( 'MENTION_LINKS_PLUGIN_SLUG', 'wp-mention-links' );
define( 'MENTION_LINKS_FIELD_SETTING_NAME', 'wpml_user_field_to_use' );
define( 'MENTION_LINKS_ENABLED_CPTS_SETTING_NAME', 'wpml_enabled_cpts' );

/**
 * Link to settings page from plugins screen.
 *
 * @param array $links Array of links.
 *
 * @return array Modified array of links.
 */
function wp_mentions_links_plugin_action_links( $links ) {
	$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'options-general.php?page=' . MENTION_LINKS_PLUGIN_SLUG ) ), __( 'Settings', 'mention-links' ) );

	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wp_mentions_links_plugin_action_links' );

/**
 * To load plugin manifest class.
 *
 * @return void
 */
function wp_mentions_links_plugin_loader() {
	\Mention_Links\Inc\Plugin::get_instance();
}

wp_mentions_links_plugin_loader();
