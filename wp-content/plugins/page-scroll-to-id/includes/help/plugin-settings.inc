<?php 
$help_plugin_settings_text=<<<EOD

<p>
	<strong>Selector(s)</strong> - 
	The matching set of elements handled by the plugin (<a href="http://www.w3.org/TR/css3-selectors/" target="_blank">strings that represent ways of choosing elements in the DOM</a>). These should be anchor tags (links) with an href value in the form of <code>#id</code>. <br />
	Each selector is separated by comma, so multiple matching sets of elements can be defined as: <code>selector1, selector2, selector3</code> etc. <br />
	The default selector value is <code>a[rel='m_PageScroll2id']</code>, meaning the plugin is applied to all anchor elements with <code>m_PageScroll2id</code> rel attribute value. <br />
	Other examples: <code>a[href*='#']</code> (anchors that contain <code>#</code> in their href attribute), <code>a[href='#top']</code> (anchors with href attribute value: <code>#top</code>), <code>a.className</code> (anchors with class: <code>className</code>).
</p>

<p>
	<strong>Scroll animation speed</strong> - 
	Sets the duration of scrolling animation in milliseconds. By checking "Auto-adjust animation speed", the duration is adjusted automatically according to target element position and window scroll. This normalizes animation speed in order to avoid short-distance animations that take too long (e.g. a page scrolling of just 100 pixels will last shorter than the value specified above).
</p>

<p>
	<strong>Scroll animation easing</strong> - 
	Sets the easing type of scrolling animation (the speed at which an animation progresses at different points within the animation). <br />
	You can set different easing types: one for when page is idle (no animation currently running) and another that applies while page is animating. <br />
	<a href="http://api.jqueryui.com/easings/" target="_blank">Visual representation of all easings</a>
</p>

<p>
	<strong>Scroll-to position</strong> - 
	Adjusts automatically the scroll-to position so it does not exceed document length. For example, when scrolling to a target element that sits at the bottom of the document, the animation stops smoothly at bottom of the page, instead of breaking at an earlier point.
</p>

<p>
	<strong>Page layout</strong> - 
	Defines the page scrolling axis. Selecting <code>vertical</code> will scroll the page in the y axis (top-bottom only), while <code>horizontal</code> will scroll the page in the x axis (left-right only). To scroll both axis simultaneously select <code>auto</code>.
</p>

<p>
	<strong>Offset</strong> - 
	Defines the amount of pixels to offset the scroll-to position. The value can a be a positive or negative number, or a matching element in your html. For example, setting Offset to 50 will stop page scrolling 50 pixels before reaching the target. <br />
	If you need to offset scroll-to position accoring to the height or width of some element (e.g. accoring to a responsive, fixed-positioned navigation menu), insert its selector in the Offset field. For example, if you have a fixed menu with id <code>navigation-menu</code>, set Offset to <code>#navigation-menu</code> in order to stop page scrolling below it and avoid overlapping your content. <br />
	To set different vertical and horizontal offsets (e.g. when Layout is set to auto), add comma seperated values in Offset field, e.g. <code>100,50</code> (vertical offset 100, horizontal offset 50). <br />
	You may also define link specific offsets by using the <code>ps2id</code> shortcode in your content, e.g. <code>[ps2id url='#id' offset='100']link[/ps2id]</code>. 
</p>

<p>
	The plugin offers few extra selector expressions in order to define more advanced offsets. Examples: 
</p>

<ul>
	<li>Offset by element with id "some-id" and CSS position fixed: <code>#some-id:fixed</code> </li>
	<li>Offset by element with class "class-name" and height equal to 100 pixels: <code>.class-name:height(100)</code> </li>
	<li>Offset by element with id "some-id" and width greater than 800 pixels: <code>#some-id:width(>800)</code> </li>
	<li>Offset by element with id "some-id", CSS position fixed and height between 50 and 100 pixels: <code>#some-id:fixed:height(>50):height(<100)</code> </li>
</ul>

<p>
	<strong>Highlight selector(s)</strong> - 
	The matching set of elements already handled by the plugin (defined in Selector(s) field) that will be highlighted. <br /> 
	The plugin adds a class (specified in Classes fields) on the links whose target elements are considered to be within the viewport. Highlight selector(s) specifies those links. <br />
	Leaving the field empty (also the default setting), all selectors specified in Selector(s) field are eligible for highlighting. In case you need to highlight only a specific selector (e.g. your navigation menu links but not back-to-top links etc.), you should enter those selector(s) (e.g. <code>.menu-item a[rel='m_PageScroll2id']</code>).
</p>

<p>
	<strong>Classes</strong> - 
	Set the classes added to links and targets by the plugin: 
</p>

<ol>
	<li>The class name for the link that's been clicked </li>
	<li>The class name for the (current) target element </li>
	<li>The class name for the (current) highlighted link </li>
</ol>

<p>
	In addition, the plugin will add the above classes with the <code>-first</code> and <code>-last</code> suffix (e.g. <code>mPS2id-highlight-first</code>, <code>mPS2id-highlight-last</code>) in order to differentiate multiple highlighted elements. This is useful when you need to style only the first or last of the highlighted links or targets in your CSS.
</p>

<p>
	By checking "Force single highlight", only one highlighted element (the first one) is allowed at a time.
</p>

<p>
	Check "Keep highlight until next" when you need to keep the current element highlighted until the next one comes into view. This way at least one element always stays highlighted.
</p>

<p>
	Check "Highlight by next target" when your target elements have zero height and/or width to enable better highlighting. This option is similar to "Keep highlight until next" but it's especially useful when your target elements are in the form of <code>&lt;a id='id'&gt;&lt;/a&gt;</code>.
</p>

<p>
	<strong>Scroll to location hash</strong> - 
	Scrolls to target id (e.g. <code>&lt;div id="id" /&gt;</code>) based on location hash (e.g. <code>mysite.com/mypage#id</code>) on page load. <br />
	Enable when you need to scroll to an id in another page. <br />
	By default, this option will only work for target elements that are handled by the plugin (e.g. are connected to a link which scrolls the page via "Page scroll to id"). To enable the option for all targets (even for elements that are not handled by the plugin) check "Enable for all targets". <br />
	To set an animation delay for "Scroll to location hash", use the "Delay" field and set a value which represents milliseconds (default value is 0 meaning no delay). For example, a value of <code>500</code> will delay page scrolling by half a second after the page has loaded. 
</p>

<p>
	<strong>Disable plugin below screen-size</strong> - 
	Set a minimum width and/or height screen-size (in pixels) that's required for the plugin to be enabled. For example, insert <code>1024</code> to disable plugin functionality when window width is below 1024 pixels or <code>1024,600</code> to disable plugin when window width/height is below 1024 and 600 pixels respectively. Leave field value empty or set to 0 to disable.<br />
</p>

EOD;
?>

<?php _e($help_plugin_settings_text, $this->plugin_slug); ?>