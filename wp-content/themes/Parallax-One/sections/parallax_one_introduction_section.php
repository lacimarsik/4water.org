<!-- =========================
 SECTION: INTRODUCTION
========================== -->
<?php
  $intro_video_link = get_theme_mod('intro_video_link', DefIntro::$video_link);
  $intro_video_caption = get_theme_mod('intro_video_caption', DefIntro::$video_caption);
  $intro_title = get_theme_mod('intro_title', DefIntro::$title);
  $intro_text = get_theme_mod('intro_text', DefIntro::$text);

  if(!empty($intro_video_link) || 
     !empty($intro_video_caption) ||
     !empty($intro_title) ||
     !empty($intro_text)) { ?>
    <section class="introduction" id="introduction">
      <div class="section-overlay-layer">
        <div class="container">
          <div id="intro-container">
            <!-- INTRO TEXT -->
            <div id="intro-text" class="col-md-7 col-md-push-5">
              <h3 class="dark-text" id="intro-title"><?php echo esc_attr($intro_title) ?></h3>
              <?php echo $intro_text ?>
            </div>
              
            <!-- VIDEO -->
            <div class="col-md-5 col-md-pull-7">
              <div id="intro-video-container"> <?php
                if(!empty($intro_video_link)) { ?>
                  <iframe id="iframe-intro-video" src="<?php echo esc_url($intro_video_link) ?>" frameborder="0" allowfullscreen></iframe>
                  <script type="text/javascript">
                    document.getElementById("iframe-intro-video").src = document.getElementById("iframe-intro-video").src;
                  </script> <?php
                } ?>
              </div> <?php

              if(!empty($intro_video_caption)){ ?>
                <p id="intro-video-text"><?php echo esc_attr($intro_video_caption) ?></p> <?php
              } ?>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>  
      </div>
    </section> <?php
  } ?>