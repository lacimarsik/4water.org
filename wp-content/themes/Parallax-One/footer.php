<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package parallax-one
 */
?>

    <footer class="footer grey-bg">

        <div class="container">
            <div class="footer-widget-wrap">

<?php
          if( is_active_sidebar( 'footer-area' ) ){
?>
            <div class="col-md-3 col-sm-6 col-xs-12 widget-box">
<?php
                dynamic_sidebar( 'footer-area' );
?>
            </div>

<?php
          }
          if( is_active_sidebar( 'footer-area-2' ) ){
?>
            <div class="col-md-3 col-sm-6 col-xs-12 widget-box">
<?php
                dynamic_sidebar( 'footer-area-2' );
?>
            </div>
<?php
          }
          if( is_active_sidebar( 'footer-area-3' ) ){
?>
            <div class="col-md-3 col-sm-6 col-xs-12 widget-box">
<?php
                dynamic_sidebar( 'footer-area-3' );
?>
            </div>
<?php
          }
          if( is_active_sidebar( 'footer-area-4' ) ){
?>
            <div class="col-md-3 col-sm-6 col-xs-12 widget-box">
<?php
                dynamic_sidebar( 'footer-area-4' );
?>
            </div>
<?php
          }
?>

          </div><!-- END footer-widget-wrap -->

          <div class="footer-bottom-wrap">
<?php
            global $wp_customize;

            /* CUSTOM FOOTER */
            $footer_heading = get_theme_mod('parallax_one_footer_heading', DefFooter::$heading);
            $footer_text = get_theme_mod('parallax_one_footer_text', DefFooter::$text);
            $copyright = get_theme_mod('parallax_one_copyright', DefFooter::$copyright);
            $social_icons_text = get_theme_mod('parallax_one_social_icons_text', DefSocial::$text);
            $footer_image_caption = get_theme_mod('parallax_one_footer_image_caption', DefFooter::$image_caption);
            $footer_image_link = get_theme_mod('parallax_one_footer_image_link', DefFooter::$image_link);
            $footer_image = get_theme_mod('parallax_one_footer_image', parallax_get_file(DefFooter::$image));
?>
            <div class="row col-md-12 footer-grid">
              <div class="col-md-3 footer-left-1">
<?php
                if( !empty($social_icons_text) ){
                  echo '<div class="social-icons-text">'.esc_attr($social_icons_text).'</div>';
                }

                /* SOCIAL ICONS */
                $parallax_one_social_icons = get_theme_mod('parallax_one_social_icons',json_encode(array(array('icon_value' =>'icon-social-facebook' , 'link' => '#'),array('icon_value' =>'icon-social-twitter' , 'link' => '#'),array('icon_value' =>'icon-social-googleplus' , 'link' => '#'))));

                if( !empty( $parallax_one_social_icons ) ){

                  $parallax_one_social_icons_decoded = json_decode($parallax_one_social_icons);

                  if( !empty($parallax_one_social_icons_decoded) ){

                    echo '<ul class="social-icons">';

                    foreach($parallax_one_social_icons_decoded as $parallax_one_social_icon){

                      echo '<li><a href="'.esc_url($parallax_one_social_icon->link).'"><span class="'.esc_attr($parallax_one_social_icon->icon_value).' transparent-text-dark"></span></a></li>';

                    }

                    echo '</ul>';

                  }
                }
?>
              </div> <!-- END footer left 1 -->
              <div class="col-md-3 footer-left-2">
<?php
                if(!empty($footer_image) && !empty($footer_image_caption)) {
                  echo '<a href="' . $footer_image_link . '" title="' . $footer_image_caption . '" target="_blank"><img class="footer-image" src="' . $footer_image . '" title="' . $footer_image_caption . '" alt="' . $footer_image_caption . '"></a>';
                }
?>
              </div> <!-- END footer left 2 -->
              <div class="col-md-6 footer-right">
<?php
          if( !empty($footer_heading) ){
            echo '<h3 class="footer-heading">'.esc_attr($footer_heading).'</h3>';
          }
          if( !empty($footer_text) ){
            echo '<p class="footer-text">'.esc_attr($footer_text).'</p>';
          }
?>
              </div> <!-- END footer right -->
            </div> <!-- END footer grid -->
<?php
          $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
          $is_main_page = $uri_parts[0] == '/';
          if( $is_main_page ) {
              echo '<div class="row footer-policy"><a href="' . get_permalink('privacy-policy') . '">' . get_the_title(url_to_postid('privacy-policy')) . '</a></div>';
          }
          if( !empty($copyright) ){
            echo '<div class="row footer-copyright">'.esc_attr($copyright).'</div>';
          }

          /* OPTIONAL FOOTER LINKS */
          wp_nav_menu(
            array(
              'theme_location'    => 'parallax_footer_menu',
              'container'         => false,
              'menu_class'        => 'footer-links small-text',
              'depth' 			=> 1,
              'fallback_cb'       => false
            )
          );
?>

          </div> <!-- END footer-bottom-wrap -->

      </div> <!-- END container -->

    </footer>

<?php
    wp_footer();
?>

</body>
</html>
