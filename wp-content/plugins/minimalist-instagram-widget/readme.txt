=== Minimalist Instagram Widget ===
Contributors: impression11
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GPVCRVWWZJXRS
Tags: Instagram, Widget, Minimalist
Requires at least: 3.6
Tested up to: 3.9.2
Stable tag: 1.8

A quick and efficient Instagram widget to display recent Instagram Photos & Videos.

== Description ==

Minimalist Instagram Widget displays user photos using Instagram API. With minimal styling it picks up your theme’s styling to blend in seamlessly.

To avoid API limits there is an optional cache feature which can be set to expire after a user defined amount of hours.

= Features =
* Custom Widget Title
* Load User Instagram Images
* The option to display Instagram Video using the WordPress media functions.
* Smart caching retrieves the newer Images only, meaning less API calls.
* Fits in perfectly with (just about) all themes!

= Coming soon =
* Deleting of older cached images

= Support = 

We try our hardest to support users of this plugin. Please let us know if you have any issues or have found anything that could be improved upon. If we have helped you or this plugin has formed part of one of your projects please leave a positive review or donate to support future development of new features.

Something not working? [Contact Me](http://impression11.co.uk/contact/)

Enjoy using our plugin? [Donate](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GPVCRVWWZJXRS)

[View our other plugins](http://profiles.wordpress.org/impression11/)

== Installation ==

1. Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

2. Go to “Instagram Options” under Appearance and input your Access Token (link provided to attain the Access Token).

4. Go to Widgets, drag the “Minimalist Instagram Widget” to the your sidebar and define the username of the Instagram account you want to use, how many photos you’d like to display, how many to display per row and a widget Title. Alternatively you can insert a short code into a post or page as so: [minstagram username=“ethjim” count=“2” row=“1” video=“0”], replacing the username, count and rows with your specified settings.

5. To avoid strict API limits use caching to ensure that the requests to Instagram are minimal. This will cache the results and the images; this however requires the plugin folder to the writable by the Plugin itself.

== Changelog ==

= 1.8 =
* Added an option to allow the retrial of images from Instagram using HTTPS. 

= 1.7 =
* Replaced Curl Instagram retrieval with wp_get_remote(), this should allow users on hosting which has Curl disabled to load Instagram images!
* Instagram images displayed by shortcode should appear where the shortcode is placed, not before any other content.
* The option to disable this widget's lightbox for when it interferes with a theme's lightbox integration.
* Cleaned up debug mode a little.

= 1.6 =
* Added a quick Debug Mode, when enabled errors in retrieving images will display raw feed data to help in diagnosing issues.

= 1.5 =
* Fixed issue where the wrong user’s images are shown (I think the API username search on the Instagram side has stopped putting exact matches at the top).

= 1.4 =
* Fixed jQuery loading before slimbox2 in some themes (whoops!).
* New caching system based on our Minimalist Twitter Widget.
* Added a check to determine if Instagram is blocking your website through their API (this may happen because you have greatly exceeded your API limit, or because their system is overzealous).

= 1.3 =
* Allows shortcodes and widgets to pull photos from different Instagram accounts.
* Cleaned up the differences in code between building the cached file and displaying the images without a cache.
* Specified that using the User ID in the options page is now a legacy field and will only be used when a username is not set at a shortcode or widget.
* Adjusted the cache file name system to reflect the introduction of using usernames.

= 1.2 =
* Optional Instagram video display support in Wordpress 3.6 and over.
* Fixed spelling mistake on menu.

= 1.1 =
* Fixed bug that only allowed the plugin to display 1 photo.
* Added Instagram Caption to the Lightbox when available.
* Fixed bug with custom rows set-up.

= 1.0 =
* Initial release.