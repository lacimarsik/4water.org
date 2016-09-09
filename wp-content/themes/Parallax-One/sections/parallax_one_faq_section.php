<!-- =========================
 SECTION: FAQ ACTION
========================== -->
<?php
  $faq_title = get_theme_mod('faq_title', DefFaq::$title);
  $faq_content = get_theme_mod('faq_content', DefFaq::$content);

  if(!empty($faq_title) ||
     !empty($faq_content)) { ?>
    <section id="faq">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($faq_title)) {
              echo '<h2 class="dark-text">'.esc_attr($faq_title).'</h2>';
            } ?>
          </div>

          <!-- CONTENT - FAQ -->
          <?php
          if(!empty($faq_content)) {
            $faq_decoded = json_decode($faq_content);
            echo '<div id="faq-wrap">';
              $counter = 0;
              foreach($faq_decoded as $faq_item) {
                if(!empty($faq_item->question) || 
                   !empty($faq_item->answer)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="faq-row col-md-12">';
                  } ?>
                  <div class="faq-box col-md-4">
                    <div class="faq-question">
                      <?php echo $faq_item->question; ?>
                    </div>
                    <div class="faq-answer">
                      <?php echo $faq_item->answer; ?>
                    </div>
                  </div>
                  <?php
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //faq-wrap
          } ?>
        </div>  
      </div>
    </section> <?php
  } ?>