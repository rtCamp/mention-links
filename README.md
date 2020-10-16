<p align="center">
<a href="https://rtcamp.com/?ref=wp-mention-links-repo" target="_blank"><img width="200"src="https://rtcamp.com/wp-content/themes/rtcamp-v9/assets/img/site-logo-black.svg"></a>
</p>

# Mention Links
[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/latest/active.svg)](https://www.repostatus.org/#active)

This plugin lets you mention a user or a post (including Custom Post Types) in a post content from the Block editor.

**Author:** rtCamp

**Contributors:** rtcamp, sid177, dharmin

**Tags:** Mentions, User mentions, Post mentions, Custom post types mentions, CPT mentions

**Requires at least:** 5.0

**Tested up to:** 5.5

**Requires PHP version:** 7.0

**Stable tag:** 1.0

**License:** GPLv2 or later (of course!)

**License URI:** http://www.gnu.org/licenses/gpl-2.0.html

## Description ##
While writing contents from the Block editor, type `@` to get suggestions of users. On selecting a user it'll create a link to authors page of that user.  
To mention a post, type `#` and it'll give you the list of all matching posts. On selecting a post it'll create a link to the single post page.

### Screenshots ###

Plugin features:

![Plugin features](/assets/screenshot-1.gif?raw=true)

Settings page (wp-admin -> Settings -> Mention Links):

![Settings page](/assets/screenshot-2.png?raw=true)

### Settings ###
This plugins adds a settings page under Settings -> Mention Links.
1. **Display username or display-name:** This setting allows you choose whether to show user's display-name or username when mentioning a user in a post.
2. **Custom Post Types support:** Checking post types here will give you suggestions of posts from these post types.

**Note:** The posts suggestion list is retrieved from the WordPress' REST API, so if a particular post type doesn't support REST API then you might not see it in **Custom Post Types support** setting.

## Installation ##

1. Extract the zip file.
2. Upload it to the `/wp-content/plugins/` directory in your WordPress installation.
3. Activate the Mention Links from your Plugins page.

## Contribute

### Reporting a bug 🐞

Before creating a new issue, do browse through the [existing issues](https://github.com/rtCamp/wp-mention-links/issues) for resolution or upcoming fixes. 

If you still need to [log an issue](https://github.com/rtCamp/wp-mention-links/issues/new), making sure to include as much detail as you can, including clear steps to reproduce your issue if possible.

### Creating a pull request

Want to contribute a new feature? Start a conversation by logging an [issue](https://github.com/rtCamp/wp-mention-links/issues).

Once you're ready to send a pull request, please run through the following checklist: 

1. Browse through the [existing issues](https://github.com/rtCamp/wp-mention-links/issues) for anything related to what you want to work on. If you don't find any related issues, open a new one.

1. Fork this repository.

1. Create a branch from `develop` for each issue you'd like to address and commit your changes.

1. Push the code changes from your local clone to your fork.

1. Open a pull request and that's it! We'll with feedback as soon as possible (Isn't collaboration a great thing? 😌)

1. Once your pull request has passed final code review and tests, it will be merged into `develop` and be in the pipeline for the next release. Props to you! 🎉


# BTW, We're Hiring!

<a href="https://rtcamp.com/"><img src="https://rtcamp.com/wp-content/uploads/2019/04/github-banner@2x.png" alt="Join us at rtCamp, we specialize in providing high performance enterprise WordPress solutions"></a>
