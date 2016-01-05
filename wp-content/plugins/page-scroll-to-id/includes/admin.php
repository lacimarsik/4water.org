<?php 
// --edit--
$repeatables=false; 
$shortcodes=false;
$plugin_info=__('<a href="#" class="mPS2id-open-help mPS2id-open-help-overview">Overview</a>&nbsp;&nbsp;&nbsp;<a href="#" class="mPS2id-open-help mPS2id-open-help-get-started">Get started</a>&nbsp;&nbsp;&nbsp;<a href="#" class="mPS2id-open-help mPS2id-open-help-plugin-settings">Plugin settings</a>&nbsp;&nbsp;&nbsp;<a href="#" class="mPS2id-open-help mPS2id-open-help-shortcodes">Shortcodes</a>', $this->plugin_slug);
$btn_add=__('Add instance', $this->plugin_slug);
$btn_more_actions=__('More actions', $this->plugin_slug);
$btn_reset=($repeatables) ? __('Delete all and reset to default', $this->plugin_slug) : __('Reset to default', $this->plugin_slug);
$toggle_instance_title=__('Click to toggle', $this->plugin_slug);
?>

<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html(get_admin_page_title()); ?></h2>
	
	<div class="plugin-header">
		<p class="plugin-info"><?php echo $plugin_info; ?></p>
		<p class="plugin-version">Version <?php echo $this->version; ?></p>
		
		<?php if(version_compare(get_bloginfo('version'), '3.6', '<')) : ?>
			<div class="oldwp-plugin-help">
				<!-- --edit-- -->
				<div class="oldwp-plugin-help-section oldwp-plugin-help-section-overview">
					<?php include_once(plugin_dir_path( __FILE__ ).'help/overview.inc'); ?>
					<p>
						<strong>For more information</strong> <br />
						<a href="http://manos.malihu.gr/page-scroll-to-id" target="_blank">Plugin homepage</a>&nbsp;&nbsp;&nbsp;<a href="http://manos.malihu.gr/page-scroll-to-id/2/" target="_blank">Code examples &amp; short tutorials</a>
					</p>
				</div>
				<div class="oldwp-plugin-help-section oldwp-plugin-help-section-get-started">
					<?php include_once(plugin_dir_path( __FILE__ ).'help/get-started.inc'); ?>
				</div>
				<div class="oldwp-plugin-help-section oldwp-plugin-help-section-plugin-settings">
					<?php include_once(plugin_dir_path( __FILE__ ).'help/plugin-settings.inc'); ?>
				</div>
				<div class="oldwp-plugin-help-section oldwp-plugin-help-section-shortcodes">
					<?php include_once(plugin_dir_path( __FILE__ ).'help/shortcodes.inc'); ?>
				</div>
			</div>
		<?php endif; ?>
		
	</div>
	
	<?php if($repeatables) : ?>
		<div class="metabox-holder">
	<?php endif; ?>

		<form id="<?php echo $this->pl_pfx; ?>form" method="post" action="options.php">
			
			<?php settings_fields($this->plugin_slug); ?>
			
			<?php echo '<input type="hidden" id="'.$this->db_prefix.'total_instances'.'" name="'.$this->db_prefix.'total_instances'.'" value="'.$this->index.'" /> '; ?>
			<?php echo '<input type="hidden" id="'.$this->db_prefix.'instances'.'" name="'.$this->db_prefix.'instances'.'" value="" /> '; ?>
			<?php echo '<input type="hidden" id="'.$this->db_prefix.'reset'.'" name="'.$this->db_prefix.'reset'.'" value="false" /> '; ?>
			
			<?php do_settings_sections($this->plugin_slug); ?>
			
			<div class="other-buttons">
				<?php if($repeatables) : ?>
					<a class="button button-small repeatable-add" href="#"><?php echo $btn_add; ?></a> 
				<?php endif; ?>
				<a class="button button-small reset-to-default" href="#"><?php echo $btn_reset; ?></a>
			</div>
			
			<?php submit_button(); ?> 
			
		</form>
	
	<?php if($repeatables) : ?>
		</div>
	<?php endif; ?>
	
	<div class="plugin-footer">
		<div class="donate">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="UYJ5G65M6ZA28">
				<span>If you like this plugin and find it useful, consider making a donation :)</span> <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	</div>

</div>

<script>
	var wpVersion="<?php echo get_bloginfo('version'); ?>",
		repeatables="<?php echo $repeatables; ?>",
		shortcodes="<?php echo $shortcodes; ?>",
		toggle_instance_title="<?php echo $toggle_instance_title; ?>";
</script>