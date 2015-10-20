<!-- =========================
 SECTION: WHY US
========================== -->
<?php
  $why_us_title = get_theme_mod('why_us_title','WHY DANCE WITH US?');
  $why_us_content = get_theme_mod(
    'why_us_content', 
    json_encode(
      array(
        array(
          'image_url' => parallax_get_file('/images/why-us-shoe.png'),
          'title' => esc_html__('NO DRESS CODE', 'parallax-one'),
          'text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
        ),
        array(
          'image_url' => parallax_get_file('/images/why-us-clock.png'),
          'title' => esc_html__('JOIN US ANYTIME','parallax-one'),
          'text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
        ),
        array(
          'image_url' => parallax_get_file('/images/why-us-paper.png'),
          'title' => esc_html__('NO REGISTRATION','parallax-one'),
          'text' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
        )
      )
    )
  );
  
  if(!empty($why_us_title) || 
     !empty($why_us_content)) {
?>
    <section class="why_us" id="why_us">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header">
<?php
            if(!empty($why_us_title)) {
              echo '<h2 class="dark-text">'.esc_attr($why_us_title).'</h2>';
            } elseif (isset($wp_customize)) {
              echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
              echo '<div class="colored-line paralax_one_only_customizer"></div>';
            }
?>
          </div>

          <!-- WHY US CONTENT-->
<?php
          if(!empty($why_us_content)) {
            $why_us_decoded = json_decode($why_us_content);
            $width_perc = 90 / count($why_us_decoded);
            echo '<div id="why-us-wrap" class="why-us-wrap">';
              $counter = 0;
              foreach($why_us_decoded as $service_box) {
                if(!empty($service_box->image_url)
                    || !empty($service_box->title) 
                    || !empty($service_box->text)) {
                  echo '<div class="why-us-box" style="width:'.$width_perc.'%">';
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
                }
              }
            echo '</div>';
          }
?>
        </div>  
      </div>
    </section>
<?php
  }
?>