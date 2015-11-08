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
      $sections_array = apply_filters("parallax_one_pro_sections_filter", array(
        'sections/parallax_one_introduction_section',
        'sections/parallax_one_which_style_section',
        'sections/parallax_one_why_us_section',
        'sections/parallax_one_how_we_teach_section',
        'sections/parallax_one_map_section'
      ));

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