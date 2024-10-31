=== Plugin Name ===
Contributors: trick77
Tags: posts, widgets, plugin, sidebar, links, page
Requires at least: 2.5
Tested up to: 3.3.1
Stable tag: 2.0.2

Retrieves posts and pages with a certain custom field (e.g. to permanently show your most recommended posts in a widget) and displays them in a list.

== Description ==

Retrieves posts (or pages) with a certain custom field (e.g. to permanently show your **most recommended posts** in a widget) and displays them in a list. The plugin uses a custom field named *must-read* if it exists in a post or a page. If the field exists in a page or post **and** has the value *true*, the post automatically will be shown in the widget.

= What's new =

* 2.0.2: Stripping HTML tags from titles (thanks, Reinaldo!)
* 2.0.1: Several sorting options added, check out the widget configuration area.

= Use it as a Widget =

If your theme supports widgets, simply drag it to your sidebar. You can specify the maximum number of posts to be shown in the widget. You can also change the widget's title to something like "Most recommended posts", "FAQ", "Read first" or whatever you like.

= Use it in a .php page =

Just put `<?php get_mustread(); ?>` in your template. You could even use it within your posts or pages using the [Exec-PHP plugin](http://wordpress.org/extend/plugins/exec-php/) that allows you to put php code fragments directly into the text. This allows you to create a static page or a post showing your most recommended posts. The get_mustread function takes 4 **optional** arguments: title, maximum number of posts to be shown, name of the custom tag, sort order. Optional means you don't have to specify any parameters if you don't need to.

= Marking a post or page to be included =

If you're using the plugin for the first time, click "Add new custom field" to add the field name *must-read* and insert *true* in the value field of the page or post you want to be shown in the new widget. Once you want to display an additional post in the widget, just select it from the custom field drop-down box and insert "true" in the value field.
If you don't want the custom field to be named *must-read* you can also change it to something else. The custom field value always has to start with *true* for the page or post to appear in the list.

= Custom sort order =

The plugin features several self explanatory sorting options. You can also specify a custom sort order. Just add a semi-colon and a sort-number after *true* in the custom value field. The field value for your 1st post would be *true;01* and the 2nd field would like *true;02* and so on. This gives you full flexibility over the positioning of your posts or pages in the Must-Read-Posts list. If you mix sorted and unsorted posts or pages, the ones with no number will be sorted first. If you have a bunch of posts or pages that you just want to sort at the end use something like *true;99* on all of them to move them at the end of the sort order. 

= Remove a post or page from the Must-ReadPosts list =

To remove a post or page from the Must-Read-Posts list set the custom-field-value to *false* or remove the custom-field from the post or pages.

== Installation ==

1. Upload must-read-posts.php to the /wp-content/plugins/ directory.
2. Activate "Must Read Posts" through the 'Plugins' menu in WordPress.
3. What to do now depends on how up to date your theme is (see below)
4. Mark all the posts/pages you want to show in the widget with the custom field *must-read* and the value *true* (see screenshots).

**Modern theme with widget support**

The plugin is a widget. If your theme supports widgets, and you have installed the widget plugin, adding the plugin to the sidebar is easy: Go to the appearance menu and drag and drop the widget into the sidebar. Don't forget to save your new widget structure using the save button below.

**Old school theme without widget support**

This will require some programming in the sidebar.php file. There are many resources on the web about how to do this.

== Frequently Asked Questions ==

= I want to change the look of the list. How can I do that? =

The look of the list of posts and pages in the widget can be customized using the style.css cascading style sheet. Just add your own or the following style to your current theme's style.css file:

<code>
#must-read-posts li {
   list-style-type:square;
   margin-bottom:0.4em;
}
</code>

== Screenshots ==
1. Must Read Posts in action in widget in the right sidebar
2. Widget configuration
3. How to add the *must-read* custom field to a post or page, don't forget to add the value *true*
