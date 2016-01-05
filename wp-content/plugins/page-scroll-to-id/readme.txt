=== Page scroll to id ===
Contributors: malihu
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UYJ5G65M6ZA28
Tags: page scrolling, page animation, navigation, single-page navigation
Requires at least: 3.3
Tested up to: 4.4
Stable tag: 1.6.0
License: The MIT License (MIT)
License URI: http://opensource.org/licenses/MIT

Page scroll to id is an easy-to-use jQuery plugin that enables animated page scrolling to specific id within the document.

== Description ==

The plugin replaces the default browser behaviour of "jumping" to page sections when links with href value containing `#` are clicked, by smoothly animating the page to those sections. You can use it for simple back-to-top links or complex, single-page website navigation and features include: 

* Auto-adjustable animation speed
* Advanced animation easings
* Vertical and/or horizontal scrolling
* Links and targets highlighting via ready-to-use classes
* Auto-adjustable scroll-to position 
* Advanced scroll-to position offset (by pixels, by element selector, link specific offsets etc.) 
* Page scrolling from/to different pages (scrolling to location hash)

= Demo =

* [Plugin demo: vertical layout](http://manos.malihu.gr/repository/page-scroll-to-id/demo/demo.html) 
* [Plugin demo: horizontal layout](http://manos.malihu.gr/repository/page-scroll-to-id/demo/demo-horizontal-layout.html) 
* [Plugin demo: auto layout](http://manos.malihu.gr/repository/page-scroll-to-id/demo/demo-auto-layout.html) 

= Requirements =

Page scroll to id requires WordPress version **3.3** or higher and jQuery version **1.6.0** or higher. For older installations implement it in your theme [manually](http://manos.malihu.gr/page-scroll-to-id/). Your theme **must** (and should) have `wp_head()` and `wp_footer()` functions. In some MS Windows based web servers the plugin might produce an error 500 (depends on server/PHP configuration). To pinpoint the issue [enable debugging](https://codex.wordpress.org/Debugging_in_WordPress) in `wp-config.php` and check `wp-content/debug.log` file for relevant errors.

= Quick usage =

1. [Install the plugin](http://wordpress.org/plugins/page-scroll-to-id/installation/). 
2. Add `rel="m_PageScroll2id"` to your links that point to existing sections within your page, making sure each link's href value contains a hash (`#`) with the id of the section you want to scroll-to. To enable the rel attribute field in WordPress Menus, click 'Screen Options' and check 'Link Relationship (XFN)'. To enable the plugin on a menu item, click the arrow on the right of the item and insert `m_PageScroll2id` in the 'Link Relationship (XFN)' field.

= Tutorials =

* [Page scroll to id for WordPress tutorial](http://manos.malihu.gr/page-scroll-to-id-for-wordpress-tutorial/)

For more information see Help in plugin settings and resources below. 

= Plugin Resources =

* [Plugin homepage](http://manos.malihu.gr/page-scroll-to-id/)
* [FAQ](http://wordpress.org/plugins/page-scroll-to-id/faq/)
* [Support](http://wordpress.org/support/plugin/page-scroll-to-id)

== Installation ==

= Automatic =

1. Click 'Add New' under 'Plugins' menu in WordPress. 
2. Perform a search for the term 'Page scroll to id' and in search results, click 'Install/Install Now' under plugin name. 
3. When installation is finished, click 'Activate Plugin'. 

= Manual =

1. Download and extract the plugin. 
2. Upload the entire `page-scroll-to-id` folder to `/wp-content/plugins/` directory. 
3. Activate the plugin through the 'Plugins' menu in WordPress. 

= Configuration =

Configure plugin options by clicking 'Settings' or through the 'Settings > Page Scroll to id' menu in WordPress. 

== Frequently Asked Questions ==

= How to use the plugin with WP custom/native menus? =

While on the 'Menus' admin page, click 'Screen Options' and check 'Link Relationship (XFN)'. To enable the plugin on a menu item (added to menu via 'Custom Links' panel), click the arrow on the right of the item and insert `m_PageScroll2id` in the 'Link Relationship (XFN)' field (assuming your menu contains links with `URL` value in the form of `#id`). 

= How to use the plugin without editing my theme's markup? =

In plugin's configuration page ('Settings > Page Scroll to id' menu in WordPress), you can change the `Selector(s)` field value to existing matching sets of elements in your theme. For example: `a.class-name`, `#id a`, `a[href*='#']` etc. For multiple selectors, use comma separated values: e.g. `a[rel='m_PageScroll2id'], a.class-name`.

= What if my links have rel values already set by the theme or other plugins? =

You can add the `m_PageScroll2id` in your link's rel attribute (along with the other values) and change the `Selector(s)` field value to `a[rel~='m_PageScroll2id']` in plugin settings. 

= How do I highlight current menu items? =

The plugin provides a ready-to-use class for styling highlighted links (the links whose target element is considered to be within the viewport). The default highlight class is `mPS2id-highlight`, so you can use it in your theme's CSS to style current menu items, e.g. `.menu-item a.mPS2id-highlight{ background: #ff0; }`. 

= More than one links are highlighted! How to highlight only the first one? =

Use the `mPS2id-highlight-first` class in your stylesheet (instead of just `mPS2id-highlight`). This class is added by the script on the first link whose target element is considered to be within the viewport, e.g. `.menu-item a.mPS2id-highlight-first{ background: #ff0; }`. Alternatively, enable 'Force single highlight' option in plugin settings.

= How to keep my links highlighted when my target elements have 0 height? =

Enable 'Keep highlight until next' option in plugin settings, which keeps the current highlighted element on until the next one comes into view. 

= When I click the link, nothing happens... =

Make sure your link has href value `#` with the id of the section you want to scroll-to (e.g. `<a href="#id" rel="m_PageScroll2id">link</a>`) and a section with such an id exists in your page (e.g. `<div id="id">target</div>`). 

= How do I make my links work from other/different pages =

To make your links work from any page, you need to add the full address in your links href (instead of just the hash with the id). For example, you'll need to change `<a href="#id" rel="m_PageScroll2id">link</a>` to something like `<a href="http://mysite.com/some-page/#id" rel="m_PageScroll2id">link</a>`. The same applies for your WP custom menus. You'll need to insert the full address in the `URL` field. To enable page scrolling to URL location hash on page load, check `Scroll to location hash` in plugin settings.

= The page doesn't scroll exactly where I want =

The scroll-to position is the top position of your target element. Your target's top position does not include its margins, so make sure to check your element's actual position via your browser's developer tools and change your CSS if needed. You can also offset the scroll-to position by setting an `offset` value (in pixels) in plugin's settings. 

= The page doesn't scroll to the very top =

Your target element is probably not at the very top (check its position via your browser's developer tools). If your link has href value `#top` and no target with id `top` exists in your page, the plugin will automatically scroll the page to the very top (the position of the `body` tag). 

= How to prevent my fixed navigation menu overlapping the content? =

Insert your menu selector in the Offset field in plugin settings. For example, if you have a fixed menu with id `navigation-menu`, set Offset to `#navigation-menu` in order to stop page scrolling below it and avoid overlapping your content. 

= Can I set different vertical and horizontal offsets? =

Yes, by inserting comma separated values in `Offset` field For example `100,50` will set vertical offset to 100 and horizontal offset to 50 pixels.

= Can I specify link specific offset values? =

Yes, by adding the html attribute `data-ps2id-offset` to a link. For example, `<a href="#id" rel="m_PageScroll2id" data-ps2id-offset="100">link</a>` will offset scroll-to position by 100 pixels. You may also use the `ps2id` shortcode to create links with specific offsets, e.g. `[ps2id url='#id' offset='100']link[/ps2id]`. 

= How do I disable the plugin on small screens? =

Use the 'Disable plugin below screen-size' option in plugin settings. You can set a minimum width,height value required in order to enable plugin functionality.

= Can I use the plugin to scroll an overflowed div? =

No. The plugin scrolls the entire page (the document's root element) so it works correctly highlighting links, alongside deep linking plugins etc. with mouse and touch events. 

= Do you support Internet Explorer 7? =

No. IE7 usage is non-existent. 

= Does the plugin offer user defined callbacks, scroll-to method or some other advanced feature? =

Yes but you probably need to implement the plugin in your theme **manually**. See [Plugin homepage](http://manos.malihu.gr/page-scroll-to-id/) for more info.

== Screenshots ==

1. Page scoll to id settings 

2. Page scoll to id settings help 

== Changelog ==

= 1.6.0 =
* Fixed contextual help shortcut links in plugin settings page. 
* Added new option 'Enable for all targets' for 'Scroll to location hash'. 
* Added new option 'Delay' for 'Scroll to location hash'. 
* Fixed an issue regarding invalid selectors with location hash. 
* Updated readme.txt.
* Updated help.

= 1.5.9 =
* Extended `ps2id` shortcode for creating `div` elements (in addition to anchors). 
* Added `ps2id_wrap` shortcode for creating target wrappers in content editor. 
* Extended offset selector expressions with `:position`, `:height()` and `:width()`.
* Updated readme.txt.
* Updated help.

= 1.5.8 =
* Fixed various PHP notices in debug mode. 
* Minor script optimizations. 

= 1.5.7 =
* Added 'Highlight by next target' option. When enabled, highlight elements according to their target and next target position (useful when targets have zero dimensions).
* Extended `ps2id` shortcode for creating targets in content editor. 

= 1.5.6 =
* Changed the way 'Force single highlight' option works. When enabled, it now highlights the first highlighted element instead of last.
* Extended highlight and target classes with additional ones in order to differentiate the first and last elements. You can now use `.mPS2id-highlight-first`, `.mPS2id-highlight-last`, `.mPS2id-target-first` and `.mPS2id-target-last` in order to target the first and last highlighted links and targets in your CSS.
* Added 'Keep highlight until next' option. When enabled, the plugin will keep the current link/target highlighted until the next one comes into view (one element always stays highlighted).
* Added 'Disable plugin below screen-size' option. Set the screen-size (in pixels), below which the plugin will be disabled. 

= 1.5.5 =
* Fixed contextual help links in plugin settings page.
* Updated Offset field to accept comma separated values for defining different offsets for vertical and horizontal layout (e.g. `100,50`).
* Added 'Scroll to location hash' option. When enabled, the plugin will scroll to target id (e.g. `<div id="id" />`) based on location hash (e.g. `mysite.com/mypage#id`) on page load.
* Updated readme.txt.
* Updated help.

= 1.5.4 =
* Fixed a minor bug in jquery.malihu.PageScroll2id-init.js.
* Updated screenshots.
* Updated readme.txt.

= 1.5.3 =
* Extended Offset option to accept element selectors in addition to fixed pixels values. 
* Added `ps2id` shortcode for creating links in content editor. 
* Added the ability to define link specific offsets via the html data attribute: `data-ps2id-offset`. 
* Fixed some minor issues for WordPress versions lower than 3.5. 
* Updated help and external links. 
* Changed plugin license from LGPL to MIT. 

= 1.5.2 =
* Minor code tweaks. 

= 1.5.1 =
* Minor code tweaks. 
* Minified scripts. 

= 1.5.0 =
* Dropped jQuery UI dependency (jQuery UI is no longer required for the plugin to work). 
* Fixed the bug of non-working links to other pages. The script now checks if href values refer to the parent document, before preventing the default behavior. 
* Fixed the bug regarding selectors referencing body class not working. 
* Any link handled by the plugin with href value `#top` will now scroll the page to top, if no element with id `top` exists.  
* Added links highlighting feature. The script adds a class (default: `mPS2id-highlight`) automatically on links  whose target elements are considered to be within the viewport. 
* Plugin adds a class (default: `mPS2id-target`) automatically on targets that are considered to be within the viewport. 
* Plugin adds a class (default: `mPS2id-clicked`) automatically on the link that has been clicked. 
* Added `offset` option: Offsets scroll-to position by x amount of pixels (positive or negative). 
* The plugin script now fully validates href values and ids before scrolling the page. 
* Fixed varius minor bugs. 
* Code rewritten and optimized for better performance and maintenance. 
* For more see [Plugin changelog](http://manos.malihu.gr/page-scroll-to-id/4/). 

= 1.2.0 =
* Added support for jQuery version 1.9.

= 1.1.0 =
* Removed the hard-coded plugin directory URL in order to fix errors of pointing .js files to a wrong location.

= 1.0.0 =
* Launch!

== Upgrade Notice ==

= 1.6.0 =

Fixed some (minor) issues in admin and front-end, added new options (Enable for all targets' and 'Delay') for 'Scroll to location hash', updated help and readme.txt.

= 1.5.9 =

Extended `ps2id` shortcode, added `ps2id_wrap` shortcode, extended offset selector expressions, updated help and readme.txt.

= 1.5.8 =

Fixed various PHP notices in debug mode, minor script optimizations.  

= 1.5.7 =

Added 'Highlight by next target' option and extended `ps2id` shortcode for creating targets in content editor. 

= 1.5.6 =

'Force single highlight' option will now highlight the first element instead of last, Extended highlight and target classes with additional ones, Added 'Keep highlight until next' and 'Disable plugin below screen-size' options, extended help, updated readme.txt.

= 1.5.5 =

Fixed contextual help links in plugin settings, define different offsets for vertical and horizontal layout, Added 'Scroll to location hash' option, updated readme.txt.

= 1.5.4 =

Fixed a minor bug in jquery.malihu.PageScroll2id-init.js, updated screenshots and readme.txt.

= 1.5.3 =

Extended Offset option, added shortcodes for link creation, updated documentation and added more external resources. 

= 1.5.0 =

Dropped jQuery UI dependency, fixed bugs, added links highlighting, optimized scripts and extended documentation. 

== License ==

MIT

You should have received a copy of the MIT License along with this program. 
If not, see <http://opensource.org/licenses/MIT>.

== Donate ==

If you like this plugin and find it useful, consider making a [donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UYJ5G65M6ZA28) :). 

== External resources ==

* [Smooth scrolling between page sections using Page scroll to id](http://sridharkatakam.com/smooth-scrolling-page-sections-using-page-scroll-id/)
* [Video tutorial: How to create a single page WordPress website](http://www.pootlepress.com/2013/02/video-tutorial-a-beginners-guide-on-how-to-create-a-single-page-wordpress-website/)