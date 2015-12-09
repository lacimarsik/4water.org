<!-- =========================
 SECTION: HOW WE TEACH
========================== -->
<?php
  $how_we_teach_image_1 = get_theme_mod('how_we_teach_image_1', parallax_get_file(DefHowTeach::$img1));
  $how_we_teach_caption_1 = get_theme_mod('how_we_teach_caption_1', DefHowTeach::$caption1);
  $how_we_teach_image_2 = get_theme_mod('how_we_teach_image_2', parallax_get_file(DefHowTeach::$img2));
  $how_we_teach_caption_2 = get_theme_mod('how_we_teach_caption_2', DefHowTeach::$caption2);
  $how_we_teach_text = get_theme_mod('how_we_teach_text', DefHowTeach::$text);

  if(!empty($how_we_teach_image_1) ||
     !empty($how_we_teach_caption_1) ||
     !empty($how_we_teach_image_2) ||
     !empty($how_we_teach_caption_2) ||
     !empty($how_we_teach_text)) { ?>
    <section id="how_we_teach">
      <div class="section-overlay-layer">
        <div class="container">
          <div class="how-we-teach-wrap">
            <div class="col-md-4 how-we-teach-left">
              <!-- HOW WE TEACH IMAGE 1 --> <?php
              if(!empty($how_we_teach_image_1) && !empty($how_we_teach_caption_1)) {
                echo '<img class="how-we-teach-image" src="'.$how_we_teach_image_1.'" title="'.$how_we_teach_caption_1.'" alt="'.$how_we_teach_caption_1.'">';
              } ?>
            </div>

            <div class="col-md-4 how-we-teach-center">
              <!-- HOW WE TEACH TEXT -->
              <p class="how-we-teach-text"> <?php
                if(!empty($how_we_teach_text)) {
                  echo $how_we_teach_text;
                } ?>
              </p>
            </div>

            <div class="col-md-4 how-we-teach-right">
              <!-- HOW WE TEACH IMAGE 2 --> <?php
              if(!empty($how_we_teach_image_2) && !empty($how_we_teach_caption_2)) {
                echo '<img class="how-we-teach-image" src="'.$how_we_teach_image_2.'" title="'.$how_we_teach_caption_2.'" alt="'.$how_we_teach_caption_2.'">';
              } ?>
            </div>
          </div>
        </div>	
      </div>
   </section> <?php
  } ?>