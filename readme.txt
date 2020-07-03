=== WP Mentions Links ===
Contributors: rtcamp, sid177, dharmin
Tags: Mentions, User mentions, Post mentions, Custom post types mentions, CPT mentions
Requires at least: 5.0
Tested up to: 5.4.2
Requires PHP: 7.0
Stable tag: 1.0
License: GPLv2 or later (of course!)
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin lets you mention a user or a post (including Custom Post Types) in a post content from the Block editor.

== Description ==

While writing contents from the Block editor, type `@` to get suggestions of users. On selecting a user it'll create a link to authors page of that user.  
To mention a post, type `#` and it'll give you the list of all matching posts. On selecting a post it'll create a link to the single post page.

== Settings ==
This plugins adds a settings page under Settings -> WP Mentions Links.

1. **Display username or display-name:** This setting allows you choose whether to show user's display-name or username when mentioning a user in a post.
2. **Custom Post Types support:** Checking post types here will give you suggestions of posts from these post types.

**Note:** The posts suggestion list is retrieved from the WordPress' REST API, so if a particular post type doesn't support REST API then you might not see it in **Custom Post Types support**.

== Installation ==

1.  Extract the zip file.
2.  Upload it to the `/wp-content/plugins/` directory in your WordPress installation.
3.  Activate the WP Mentions Links from your Plugins page.

== Screenshots ==

1. Plugin features
2. Settings page

== Important Links ==

* [GitHub](https://github.com/rtCamp/wp-mentions-links) - Please mention your wordpress.org username when sending pull requests.

== License ==

Same [GPL](http://www.gnu.org/licenses/gpl-2.0.txt) that WordPress uses!

== Changelog ==

= 1.0 =
* Initial release

== See room for improvement? ==

Great! There are several ways you can get involved to help make this plugin better:

1. **Report Bugs:** If you find a bug, error or other problem, please report it! You can do this by [creating a new topic](https://github.com/rtCamp/wp-mentions-links/issues) in the issue tracker.
2. **Suggest New Features:** Have an awesome idea? Please share it! Simply [create a new topic](https://github.com/rtCamp/wp-mentions-links/issues) in the issure tracker to express your thoughts on why the feature should be included and get a discussion going around your idea.
