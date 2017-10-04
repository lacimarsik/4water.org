<!-- =========================
 SECTION: SUBSCRIPTION  
============================== -->
<?php
$subscription_title = get_theme_mod('subscription_section_title',  DefSubscription::$title);
$subscription_subtitle = get_theme_mod('subscription_section_subtitle',  DefSubscription::$subtitle);
$subscription_url = get_theme_mod('subscription_section_url', DefSubscription::$url);

if(!empty($subscription_title) ||
	!empty($subscription_subtitle) ||
	!empty($subscription_url)) { ?>
	<section id="subscription">
		<div class="section-overlay-layer">
			<div class="container">
				<!-- HEADER -->
				<div class="section-header"> <?php
					if(!empty($subscription_title)) {
						echo '<h2 class="dark-text">'.esc_attr($subscription_title).'</h2>';
					} elseif (isset($wp_customize)) {
						echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
						echo '<div class="colored-line paralax_one_only_customizer"></div>';
					}
					if(!empty($subscription_subtitle)) {
						echo '<div class="sub-heading">'.esc_attr($subscription_subtitle).'</div>';
					} elseif (isset($wp_customize)) {
						echo '<div class="sub-heading paralax_one_only_customizer"></div>';
					} ?>
				</div>

				<div class="subscription">
					<link href="<?php echo $subscription_url; ?>" rel="stylesheet" type="text/css">
					<style type="text/css">
						#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
						/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
						   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
					</style>
					<div id="mc_embed_signup">
						<form action="//4water.us15.list-manage.com/subscribe/post?u=5410f150f2af255024e9e7612&amp;id=e3f5e363b0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							<div id="mc_embed_signup_scroll">
								<label for="mce-EMAIL">Subscribe to our mailing list</label>
								<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
								<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
								<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_5410f150f2af255024e9e7612_e3f5e363b0" tabindex="-1" value=""></div>
								<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
	</section> <?php
} ?>