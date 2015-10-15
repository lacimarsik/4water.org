<!-- =========================
 SECTION: INTRODUCTION
========================== -->
<?php
	$intro_video_link = get_theme_mod('intro_video_link', 'https://www.youtube.com/embed/bs8SU24k8P4');
	$intro_video_caption = get_theme_mod('intro_video_caption','Don\'t believe us? Check the video');
  $intro_title = get_theme_mod('intro_title','Heeey, welcome on SALSA4WATER GLASGOW!');
	$intro_text = get_theme_mod('intro_text','Come and taste .....');

	if(!empty($intro_video_link) || 
     !empty($intro_video_caption) ||
     !empty($intro_text)) {
?>
		<section class="introduction" id="introduction">
			<div class="section-overlay-layer">
				<div class="container">
          <div id="intro-container">

            <!-- VIDEO -->
            <div id="intro-video">
              <?php
                if(!empty($intro_video_link)) {
              ?>
              <iframe width="100%" id="iframe-intro-video" src="<?php echo esc_url($intro_video_link) ?>" frameborder="0" allowfullscreen></iframe>
              <script type="text/javascript">
                document.getElementById("iframe-intro-video").src = document.getElementById("iframe-intro-video").src;
              </script>
              <?php
                } elseif (isset($wp_customize)) {

                }

                if(!empty($intro_video_caption)){
              ?>
              <p id="intro-video-text"><?php echo esc_attr($intro_video_caption) ?></p>
              <?php
                } elseif (isset( $wp_customize)) {}
              ?>
            </div>

            <!-- INTRO TEXT -->
            <div id="intro-text">
              <h3 class="dark-text" id="intro-title"><?php echo esc_attr($intro_title) ?></h3>
              <?php echo $intro_text ?>
            </div>
          </div>
				</div>	
			</div>
		</section>
<?php
	}
?>