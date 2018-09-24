<!-- =========================
 SECTION: IMAGE
========================== -->
<?php
  $image_section_use_static_image = get_theme_mod('image_section_use_static_image', DefImage::$use_static_image);
  $image_section_title_above = get_theme_mod('image_section_title_above', DefImage::$title_above);
  $image_section_subtitle_above = get_theme_mod('image_section_subtitle_above', DefImage::$subtitle_above);
  $image_section_link_above = get_theme_mod('image_section_link_above', DefImage::$link_above);
  $image_section_link_text_above = get_theme_mod('image_section_link_text_above', DefImage::$link_text_above);
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
?>
  <div id="calendar-section"></div>
  <section id="image-section">
<?php  
  if (!empty($image_section_title_above)) {
    echo '<h2 class="title-above">' . $image_section_title_above . '</h2>';
  }
  
  if (!empty($image_section_subtitle_above)) {
    echo '<div class="subtitle-above">' . $image_section_subtitle_above;
    if (!empty($image_section_link_above) && !empty($image_section_link_text_above)) {
      echo ' <a href="' . $image_section_link_above . '">' . $image_section_link_text_above . '</a>';
    }
    echo '</div>';
  }

  if ($image_section_use_static_image) {
    
    if(!empty($static_image)){
      echo '<div class="image-section-static-image"><img src="' . $static_image . '" /></div>';
    } else {
      echo '<div class="image-section-static-image">';
    }
    
  } else {
    if(!empty($ribbon_background)){
      echo '<div class="image-section-ribbon ribbon-wrap" id="ribbon" style="background-image:url('.$ribbon_background.');">';
    } else {
      echo '<div class="image-section-ribbon ribbon-wrap" id="ribbon">';
    }
  
    ?>
      <div class="section-overlay-layer">
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-md-offset-1">
  
              <?php
              if(!empty($image_section_title_inside) ){
                echo '<h2 class="white-text strong title-inside">'.esc_attr($image_section_title_inside).'</h2>';
              }
  
              if(!empty($image_section_text_inside) ){
                echo '<p class="white-text text-inside">'.esc_attr($image_section_text_inside).'</p>';
              }
  
              if(!empty($image_section_button_text) ){
                if(empty($image_section_button_link) ){
                  echo '<a onclick="" class="btn btn-primary paralax_one_only_customizer image-section-button" type="button" data-toggle="modal" data-target="#stamp-modal">'.$image_section_button_text.'</a>';
                } else {
                  echo '<a onclick="window.location=\''.esc_url($image_section_button_link).'\'" class="btn btn-primary image-section-button" type="button" data-toggle="modal" data-target="#stamp-modal">'.esc_attr($image_section_button_text).'</a>';
                }
              } elseif ( isset( $wp_customize )   ) {
                echo '<a class="btn btn-primary paralax_one_only_customizer image-section-button" type="button" data-toggle="modal" data-target="#stamp-modal"></a>';
              }
              ?>
  
            </div>
          </div>
        </div>
      </div>
    </div>
    </section>
  
    <?php
  }
}
?>