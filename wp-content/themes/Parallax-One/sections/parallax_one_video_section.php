<!-- =========================
 SECTION: VIDEO
========================== -->
<?php
  $video_link = get_theme_mod('video_link', DefVideo::$video_link);
  $video_caption = get_theme_mod('video_caption', DefVideo::$video_caption);
  $video_title = get_theme_mod('video_title', DefVideo::$title);
  $video_text = get_theme_mod('video_text', DefVideo::$text);

  if(!empty($video_link) || 
     !empty($video_caption) ||
     !empty($video_title) ||
     !empty($video_text)) { ?>
    <section class="video-section" id="video-section">
      <div class="section-overlay-layer">
        <div class="container">
          <div id="video-container">
            <!-- VIDEO TITLE -->
              <h2 class="dark-text" id="video-title"><?php echo esc_attr($video_title) ?></h2>
              <!-- VIDEO TEXT -->
              <div class="subtitle"><?php echo $video_text ?></div>
              <!-- VIDEO -->
                <div id="video-container"> <?php
                  if (!empty($video_link)) { ?>
                    <iframe id="iframe-videosection-video" src="<?php echo esc_url($video_link) ?>" frameborder="0"
                            allowfullscreen></iframe>
                    <script type="text/javascript">
                      document.getElementById("iframe-videosection-video").src = document.getElementById("iframe-videosection-video").src;
                    </script> <?php
                  } ?>
                </div> <?php
    
                if (!empty($video_caption)) { ?>
                  <p id="video-caption"><?php echo esc_attr($video_caption) ?></p> <?php
                } ?>
          </div>
        </div>  
      </div>
    </section> <?php
  } ?>