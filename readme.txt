=== Mention Links ===
Contributors: rtcamp, sid177, dharmin, vaishu.agola27, pavanpatil1, mukulsingh27
Tags: Mentions, User mentions, Post mentions, Custom post types mentions, CPT mentions
Requires at least: 5.0
Tested up to: 6.4.1
Requires PHP: 7.0
Stable tag: 1.0.4
License: GPLv2 or later (of course!)
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin lets you mention a user or a post (including Custom Post Types) in post content from the block editor. Type `@` to link to an author or `#` to link to a post, page, or custom post type.

== Description ==

While writing contents from the block editor, type `@` to get suggestions of users. On selecting a user it will create a link to authors page of that user.  
To mention a post, type `#` and it will give you the list of all matching posts. On selecting a post it will create a link to the single post page.

= Settings =
This plugins adds a settings page under **Settings -> Mention Links**.

1. **Display username or display-name:** This setting allows you choose whether to show user's display-name or username when mentioning a user in a post.
2. **Custom Post Types support:** Checking post types here will give you suggestions of posts from these post types.

**Note:** The posts suggestion list is retrieved from the WordPress REST API, so if a particular post type doesn't support REST API then you might not see it in **Custom Post Types support** setting.

= BTW, We're Hiring! =

[Join us at rtCamp, we specialize in providing high performance enterprise WordPress solutions](https://rtcamp.com/?ref=mention-links-repo)

== Installation ==

1.  Extract the zip file.
2.  Upload it to the `/wp-content/plugins/` directory in your WordPress installation.
3.  Activate the Mention Links from your Plugins page.

== Frequently Asked Questions ==
 
= Reporting a bug 🐞 =
 
Before creating a new issue, do browse through the [existing issues](https://github.com/rtCamp/mention-links/issues) for resolution or upcoming fixes. 

If you still need to [log an issue](https://github.com/rtCamp/mention-links/issues/new), making sure to include as much detail as you can, including clear steps to reproduce the issue, if possible.
 
= Creating a pull request =
 
Want to contribute a new feature? Start a conversation by [logging an issue](https://github.com/rtCamp/mention-links/issues).

Once you're ready to send a pull request, please run through the following checklist: 

1. Browse through the [existing issues](https://github.com/rtCamp/mention-links/issues) for anything related to what you want to work on. If you don't find any related issues, open a new one.

2. Fork this repository.

3. Create a branch from `develop` for each issue you'd like to address and commit your changes.

4. Push the code changes from your local clone to your fork.

5. Open a pull request and that's it! We'll respond with feedback as soon as possible (Isn't collaboration a great thing? 😌)

6. Once your pull request has passed final code review and tests, it will be merged into `develop` and be in the pipeline for the next release. Props to you! 🎉


== Screenshots ==

1. Plugin features
2. Settings page

== Important Links ==

* [GitHub](https://github.com/rtCamp/mention-links) - Please mention your wordpress.org username when sending pull requests.

== License ==

Same [GPL](http://www.gnu.org/licenses/gpl-2.0.txt) that WordPress uses!

== Changelog ==

= 1.0.4 =
* Compatible with the latest WordPress 6.4.1
* Added PHP 8.1 compatibility.

= 1.0.3 =
* Update Text Domain.

= 1.0.2 =
* Display notice when Custom Post Types support option are not selected.

= 1.0.1 =
* Initial release

== Upgrade Notice ==
 
= 1.0.4 =
Mention Link 1.0.4 with PHP 8.1 Compatibility.
