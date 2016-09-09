<!-- =========================
 SECTION: CALL TO ACTION
========================== -->
<?php
  $call_to_action_title = get_theme_mod('call_to_action_title', DefCallToAction::$title);
  $call_to_action_text = get_theme_mod('call_to_action_text', DefCallToAction::$text);
  $call_to_action_content = get_theme_mod('call_to_action_content', DefCallToAction::$content);
  $call_to_action_note = get_theme_mod('call_to_action_note', DefCallToAction::$note);
  $call_to_action_big_buttons = get_theme_mod('call_to_action_big_buttons', DefCallToAction::$big_buttons);

  if(!empty($call_to_action_title) ||
     !empty($call_to_action_title) ||
     !empty($call_to_action_title) ||
     !empty($call_to_action_content)) { ?>
    <section id="call-to-action">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($call_to_action_title)) {
              echo '<h2 class="dark-text">'.esc_attr($call_to_action_title).'</h2>';
            } ?>
          </div>

          <!-- TEXT -->
          <div class="call-to-action-text"> <?php
            if(!empty($call_to_action_text)) {
              echo '<p>'.esc_attr($call_to_action_text).'</p>';
            } ?>
          </div>

          <!-- CONTENT - BUTTONS -->
          <?php
          if(!empty($call_to_action_content)) {
            $call_to_action_decoded = json_decode($call_to_action_content);
            echo '<div id="call-to-action-wrap">';
              $counter = 0;
              foreach($call_to_action_decoded as $call_to_action_item) {
                if(!empty($call_to_action_item->text) || 
                   !empty($call_to_action_item->link)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="call-to-action-row">';
                  } ?>
                  <div class="call-to-action-box">
                    <a
                        class="<?php if ($call_to_action_big_buttons) { echo 'call-to-action-button-big'; } else { echo 'call-to-action-button'; } ?> btn btn-info"
                        href="<?php echo esc_attr($call_to_action_item->link) ?>">
                      <?php echo esc_attr($call_to_action_item->text) ?>
                    </a>
                  </div>
                  <?php
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //call-to-action-wrap
          } ?>

          <!-- NOTE -->
          <?php
          if(!empty($call_to_action_note)) {
            echo '<div class="call-to-action-note">'. $call_to_action_note . '</div>';
          } ?>
        </div>  
      </div>
    </section> <?php
  } ?>