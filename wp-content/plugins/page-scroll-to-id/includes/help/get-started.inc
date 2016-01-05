<?php
$help_get_started_text=<<<EOD

<p>
	The plugin works simply by connecting links in the form of <code>&lt;a href="#id"&gt;link&lt;/a&gt;</code>, to sections within the document, in the form of <code>&lt;div id="id"&gt;target&lt;/div&gt;</code>. Clicking the links will smoothly animate the page to the connected sections, provided the links are included in the Selector(s) field. <br />
	The default value of Selector(s) is <code>a[rel='m_PageScroll2id']</code>, meaning the plugin will apply on links with <code>m_PageScroll2id</code> rel attribute value (e.g. <code>&lt;a href="#id" rel="m_PageScroll2id"&gt;link&lt;/a&gt;</code>). 
</p>

<p>
	<strong>Get started</strong> by adding <code>rel="m_PageScroll2id"</code> to your links that point to existing sections within your page, making sure each link's href value contains a hash (<code>#</code>) with the id of the section you want to scroll-to. 
</p>

<p>
	To add <code>rel="m_PageScroll2id"</code> to links in custom menus (menus created in Appearance &rsaquo; Menus), do the following: <br />
	While on the Menus admin page, click "Screen Options" and check "Link Relationship (XFN)". To enable the plugin on a menu item, click the arrow on the right of the item and insert <code>m_PageScroll2id</code> in the "Link Relationship (XFN)" field (assuming your menu contains links with "URL" value in the form of <code>#id</code>). 
</p>

<p>
	If you cannot edit your html markup or don't want to alter your links rel attributes, you can change the Selector(s) field value to existing matching sets of elements in your theme, e.g. <code>a.class-name</code>, <code>#id a</code>, <code>a[href*='#']</code> etc. For multiple selectors, use comma separated values: e.g. <code>a[rel='m_PageScroll2id'], a.class-name</code>.
</p>

<p>
	To highlight your links and/or targets, use the class(es) provided by the plugin in your theme's stylesheet. The default highlight class is <code>mPS2id-highlight</code> but you can set your own in the Classes fields below. <br />
	For example, to style the highlighted link (the link whose target element is considered to be within the viewport), you could add in your CSS: <br />
	<code>a.mPS2id-highlight{ background: #ff0; }</code> or <code>.menu-item a.mPS2id-highlight{ background: #ff0; }</code> for highlighting custom menus links only.
</p>

<p>
	If you have a fixed-positioned menu which overlaps your target's content when page scrolling is completed, insert your menu selector in the Offset field. For example, inserting <code>#navigation-menu</code> will offset the scroll-to position according to the height/width/position of the element with id <code>navigation-menu</code>. 
</p>

EOD;
?>

<?php _e($help_get_started_text, $this->plugin_slug); ?>