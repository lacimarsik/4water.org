<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package parallax-one
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
      if (!window.jQuery) { 
        document.write('<script src="<?= get_bloginfo("template_url"); ?>/js/jquery-1.11.3.js"><\/script>'); 
      }
    </script>
    <script src="<?= get_bloginfo("template_url"); ?>/js/angular.min.js"></script>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
      
    <!-- =============================
       PRE LOADER       
    ============================== -->
<?php
    global $wp_customize;

// TODO - consider uncommenting this. This piece of code does not display the front page
// until it's fully loaded (with all external content as well). Instead, a "loader wheel"
// is displayed instead
//    if(is_front_page() && !isset( $wp_customize ) && get_option( 'show_on_front' ) != 'page' ): 
//      $parallax_one_disable_preloader = get_theme_mod('paralax_one_disable_preloader');
//      if( isset($parallax_one_disable_preloader) && ($parallax_one_disable_preloader != 1)):	 
//        echo '<div class="preloader">';
//        echo '<div class="status">&nbsp;</div>';
//        echo '</div>';
//      endif;	
//    endif; 
?>
    
    <!-- ============================
       SECTION: HOME / HEADER  
    ============================== -->
    <header class="header header-style-one" data-stellar-background-ratio="0.5" id="home">
    <!-- COLOR OVER IMAGE -->
<?php
    $paralax_one_sticky_header = get_theme_mod('paralax_one_sticky_header','parallax-one');
    if( isset($paralax_one_sticky_header) && ($paralax_one_sticky_header != 1)){
      $fixedheader = 'sticky-navigation-open';
    }
    else {
      if(!is_front_page()){
        $fixedheader = 'sticky-navigation-open';
      }
      else {
        $fixedheader = '';
        if ( 'posts' != get_option( 'show_on_front' ) ) {
          if( isset($paralax_one_sticky_header) && ($paralax_one_sticky_header != 1)){
            $fixedheader = 'sticky-navigation-open';
          }
          else {
            $fixedheader = '';
          }
        }
      }
    }
?>
    <div class="overlay-layer-nav <?php if(!empty($fixedheader)) {echo esc_attr($fixedheader);} ?>">
      <!-- STICKY NAVIGATION -->
      <div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation appear-on-scroll" role="navigation">
        <!-- CONTAINER -->
        <div class="container">
          <!-- NAVBAR HEADER -->
          <div class="navbar-header">
            <!-- LOGO (SMALL SCREENS ONLY) -->
            <div class="logo-small-screens">
<?php
              $parallax_one = get_theme_mod('paralax_one_logo', parallax_get_file(DefHeader::$logo) );
              if(!empty($parallax_one)):
                echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand" title="'.get_bloginfo('title').'">';
                echo '<img src="'.esc_url($parallax_one).'" alt="'.get_bloginfo('title').'">';
                echo '</a>';
                echo '<div class="header-logo-wrap paralax_one_only_customizer">';
                echo "<h1 class='site-title'><a href='".esc_url( home_url( '/' ) )."' title='".esc_attr( get_bloginfo( 'name', 'display' ) )."' rel='home'>".get_bloginfo( 'name' )."</a></h1>";
                echo "<h2 class='site-description'>".get_bloginfo( 'description' )."</h2>";
                echo '</div>';
              else:
                if( isset( $wp_customize ) ):
                  echo '<a href="'.esc_url( home_url( '/' ) ).'" class="navbar-brand paralax_one_only_customizer" title="'.get_bloginfo('title').'">';
                  echo '<img src="" alt="'.get_bloginfo('title').'">';
                  echo '</a>';
                endif;

                echo '<div class="header-logo-wrap">';
                echo "<h1 class='site-title'><a href='".esc_url( home_url( '/' ) )."' title='".esc_attr( get_bloginfo( 'name', 'display' ) )."' rel='home'>".get_bloginfo( 'name' )."</a></h1>";
                echo "<h2 class='site-description'>".get_bloginfo( 'description' )."</h2>";
                echo '</div>';
              endif;
?>
            </div>
            <!-- /END LOGO (SMALL SCREENS ONLY) -->
            <!-- COLLAPSED MENU -->
            <div class="collapsed-menu-wrapper">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#stamp-navigation">
                <span class="sr-only"><?php esc_html_e('Toggle navigation','parallax-one'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <!-- HEADER WIDGET (SMALL SCREENS ONLY) -->
<?php
                if (is_active_sidebar('header-widget-small-screens')):
?>
                  <div class="header-widget-small-screens">
                    <?php dynamic_sidebar('header-widget-small-screens'); ?>
                  </div>
<?php
                endif;
?>
              <!-- /END HEADER WIDGET (SMALL SCREENS ONLY) -->
            </div>
            <!-- /END COLLAPSED MENU -->
          </div>
          <!-- /END NAVBAR HEADER -->

          <!-- MENU -->
          <div class="navbar-collapse collapse" id="stamp-navigation">		
<?php
            wp_nav_menu( 
              array( 
                'theme_location'    => 'primary',
                'container'         => false,
                'menu_class'        => 'nav navbar-nav navbar-right main-navigation',
                'fallback_cb'       => 'parallax_one_wp_page_menu' 
              ) 
            );
?>
          </div>
          <!-- /END MENU -->
          <!-- HEADER WIDGET MEDIUM SCREENS -->
          <?php
          if (is_active_sidebar('header-widget-medium-screens')):
            ?>
            <div class="header-widget-medium-screens">
              <?php dynamic_sidebar('header-widget-medium-screens'); ?>
            </div>
            <?php
          endif;
          ?>
          <!-- /END HEADER WIDGET MEDIUM SCREENS -->
          <!-- HEADER WIDGET -->
<?php
          if (is_active_sidebar('header-widget')):
?>
            <div class="header-widget">
              <?php dynamic_sidebar('header-widget'); ?>
            </div>
<?php
          endif;
?>
          <!-- /END HEADER WIDGET -->
        </div>
        <!-- /END CONTAINER -->
      </div>
      <!-- /END STICKY NAVIGATION -->