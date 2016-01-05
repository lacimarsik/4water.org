<?php
$help_shortcodes_text=<<<EOD

<p>
	<strong>Create link</strong> - <code>[ps2id url='#id' offset='0']link[/ps2id]</code>
</p>

<p>
	<strong>Create link shrotcode attributes</strong> 
</p>

<ul>
	<li>
		<code>url</code> - link URL (the target element id the link points to) <br /> 
		Examples: <br /> 
		<code>[ps2id url='#some-id']link[/ps2id]</code> <br />
		<code>[ps2id url='http://somesite.com/somepage/#some-id']link[/ps2id]</code>
	</li>
	<li>
			<code>offset</code> - link specific offset <br /> 
			Examples: <br /> 
			<code>[ps2id url='#id' offset='100']link[/ps2id]</code> - offset by 100 pixels <br />
			<code>[ps2id url='#id' offset='#navigation-menu']link[/ps2id]</code> - offset by element's height/width/position <br />
			<code>[ps2id url='#id' offset='{"y":"100","x":"50"}']link[/ps2id]</code> - offset vertically by 100 pixels and horizontally by 50 
	</li>
</ul>

<p>
	<strong>Create target</strong> - <code>[ps2id id='id' target=''/]</code>
</p>

<p>
	<strong>Create target shrotcode attributes</strong> 
</p>

<ul>
	<li>
		<code>id</code> - target element id <br /> 
		Examples: <br /> 
		<code>[ps2id id='some-id'/]</code> 
	</li>
	<li>
			<code>target</code> - the element that will be considered as the actual target (useful when you need proper highlighting with targets that have zero dimensions) <br /> 
			Examples: <br /> 
			<code>[ps2id id='some-id' target='#id + div'/]</code> - set the target as the next div from the #some-id element <br />
			<code>[ps2id id='some-id' target='#another-id'/]</code> - set the target as the element with id: another-id 
	</li>
</ul>

<p>
	<strong>Create target wrapper</strong> - <code>[ps2id_wrap id='id'] content... [/ps2id_wrap]</code>
</p>

<p>
	Examples: <br /> 
	<code>[ps2id_wrap id='some-id'] content... [/ps2id_wrap]</code> <br />
	<code>[ps2id_wrap id='another-id'] content... [ps2id url='#id']link[/ps2id] [/ps2id_wrap]</code> 
</p>

EOD;
?>

<?php _e($help_shortcodes_text, $this->plugin_slug); ?>