=== Tabby Responsive Tabs ===
Contributors: numeeja
Donate link: http://cubecolour.co.uk/wp
Tags: tabs, responsive, shortcode, tab
Requires at least: 3.7
Tested up to: 3.8.1
Stable tag: 1.0.3
License: GPLv2 / MIT

Tabby enables you to create responsive tabs inside your posts, pages or custom post types by adding simple shortcodes inside the post editor. The tabs transform into an accordion on a viewport 767px wide or less.

== Description ==

* Adds a set of horizontal tabs which changes to an accordion on narrow viewports
* Tabs and accordion are created with jQuery
* Supports multiple sets of tabs on same page
* Uses Semantic header and Content markup
* Aria attributes and roles aid screen reader accessibility
* Tabs and content are accessible via keyboard

= Usage: =

There are two shortcodes which should both be used `[tabby]` and `[tabbyending]`

`[tabby title="tabname"]`

replace tabname with the name of your tab.

Add the tab content after that.

Add a `[tabbyending]` shortcode after the content of the last tab in a tabgroup.
		
= Example =
`
[tabby title="First Tab"]
Tabby ipsum dolor sit amet, kitty sunbathe dolor, feed me.

[tabby title="Second Tab"]
Lay down in your way catnip stuck in a tree, sunbathe kittens.

[tabby title="Third Tab"]
sleep in the sink climb the curtains attack, give me fish.
[tabbyending]
`
You can see the tabs on the [demo page](http://cubecolour.co.uk/tabby-responsive-tabs/ "Tabby Responsive Tabs demo").

If you want to change the style of the tabs / accordion, copy the contents of the plugin's stylesheet into your child theme, or custom styles plugin and make the changes. This will also enable you to change the dimension used as the responsive breakpoint.

If you are using your own custom version of the css, you can prevent the built-in styles from loading by adding the following line to your child theme's functions.php or a custom functionality plugin:

`<?php remove_action('wp_print_styles', 'cc_tabby_css', 30); ?>`


== Installation ==

1. Upload the plugin folder to your '/wp-content/plugins/' directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Where is the plugin's admin page? =

There isn't one. This is a lightweight plugin with no options, so there is no need for an admin page.

= Is it responsive? =

Yes - it should work with responsive themes. It defaults to 100% of the width of the enclosing element.

= How can I change the colours? =

You can copy the css rules from the plugin's stylesheet into your child theme's stylesheet and then customise the colours or use a plugin to add in the css. The css rules should be straighforward to work out.

= OK I've done that, now how do I stop the default styles from loading? =

You can prevent the built-in styles from loading by adding the following line to your child theme's functions.php or a custom functionality plugin:

`<?php remove_action('wp_print_styles', 'cc_tabby_css', 30); ?>`

= Can I change the responsive breakpoint from the default 767px? =

Yes, you'll find where that is set in the css. Refer to the answer above about using custom css.

= Can I display multiple tab groups on a single page? =

Yes you can. As many as you like.

= My Tabs are displaying too high or low & look odd =

This can be due to differences in the metrics of different fonts and the css that is inherited from your theme. You sould be able to overide this with a little additional css in your child theme stylesheet or addded via a custom css plugin.

You can increase specificity to ensure that additional css rules are applied.

The value to look at here are

1. **margin-bottom** for the **.responsive-tabs__list class**
1. **padding-bottom** for the **responsive-tabs__list__item class**

eg:
`
.responsive-tabs-wrapper .responsive-tabs .responsive-tabs__list {
	margin-bottom: 5px;


}

.responsive-tabs-wrapper .responsive-tabs__list__item {
	padding-bottom: 3px;

}
`

Changing these values individually will show you how they interact.

= I've just updated to version 1.0.2 and the tabs are now displaying incorrectly =

The CSS has changed in version 1.0.2. It is possible that you added css rules to your theme's stylesheet rather than following the recommended method for using  a customised version of the css.

= Can you create a customised stylesheet for me to fit in with the colours of my website? =

I'd love to, but my time is limited and this is beyond of the scope of the free support that I can provide. I can however offer this as paid consultancy. Please send me details of your requirements via the [cubecolour contact form](http://cubecolour.co.uk/contact/ "cubecolour contact form") for a quote. Please do not use that form for requests for free support. Plugin support is provided at the [plugin's support forum](http://wordpress.org/support/plugin/tabby-responsive-tabs/ "Tabby Responsive Tabs plugin support forum") on WordPress.org.

= Why do you spell the word 'color' incorrectly? =

I don't, I'm from England and 'colour' is the correct spelling.

= I am using the plugin and love it, how can I show my appreciation? =

You can donate via [my donation page](http://cubecolour.co.uk/wp/ "cubecolour donation page")

If you find the plugin useful I would also appreciate a review on the [plugin review page](http://wordpress.org/support/view/plugin-reviews/tabby-reponsive-tabs/ "Tabby Responsive Tabs plugin reviews")

If the isn't working for you, please read the documentation to check whether your issue is answered already. If your issue is not addressed here, please post a question on the [plugin support forum](http://wordpress.org/support/plugin/tabby-responsive-tabs/ "Tabby Responsive Tabs plugin support forum") so we have an opportunity to try to get it working before you leave a review.

== Other Notes ==

The plugin is licenced under [GNU GPLv2](http://opensource.org/licenses/GPL-2.0 "GNU GPLv2"), however as the original responsive tabs script was [hosted at codepen as a public pen](http://blog.codepen.io/legal/licensing/ "hosted at codepen as a public pen"), the GPL compatible [MIT license](http://opensource.org/licenses/MIT "MIT license") applies to that component.

== Screenshots ==

1. On a desktop browser the content is displayed within tabs.
1. When the browser width is below the size set in the media query, the tabs are replaced by an accordion.

== Changelog ==

= 1.0.3 =

* improved theme compatibility with default css

= 1.0.2 =

* enqueue plugin js only when needed
* css for improved specificity

= 1.0.1 =

* Updated js & css

= 1.0.0 =

* Initial Version

== Upgrade Notice ==

= 1.0.3 =

* improved theme compatibility with default css

= 1.0.2 =

* better efficiency - enqueue plugin js only when needed
* improved theme compatibility with default css

= 1.0.1 =

* Updated js & css

= 1.0.0 =

* Initial Version