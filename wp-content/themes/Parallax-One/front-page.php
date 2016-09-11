<?php
  if ( 'posts' == get_option( 'show_on_front' ) ) {
    get_header();
    get_template_part('/sections/parallax_one_header_section');
    ?>
    </div>
    <!-- /END COLOR OVER IMAGE -->
    </header>
    <!-- /END HOME / HEADER  -->
    <div class="content-wrap">
    <?php
      $not_hidden_sections = array();

      $sitePath = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );
    
      $parallax_one_intro_show = get_theme_mod('parallax_one_intro_show');
      if (isset($parallax_one_intro_show) && $parallax_one_intro_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_introduction_section');
      endif;

      // temporary fix for Language4Water - Image section after Introduction section
      if ($sitePath == '/glasgow/language/') {
        $parallax_one_image_section_show = get_theme_mod('parallax_one_image_section_show', DefImage::$hide);
        if (isset($parallax_one_image_section_show) && $parallax_one_image_section_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_image_section');
        endif;
      }

      $parallax_one_which_style_show = get_theme_mod('parallax_one_which_style_show');
      if (isset($parallax_one_which_style_show) && $parallax_one_which_style_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_which_style_section');
      endif;

      // temporary fix for 4Water to have Why us section in the right place
      if ($sitePath != '/') {
        $parallax_one_why_us_show = get_theme_mod('parallax_one_why_us_show');
        if (isset($parallax_one_why_us_show) && $parallax_one_why_us_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_why_us_section');
        endif;
      }

      $parallax_one_call_to_action_show = get_theme_mod('parallax_one_call_to_action_show', DefCallToAction::$hide);
      if (isset($parallax_one_call_to_action_show) && $parallax_one_call_to_action_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_call_to_action_section');
      endif;

      $parallax_one_how_we_teach_show = get_theme_mod('parallax_one_how_we_teach_show');
      if (isset($parallax_one_how_we_teach_show) && $parallax_one_how_we_teach_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_how_we_teach_section');
      endif;

      $parallax_one_faq_show = get_theme_mod('parallax_one_faq_show', DefFaq::$hide);
      if (isset($parallax_one_faq_show) && $parallax_one_faq_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_faq_section');
      endif;

      $parallax_one_many_things_show = get_theme_mod('parallax_one_many_things_show');
      if (isset($parallax_one_many_things_show) && $parallax_one_many_things_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_many_things_section');
      endif;

      // temporary fix for Language4Water and 4Water to have Image section in the right place
      if (($sitePath != '/glasgow/language/') && ($sitePath != '/')) {
        $parallax_one_image_section_show = get_theme_mod('parallax_one_image_section_show', DefImage::$hide);
        if (isset($parallax_one_image_section_show) && $parallax_one_image_section_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_image_section');
        endif;
      }

      $parallax_one_prices_show = get_theme_mod('parallax_one_prices_show');
      if (isset($parallax_one_prices_show) && $parallax_one_prices_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_prices_section');
      endif;

      $parallax_one_calendar_show = get_theme_mod('parallax_one_calendar_show');
      if (isset($parallax_one_calendar_show) && $parallax_one_calendar_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_calendar_section');
      endif;

      // temporary fix for 4Water to have Articles section in the right place
      if ($sitePath != '/') {
        $parallax_one_articles_section_show = get_theme_mod('parallax_one_articles_show', DefArticles::$hide);
        if (isset($parallax_one_articles_section_show) && $parallax_one_articles_section_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_articles_section');
        endif;
      }

      $parallax_one_map_show = get_theme_mod('parallax_one_map_show');
      if (isset($parallax_one_map_show) && $parallax_one_map_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_map_section');
      endif;

      // temporary fix for 4Water - Why us, Image and Articles sections after Map section
      if ($sitePath == '/') {
        $parallax_one_why_us_show = get_theme_mod('parallax_one_why_us_show');
        if (isset($parallax_one_why_us_show) && $parallax_one_why_us_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_why_us_section');
        endif;

        $parallax_one_image_section_show = get_theme_mod('parallax_one_image_section_show', DefImage::$hide);
        if (isset($parallax_one_image_section_show) && $parallax_one_image_section_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_image_section');
        endif;

        $parallax_one_articles_section_show = get_theme_mod('parallax_one_articles_show', DefArticles::$hide);
        if (isset($parallax_one_articles_section_show) && $parallax_one_articles_section_show != 1):
          array_push($not_hidden_sections, 'sections/parallax_one_articles_section');
        endif;
      }

      $parallax_one_contact_show = get_theme_mod('parallax_one_contact_show');
      if (isset($parallax_one_contact_show) && $parallax_one_contact_show != 1):
        array_push($not_hidden_sections, 'sections/parallax_one_contact_section');
      endif;

      $sections_array = apply_filters("parallax_one_pro_sections_filter", $not_hidden_sections);

      if(!empty($sections_array)){
        foreach($sections_array as $section){
          get_template_part($section);
        }
      }
?>
    </div><!-- .content-wrap -->
<?php 
    get_footer();
  } 
  else {
    include(get_page_template());
  }
?>