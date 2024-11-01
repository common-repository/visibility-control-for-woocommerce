=== Visibility Control for WooCommerce ===
Contributors: liveaspankaj
Donate link:
Tags: WooCommerce, ecommerce, online store, Hide, Hide Content, Hide Message, show, show messages
Requires at least: 4.0
Tested up to: 6.5.3
Stable tag: trunk
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Visibility Control for WooCommerce helps you hide or show messages, menu and content for specific criterion anywhere on your WordPress page.

== Description ==

Visibility Control for WooCommerce helps you hide or show messages, menu and content for specific criterion anywhere on your WordPress page.

You can show/hide HTML elements, menus, and other details based on:
1. User's purchase of a particular WooCommerce Product or Variation, Or
2. User is Logged In or Logged Out.

You simply need to add a CSS class to your element div or span. As explained here:

**Example:**

If Product or Variation ID is 123

* To show the element/menu item to user who purchased above product, add this CSS class: **visible_to_product_123**
* To hide the element/menu item from user who purchased above product, add this CSS class: **hidden_to_product_123**
* To show the element/menu item to a logged-in user, add this CSS class: **visible_to_logged_in** OR  **hidden_to_logged_out**
* To hide the element/menu item from a logged-in user, add this CSS class: **visible_to_logged_out** OR  **hidden_to_logged_in**

**For user’s role:**
* To show the element/menu item to a user will role administrator, add this CSS class: **visible_to_role_administrator** OR **hidden_to_role_administrator**
* Note: To show an element to multiple specific roles only, you need add the element multiple times, one for each role. To hide an element/menu from specific multiple roles only you can add the element once add multiple classes to the same element.

**Mechanism of Functioning**

* **Multiple CSS Classes:** If multiple visibility control classes are added, ALL of them must meet the criterion to keep the element visible. If any one of them hides the element, it will be hidden. For example: visible_to_product_123 visible_to_product_124 will show the element only to those who have purchased to both products.
* Hidden data/elements reaches the browser. Though user's do not see it.
* CSS is added to the page for all CSS elements that needs to be hidden based on above rules.
* After page is loaded. These elements are removed from page using jQuery (if available), so it won't be available even on Inspect.
* Elements rendered after the page load are hidden but not removed from DOM/page.

**Future Development**

Depending on the interest in this feature, we will decide on adding a setting, shortcode and/or a Gutenberg Block option to achieve this feature.

**Other Visibility Control Plugins:**

* [Visibility Control for LearnDash LMS](https://www.nextsoftwaresolutions.com/learndash-visibility-control/)
* [Visibility Control for WP Courseware LMS](https://www.nextsoftwaresolutions.com/visibility-control-for-wp-courseware/)
* [Visibility Control for LearnPress LMS](https://www.nextsoftwaresolutions.com/visibility-control-for-learnpress/)
* [Visibility Control for LifterLMS](https://www.nextsoftwaresolutions.com/visibility-controlfor-lifterlms/)
* [Visibility Control for MasterStudyLMS](https://www.nextsoftwaresolutions.com/visibility-control-for-masterstudy/)
* [Visibility Control for Sensei LMS](https://www.nextsoftwaresolutions.com/visibility-control-for-sensei/)

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/visibility-control-for-woocommerce` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add the CSS classes to your HTML elements or Menu Items as described in the Details section.

== Frequently Asked Questions ==

= What is WooCommerce? =

[WooCommerce](https://woocommerce.com) is one of the best eCommerce plugin for WordPress. It allows users to create a fully-fledge eCommerce store with multiple payment methods.

= Our Other Products =

**What is GrassBlade xAPI Companion plugin?**

[GrassBlade xAPI Companion](https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/) is a paid WordPress plugin that enables support for Experience API (xAPI)  based content on WordPress.

It also provides best in industry Advanced Video Tracking feature, that works with YouTube, Vimeo and self-hosted MP4 videos. Tracking of MP3 audios is also supported.

It can be used independently without any LMS. However, to add advanced features, it also has integrations with several LMSes.

**What is GrassBlade Cloud LRS?**
[GrassBlade Cloud LRS](https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/) is a cloud-based Learning Record Store (LRS). An LRS is a required component in any xAPI-based ecosystem. It works as a data store of all eLearning data, as well as a reporting and analysis platform.  There is an installable version which can be installed on any PHP/MySQL based server.

= Other Plugins =

* **[Autocomplete LearnDash Lessons and Topics](https://wordpress.org/plugins/autocomplete-learndash/)**

It automatically mark the [LearnDash](https://www.nextsoftwaresolutions.com/r/learndash/wp_vcw_plugin_page) lessons or topic page completed in the background when user visits the page. The Mark Complete button will will act as next button after enabling this plugin.

* **[Experience API for GamiPress](https://www.nextsoftwaresolutions.com/experience-api-for-gamipress/)**

This plugin allows you issuing points and badges for the activities happening on xAPI or SCORM Content. It works with GamiPress and GrassBlade xAPI Companion plugin.


= About Us  =

We provide native Experience API (xAPI or TinCan API) support for WordPress with [GrassBlade xAPI Companion](https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/) plugin. We also have a Learning Record Store called [GrassBlade Cloud LRS](https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/) for advanced reporting of WordPress events and eLearning content.

== Screenshots ==

1. Customer has a Product. Upsell an upgrade.
2. Hide a sale, if customer has the product already.
3. Control menu links based on Login/Logout, or purchased product.

== Changelog ==

= 1.4 =
* Feature: Added support for roles: Example: visible_to_role_administrator
* Fixed: issues with addons page specially on network website.

= 1.3 =
* Fixed: jQuery 3.0 conflict on some websites.

= 1.2 =
* Improvement: Compatible with different editors now: Gutenberg, WPBakery Builder, Visual Composer, Elementor, Brizy Builder, Beaver Builder, Divi

= 1.1 =
* Added Add-ons page

= 1.0 =
* Initial Commit

== Upgrade Notice ==
