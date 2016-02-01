<!-- =========================
 SECTION: WHICH STYLE
========================== -->
<?php
  $which_style_title = get_theme_mod('which_style_title',  DefWhichStyle::$title);
  $which_style_subtitle = get_theme_mod('which_style_subtitle',  DefWhichStyle::$subtitle);
  $which_style_dances = get_theme_mod('which_style_content', DefWhichStyle::$content);
          
  if(!empty($which_style_title) || 
     !empty($which_style_subtitle) ||
     !empty($which_style_dances)) { ?>
    <section id="which-style">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($which_style_title)) {
              echo '<h2 class="dark-text">'.esc_attr($which_style_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            } /* @TODO - find out why this branch was here */ 
            
            if(!empty($which_style_subtitle)) {
              echo '<div class="sub-heading">'.esc_attr($which_style_subtitle).'</div>';
            } elseif (isset($wp_customize)) {
              echo '<div class="sub-heading paralax_one_only_customizer"></div>';
            } /* @TODO - find out why this branch was here */ ?>
          </div>
          
          <script src="<?= get_bloginfo("template_url"); ?>/js/align_col_heights.js"></script>
          <script>          
            align_which_style_boxes = function () {
              align_col_heights('which-style-row', 'which-style-box', 992);
            };
            
            //adjust the heights of boxes only in wider viewports
            $(window).load(align_which_style_boxes);
            $(window).resize(align_which_style_boxes);
          </script>
          
          <!-- DANCE STYLES --> <?php
          if(!empty($which_style_dances)) {
            $which_style_decoded = json_decode($which_style_dances);
            echo '<div id="which-style-wrap">';
              $counter = 0;
              foreach($which_style_decoded as $which_style) {
                if(!empty($which_style->url) || !empty($which_style->style) || !empty($which_style->desc)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="which-style-row col-md-12">';
                  }
                  
                  echo '<div class="col-md-4 which-style-wrap-box">';
                  echo '<div class="which-style-box">';
                  
                  //title
                  if(!empty($which_style->style)) {
                    echo '<h3 class="which-style-box-title">'.esc_attr($which_style->style).'</h3>';
                  }
                  
                  //video
                  if( !empty($which_style->url)) { ?>
                    <div class="which-style-video-container">
                      <iframe 
                          class="iframe-which-style-video" 
                          id="frame<?=$counter?>" 
                          src="<?=esc_url($which_style->url)?>" 
                          frameborder="0" 
                          allowfullscreen>
                      </iframe>
                      <script type="text/javascript">
                        //this is to refresh when changes are made
                        document.getElementById("frame<?=$counter?>").src=
                          document.getElementById("frame<?=$counter?>").src;
                      </script>
                    </div> <?php
                  }

                  //text
                  if(!empty($which_style->desc)) {
                    echo '<p class="which-style-box-text">'. esc_attr($which_style->desc).'</p>';
                  }
                  
                  $counter++;
                  echo '</div>'; //which-style-box
                  echo '</div>'; //which-style-wrap-box
                }
              }
            echo '</div>'; //row
            echo '</div>'; //which-style-wrap
          } ?>
        </div>  
      </div>
    </section> <?php
  } ?>