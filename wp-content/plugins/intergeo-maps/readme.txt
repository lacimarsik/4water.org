=== WordPress Google Maps Plugin ===
Contributors: codeinwp,marius2012,marius_codeinwp,hardeepasrani,themeisle,Madalin_ThemeIsle
Tags:  directions, easy map, google, google map, google map plugin, google maps, latitude, location, longitude, map, map directions, map markers, map plugin, map widget, maps, marker, polygons, polylines, routes, store locator, streetview, wp google map, wp google maps, wp maps,plugin,admin,widget,shortcode,google maps, maps, map, map markers, google, google map, maps api, wp maps, wp google maps, easy map, embed, marker, placemark, icon, geocode, shortcode, custom post type, multisite, marker clustering
Requires at least: 3.5
Tested up to: 4.4.1
Stable tag: trunk
License: GPL v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php

A simple, easy and quite powerful Google Maps tool to create, manage and embed custom Google Maps into your WordPress posts and pages.

== Description ==

The Intergeo Google Maps WordPress plugin is a simple, easy and in the same time quite powerful tool for handling Google Maps in your website. This simple WordPress map plugin allow users to create new maps by using powerful UI builder. Created maps could be easily edited and saved with new settings. To increase the speed of creation process the plugin has ability to clone a map with all it's settings. Finally the plugin has attractive library which allows users to browse all maps in the system and delete unnecessary maps.

The powerful UI builder allows users to:

* Setup initial position and zooming level of a map;
* Adjust controls settings and positioning; 
* Setup map color styles by using predefined color schemes or by using custom color settings;
* Add overlays like markers, rectangles, circles, polylines and polygons;
* Create directions routes from A address to B address;
* Integrate AdSense service into your maps and earn money by displaying ads on maps.

### Create Google maps with shortcode ###

To create new WordPress maps you just can input simple shortcode into your post, page, text widget or taxonomy description:

`[intergeo]Your address[/intergeo]`

This shortcode will be displayed as Google Maps centered at specific address. The shortcode could be extended with custom attributes like height, width, zoom, etc. These attributes will setup special settings for a map. 

> **Time-saving features available in the Pro version:**
>
> * Custom layers for maps
> * Import markers in bulk
> * Priority email support from the developer of the plugin
> * Support and updates for 1 year
>
> **[Learn more about Intergeo Maps Pro](http://themeisle.com/plugins/intergeo-maps-pro/)**

The following table describes all possible attributes, which users can use with shortcodes:

**Width**
Sets width of the map container. Accepts all valid CSS values as css width property accepts. For example, the value could be set in pixels like 500px, or in percentage like 75%. Default value is 100%.

**Height**
Sets width of the map container. Accepts all valid CSS values as css height property accepts. For example, the value could be set in pixels like 700px. Default value is 300px.

**Style**
This attribute allows users to set extra styles for Google map's container element. It accepts all valid css properties and will echo it in the style attribute of the container element. Default value is empty.

**Zoom**
Sets the initial zoom level of the map. This attribute accepts integer value from 0 to 19, where 0 is the biggest distance and 19 is the lowest distance to the ground. The default value is 5.

**Hook**
This attribute allows users to setup their own filter, which will be used to filter settings of a map before using it to render a map. Hooks for the filter will receive one parameter which will be array of options and they have to return it modified or not.

So your shortcode could looks like this one:

`[intergeo zoom=”12” width=”50%” heigth=”400px” style=”border: 3px solid red; margin: 0 auto;”]Central Park, NY[/intergeo]`

Check-out the <a href="http://themeisle.com/plugins/intergeo-maps-lite/" rel="frield">#1 free Google Maps plugin</a>

### Create map with UI builder ###

Another way to create map is to use UI builder. This is more recommended way to build a Google map as this way provides much more features and wide range of settings to customize. To create a map with UI builder, pass following steps:

1. Create a new post or a page, or just edit existing one;
1. Place the mouse cursor into the content editor, at the place you want to embed a map and click on **Add Media** button above editor toolbar;
1. When media popup appears, find **Intergeo Maps** link in the left sidebar of popup window, click on the link;
1. Now you have to see Intergeo UI builder which allows you to customize your map;
1. Use all tools from right sidebar of the builder to create a map you need;
1. After finishing maps configuration click on **Insert into post**  button at the footer of the builder;
1. After doing it a map has to be saved in background, popup has to be closed and new appropriate shortcode has to be inserted into the place, where your cursor was.

### Using maps library ###

All maps which have been created with UI builder are stored in WordPress database. The plugin allows to browse and manage these Google maps in the maps library. To see it go to the **Media** » **Intergeo Maps** page to see all maps which have been created in your website.

The library shows you maps preview as you will see it at front end pages. Here users can copy shortcode of a Google map, edit or clone maps, and delete unnecessary or deprecated maps. 

Also users can create a Google map from library page. To do it just click on **Add New** button next to the page title and UI builder popup immediately appears. The builder interacts in the same way as it does at edit posts page, except that popup doesn't insert shortcode into somewhere, popup just save a map into database for future reuse.

Check-out the <a href="http://www.codeinwp.com/blog/intergeo-maps-plugin-review/" target="_blank" rel="friend">Intergeo review</a> and find out some of the <a href="http://www.codeinwp.com/blog/top-non-obvious-wordpress-plugins/" target="_blank" rel="friend">best WordPress plugins</a>.

== Installation ==

1. Upload the files to the `/wp-content/plugins/intergeo/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.


== Frequently Asked Questions ==

= How to override Google map settings =

To override Google map settings you can use your own hook. Just add **hook** attribute to your shortcode like this:

`[intergeo hook="my_custom_intergeo_hook" ...]...[/intergeo]`

And add a function to hook that filter:

`add_filter( 'my_custom_intergeo_hook', 'filter_intergeo_map_settings' ) {
function filter_intergeo_map_settings( $options ) {
    // update options
    $options[...] = ...;
    ...

    // return updated options
    return $options;
}`

== Screenshots ==

1. Directions Google Maps layer
2. Wather and cloud Google Maps layers
3. Panaramio layer and styles settings
4. Bicycling layer and gray styles
5. Overlay settings
6. Markers settings

== Changelog ==

= 1.0.2 =
* Fixed minZoom and maxZoom settings.

= 1.0.1 =
* Fixed compatibility with Wordpress 4.3 versions

