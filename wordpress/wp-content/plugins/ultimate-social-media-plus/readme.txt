﻿=== Social Share Icons & Social Share Buttons ===
Contributors: socialsharepro, socialtech
Tags: Share, sharing, share buttons, share button, share social media, share icons, social buttons, sharing buttons, sharing icons, social media icons, social share, social sharing
Requires at least: 3.0
Tested up to: 5.4.2
Stable tag: 3.4.2
License: GPLv2 
License URI: http://www.gnu.org/licenses/gpl-2.0.html
﻿
Social sharing plugin adding social buttons.

== Description ==

Add social share icons on your website with just a few clicks. 

The plugin can be customized to suit any need and is FREE. It also has been **translated into various languages**. 

Feature list:

- Numerous **social share platforms** (see a list of them below)
- Many placement options **before or after posts, floating over your website's pages, via widget, via shortcode,** (top right, bottom left etc.) 
- The possibility to give **several actions to one social share button** (e.g. your Facebook icon can lead visitors to your Facebook page, and also show a Facebook button to share your page on social media)
- **16 design styles** for your social share buttons
- **Animated** social share buttons  (e.g. automatic shuffling, mouse-over effects)
- Social **pop-up** - ask people to follow or share you
- **Subscription service** - allow visitors to subscribe to your site and receive new posts automatically by email 
- Share counts
- **Rearrange Order** of social share icons
- **Lots of other customization options** for your social share buttons
- Compatible with Gutenberg editor

List of platforms supported in the free plugin:

* Facebook share icon
* Twitter share icon
* Email icon
* RSS icon
* Instagram share icon
* Youtube share icon
* Pinterest share icon
* LinkedIn share icon
* Houzz share icon
* OK icon
* Telegram icon 
* VK icon
* WeChat icon
* Weibo icon
* Share icon (allows your visitors to share your site on over 200+ other social media sites; powered by addthis/sharethis)

If there are any important social share networks not covered yet, please let us know!

For GDPR compliance, please have a look at our [Social Media GDPR Compliance page](https://ultimatelysocial.com/gdpr/). 

In case of issues or questions please ask in the [Support forum] (https://wordpress.org/support/plugin/ultimate-social-media-plus).

= Premium Plugin =

The free plugin already provides tons of options for social sharing (as outlined above). In our Premium Plugin, even more is possible. Some examples for additional features in the Premium Plugin: 

* More social share buttons (the icon pack includes an Instagram button, Snapchat button, Yummly button, Print button, Whatsapp button, Yelp button, Soundcloud button, Skype button, Flickr button, Share button, Blogger button, Digg button, Reddit button, Vimeo button, Tumblr button, Xing button, vk button, Telegram button, Amazon button, Spotify button and many more badge, see list above)
* More (default) design styles for your social share icons
* Themed design styles for your social share buttons (e.g. if you have a site about cats, you can pick from cat-themed buttons etc.)
* Better sharing & following features (tailored tweet texts, allow people to follow you directly on your page etc.)
* Place the social share icons on specific pages
* Optimized for mobile sharing and buton display
* More functions for email icon to connect with you 
* More lightbox / popup options (e.g. limit how often the popup is shown to the same user)
* (Friendly and fast) Support
* Many more settings & options

Note: this plugin uses the third party provider SpecificFeeds.com for the subscription feature, enabling you to allow your visitors to subscribe to your site and get new posts automatically by email. Upon installation of the plugin a feed will be set up on SpecificFeeds, transmitting your IP address. This is required for this feature to work.

== Installation ==
Extract the zip file and drop the contents into the wp-content/plugins/ directory of your WordPress installation. Then activate the plugin from the plugins page.

Then go to plugin settings page and answer the first 3 questions. That's it. 

Note: This plugin requires CURL to be activated/installed on your server (which should be the standard case). If you don't have it, please contact your hosting provider.

== Frequently Asked Questions ==

= Please also check the more comprehensive FAQ on http://ultimatelysocial.com/faq =

We will try to keep this FAQ section up-to-date, but please note that the latest version of the FAQ might be only available at http://ultimatelysocial.com/faq

= I face fundamental issues (the plugin doesn't load, social share buttons don't show etc.) =

Please ensure that: 

- You're using the latest version of the plugin(s)
- Your site is running on PHP 5.4 or above 
- You have CURL activated (should be activated by default)

If you're not familiar with those please contact your hosting company or server admin.

Please check if you have browser extensions activated which may conflict with the social share buttons. Known culprits include:

- Open SEO Stats (Formerly: PageRank Status) in Chrome
- Adblock Plus in Chrome
- Vine in Chrome

Either de-activate those extensions or try it in a different browser.

If the plugin setting's area looks 'funny' after an upgrade then please clear your cache with String+F5 (PC) or Command+R (Mac).

If you get the error message “Are you sure you want to do this? / Please try again” when uploading the plugin: Some servers may have a low limits with respect to permitted upload times. Please set the values in the “php.ini” file to:

max_execution_time 90
post_max_size 48M

If you don’t know how to do it, please contact your server support / hosting company for that. Tell them you need it for a sharing plugin on WordPress which may take longer to upload as many socialsharing buttons are included in it (larger file size).  

If your issue is still not fixed after you’ve followed the steps above, we can provide support as part of our new share to social Premium Plugin: https://www.ultimatelysocial.com/usm-premium/.

= I get error messages 'Error : 7', 'Error : 56', 'Error : 6' etc. =

Those point to a CURL-issue on your site. Please contact your server admin or your hosting company to resolve it.

The plugin requires CURL for the social share counts and other features. 

= Social share buttons don't show = 

Please ensure you actually placed the social share buttons either as social widget (in your widget area) or as floating icons under question 5). The Premium Plugin makes placing sharing buttons especially easy and also allows you to place sticky buttons on your site, define the placement of the share buttons by margins and many other options, see https://www.ultimatelysocial.com/usm-premium/.

If only some social share buttons show, but not all, then please clear your cache, and check if you may have conflicting browser extensions (e.g. 'Disconnect'-app in Chrome). Also Ad-Blockers are known culprits, please switch them off temporarily to see if that is the reason.

If the social share buttons still don't show then there's an issue with your template. Please contact the creator of your template for that. 

If you are referring to specific social share buttons not showing in the plugin itself (e.g. you're looking for a Whatsapp icon, but it doesnt exist) please note that our Premium Plugin has many more social media share buttons, see https://www.ultimatelysocial.com/usm-premium/

= Twitter share counters are not displaying (anymore) =

Unfortunately, Twitter stopped providing any social share counter. God knows why. 

= Changes don't get saved / Deleted plugin but sharing buttons still show = 

Most likely you have the WP Cache plugin installed. Please de-activate and then re-activate it.

= Links don't work = 

Please ensure you've entered the 'http://' at the beginning of the url (for *all* social networks). If the share buttons are not clickable at all there is most likely an issue with your template. This is especially the case if you've given your social share buttons several features, which should show a pop-up (tooltip) when you move over the share buttons. 

= I cannot upload social custom buttons = 

Most likely that's because you've set 'allow_url_fopen' to 'off'. Please turn it to 'on' (or ask your server admin to do so, he'll know what to do. Tell them you need it to upload custom buttons for a social media buttons plugin which are not included yet).

= My Youtube button (direct follow) doesn't work = 

Please ensure that you've selected the radio button 'Username' when you enter a youtube username, or 'Channel ID' when you entered a channel ID.

= Aligning the social share buttons (centered, left- or right-aligned) doesn't work = 

The alignment options under question 5 align the sharing icons with respect to each other, not where they appear on the page. Our new Premium Plugin is the best social sharing plugin on the market, allowing you to define also many other button alignments (e.g. within a widget, within shortcode etc.).  

= Clicking on the RSS button returns funny codes = 

That's normal. RSS users will know what to do with it (i.e. copy & paste the url into their RSS readers).

= Facebook 'like'-count isn't correct = 

When you 'like' something on your blog via facebook it likes the site you're currently on (e.g. your blog) and not your Facebook page.

The new Premium Plugin also allows to show the number of your Facebook page likes, see https://www.ultimatelysocial.com/usm-premium/. 

= Sharing doesn't take the right text or picture = 

We use the codes from Facebook, Google+ etc. and therefore don't have any influence over which text & pic is used for sharing.

Note that you can define an image as 'Featured Image' which tells Facebok / Google etc. to share that one. You'll find this 'Featured Image' section in your blog's admin area where you can edit your blog post.

You can crosscheck which image Facebook will share by entring your url on https://developers.facebook.com/tools/debug/og/object/.

= The pop-up shows although I only gave my social share button one share function = 

The pop-up only disappears if you've given your sharing buttons only a 'visit us'-function, otherwise (e.g. if you gave it 'Like' (on facebook) or 'Tweet' functions or sharing functions) a pop-up is still needed because the share buttons for those are coming directly from the social media sites (e.g. Facebook, Twitter) and we don't have any influence over their design.

= I selected to display the social sharing buttons after every post but they don't show = 

The social sharing buttons usually do show, however not on your blog page, but on your single posts pages. The Premium plugin (https://www.ultimatelysocial.com/usm-premium/) also allows to display the share buttons on your homepage.

= Plugin decreases my site's loading speed = 

The plugin is one of the most optimized social media plugin in terms of impact on a site's loading speed (optimized code, compressed pictures etc.).

If you still experience loading speed issues, please note that:

- The more social sharing bottons and invite features you place on your site, the more external codes you load (i.e. from the social media sites; we just use their code), therefore impacting loading speed. So to prevent this, give your sharing buttons only 'Visit us'-functionality rather than sharing functionalities.

- We've programed it so that the code for the social media buttons is the one which loads lasts on your site, i.e. after all the other content has already been loaded. This means: even if there is a decrease in loading speed, it does not impact a user's experience because he sees your site as quickly as before, only the social media buttons take a bit longer to load.

There might be also other issues on your site which cause a high loading speed (e.g. conflicts with our plugins or template issues). Please ask your template creator about that.

Also, if you've uploaded social media sharing buttons not provided by the plugin itself (i.e. custom buttons) please ensure they are compressd as well. 

= After moving from demo-server to live-server the follow or subscribe link doesn't work anymore = 

Please delete and install the plugin again.

If you already placed the code for a subscription form on your site, remove it again and take the new one from the new plugin installation.

= When I try to like or share via Facebook, I get error message 'App Not Setup: This app is still...' = 

If you get the error message...

'App Not Setup: This app is still in development mode, and you don't have access to it. Switch to a registered test user or ask an app admin for permissions.'

...then most likely you're curently logged in with a business account on Facebook. Please logout, or switch to your personal account.

= There are other issues when I activate the plugin or place the share buttons = 

Please check the following:

The plugin requires that CURL is instaled & activated on your server (which should be the standard case). If you don't have it, please contact your hosting provider.

Please ensure that you don't have any browser extension activated which may conflict with the plugin, esp. those which block certain content including the share buttons. Known culprits include the 'Disconnect' extension in Chrome or the 'Privacy Badger' extension in Firefox.

If issues persist most likely your theme has issues which makes it incompatible with our plugin. Please contact your template creator for that. As part of the Premium Plugin (https://www.ultimatelysocial.com/usm-premium/) we fix also theme issues, and provide support to ensure that your social media share buttons appear on your site (exactly where you want them). 

= How can I see how many people share or like my posts? = 

You can see this by activating the sharnig 'counts' on the front end (under question 5 in the plugin). This will display the counters in little bubbles showing how often people share your posts. 

We cannot provide you this data in other ways as it's coming directly from the social media sites. One exception: if you like to know when people start to follow you by email, then you can get email alerts. For that, please claim your feed.

= How can I change the 'Please follow & like us :)'? = 

You can change it in the Widget-area where you dropped the widget with the sharing buttons on the sidebar. Please click on it (on the sidebar), it will open the menu where you can change the text.

If you don't want to show any text, just enter a space (' ').

= How can I remove the credit-link ('Powered by Ultimatelysocial')? = 

Please note that we didn't place the credit link without your consent (you agreed to it when de-selecting the email button).

Open the first question in the plugin ('1. Which sharing buttons do you want to show on your site?'), on the level of the email button you see a link on the right hand side. Please click it to remove the credit link.

= Can I use a shortcode to place the share buttons? = 

Yes, it's [DISPLAY_ULTIMATE_SOCIAL_ICONS]. You can place it into any editor. If the sharing buttons still don't show, there might be an issue with your theme. 

Alternatively, you can place the followin into your codes: <?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?> 

In some cases there might be issues to display social media sharing buttons which you uploaded as custom buttons. In this case, we provide support as part of our premium plugin: https://www.ultimatelysocial.com/usm-premium/

= Can I get more options for the social share buttons next to posts? = 

Please use this plugin for that: https://www.ultimatelysocial.com/usm-premium/. This allows you to place more share buttons (e.g. including Linkedin) as well as giving you more configuration options. 

= Can I also give the email button a 'mailto:' functionality? = 

Yes, that is possible in our new social share plugin, the Premium Plugin: https://www.ultimatelysocial.com/usm-premium/

To get the email button in the same design style you picked, activate it, then on the front-end, rightclick on the button, and save it as picture. Upload that picture as custom button.

= Can I also display the share buttons vertically? = 

Yes, that is possible in our new social sharing plugin, the Premium Plugn: https://www.ultimatelysocial.com/usm-premium/.

= How can I change the text on the 'visit us'-buttons? = 

Use this plugin: https://www.ultimatelysocial.com/usm-premium/

= Can I deactivate the social sharing buttons on mobile? = 

Yes, there's an option for that under question 5. In our new Premium Plugin you can define different settings of the share buttons for mobile, see https://www.ultimatelysocial.com/usm-premium/. The best way to share social media! :)

= How can I use two instances of the plugin on my site? = 

You cannot use the same plugin twice, however you can install both the first USM plugin (https://wordpress.org/plugins/ultimate-social-media-icons/) as well as the Premiuem plugin (https://www.ultimatelysocial.com/usm-premium/). We've developed the code so that there are no conflicts and they can be used in parallel.

= Where can I find icons for more social media platforms? = 

The premium plugin offrs many more social buttons from other social media platforms such as Snapchat, Whattsapp, Yelp, Sound cloud and many others. It's the best socialsharing plugin on the market :) Check it out at https://www.ultimatelysocial.com/usm-premium/


== Screenshots ==

1. After installing the plugin, you'll see this overview. You'll be taken through the easy-to-understand steps to configure your plugin 

2. As a first step you select which icons you want to display on your website

3. Then you'll define what the icons should do (they can perform several actions, e.g. lead users to your facebook page, or allow them to share your content on their facebook page)

4. In a third step you decide where the icons should be placed: a.) via Widget, b.) Floating, c.) via Shortcode and/or d.) Before or after posts

5. You can pick from a wide range of social share icon designs

6. Here you can animate your main icons (automatic shuffling, mouse-over effects etc.), to make visitors of your site aware that they can share, follow & like your site

7. You can choose to display counts next to your icons (e.g. number of Twitter-followers) 

8. There are many more options to choose from 

9. You can also display a pop-up (designed to your liking) which asks users to like & share your site

== Changelog ==

= 3.4.2 =
* Update the banner to show less frequently

= 3.4.0 =
* Removed banner options

= 3.3.9 =
* Subscription fallback Url issue fixed

= 3.3.8 =
* Plugin url fixes
* Updated youtube API ID

= 3.3.7 =
* Popup skip error solved
* Corrected a banner

= 3.3.6 =
* Updated auto open q3 removed.
* Fixed subscribe form button value.
* Updated pinterest model images.
* Fixed claim feed from Q8 popup.

= 3.3.5 =
* Fixed UI issues.
* Fixed problems with moving to Follow.it

= 3.3.4 =
* Updated Banners to make them less annoying.
* Updated to follow.it
* Quick purchase updaed.
* Some Style and typo corrections.

= 3.3.3 =
* Updated texts

= 3.3.2 =
* Update: Option to define margin above and below responsive icons added
* Update: Widget alignment issues fixed
* Update: Replaced with icons which reduce the loading time

= 3.3.1 =
* Updated: Tweet text blank.
* Updated: Export and import text size changed.
* Updated: Video url changed.
* Updated: Resolved the illigal offset error.

= 3.3.0 =
* Update: Responsive icons only on blog post.
* Update: Lazy load css added.
* Update: Success message after export.
* Update: Changed the installer.
* Update: Added shortcode support for the custom url.
* Update: Updated Ping function.

= 3.2.9 =
* Update: Q3 auto opening and opening of Floating and 'before and after posts' open automatically for new installes.
* Update: Popup open error fixed.
* Update: Analyst5.4.
* Update: Added the waiting imgage on contact.
* Update: Sellcodes callback.
* Update: Removed console.log.

= 3.2.8 =
* Update: Url encoded for location.href
* Update: Restrucutre the section 8 options
* Update: UI improvements
* Update: Shortcode updated

= 3.2.7 =
* Update: Feedback system updated.
* Update: Banner text for responsive icons updated.
* Update: Css Validation issue corrected;

= 3.2.6 =
* Update: Fixed the text in theme banner.
* Update: Fixed follow icon and subscription box when Curl is disabled.
* Update: Fixed cURL errors.

= 3.2.5 =
* Update: Q4 missing images corrected.

= 3.2.4 =
* Update: Text changes.
* Update: Solved widget alignments.
* Update: Solved php errors.

= 3.2.3 =
* Update: Text changes.
* Update: Link for email and action for subscription when request fails.

= 3.2.2 =
* Update: Feedback system updated

= 3.2.1 =
* Update: Feedback system updated

= 3.2.0 =
* Update: SDK.
* Update: Grammer Errors.

= 3.1.9 =
* Update: Responsive icons options display logic corrected.
* Update: Twitter and other external js inclusion logic updated.
* Solved: Cancel button on banner reapplied.
* Solved: Validation for section 2 options while section 1 options are checked but not saved corrected.
* Update: Feedback system updated

= 3.1.8 =
* New Feature: Responsive icons in the plugin.
* Solved: Icons not rendering on woocomerce product page.
* Solved: Stop loading unused external library code for faster load.
* Solved: Updated feedback system to next version.

= 3.1.7 =
* Update: Feedback system added

= 3.1.6 =
* Update: Removed google icon.
* Update: Nonce error in Q6 preview language icons

= 3.1.5 =
* Update: Corrected typos
* Update: Updated theme suggestion data
* Update: Removed Curl error
* Update: Fixed Facebook and Twitter icons not working on some pages
* Update: Removed w3 validation errors
* Update: Removed googleplus icon

= 3.1.4 =
* Update: Solved the Undefined Notice messages.

= 3.1.3 =
* Update: Google plus like removed
* Update: Extra debug log removed
* Update: Screencast video removed
* Update: more icons included.
* Update: White background from icons removed.

= 3.1.2 =
* Update: updated the new added icons.
* Update: optimized the extraicons of premium shown to the plugin. 

= 3.1.1 =
* Update: removed unwanted files.
* Update: included skins for wechat icons.
* Update: Custom skin for newly added icons.
* Update: Compatablity Errors corrected.

= 3.1.0 =
* New Feature: New icons Implemented.
* Update: Alert for checkbox conflict.
* Update: Cron implemented for rss count.
* Update: Custom icons not showing solved.


= 3.0.9 =
* Update: Woocommerce resolved conflict resulted in other conflicts - fixed. 

= 3.0.8 =
* Update: Critical Security Patch. 
* Update: Resolved Conflict with woocommerce auto update.

= 3.0.7 =
* Update: Security Patch.

= 3.0.6 =
* Update: security update.
* Update: save button not working.

= 3.0.5 =
* Update: Theme cheker dom error updated.
* Update: Deprecated Google plus
* Updated: css changes to make icons more symetric.

= 3.0.4 =
* Updated: Security patch in freemius.

= 3.0.3 =
* Update: solved Undefined constant notice resolved.
* Update: offline chat email validation added.
* Update: ROUND SHORTCODE sharing error solved.
* Update: curl errors in backend solved.
* Update: ajax_object conflict solved and updated sfsi_plus_ajax.

= 3.0.2 =
* Update: Conflict solved.

= 3.0.1 =
* Update: design changes in gutenberg.
* Update: Dashboard chat updated.
* Update: Security updates. 

= 3.0.0 =
* Update: Updated gutenberg block to incorporate current changes. Added support for multiple controls on block inspector controls.
* update: In-admin-pannel chat updated for more user friendly features. 

= 2.9.9 =
* Duplicate IDs removed from icon's link
* Facebook share counts (rectangle icons) do not show
* specificfeeds.com links changed to https
* Remove google like
* Click on G+ in firefox opens a new window

= 2.9.8 =
* Update: Display counts can’t be manually updated

= 2.9.7 =
* New Feature: Direct chat added to the plugins settings page.

= 2.9.6 =
* Image not showing error fixed for banner in animation section in Question 4 added 

= 2.9.5 =
* Lightbox removed after click on de-activation of plugin
* Banner for animation section in Question 4 added
* Different icon for mouseover section pointing in premium in Question 4 added
* Removed theme icon banner if no match

= 2.9.4 =
* Optimized footer

= 2.9.3 =
* Fixed Gutenberg issues which arose for old PHP versions
* Removed Addthis due to GDPR compliance issues

= 2.9.2 =
* Issue fixed that click on dismiss for banner didn't dismiss it permanently
* Gutenberg implemented

= 2.9.1 =
* Count Error for newer PHP version fixed

= 2.9.0 =
* Count Error shown for newer php versions fixed.

= 2.8.9 =
* Language in Question 6 not saving issue fixed

= 2.8.8 =
* Optimized code for setting value for "adding_plustags" which caused issues on some sites

= 2.8.7 =
* Various instructions optimized 

= 2.8.5 =
* Cookies don't get set anymore if selected to show pop-up when user scrolls to end of page (relevant for GDPR compliance)

= 2.8.4 =
* Like count issue fixed
* Youtube subscribe issue fixed

= 2.8.3 =
* Instagram followers count issue fixed
* Twitter count issue fixed
* Facebook share count issue fixed

= 2.8.2 =
* Non-numeric value errors fixed

= 2.8.0 =
* Removed error log files
* Follow icon sometimes showed too large - fixed

= 2.7.9 =
* Linkedin-counter after posts corrected

= 2.7.8 =
* Text changes

= 2.7.7 =
* New question for referring added

= 2.7.6 =
* Saving links for custom icons sometimes didn't work. Fixed now. 

= 2.7.5 =
* Links updated

= 2.7.4 =
* Themed icons notification optimized

= 2.7.3 =
* Important bug fixed (which caused fatal error on sites with PHP version below 5.5. and sensitive error reporting on server)

= 2.7.2 =
* Banners modified
* Spelling mistakes corrected

= 2.7.1 =
* Added more themed icons banners

= 2.7.0 =
* There were conflicts when both free USM plugins were installed at the same time, those are now resolved

= 2.6.9 =
* Notification for possibility to define sharing text and pic added

= 2.6.8 =
* Link to full list of premium icons added

= 2.6.7 =
* Info added that url shortener is available in premium plugin 
* Non numeric value warning fixed
* Templates with no head issue fixed

= 2.6.6 =
* Incorrect error messages removed 
* Better formatting of socialshare review bar  

= 2.6.5 =
* Updated so that also widget data gets removed when you de-install the plugin, so now everything is completely removed 

= 2.6.4 =
* New CURL error messages to point better to the specific issue
* Error message if user is using outdated PHP version
* "Mandatory" removed from email and rss icons
* Freemius Error (uninstall hook error) fixed
* Icons not underlined anymore (was a conflict with certain themes such as twentyseventeen)
* Js removed after de-activating the icons
* Freemius image added
* After activation of plugin you're directly taken to the plugin's settings page

= 2.6.3 =
* Fremius analytics implemented 

= 2.6.2 =
* More strings made translation-ready
* Better claiming of feed enabled

= 2.6.1 =
* Issue with Instagram button counters fixed

= 2.5.9 =
* Issue fixed that sometimes incorrect error-messages showed on front-end
* Credit link updated
* More icons added for pro-version
* SpecificFeeds adjusted for paid option
* De-installation will now clear database entirely
* Upgrade to pro-link renamed

= 2.5.7 =
* New option for tailor-made icons

= 2.5.6 =
* Activation/de-activation links optimized

= 2.5.5 =
* Notifications activated

= 2.5.4 =
* Notifications revised

= 2.5.3 =
* Notification added

= 2.5.1 =
* Instructions for troubleshooting optimized

= 2.5.0 =
* Facebook icon leading to empty pages (in specific cases) fixed

= 2.4.9 =
* Twitter sharing text issues with forwarded slashes fixed
* Links to review sites adjusted following Wordpress changes in review section

= 2.4.7 =
* Missing counts for email follow option fixed (when there are no subscribers yet)
* Extra explanation text added

= 2.4.6 =
* Corner case vulnerability fixed

= 2.4.5 =
* Claiming box made nicer

= 2.4.4 =
* Updated PIN-it button to SAVE 
* Claiming process simplified

= 2.4.3 =
* jQuery issue fixed
* Counts for SpecificFeeds-subscribers are back, getting updated once a day
* Some mouse-over issues for custom icons, fixed now

= 2.4.2 =
* Cute G+ icon didn't look good on dark backgrounds, fixed now
* Counts for SpecificFeeds-subscribers disabled due to high server load. We'll try to bring them back in a future plugin version. 

= 2.4.1 =
* Size of custom icons corrected
* Cute G+ icon too small before, corrected now
* Better description how to get G+ API key added
* Unsupported "live" function in jquery fixed

= 2.3.9 =
* Language issues fixed
* Counter didn't disappear before/after posts if round icons were selected - fixed now

= 2.3.8 =
* Language folder added
* Persian added as first language
* For round icons before/after posts, the counts now correctly show the counts of the post page, not necessarily the page they are on

= 2.3.7 =
* Translation errors fixed

= 2.3.6 =
* Translation errors fixed
* Icons sometimes on top of each other - fixed
* New icon function: If user has given the icon a visit-us functionality, then it already works now when clicking on the icon (i.e. no selection in tooltip required) 

= 2.3.5 =
* Errors appearing on front end fixed

= 2.3.4 =
* Plugin updated for translations
* E-NOTICE error fixed

= 2.3.3 =
* Removed the js files from plugin and using the ones provided by WP now
* POST calls optimized (sanitize, escape, validate)
* Removed feedback option
* Tags changed

= 2.3.2 =
* Feedback mechanism disabled
* Tags reduced

= 2.3.1 =
* Added Facebook share button after/before posts
* G+ design issues on black background fixed

= 2.2.9 =
* Crashes/content disappearing fixed

= 2.2.7 =
* Overkill declaration in the CSS fixed 
* Custom icons can now have mailto:-functionality
* jQuery UI issues fixed
* Rectangle G+ icon now shown as last one as it takes more space (looks better)

= 2.2.6 =
* jQuery issues/conflicts fixed
* Script issues fixed
* Count issues for icons on homepage fixed
* Text added on plugin setting's page for easier understanding
* Issue that dashboard sometimes doesn't load fixed
* Instagram thin-icon issue fixed (misspelled, therefore didn't show)
* Custom icon uploads optimized 

= 2.2.5 =
* Facebook changed their API - please upgrade if you want Facebook sharing on mobile to work properly on your site! 

= 2.2.4 =
* Custom icon uploads optimized 

= 2.2.3 =
* Houzz error message fixed 

= 2.2.2 =
* Plugin made ready for translations

= 2.2.1 =
* Feed claiming optimized

= 2.2 =
* Shortpixel link updated

= 2.1 =
* Feed claiming bug fixed

= 2.0 =
* Houzz-button integrated
* New G+ button updated
* Quicker claiming of feed possible
* Comments to share-button added
* Credit to shortpixel added

= 1.9 =
* New feature: Users can now decide where exactly the floating icons will display
* Internal links corrected
* Fixed: Targets only labels within the social icons div.
* Subscriber counts fixed
* Apostrophe issues fixed
* Conflicts with Yoast SEO plugin resolved
* PHP errors fixed

= 1.8 =
* Plugin also allows a subscription form now (question 8)!

= 1.7 =
* Count issues fixed - please upgrade!
* Style constructor updated to PHP 5
* Text adjustments in admin area

= 1.6 =
* More explanations added how to fix if counts don't work
* Icon files are compressed now for faster loading - thank you ShortPixel.com!
* A typo in the code threw an error message in certain cases, this is fixed now

= 1.5 =
* jQuery issues fixed
* Vulnerability issues fixed
* Twitter-button didn't get displayed in full sometimes, this is fixed now
* CSS issues (occurred on some templates) fixed
* Facebook updated API (so counts didn't get displayed correctly anymore), we updated the plugin accordingly
* Sometimes error messages appeared on the front end, this is fixed now

= 1.4 =
* New follow-icons added
* More "rectangle" icons added before/after posts
* Widget was rendered incorrectly on some templates, fixed now
* Icons didn't always line up (on some themes), fixed now
* Youtube API got changed, which made the counts not displayed correctly, this is now adjusted in the plugin
* Slight layout adjustments in plugin's admin area


= 1.3 =
* Links with "@" in the url (e.g. as in Flickr-links) now get recognized as well
* Alignment issues of icons in tooltip fixed
* Layout optimizations in plugin area
* Users can now select to have the number of likes of their facebook page displayed as counts of the facebook icon on their blogs
* Typos in admin area corrected
* Users can now disable auto-scaling feature for mobile devices ("viewport" meta tag)

= 1.2 =
* Vulnerabilities (AJAX) fixed 
* OG-issues (caused in conjunction with other plugins) fixed

= 1.1 =
* Og-issues fixed
* Conflicts with Yoast SEO plugin sorted
* Alignments under posts didn't work sometimes before, fixed now
* When user selected icons to shuffle pop-up didn't show up, fixed now
* Short code corrected
* On some templates the checkboxes in the admin area couldn't get selected, fixed now
* Links now to the correct review screen
* Share-box only displayed partly sometimes, fixed now
* When sharing from a Facebook business page it returned errors, this should be fixed now (to be observed) 
* Sometimes facebook share count didn't increase despite liking it, this should be fixed now (to be observed) 
* Template CSS conflicts solved in the plugin
* Facebook sharing text issues fixed

= 1.0 =
* First release

== Upgrade Notice ==

= 3.4.2 =
* Please update