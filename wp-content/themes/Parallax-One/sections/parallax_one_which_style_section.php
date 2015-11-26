<!-- =========================
 SECTION: WHICH STYLE
========================== -->
<?php
  $which_style_title = get_theme_mod('which_style_title','DANCE4WATER STYLES');
  $which_style_subtitle = get_theme_mod('which_style_subtitle','Some introductory text');
  $which_style_dances = get_theme_mod(
    'which_style_content', 
    json_encode(
      array(
        array(
          'title' => esc_html__('CUBAN SALSA','parallax-one'),
          'text' => esc_html__('Description of the dance and blabla','parallax-one'),
          'video_url' => esc_html__('https://www.youtube.com/embed/bs8SU24k8P4', 'parallax-one'),
        ),
        array(
          'title' => esc_html__('BACHATA','parallax-one'),
          'text' => esc_html__('Description of bachata and blabla','parallax-one'),
          'video_url' => esc_html__('https://www.youtube.com/embed/iCVQmEeBfbU', 'parallax-one'),
        ),
        array(
          'title' => esc_html__('ZOUK','parallax-one'),
          'text' => esc_html__('Description of zouk and blabla','parallax-one'),
          'video_url' => esc_html__('https://www.youtube.com/embed/_QkP168_Ltc', 'parallax-one'),
        )
      )
    )
  );
  
  if(!empty($which_style_title) || 
     !empty($which_style_subtitle) ||
     !empty($which_style_dances)) {
?>
    <section id="section-which-style">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header">
<?php
            if(!empty($which_style_title)) {
              echo '<h2 class="dark-text">'.esc_attr($which_style_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            } /* @TODO - find out why this branch was here */
  ?>

  <?php
            if(!empty($which_style_subtitle)) {
              echo '<div class="sub-heading">'.esc_attr($which_style_subtitle).'</div>';
            } elseif (isset($wp_customize)) {
              echo '<div class="sub-heading paralax_one_only_customizer"></div>';
            } /* @TODO - find out why this branch was here */
?>
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
          
          <!-- DANCE STYLES -->
<?php
          if(!empty($which_style_dances)) {
            $which_style_decoded = json_decode($which_style_dances);
            echo '<div id="which-style-wrap">';
              $counter = 0;
              foreach($which_style_decoded as $service_box) {
                if(!empty($service_box->video_url)
                    || !empty($service_box->title) 
                    || !empty($service_box->text)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="which-style-row">';
                  }
                  
                  echo '<div class="col-md-4 which-style-wrap-box">';
                  echo '<div class="which-style-box">';
                  
                  //title
                  if(!empty($service_box->title)) {
                    echo '<h3 class="which-style-box-title">'.esc_attr($service_box->title).'</h3>';
                  }
                  
                  //video
                  if( !empty($service_box->video_url)) {
?>
                    <div class="which-style-video-container">
                      <iframe class="iframe-which-style-video" id="frame<?=$counter?>" src="<?=esc_url($service_box->video_url)?>" frameborder="0" allowfullscreen></iframe>
                      <script type="text/javascript">
                        document.getElementById("frame<?=$counter?>").src=document.getElementById("frame<?=$counter?>").src;
                      </script>
                    </div>
<?php
                  }

                  //text
                  if(!empty($service_box->text)) {
                    echo '<p class="which-style-box-text">'. esc_attr($service_box->text).'</p>';
                  }
                  
                  $counter++;
                  echo '</div>'; //which-style-box
                  echo '</div>'; //which-style-wrap-box
                }
              }
            echo '</div>'; //row
            echo '</div>'; //which-style-wrap
          }
?>
        </div>  
      </div>
    </section>
<?php
  }
?>