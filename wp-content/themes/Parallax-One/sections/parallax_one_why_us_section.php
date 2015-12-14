<!-- =========================
 SECTION: WHY US
========================== -->
<?php
  $why_us_title = get_theme_mod('why_us_title', DefWhyUs::$title);
  $why_us_content = get_theme_mod('why_us_content', DefWhyUs::$content);
  
  if(!empty($why_us_title) || 
     !empty($why_us_content)) { ?>
    <section id="why-us">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($why_us_title)) {
              echo '<h2 class="dark-text">'.esc_attr($why_us_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            } ?>
          </div>
          
          <!-- WHY US CONTENT--> <?php
          if(!empty($why_us_content)) {
            $why_us_decoded = json_decode($why_us_content);
            echo '<div id="why-us-wrap">';
              $counter = 0;
              foreach($why_us_decoded as $price) {
                if(!empty($price->image) || 
                   !empty($price->reason) || 
                   !empty($price->desc)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="why-us-row col-md-12">';
                  }
                  
                  echo '<div class="col-md-4 why-us-box">';
                  if(!empty($price->image)) {
                    echo '<img class="why-us-img" src="'.$price->image.'" alt="'.$price->reason.'">';
                  }

                  if(!empty($price->reason)) {
                    echo '<h3 class="colored-text">'.esc_attr($price->reason).'</h3>';
                  }

                  if(!empty($price->desc)) {
                    echo '<p>'. esc_attr($price->desc).'</p>';
                  }
                  echo '</div>';
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //why-us-wrap
          } ?>
        </div>  
      </div>
    </section> <?php
  } ?>