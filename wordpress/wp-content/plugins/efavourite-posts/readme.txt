=== EFavourite Posts ===
Contributors: excellentwebworld123
Donate link: https://excellentwebworld.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: favourite posts, favourite, favourite, posts, favourites,
efavourite-posts, reading list, post list, post lists, lists
Requires at least: 4.6
Tested up to: 5.0.2
Stable tag: 4.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Do you want to allow your users to add <strong>Most Favorite Posts</strong> in WordPress Website?

Here is the <strong>most favorite post plug-in for WordPress</strong> which allows your website visitors to add favorite posts. This plug-in also uses cookies for saving data so unregistered users can also favorite a post.

<h2>How to Allow Users to Add Favorite Posts in WordPress?</h2>

You have two options to set favorite posts with login user or without login.

- If a user logged in then favorite’s data will be saved in the database instead of cookies.
- If user not logged in data will be saved in cookies.

You have also option to set for only registered users can favorite posts as well as where to show favorite posts link for adding a post as favorite. You can set widget for favorite posts where the user can see most visited posts on your website. For this, you have to put below function where you want to display your <strong>EFavorite Posts</strong> widget.

Plug-in also support custom posts so that your user can favorite unlimited post types by selecting posts to display favorite option on any post type from "Custom Posts Settings".

you can also create a page template for display favorite posts list for specific user and for this one you have to add this shortcode: {{efav-favourite-posts}} to the content area.

<h2>Most Favourited Posts</h2>
<?php efav_list_most_favourited(); ?>

If you use WP Super Cache you must add page (which you show favorites) URI to "Accepted Filenames &
Rejected URIs

- If a user logged in then favourites data will saved in database instead of cookies.
- If user not logged in data will saved in cookies.

If you need support [create a topic on support forum](http://wordpress.org/support/plugin/efavourite-posts)

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php if (function_exists('efav_link')) { efav_link(); } ?>` in your
single.php or page.php template file. Then favourite this post link will appear in all posts.
1. OR if you DO NOT want the favourite link to appear in every post/page, DO NOT
use the code above. Just type in [efav-link] into the selected post/page
content and it will embed the print link into that post/page only.
1. Create a page e.g. "Your Favourites" and insert `{{efav-favourite-posts}}`
text into content section. This page will contain users favourite posts.
1. That's it :)

== Screenshots ==
1. General Settings
2. Label Settings
3. Custom Posts Settings
4. Help
5. Add posts to favourite and widget
6. Page for Favourite posts list

= 1.0 (2018-03-30) =
* First Release of Efavourite Posts
