<!-- =========================
 SECTION: MANY THINGS TO DO
========================== -->
<?php
  $many_things_title = get_theme_mod('many_things_title', DefManyThings::$title);
  $many_things_content = get_theme_mod('many_things_content', DefManyThings::$content);
  
  if(!empty($many_things_title) ||
     !empty($many_things_content)) { ?>
    <section id="many-things">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($many_things_title)) {
              echo '<h2 class="dark-text">'.esc_attr($many_things_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            } ?>
          </div>
          
          <!-- MANY THINGS CONTENT--> <?php
          if(!empty($many_things_content)) {
            $many_things_decoded = json_decode($many_things_content);
            echo '<div id="many-things-wrap">';
              $counter = 0;
              foreach($many_things_decoded as $many_things_item) {
                if(!empty($many_things_item->image) ||
                   !empty($many_things_item->title) ||
                   !empty($many_things_item->desc)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="many-things-row col-md-12">';
                  }
                  
                  echo '<div class="col-md-4 many-things-box">';
                  if(!empty($many_things_item->image)) {
                    echo '<img class="many-things-img" src="'.$many_things_item->image.'" alt="'.$many_things_item->title.'">';
                  }

                  if(!empty($many_things_item->title)) {
                    echo '<h3 class="colored-text">'.esc_attr($many_things_item->title).'</h3>';
                  }

                  if(!empty($many_things_item->desc)) {
                    echo '<p>'. esc_attr($many_things_item->desc).'</p>';
                  }
                  echo '</div>';
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //many-things-wrap
          } ?>
        </div>  
      </div>
    </section> <?php
  } ?>