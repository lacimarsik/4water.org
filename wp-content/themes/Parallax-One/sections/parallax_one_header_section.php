<!-- CONTAINER -->
<?php
	$paralax_one_header_logo = get_theme_mod('paralax_one_header_logo', parallax_get_file(DefHeader::$header_logo));
	$parallax_one_header_title = get_theme_mod('parallax_one_header_title', DefHeader::$header_title);
	$parallax_one_header_subtitle = get_theme_mod('parallax_one_header_subtitle', DefHeader::$header_subtitle);
	$parallax_one_header_button_text = get_theme_mod('parallax_one_header_button_text', DefHeader::$header_button_text);
	$parallax_one_header_button_link = get_theme_mod('parallax_one_header_button_link', DefHeader::$header_button_link);
	$parallax_one_enable_move = get_theme_mod('paralax_one_enable_move');
	$parallax_one_first_layer = get_theme_mod('paralax_one_first_layer', parallax_get_file('/images/background1.png'));
	$parallax_one_second_layer = get_theme_mod('paralax_one_second_layer',parallax_get_file('/images/background2.png'));
	if(!empty($paralax_one_header_logo) || !empty($parallax_one_header_title) || !empty($parallax_one_header_subtitle) || !empty($parallax_one_header_button_text)) {
?>

<?php
    if( !empty($parallax_one_enable_move) && $parallax_one_enable_move ) {
      echo '<ul id="parallax_move">';
			if ( empty($parallax_one_first_layer) && empty($parallax_one_second_layer) ) {
				$parallax_one_header_image2 = get_header_image();
				echo '<li class="layer layer1" data-depth="0.10" style="background-image: url('.$parallax_one_header_image2.');"></li>';
			} 
      else {
				if( !empty($parallax_one_first_layer) )  {
					echo '<li class="layer layer1" data-depth="0.10" style="background-image: url('.$parallax_one_first_layer.');"></li>';
				}
				if( !empty($parallax_one_second_layer) ) {
					echo '<li class="layer layer2" data-depth="0.20" style="background-image: url('.$parallax_one_second_layer.');"></li>';
				}
			}
      echo '</ul>';
    }
?>
		<div class="overlay-layer-wrap">
			<div class="container overlay-layer" id="parallax_header">

  			<!-- ONLY LOGO ON HEADER -->
<?php
				if( !empty($paralax_one_header_logo) ){
					echo '<div class="only-logo"><div id="only-logo-inner" class="navbar"><div id="parallax_only_logo" class="navbar-header"><img src="'.esc_url($paralax_one_header_logo).'"   alt=""></div></div></div>';
				} elseif (isset($wp_customize)) {
					echo '<div class="only-logo"><div id="only-logo-inner" class="navbar"><div id="parallax_only_logo" class="navbar-header"><img src="" alt=""></div></div></div>';
				}
?>
    		<!-- END ONLY LOGO ON HEADER -->
        <div class="row">
          <div class="col-md-12 intro-section-text-wrap">
<?php 
            //HEADING AND BUTTONS
            if(!empty($paralax_one_header_logo) || !empty($parallax_one_header_title) || !empty($parallax_one_header_subtitle) || !empty($parallax_one_header_button_text)){
?>
              <div id="intro-section" class="intro-section">
<?php
                //WELCOME MESSAGE
								if( !empty($parallax_one_header_title) ){
									echo '<h1 id="intro_section_text_1" class="intro white-text">'.esc_attr($parallax_one_header_title).'</h1>';
								} elseif ( isset( $wp_customize )   ) {
									echo '<h1 id="intro_section_text_1" class="intro white-text paralax_one_only_customizer"></h1>';
								}

								if( !empty($parallax_one_header_subtitle) ){
									echo '<h5 id="intro_section_text_2" class="white-text">'.esc_attr($parallax_one_header_subtitle).'</h5>';
								} elseif ( isset( $wp_customize )   ) {
									echo '<h5 id="intro_section_text_2" class="white-text paralax_one_only_customizer"></h5>';
								}
                
                //BUTTON
								if( !empty($parallax_one_header_button_text) ){
									if( empty($parallax_one_header_button_link) ){
										echo '<div id="intro_section_text_3" class="button"><a href="" class="btn btn-info header-button">'.esc_attr($parallax_one_header_button_text).'</a></div>';
									} else {
										echo '<div id="intro_section_text_3" class="button"><a href="'.esc_url($parallax_one_header_button_link).'" class="btn btn-info header-button">'.$parallax_one_header_button_text.'</a></div>';
									}
								} elseif ( isset( $wp_customize )   ) {
									echo '<div id="intro_section_text_3" class="button"><a href="" class="btn btn-info header-button paralax_one_only_customizer"></a></div>';
								}
?>
              </div> <!-- /END BUTTON -->
<?php
            } //END HEADING AND BUTTONS
?>
          </div>
        </div>
      </div>
    </div>
<?php
	}
?>
