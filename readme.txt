=== Publishing Conditions ===
Contributors: maurobringolf
Tags: publishing, blogging, writing, checklist, conditions, verification, workflow
Requires at least: 3.0
Tested up to: 4.8.2
Requires PHP: 5.3
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Prevent yourself from publishing unfinished posts.

== Description ==

This plugin helps enforcing a set of conditions before posts can be published. You can basically integrate your pre-publish checklist into WordPress itself! The following conditions are currently supported:

* The post is not 'Uncategorized'
* The post has at least one tag

If you need more conditions or have other suggestions for improvement, let me know! The best place to do so is via an issue on [GitHub](https://github.com/maurobringolf/publishing-conditions).

== Usage ==

If a post does not meet your publishing conditions and you try to publish anyway, **it will be set to draft instead**. You can customize your publishing conditions under **Settings->Writing**. That is all there is to it!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/publishing-conditions` directory, or install the plugin through the WordPress plugins screen directly.

1. Activate the plugin through the **Plugins** area in WordPress.

1. Choose your publishing conditions under **Settings->Writing**.

== Changelog ==

= v1.0.2 =

**Backend**

* Show message when publishing conditions are not met.

**Internal**

* Improved settings title and updated translations.

= v1.0.1 =

**Documentation**

* Improve wording in various places.

**Internal**

* Remove `circle.yml` from archives properly.
* Basic internationalization setup and german translations.

= v1.0.0 =

* Initial version
