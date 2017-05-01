<!-- =========================
 SECTION: PRICES
========================== -->
<?php
  $prices_title = get_theme_mod('prices_title', DefPrices::$title);
  $prices_content = get_theme_mod('prices_content', DefPrices::$content);
  $prices_note = get_theme_mod('prices_note', DefPrices::$note);
  $prices_student_switch = get_theme_mod('prices_student_switch', DefPrices::$student_switch);
  $prices_option_one = get_theme_mod('prices_option_one', DefPrices::$option_one);
  $prices_option_two = get_theme_mod('prices_option_two', DefPrices::$option_two);

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

          <!-- PRICES -->
          <script>
            $(document).ready(function() {
              var $options = $('.student-switch-option');
              var $prices = $('.prices-value');
              $('.student-switch-option').on('click', function() {
                if ($(this).hasClass('student-switch-selected')) {
                  return;
                }
                $options.toggleClass('student-switch-selected');
                $prices.toggle();
              });
            });
          </script>
<?php
          if ($prices_student_switch) {
?>
            <div id="student-switch-wrap">
              <div id="student-switch">
                <div class="student-switch-option student-switch-selected"><?php echo $prices_option_one ?></div>
                <div class="student-switch-option"><?php echo $prices_option_two ?></div>
              </div>
            </div>
<?php
          }

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
                  } ?>
                  <div class="col-md-4 prices-box"
<?php 
                  // the remaining elements after full row (e.g. 4th and 5th after row of 3 columns)
                  // should be centered
                  if (($counter + 1) > (round(sizeof($prices_decoded) / 3) * 3) || sizeof($prices_decoded) < 3) {
                    echo 'style="float: none;"';
                  }
?>
                  >
<?php
                  if(!empty($price->type)) {
                    echo '<h3 class="prices-type">'.esc_attr($price->type).'</h3>';
                  }

                  if(!empty($price->desc)) {
                    echo '<p class="prices-desc">'. esc_attr($price->desc).'</p>';
                  }
                  
                  if(!empty($price->length)) {
                    echo '<p class="prices-length">'. esc_attr($price->length).'</p>';
                  }
                  
                  if(!empty($price->student_price)) {
                    echo '<p class="prices-value">'. esc_attr($price->student_price).'</p>';
                  }
                  
                  if(!empty($price->non_student_price)) {
                    echo '<p class="prices-value" style="display:none">'. esc_attr($price->non_student_price).'</p>';
                  }
                  
                  echo '</div>';
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //prices-wrap
          } ?>
        </div>  
          
        <!-- NOTE -->
        <div id="prices-note">
          <p><?=$prices_note?></p>
        </div>
      </div>
    </section> <?php
  } ?>