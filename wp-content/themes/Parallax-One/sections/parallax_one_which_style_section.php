<!-- =========================
 SECTION: WHICH STYLE
========================== -->
<?php
	$which_style_title = get_theme_mod('which_style_title','DANCE4WATER STYLES');
	$which_style_subtitle = get_theme_mod('which_style_subtitle','Some introductory text');
	$which_style_dances = get_theme_mod(
    'which_style_content', 
    json_encode(
      array(
        array(
          'title' => esc_html__('CUBAN SALSA','parallax-one'),
          'text' => esc_html__('Description of the dance and blabla','parallax-one'),
          'video_url' => esc_html__('https://www.youtube.com/embed/bs8SU24k8P4', 'parallax-one'),
        ),
        array(
          'title' => esc_html__('BACHATA','parallax-one'),
          'text' => esc_html__('Description of bachata and blabla','parallax-one'),
          'video_url' => esc_html__('https://www.youtube.com/embed/iCVQmEeBfbU', 'parallax-one'),
        ),
        array(
          'title' => esc_html__('ZOUK','parallax-one'),
          'text' => esc_html__('Description of zouk and blabla','parallax-one'),
          'video_url' => esc_html__('https://www.youtube.com/embed/_QkP168_Ltc', 'parallax-one'),
        )
      )
    )
	);
  
	if(!empty($which_style_title) || 
     !empty($which_style_subtitle) ||
     !empty($which_style_dances)) {
?>
		<section class="which_style" id="which_style">
			<div class="section-overlay-layer">
				<div class="container">

					<!-- HEADER -->
					<div class="section-header">
						<?php
							if(!empty($which_style_title)) {
								echo '<h2 class="dark-text">'.esc_attr($which_style_title).'</h2>';
							} elseif (isset($wp_customize)) {
								echo '<h2 class="dark-text paralax_one_only_customizer"></h2>';
                echo '<div class="colored-line paralax_one_only_customizer"></div>';
							}
						?>

						<?php
							if(!empty($which_style_subtitle)) {
								echo '<div class="sub-heading">'.esc_attr($which_style_subtitle).'</div>';
							} elseif (isset($wp_customize)) {
								echo '<div class="sub-heading paralax_one_only_customizer"></div>';
							}
						?>
					</div>

          <!-- DANCE STYLES -->
					<?php
						if(!empty($which_style_dances)) {
							$which_style_decoded = json_decode($which_style_dances);
							echo '<div id="which_style_wrap" class="which_style-wrap">';
                $counter = 0;
								foreach($which_style_decoded as $service_box) {
									if(!empty($service_box->video_url)
                      || !empty($service_box->title) 
                      || !empty($service_box->text)) {
										echo '<div class="service-box"><div class="single-service border-bottom-hover">';
                    if(!empty($service_box->title)) {
                      echo '<h3 class="colored-text">'.esc_attr($service_box->title).'</h3>';
                    }

                    if(!empty($service_box->text)) {
                      echo '<p>'. esc_attr($service_box->text).'</p>';
                    }

                    $counter++;
                    if( !empty($service_box->video_url)) {
                      echo '<iframe width="100%" id="frame'.$counter.'" src="'.esc_url($service_box->video_url).'" frameborder="0" allowfullscreen></iframe>';
                      echo '<script type="text/javascript">';
                      echo 'document.getElementById("frame'.$counter.'").src=document.getElementById("frame'.$counter.'").src;';
                      echo '</script>';
                    }
										echo '</div></div>';
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