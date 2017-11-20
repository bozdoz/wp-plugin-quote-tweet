=== Quote Tweet ===
Author: bozdoz
Author URI: http://www.twitter.com/bozdoz/
Plugin URI: http://wordpress.org/plugins/quote-tweet/
Contributors: bozdoz
Donate link: https://www.gittip.com/bozdoz/
Tags: twitter, tweet, text selection, share, social media
Requires at least: 3.0.1
Tested up to: 4.9
Version: 0.7
Stable tag: 0.7
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that shows a link when a user selects text on your WordPress site to quote that text, with the current URL, in a tweet.

== Description ==

Let your visitors share a quote from your pages with Quote Tweet!  

When a visitor selects text from one of your pages, a prompt appears for them to share the quote, with the current page URL, to Twitter.

Check out the source code on [GitHub](https://github.com/bozdoz/wp-plugin-quote-tweet)!

== Installation ==

1. Choose to add a new plugin, then click upload
2. Upload the quote-tweet zip
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Try selecting text on one of your pages, to see the Twitter icon pop up.

== Frequently Asked Questions ==

None yet! Shoot me a question [@bozdoz](http://www.twitter.com/bozdoz/).

== Screenshots ==

1. Select text to see the prompt.

== Changelog ==

= 0.7 =
* Added default hashtags.

= 0.6 =
* Fix to overwritten variable which wiped text selection in 0.5 (sorry, all affected).

= 0.5 =
* Added timeouts, contextmenu event, and `addEventListener` for all events.

= 0.4 =
* Added z index so that the popup will show up on most sites; added retina Twitter logo.

= 0.3 =
* Tightened whitespace and comments, made globals explicit; eventually moved most of the plugin into a function executed on the `init` action.

= 0.2 =
* Should be more compatible with other plugins.

= 0.1 =
* First Version. Select text to see Twitter prompt.

== Upgrade Notice ==

= 0.7 =
Added default hashtags.

= 0.6 =
Critical fix to some sloppy code in 0.5.

= 0.5 =
Right-click doesn't hide selection; popup show/hide is more accurate with delayed checks for selection; added addEventListeners for all events.

= 0.4 =
Fixed issue where popup didn't show up on some sites due to z-indexing; added retina support.

= 0.3 =
Fixed warning of # of characters of unexpected output

= 0.2 =
Removed windows.onload and moved script to the bottom of page for compatibility with other plugins and to save on load time.

= 0.1 =
First Version.