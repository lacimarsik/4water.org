<!-- =========================
 SECTION: IMAGE
========================== -->
<?php
  $image_section_use_static_image = get_theme_mod('image_section_use_static_image', DefImage::$use_static_image);
  $image_section_title_above = get_theme_mod('image_section_title_above', DefImage::$title_above);
  $image_section_title_inside = get_theme_mod('image_section_title_inside', DefImage::$title_inside);
  $image_section_text_inside = get_theme_mod('image_section_text_inside', DefImage::$text_inside);
  $image_section_button_text = get_theme_mod('image_section_button_text', DefImage::$button_text);
  $image_section_button_link = get_theme_mod('image_section_button_link', DefImage::$button_link);
  $ribbon_background = get_theme_mod('paralax_one_ribbon_background', parallax_get_file(DefImage::$ribbon_background));
  $static_image = get_theme_mod('image_section_static_image', parallax_get_file(DefImage::$static_image));

if(!empty($image_section_title_above) ||
  !empty($image_section_title_inside) ||
  !empty($image_section_text_inside) ||
  !empty($image_section_button_text) ||
  !empty($image_section_button_link) ||
  !empty($ribbon_background) ||
  !empty($static_image)) {

  if(!empty($ribbon_background)){
    echo '<section class="call-to-action ribbon-wrap" id="ribbon" style="background-image:url('.$ribbon_background.');">';
  } else {
    echo '<section class="call-to-action ribbon-wrap" id="ribbon">';
  }


  ?>
  <div class="section-overlay-layer">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">

          <?php
          if( !empty($image_section_title_inside) ){
            echo '<h2 class="white-text strong">'.esc_attr($image_section_title_inside).'</h2>';
          } elseif ( isset( $wp_customize )   ) {
            echo '<h2 class="white-text strong paralax_one_only_customizer"></h2>';
          }

          if( !empty($image_section_button_text) ){
            if( empty($image_section_button_link) ){
              echo '<button onclick="" class="btn btn-primary standard-button paralax_one_only_customizer" type="button" data-toggle="modal" data-target="#stamp-modal">'.$image_section_button_text.'</button>';
            } else {
              echo '<button onclick="window.location=\''.esc_url($image_section_button_link).'\'" class="btn btn-primary standard-button" type="button" data-toggle="modal" data-target="#stamp-modal">'.esc_attr($image_section_button_text).'</button>';
            }
          } elseif ( isset( $wp_customize )   ) {
            echo '<button class="btn btn-primary standard-button paralax_one_only_customizer" type="button" data-toggle="modal" data-target="#stamp-modal"></button>';
          }
          ?>

        </div>
      </div>
    </div>
  </div>
  </section>

  <?php
}
?>