<!-- =========================
 SECTION: CALL TO ACTION
========================== -->
<?php
  $call_to_action_title = get_theme_mod('call_to_action_title', DefCallToAction::$title);
  $call_to_action_text = get_theme_mod('call_to_action_text', DefCallToAction::$text);
  $call_to_action_content = get_theme_mod('call_to_action_content', DefCallToAction::$content);
  $call_to_action_payments_heading = get_theme_mod('call_to_action_payments_heading', DefCallToAction::$payments_heading);
  $call_to_action_payments_note = get_theme_mod('call_to_action_payments_note', DefCallToAction::$payments_note);
  $call_to_action_payments_image = get_theme_mod('call_to_action_payments_image', parallax_get_file(DefCallToAction::$payments_image));
  $call_to_action_payments = get_theme_mod('call_to_action_payments', DefCallToAction::$payments);
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
              echo '<h2 class="dark-text  call-to-action-header">'.esc_attr($call_to_action_title).'</h2>';
            } ?>
          </div>

          <!-- TEXT -->
<?php
          if(!empty($call_to_action_text)) {
?>
          <div class="call-to-action-text"> <?php
              echo '<p>'.esc_attr($call_to_action_text).'</p>'; ?>
          </div>
<?php
          }
?>

          <!-- SCRIPT TO SHOW/HIDE UP PAYMENTS SECTION -->
          <script>
            function openPaymentSection() {
              document.getElementById("call-to-action-payments-wrap").style.display = 'block';
              var openButtons = document.getElementsByClassName("open-button");
              for (var i = 0; i < openButtons.length; i++) {
                openButtons[i].style.display = "none";
              }
              document.getElementsByClassName("close-button")[0].style.display = "inline-block";
            }

            function closePaymentSection() {
              document.getElementById("call-to-action-payments-wrap").style.display = 'none';
              var openButtons = document.getElementsByClassName("open-button");
              for (var i = 0; i < openButtons.length; i++) {
                openButtons[i].style.display = "inline-block";
              }
              document.getElementsByClassName("close-button")[0].style.display = "none";
            }
          </script>

          <!-- CONTENT - BUTTONS -->
          <?php
          if (!empty($call_to_action_content)) {
            $call_to_action_decoded = json_decode($call_to_action_content);
            echo '<div id="call-to-action-wrap">';
              $counter = 0;
              foreach($call_to_action_decoded as $call_to_action_item) {
                if (!empty($call_to_action_item->text) || 
                   !empty($call_to_action_item->link)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="call-to-action-row">';
                  } ?>
                  <div class="call-to-action-box">
                    <a
                        class="<?php if ($call_to_action_big_buttons) {
                          echo 'call-to-action-button-big';
                        } else {
                          echo 'call-to-action-button';
                        } ?> btn btn-info <?php if ($call_to_action_item->is_payment == "yes") {
                          echo 'open-button';
                        } ?>"

                        <?php if ($call_to_action_item->is_payment == "yes") {
                          echo 'onClick="openPaymentSection();"';
                        } else {
                          echo 'href="' . esc_attr($call_to_action_item->link) . '"';
                        }?>>
                      <?php echo esc_attr($call_to_action_item->text) ?>
                    </a>
                    <?php if ($call_to_action_item->is_payment == "yes") { ?>
                      <a
                        class="<?php if ($call_to_action_big_buttons) {
                          echo 'call-to-action-button-big';
                        } else {
                          echo 'call-to-action-button';
                        } ?> btn btn-info close-button"
                        onClick="closePaymentSection();">
                        <?php echo esc_attr($call_to_action_item->text) ?>
                      </a>
<?php
                    }
?>
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
<?php
          if (!empty($call_to_action_payments)) {
            $call_to_action_payments_decoded = json_decode($call_to_action_payments);
            echo '<div id="call-to-action-payments-wrap">';
            if (!empty($call_to_action_payments_heading)) {
              echo '<h2>' . $call_to_action_payments_heading . '</h2>';
            }
            if (!empty($call_to_action_payments_note)) {
              echo '<div class="call-to-action-payments-note">' . $call_to_action_payments_note . '</div>';
            }
            if (!empty($call_to_action_payments_image) && !empty($call_to_action_payments_note)) {
              echo '<img class="call-to-action-payments-image" title="' . $call_to_action_payments_note . '" src="' . $call_to_action_payments_image . '" />';
            }
            echo '<div id="call-to-action-payments">';
            $counter = 0;
            foreach ($call_to_action_payments_decoded as $payment) {
              if(!empty($payment->hosted_button_id) ||
                !empty($payment->description) ||
                !empty($payment->student_charge) ||
                !empty($payment->non_student_charge) ||
                !empty($payment->field_description) ||
                !empty($payment->button_text)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="call-to-action-payments-row col-md-12">';
                  } ?>
                <div class="call-to-action-payments-box col-md-4">
                  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick"><br/>
                    <input type="hidden" name="hosted_button_id" value="<?php echo $payment->hosted_button_id; ?>"></p>
                    <table class="payment-table">
                      <tr>
                        <td class="payment-description"><input type="hidden" name="on0"
                                   value="<?php echo $payment->description; ?>"><strong><?php echo $payment->description; ?></strong>
                        </td>
                      </tr>
                      <tr>
                        <td class="payment-options"><select name="os0"><br/>
                            <option value="Student"><?php echo $payment->student_charge; ?></option>
                            <br/>
                            <option value="Non-student"><?php echo $payment->non_student_charge; ?></option>
                            <br/>
                          </select></td>
                      </tr>
<?php
                      if ($payment->product_available == "yes") {
                        ?>
                        <tr>
                          <td class="payment-field-description"><input type="hidden" name="on1"
                                                                       value="<?php echo $payment->field_description; ?>"><?php echo $payment->field_description; ?>
                          </td>
                        </tr>
                        <tr>
                          <td class="payment-required-field"><input type="text" name="os1" maxlength="200"></td>
                        </tr>
                        <tr>
                          <td class="payment-submit">
                            <input type="hidden" name="currency_code" value="GBP"><br/>
                            <button type="submit" class="btn btn-info paypal-button" border="0" name="submit"
                                    alt="PayPal – The safer, easier way to pay online!">
                              <?php echo $payment->button_text; ?><span class="paypal-image"></span>
                            </button>
                            <br/>
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1"
                                 height="1">
                          </td>
                        </tr>
<?php
                      } else {
?>
                        <tr>
                          <td class="payment-not-available">We are sorry but this option is no longer available</td>
                        </tr>
<?php
                      }
?>
                    </table>
                  </form>
                </div>
                <?php
                $counter++;
              }
            }
?>
            <div class="clearfix"></div>
            <a
              class="<?php if ($call_to_action_big_buttons) { echo 'call-to-action-button-big'; } else { echo 'call-to-action-button'; } ?> btn btn-info"
              onClick="closePaymentSection();">
              Hide
            </a>
<?php
          }
?>
          </div>
        </div>
      </div>
    </section> <?php
  } ?>