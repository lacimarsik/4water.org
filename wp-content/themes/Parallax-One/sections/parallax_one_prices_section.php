<!-- =========================
 SECTION: PRICES
========================== -->
<?php
  $prices_title = get_theme_mod('prices_title', DefPrices::$title);
  $prices = get_theme_mod('prices_content', DefPrices::$prices_content);
  
  if(!empty($prices_title) || !empty($prices_content)) { ?>
    <section id="prices">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($prices_title)) {
              echo '<h2 class="dark-text">'.esc_attr($prices_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            } ?>
          </div>
          
          <!-- CONTENT--> <?php
          if(!empty($prices_content)) {
            $prices_decoded = json_decode($prices_content);
            echo '<div id="prices-wrap">';
              $counter = 0;
              foreach($prices_decoded as $price) {
                if(!empty($price->type) || 
                   !empty($price->desc) || 
                   !empty($price->length) ||
                   !empty($price->student_price) ||
                   !empty($price->non_student_price)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="prices-row col-md-12">';
                  }
                  
                  echo '<div class="col-md-4 prices-box">';
                  
                  if(!empty($price->type)) {
                    echo '<h3 class="colored-text">'.esc_attr($price->type).'</h3>';
                  }

                  if(!empty($price->desc)) {
                    echo '<p>'. esc_attr($price->desc).'</p>';
                  }
                  
                  if(!empty($price->length)) {
                    echo '<p>'. esc_attr($price->length).'</p>';
                  }
                  
                  if(!empty($price->student_price)) {
                    echo '<p>'. esc_attr($price->student_price).'</p>';
                  }
                  
                  if(!empty($price->non_student_price)) {
                    echo '<p>'. esc_attr($price->non_student_price).'</p>';
                  }
                  
                  echo '</div>';
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //prices-wrap
          } ?>
        </div>  
      </div>
    </section> <?php
  } ?>