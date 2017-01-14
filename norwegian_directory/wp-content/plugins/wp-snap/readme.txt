=== WP-SNAP! ===
Contributors: nateomedia
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=paypal%40nateomedia%2ecom&item_name=Donation&no_shipping=1&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8
Tags: navigation, alphabetical, post, page, glossary, index, reviews
Requires at least: 2.5
Tested up to: 3.0.1
Stable tag: 0.9.4

WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an user interface for navigating alphabetized post titles.

== Description ==

WP-SNAP! (WordPress System for Navigating Alphabetized Posts) creates an alphabetical listing of post titles on a Category or Page template file. Navigation through the listings WP-SNAP! generates is accomplished using the alphabet itself. (For example, if a site visitor clicked on the letter D, any post titles that began with that letter would be showcased.) WP-SNAP! will work on any Wordpress 2.5 or higher site, but is particularly useful managing glossaries, indexes, reviews, or directories.

WP-SNAP! offers three different navigational styles and integration with both custom permalinks and the Wordpress loop. Plugin options can be managed both site-wide and on the template itself with results either restricted to one category or broadened to include child categories as well. The clever web developer should have no problem seamlessly integrating WP-SNAP! into their latest project. Options have also been added to allow the customization of css class names and the appearance of html mark-up.

== Installation ==

1. Download the WP-SNAP! WordPress Plugin, extract it and upload it to your WordPress Plugins folder on your site.
2. Activate the Plugin from the WordPress Administration Plugins tab.
3. Edit the category templates your Theme uses, such as category.php, and add the following code above the start of the Wordpress Loop:
    <?php if (function_exists('wp_snap')) { echo wp_snap(); } ?>
4. Copy the CSS example below and paste it into your WordPress Theme stylesheet (you can style it better later).
5. Upload the files and refresh the category page on your WordPress blog to see it in action.
6. For further customization, go to Wordpress Admin > Plugins > WP-SNAP! settings. The available settings allow you to make site-wide changes to things like the alphabet, the navigational structure, permalink structure. You may also change the categories to be displayed and the menu navigational structure by passing variables as a query-string to the plugin like so:  
    <?php if (function_exists('wp_snap')) { echo wp_snap('arguments'); ?>
There are currently four possible arguments: Category ('cat'), Include Category Children ('child'), Navigational Menu Style ('menu'), and First Load ('firstload'). Category must equal a category number from your WordPress installation, Include Category Children must equal true or false as to whether to include child categories (the default value is false), Navigational Menu Style must equal a number between 1 and 3 (corresponding with the three navigational styles offered in the admin options panel), and First Load must equal ALL, NONE or RECENT and will affect how WP-SNAP! displays posts/tags when it is first called on a template. Note that if RECENT is selected, the number of recent posts/tags to display can be controlled from the admin options page. For instance, to create a navigational menu for all posts in category 15, including child categories, using the default menu navigational style, and displaying recent posts on first load, WP-SNAP! would be called like this:
    <?php if (function_exists('wp_snap')) { echo wp_snap('cat=15&child=true&firstload=recent'); } ?>
To create a navigational menu for the current category, excluding children and using navigational menu style 3, WP-SNAP! would be called like this:
    <?php if (function_exists('wp_snap')) { echo wp_snap('menu=3'); } ?>
To create a navigational menu for all categories, using default navigational menu style, WP-SNAP! would be called like this:
    <?php if (function_exists('wp_snap')) { echo wp_snap('cat=all'); } ?>
7. Test it out and enjoy!

Note: For the Plugin to work, you must have access to edit your WordPress Theme files. You must also have a category.php template file in your WordPress Theme. If you do not, you can create one following the instructions on the WordPress Codex for creating a category template file.

== Frequently Asked Questions ==

= When will the next version of your plugin be released? =
As soon as I find the time, I will update the plugin and release a new version. I understand how frustrating it can be to be so close to having the perfect Wordpress installation only to be held up by a plugin that just needs a little more work to be exactly what's needed. However, please remember that I am not paid write this plugin and that, like you, I have a family and responsibilities that extend far beyond this little piece of code. I really appreciate your enthusiasm, but if you wish to reap the benefits of my freely given labor, then you must be satisfied with doing so on my timetable. Otherwise, if you simply cannot wait, you are more than welcome to modify and extend the capabilities of my plugin yourself.

= Why do the results WP-SNAP! returns look funky? Why is it numbering every item? =
A web page is composed of two parts: a document containing HTML code and a document containing styling code (known as a Cascading Style Sheet, or CSS for short). Because WordPress templates can look so drastically different from one another, I have intentionally avoided injecting any CSS information into WP-SNAP! However, I have included several ID selectors (that can even be modified from within wp-admin) that should allow you to style WP-SNAP! to look however you'd like. Those numbered lists? You can turn them off. I do ask that you try to refrain from asking me CSS related questions -- while I would love to help you, my time is limited. If you would like to learn more about CSS, I suggest visiting A List Apart or Vitamin.

= I tried using your plugin, but it just won't work. What am I doing wrong? =
Unfortunately, I don't have the time to troubleshoot every installation of this plugin. However, if you believe you have discovered a bug, I encourage you to post a comment to my website and I will reply as soon as I can. I do request that you be as specific as possible when asking for assistance. Please provide a detailed account of the steps you took that resulted in the error you encountered so that I can try to reproduce it and more quickly deduce how to fix it.