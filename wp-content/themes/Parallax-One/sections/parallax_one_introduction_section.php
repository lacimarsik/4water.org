<!-- =========================
 SECTION: INTRODUCTION
========================== -->
<?php
  $intro_use_video = get_theme_mod('intro_use_video', DefIntro::$use_video);
  $intro_video_link = get_theme_mod('intro_video_link', DefIntro::$video_link);
  $intro_video_caption = get_theme_mod('intro_video_caption', DefIntro::$video_caption);
  $intro_image = get_theme_mod('intro_image', parallax_get_file(DefIntro::$image));
  $intro_image_caption = get_theme_mod('intro_image_caption', DefIntro::$image_caption);
  $intro_title = get_theme_mod('intro_title', DefIntro::$title);
  $intro_text = get_theme_mod('intro_text', DefIntro::$text);
  $intro_under_construction_text = get_theme_mod('intro_under_construction_text', DefIntro::$under_construction_text);
  $intro_under_construction_link = get_theme_mod('intro_under_construction_link', DefIntro::$under_construction_link);
  $intro_under_construction_link_text = get_theme_mod('intro_under_construction_link_text', DefIntro::$under_construction_link_text);

  if(!empty($intro_video_link) || 
     !empty($intro_video_caption) ||
     !empty($intro_video_caption) ||
     !empty($intro_image) ||
     !empty($intro_text) ||
     !empty($intro_under_construction_text) ||
     !empty($intro_under_construction_link) ||
     !empty($intro_under_construction_link_text)) { ?>
    <section class="introduction" id="introduction">
      <div class="section-overlay-layer">
        <div class="container">
          <div id="intro-container">
            <!-- INTRO TEXT -->
            <div id="intro-text" class="col-md-7 col-md-push-5">
              <h3 class="dark-text" id="intro-title"><?php echo esc_attr($intro_title) ?></h3>
              <?php echo $intro_text ?>
              <?php if (!empty($intro_under_construction_text) ||
                !empty($intro_under_construction_link) ||
                !empty($intro_under_construction_link_text)) { ?>
                <div id="intro-under-construction">
                  <?php echo $intro_under_construction_text; ?> <a
                    href="<?php echo $intro_under_construction_link; ?>"><?php echo $intro_under_construction_link_text; ?></a>
                </div>
                <?php
              }
              ?>
            </div>
<?php
            if ($intro_use_video) {
?>
              <!-- VIDEO -->
              <div class="col-md-5 col-md-pull-7">
                <div id="intro-video-container"> <?php
                  if (!empty($intro_video_link)) { ?>
                    <iframe id="iframe-intro-video" src="<?php echo esc_url($intro_video_link) ?>" frameborder="0"
                            allowfullscreen></iframe>
                    <script type="text/javascript">
                      document.getElementById("iframe-intro-video").src = document.getElementById("iframe-intro-video").src;
                    </script> <?php
                  } ?>
                </div> <?php
    
                if (!empty($intro_video_caption)) { ?>
                  <p id="intro-video-text"><?php echo esc_attr($intro_video_caption) ?></p> <?php
                } ?>
              </div>
<?php
            } else {
?>
              <!-- IMAGE -->
              <div class="col-md-5 col-md-pull-7">
                <div id="intro-image-container"> <?php
                  if(!empty($intro_image) && !empty($intro_image_caption)) {
                    echo '<img class="intro-image" src="'.$intro_image.'" title="'.$intro_image_caption.'" alt="'.$intro_image_caption.'">';
                  } ?>
                </div>
              </div>
<?php
            }
?>
            <div class="clearfix"></div>
          </div>
        </div>  
      </div>
    </section> <?php
  } ?>