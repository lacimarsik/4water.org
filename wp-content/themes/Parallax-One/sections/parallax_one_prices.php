<!-- =========================
 SECTION: PRICES
========================== -->
<?php
  $prices_title = get_theme_mod('prices_title', 'PRICES');
  $prices = array(
    'student' => array(
      'type' => get_theme_mod('prices_student_type_1', 'ONE TIME ENTRY'),
      'text' => get_theme_mod('prices_student_type_1', 'ONE TIME ENTRY'),
       

    ),
    'non-student' => array (

    )
  )
  
  if(!empty($prices_title) || 
     !empty($prices_content)) {
?>
    <section id="why-us">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header">
<?php
            if(!empty($prices_title)) {
              echo '<h2 class="dark-text">'.esc_attr($prices_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            }
?>
          </div>
          
          <!-- WHY US CONTENT-->
<?php
          if(!empty($prices_content)) {
            $prices_decoded = json_decode($prices_content);
            echo '<div id="why-us-wrap">';
              $counter = 0;
              foreach($prices_decoded as $service_box) {
                if(!empty($service_box->image_url)
                    || !empty($service_box->title) 
                    || !empty($service_box->text)) {
                  if ($counter % 3 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="why-us-row col-md-12">';
                  }
                  
                  echo '<div class="col-md-4 why-us-box">';
                  if(!empty($service_box->image_url)) {
                    echo '<img class="why-us-img" src="'.$service_box->image_url.'" alt="'.$service_box->title.'">';
                  }

                  if(!empty($service_box->title)) {
                    echo '<h3 class="colored-text">'.esc_attr($service_box->title).'</h3>';
                  }

                  if(!empty($service_box->text)) {
                    echo '<p>'. esc_attr($service_box->text).'</p>';
                  }
                  echo '</div>';
                  $counter++;
                }
              }
            echo '</div>'; //row
            echo '</div>'; //why-us-wrap
          }
?>
        </div>  
      </div>
    </section>
<?php
  }
?>