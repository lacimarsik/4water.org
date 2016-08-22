<?php
/**
 * parallax-one Theme Customizer
 *
 * @package parallax-one
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

include dirname(__FILE__).'/../customizer_defaults.php';

function parallax_one_customize_register( $wp_customize ) {


  $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

  /********************************************************/
  /************** WP DEFAULT CONTROLS  ********************/
  /********************************************************/

  $wp_customize->remove_control('background_color');
  $wp_customize->get_section('background_image')->panel='panel_2';
  $wp_customize->get_section('colors')->panel='panel_2';

  /********************************************************/
  /************* HEADER OPTIONS ***************************/
  /********************************************************/
  
  $wp_customize->add_panel( 'panel_1', array(
    'priority' => 31,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => esc_html__( 'Header section', 'parallax-one' )
  ) );

  /* HEADER CONTENT */

  $wp_customize->add_section( 'parallax_one_header_content' , array(
      'title'       => esc_html__( 'Content', 'parallax-one' ),
      'priority'    => 1,
      'panel' => 'panel_1'
  ));

  /* Logo (we are showing this logo only on mobile screens but might be important for search engines */
  $wp_customize->add_setting( 'paralax_one_logo', array(
    'default' => parallax_get_file(DefHeader::$logo),
    'sanitize_callback' => 'esc_url',
    'transport' => 'postMessage'
  ));

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'paralax_one_logo', array(
    'label'    => esc_html__( 'Menu Logo', 'parallax-one' ),
    'section'  => 'parallax_one_header_content',
    'priority'    => 1,
  )));

  /* Header Logo */
  $wp_customize->add_setting( 'paralax_one_header_logo', array(
    'default' => parallax_get_file(DefHeader::$header_logo),
    'sanitize_callback' => 'esc_url',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'paralax_one_header_logo', array(
          'label'    => esc_html__( 'Header Logo', 'parallax-one' ),
          'section'  => 'parallax_one_header_content',
      'active_callback' => 'parallax_one_show_on_front',
      'priority'    => 2
  )));

  /* Header title */
  $wp_customize->add_setting( 'parallax_one_header_title', array(
    'default' => esc_html__(DefHeader::$header_title,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_header_title', array(
    'label'    => esc_html__( 'Main title', 'parallax-one' ),
    'section'  => 'parallax_one_header_content',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 3
  ));

  /* Header subtitle */
  $wp_customize->add_setting( 'parallax_one_header_subtitle', array(
    'default' => esc_html__(DefHeader::$header_subtitle, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_header_subtitle', array(
    'label'    => esc_html__( 'Subtitle', 'parallax-one' ),
    'section'  => 'parallax_one_header_content',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 4
  ));


  /* Header Button text */
  $wp_customize->add_setting( 'parallax_one_header_button_text', array(
    'default' => esc_html__(DefHeader::$header_button_text, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_header_button_text', array(
    'label'    => esc_html__( 'Button label', 'parallax-one' ),
    'section'  => 'parallax_one_header_content',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 4
  ));


  $wp_customize->add_setting( 'parallax_one_header_button_link', array(
    'default' => esc_html__(DefHeader::$header_button_link, 'parallax-one'),
    'sanitize_callback' => 'esc_url',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_header_button_link', array(
    'label'    => esc_html__( 'Button link', 'parallax-one' ),
    'section'  => 'parallax_one_header_content',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 5
  ));

    require_once ( 'class/parallax-one-general-control.php');

  $wp_customize->get_section('header_image')->panel='panel_1';
  $wp_customize->get_section('header_image')->title=esc_html__( 'Background', 'parallax-one' );

  /* Enable parallax effect */
  $wp_customize->add_setting( 'paralax_one_enable_move', array(
    'sanitize_callback' => 'parallax_one_sanitize_text',
  ));
  $wp_customize->add_control(
      'paralax_one_enable_move',
      array(
        'type' => 'checkbox',
        'label' => esc_html__('Parallax effect','parallax-one'),
        'description' => esc_html__('If this box is checked, the parallax effect is enabled.','parallax-one'),
        'section' => 'header_image',
        'priority'    => 3,
      )
  );

  /* Layer one */
  $wp_customize->add_setting( 'paralax_one_first_layer', array(
    'default' => parallax_get_file('/images/background1.png'),
    'sanitize_callback' => 'esc_url',
    //'transport' => 'postMessage'
  ));

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'paralax_one_first_layer', array(
          'label'    => esc_html__( 'First layer', 'parallax-one' ),
          'section'  => 'header_image',
      'priority'    => 4,
  )));

  /* Layer two */
  $wp_customize->add_setting( 'paralax_one_second_layer', array(
    'default' => parallax_get_file('/images/background2.png'),
    'sanitize_callback' => 'esc_url',
    //'transport' => 'postMessage'
  ));

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'paralax_one_second_layer', array(
          'label'    => esc_html__( 'Second layer', 'parallax-one' ),
          'section'  => 'header_image',
      'priority'    => 5,
  )));

  /********************************************************/
  /****************** INTRODUCTION OPTIONS  ***************/
  /********************************************************/

  $wp_customize->add_section('intro_section', array(
    'title'       => esc_html__('Introduction section', 'parallax-one'),
    'priority'    => 32,
  ));

  /* Introduction video link */
  $wp_customize->add_setting('intro_video_link', array(
    'default' => esc_html__(DefIntro::$video_link, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('intro_video_link', array(
    'label'    => esc_html__('Introduction video embed-link', 'parallax-one'),
    'section'  => 'intro_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));
  
  /* Introduction video caption */
  $wp_customize->add_setting('intro_video_caption', array(
    'default' => esc_html__(DefIntro::$video_caption, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('intro_video_caption', array(
    'label'    => esc_html__('Video caption', 'parallax-one' ),
    'section'  => 'intro_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));
  
  /* Introduction title */
  $wp_customize->add_setting('intro_title', array( 
    'default' => esc_html__(DefIntro::$title,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_html',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('intro_title', array(
    'label'   => esc_html__('Introduction text title', 'parallax-one'),
    'section' => 'intro_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 2,
  ));
  
  /* Introduction text */
  $wp_customize->add_setting('intro_text', array( 
    'default' => esc_html__(DefIntro::$text,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_html',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('intro_text', array(
    'type' => 'textarea',
    'label'   => esc_html__('Introduction text', 'parallax-one'),
    'section' => 'intro_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 2,
  ));

  /* Introduction show/hide */

  $wp_customize->add_setting('parallax_one_intro_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_intro_show', array(
    'type' => 'checkbox',
    'label' => __('Hide introduction section?', 'parallax-one'),
    'section' => 'intro_section',
    'priority' => 3,
  ));
  
  /********************************************************/
  /****************** WHICH STYLE OPTIONS *****************/
  /********************************************************/

  $wp_customize->add_section('which_style_section', array(
      'title'       => esc_html__('Which style section', 'parallax-one'),
      'priority'    => 32,
  ));

  /* Which style title */
  $wp_customize->add_setting('which_style_title', array(
    'default' => esc_html__(DefWhichStyle::$title, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('which_style_title', array(
    'label'    => esc_html__('Section title', 'parallax-one'),
    'section'  => 'which_style_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));

  /* Which style subtitle */
  $wp_customize->add_setting('which_style_subtitle', array(
    'default' => esc_html__(DefWhichStyle::$subtitle,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('which_style_subtitle', array(
    'label'    => esc_html__('Section subtitle', 'parallax-one'),
    'section'  => 'which_style_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 2
  ));
    
  /* Which style content */
  $wp_customize->add_setting(
    'which_style_content', 
    array(
      'sanitize_callback' => 'parallax_one_sanitize_text',
      'default' => DefWhichStyle::$content
    )
  );
  $wp_customize->add_control(
    new Parallax_One_General_Repeater( 
      $wp_customize, 
      'which_style_content', 
      array(
        'label' => esc_html__('Add new style','parallax-one'),
        'section' => 'which_style_section',
        'active_callback' => 'parallax_one_show_on_front',
        'priority' => 3,
        'fields' => array(
          'style' => array('type' => 'text', 'label' => 'Style', 'placeholder' => 'CUBAN SALSA'),
          'url' => array('type' => 'text', 'label' => 'Video embed URL', 'placeholder' => 'https://www.youtube.com/embed/bs8SU24k8P4'),
          'desc' => array('type' => 'textarea', 'label' => 'Description', 'placeholder' => 'Fun, exciting...'),
        )
      ) 
    ) 
  );

  /* Which style show/hide */

  $wp_customize->add_setting('parallax_one_which_style_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_which_style_show', array(
    'type' => 'checkbox',
    'label' => __('Hide which style section?', 'parallax-one'),
    'section' => 'which_style_section',
    'priority' => 4,
  ));

  /********************************************************/
  /****************** WHY US OPTIONS **********************/
  /********************************************************/

  $wp_customize->add_section('why_us_section', array(
      'title'       => esc_html__('Why us section', 'parallax-one'),
      'priority'    => 32,
  ));

  /* Why us title */
  $wp_customize->add_setting('why_us_title', array(
    'default' => esc_html__(DefWhyUs::$title,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('why_us_title', array(
    'label'    => esc_html__('Section title', 'parallax-one'),
    'section'  => 'why_us_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));

  /* Why us content */
  $wp_customize->add_setting(
    'why_us_content', 
    array(
      'sanitize_callback' => 'parallax_one_sanitize_text',
      'default' => DefWhyUs::$content
    )
  );
  $wp_customize->add_control(
    new Parallax_One_General_Repeater( 
      $wp_customize, 
      'why_us_content', 
      array(
        'label' => esc_html__('Add new reason "why us"','parallax-one'),
        'section' => 'why_us_section',
        'active_callback' => 'parallax_one_show_on_front',
        'priority' => 3,
        'fields' => array(
          'image' => array('type' => 'image', 'label' => 'Image'),
          'reason' => array('type' => 'text', 'label' => 'Reason', 'placeholder' => 'NO DRESS CODE'),
          'desc' => array('type' => 'textarea', 'label' => 'Description', 'placeholder' => 'We don\'t care if you wear sandals or boots...'),
        )
      ) 
    ) 
  );

  /* Why us show/hide */

  $wp_customize->add_setting('parallax_one_why_us_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_why_us_show', array(
    'type' => 'checkbox',
    'label' => __('Hide why us section?', 'parallax-one'),
    'section' => 'why_us_section',
    'priority' => 4,
  ));

  /********************************************************/
  /****************** HOW WE TEACH OPTIONS ****************/
  /********************************************************/

  $wp_customize->add_section('how_we_teach_section', array(
      'title'       => esc_html__('How we teach section', 'parallax-one'),
      'priority'    => 32,
  ));
                
  /* How we teach caption 1 */
  $wp_customize->add_setting('how_we_teach_caption_1', array(
    'default' => esc_html__(DefHowTeach::$caption1,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('how_we_teach_caption_1', array(
    'label'    => esc_html__('How we teach caption 1', 'parallax-one'),
    'section'  => 'how_we_teach_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));
        
  /* How we teach image 1 */
  $wp_customize->add_setting('how_we_teach_image_1', array(
    'default' => parallax_get_file(DefHowTeach::$img1),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'how_we_teach_image_1', array(
    'label'    => esc_html__('How we teach image 1', 'parallax-one'),
    'section'  => 'how_we_teach_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  )));
                
  /* How we teach caption 2 */
  $wp_customize->add_setting('how_we_teach_caption_2', array(
    'default' => esc_html__(DefHowTeach::$caption2, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('how_we_teach_caption_2', array(
    'label'    => esc_html__('How we teach caption 2', 'parallax-one'),
    'section'  => 'how_we_teach_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));
        
  /* How we teach image 2 */
  $wp_customize->add_setting('how_we_teach_image_2', array(
    'default' => parallax_get_file(DefHowTeach::$img2),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'how_we_teach_image_2', array(
    'label'    => esc_html__('How we teach image 2', 'parallax-one'),
    'section'  => 'how_we_teach_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  )));
        
  /* How we teach text */
  $wp_customize->add_setting('how_we_teach_text', array(
    'default' => esc_html__(DefHowTeach::$text, 'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('how_we_teach_text', array(
    'label'    => esc_html__('How we teach text', 'parallax-one'),
    'section'  => 'how_we_teach_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 2
  ));

  /* How we teach show/hide */

  $wp_customize->add_setting('parallax_one_how_we_teach_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_how_we_teach_show', array(
    'type' => 'checkbox',
    'label' => __('Hide how we teach section?', 'parallax-one'),
    'section' => 'how_we_teach_section',
    'priority' => 3,
  ));

  /********************************************************/
  /****************** MANY THINGS OPTIONS **********************/
  /********************************************************/

  $wp_customize->add_section('many_things_section', array(
    'title'       => esc_html__('Many things section', 'parallax-one'),
    'priority'    => 32,
  ));

  /* Many things title */
  $wp_customize->add_setting('many_things_title', array(
    'default' => esc_html__(DefManyThings::$title,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('many_things_title', array(
    'label'    => esc_html__('Section title', 'parallax-one'),
    'section'  => 'many_things_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));

  /* Many things content */
  $wp_customize->add_setting(
    'many_things_content',
    array(
      'sanitize_callback' => 'parallax_one_sanitize_text',
      'default' => DefManyThings::$content
    )
  );
  $wp_customize->add_control(
    new Parallax_One_General_Repeater(
      $wp_customize,
      'many_things_content',
      array(
        'label' => esc_html__('Add new "thing to do"','parallax-one'),
        'section' => 'many_things_section',
        'active_callback' => 'parallax_one_show_on_front',
        'priority' => 3,
        'fields' => array(
          'image' => array('type' => 'image', 'label' => 'Image'),
          'title' => array('type' => 'text', 'label' => 'Title', 'placeholder' => 'CLASSES'),
          'desc' => array('type' => 'textarea', 'label' => 'Description', 'placeholder' => 'We teach regular classes every monday ...'),
          'link_text' => array('type' => 'text', 'label' => 'Link Text', 'placeholder' => 'more >'),
          'link' => array('type' => 'text', 'label' => 'Link', 'placeholder' => '#section-to-get-more-info')
        )
      )
    )
  );

  /* Many things show/hide */

  $wp_customize->add_setting('parallax_one_many_things_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_many_things_show', array(
    'type' => 'checkbox',
    'label' => __('Hide many things section?', 'parallax-one'),
    'section' => 'many_things_section',
    'priority' => 4,
  ));

  /********************************************************/
  /******************* PRICES OPTIONS *********************/
  /********************************************************/

  $wp_customize->add_section('prices_section', array(
      'title'       => esc_html__('Prices section', 'parallax-one'),
      'priority'    => 32,
  ));
  
  /* prices section title */
  $wp_customize->add_setting('prices_title', array(
    'default' => esc_html__(DefPrices::$title,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('prices_title', array(
    'label'    => esc_html__('Section title', 'parallax-one'),
    'section'  => 'prices_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));
  
  /* prices - note at the bottom */
  $wp_customize->add_setting('prices_note', array(
    'default' => esc_html__(DefPrices::$note,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('prices_note', array(
    'label'    => esc_html__('Note', 'parallax-one'),
    'section'  => 'prices_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));
  
  /* prices */
  $wp_customize->add_setting( 
    'prices_content', 
    array(
      'sanitize_callback' => 'parallax_one_sanitize_text',
      'default' => DefPrices::$content
    )
  );
  $wp_customize->add_control(
    new Parallax_One_General_Repeater( 
      $wp_customize, 
      'prices_content', 
      array(
        'label' => esc_html__('Price entries','parallax-one'),
        'section' => 'prices_section',
        'active_callback' => 'parallax_one_show_on_front',
        'priority' => 3,
        'fields' => array(
          'type' => array('type' => 'text', 'label' => 'Type', 'placeholder' => 'ONE TIME ENTRY'),
          'desc' => array('type' => 'textarea', 'label' => 'Description', 'placeholder' => 'Come and taste...'),
          'length' => array('type' => 'text', 'label' => 'Length', 'placeholder' => '1 day (2 lessons...)'),
          'student_price' => array('type' => 'text', 'label' => 'Student price', 'placeholder' => '70CZK'),
          'non_student_price' => array('type' => 'text', 'label' => 'Non-student price', 'placeholder' => '100CZK'),
        )
      ) 
    ) 
  );

  /* Prices show/hide */

  $wp_customize->add_setting('parallax_one_prices_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_prices_show', array(
    'type' => 'checkbox',
    'label' => __('Hide prices section?', 'parallax-one'),
    'section' => 'prices_section',
    'priority' => 4,
  ));

  /********************************************************/
  /****************** CONTACT OPTIONS  ********************/
  /********************************************************/

  /* Map ShortCode  */
  $wp_customize->add_setting( 'parallax_one_contact_map_shortcode', array(
    'default' => '',
    'sanitize_callback' => 'parallax_one_sanitize_text'
  ));
  $wp_customize->add_control( 'parallax_one_contact_map_shortcode', array(
    'label'    => esc_html__( 'Map shortcode', 'parallax-one' ),
    'description' => __('To use this section please install <a href="https://wordpress.org/plugins/intergeo-maps/">Intergeo Maps</a> plugin then use it to create a map and paste here the shortcode generated','parallax-one'),
    'section'  => 'contact_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));

  /* Map show/hide */

  $wp_customize->add_setting('parallax_one_map_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_map_show', array(
    'type' => 'checkbox',
    'label' => __('Hide map section?', 'parallax-one'),
    'section' => 'contact_section',
    'priority' => 2,
  ));

  $wp_customize->add_section( 'contact_section' , array(
    'title' => esc_html__( 'Contact section', 'parallax-one' ),
    'priority' => 37,
  ));

  $wp_customize->add_setting( 'parallax_one_contact_info_content', array(
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'default' => DefContact::$content
  ));

  $wp_customize->add_control(
    new Parallax_One_General_Repeater(
      $wp_customize,
      'parallax_one_contact_info_content',
      array(
        'label'   => esc_html__('Add new contact field','parallax-one'),
        'section' => 'contact_section',
        'active_callback' => 'parallax_one_show_on_front',
        'priority' => 3,
        'fields' => array(
          'text' => array('type' => 'text', 'label' => 'Text', 'placeholder' => 'Contact info'),
          'link' => array('type' => 'text', 'label' => 'Link', 'placeholder' => '#'),
          'icon_value' => array('type' => 'icon', 'label' => 'Icon', 'placeholder' => 'Select icon')
        )
      )
    )
  );

  /* Contact Form  */
  $wp_customize->add_setting( 'parallax_one_contact_form_shortcode', array(
    'default' => '',
    'sanitize_callback' => 'parallax_one_sanitize_text'
  ));
  $wp_customize->add_control( 'parallax_one_contact_form_shortcode', array(
    'label'    => esc_html__( 'Contact form shortcode', 'parallax-one' ),
    'description' => __('Create a form, copy the shortcode generated and paste it here. We recommend <a href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a> but you can use any plugin you like.','parallax-one'),
    'section'  => 'contact_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 3
  ));

  /* Contact show/hide */

  $wp_customize->add_setting('parallax_one_contact_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_contact_show', array(
    'type' => 'checkbox',
    'label' => __('Hide contact information?', 'parallax-one'),
    'section' => 'contact_section',
    'priority' => 4,
  ));

  /********************************************************/
  /****************** FOOTER OPTIONS  *********************/
  /********************************************************/

  $wp_customize->add_section( 'parallax_one_footer_section' , array(
    'title'       => esc_html__( 'Footer options', 'parallax-one' ),
    'priority'    => 39,
    'description' => esc_html__('Custom widgets can be added to the footer in: Customize -> Widgets -> Footer area. ','parallax-one'),
  ));

  /* Footer Menu */
  $nav_menu_locations_footer = $wp_customize->get_control('nav_menu_locations[parallax_footer_menu]');
  if(!empty($nav_menu_locations_footer)){
    $nav_menu_locations_footer->section = 'parallax_one_footer_section';
    $nav_menu_locations_footer->priority = 1;
  }

  /* Footer heading */
  $wp_customize->add_setting( 'parallax_one_footer_heading', array(
    'default' => DefFooter::$heading,
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_footer_heading', array(
    'label'    => esc_html__( 'Footer heading', 'parallax-one' ),
    'section'  => 'parallax_one_footer_section',
    'priority'    => 2
  ));

  /* Footer text */
  $wp_customize->add_setting( 'parallax_one_footer_text', array(
    'default' => DefFooter::$text,
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_footer_text', array(
    'label'    => esc_html__( 'Footer text', 'parallax-one' ),
    'section'  => 'parallax_one_footer_section',
    'priority'    => 2
  ));

  /* Footer image caption */
  $wp_customize->add_setting('parallax_one_footer_image_caption', array(
    'default' => esc_html__(DefFooter::$image_caption,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('parallax_one_footer_image_caption', array(
    'label'    => esc_html__('Footer image caption', 'parallax-one'),
    'section'  => 'parallax_one_footer_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));

  /* Footer image link */
  $wp_customize->add_setting('parallax_one_footer_image_link', array(
    'default' => esc_html__(DefFooter::$image_link,'parallax-one'),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control('parallax_one_footer_image_link', array(
    'label'    => esc_html__('Footer image link', 'parallax-one'),
    'section'  => 'parallax_one_footer_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  ));

  /* Footer image */
  $wp_customize->add_setting('parallax_one_footer_image', array(
    'default' => parallax_get_file(DefFooter::$image),
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'parallax_one_footer_image', array(
    'label'    => esc_html__('Footer image', 'parallax-one'),
    'section'  => 'parallax_one_footer_section',
    'active_callback' => 'parallax_one_show_on_front',
    'priority'    => 1
  )));

  /* Copyright */
  $wp_customize->add_setting( 'parallax_one_copyright', array(
    'default' => DefFooter::$copyright,
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_copyright', array(
    'label'    => esc_html__( 'Copyright', 'parallax-one' ),
    'section'  => 'parallax_one_footer_section',
    'priority'    => 2
  ));

  /* Socials icons text */
  $wp_customize->add_setting( 'parallax_one_social_icons_text', array(
    'default' => DefSocial::$text,
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'transport' => 'postMessage'
  ));
  $wp_customize->add_control( 'parallax_one_social_icons_text', array(
    'label'    => esc_html__( 'Social icons text', 'parallax-one' ),
    'section'  => 'parallax_one_footer_section',
    'priority'    => 2
  ));

  /* Socials icons */
  $wp_customize->add_setting( 'parallax_one_social_icons', array(
    'sanitize_callback' => 'parallax_one_sanitize_text',
    'default' => DefSocial::$content

  ));
  $wp_customize->add_control(
    new Parallax_One_General_Repeater(
      $wp_customize,
      'parallax_one_social_icons',
      array(
        'label' => esc_html__('Add new social icon','parallax-one'),
        'section' => 'parallax_one_footer_section',
        'priority' => 3,
        'fields' => array(
          'link' => array('type' => 'text', 'label' => 'Link', 'placeholder' => '#'),
          'icon_value' => array('type' => 'icon', 'label' => 'Icon', 'placeholder' => 'Select icon')
        )
      )
    )
  );

	/********************************************************/
	/******************* CALENDAR OPTIONS *******************/
	/********************************************************/

	$wp_customize->add_section('calendar_section', array(
			'title'       => esc_html__('Calendar section', 'parallax-one'),
			'priority'    => 32,
	));

	/* calendar section title */
	$wp_customize->add_setting('calendar_title', array(
		'default' => esc_html__(DefCalendar::$title,'parallax-one'),
		'sanitize_callback' => 'parallax_one_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('calendar_title', array(
		'label'    => esc_html__('Section title', 'parallax-one'),
		'section'  => 'calendar_section',
		'active_callback' => 'parallax_one_show_on_front',
		'priority'    => 1
	));
        
        /* calendar mode */
	$wp_customize->add_setting('calendar_mode', array(
		'default' => DefCalendar::$mode,
		'sanitize_callback' => 'parallax_one_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control('calendar_mode', array(
		'label'    => esc_html__('Calendar mode', 'parallax-one'),
		'section'  => 'calendar_section',
                'choices' => array('condensed' => 'Condensed', 'expanded' => 'Expanded'),
                'type' => 'radio',
		'active_callback' => 'parallax_one_show_on_front',
		'priority'    => 1
	));

  /* Calendar show/hide */

  $wp_customize->add_setting('parallax_one_calendar_show', array('sanitize_callback' => 'parallax_one_sanitize_text'));
  $wp_customize->add_control(
    'parallax_one_calendar_show', array(
    'type' => 'checkbox',
    'label' => __('Hide calendar section?', 'parallax-one'),
    'section' => 'calendar_section',
    'priority' => 4,
  ));

  /********************************************************/
  /************** ADVANCED OPTIONS  ***********************/
  /********************************************************/

  $wp_customize->add_section( 'parallax_one_general_section' , array(
    'title' => esc_html__( 'Advanced options', 'parallax-one' ),
      'priority' => 40,
      'description' => esc_html__('Paralax One theme general options','parallax-one'),
  ));

  $blogname = $wp_customize->get_control('blogname');
  $blogdescription = $wp_customize->get_control('blogdescription');
  $show_on_front = $wp_customize->get_control('show_on_front');
  $page_on_front = $wp_customize->get_control('page_on_front');
  $page_for_posts = $wp_customize->get_control('page_for_posts');
  if(!empty($blogname)){
    $blogname->section = 'parallax_one_general_section';
    $blogname->priority = 1;
  }
  if(!empty($blogdescription)){
    $blogdescription->section = 'parallax_one_general_section';
    $blogdescription->priority = 2;
  }
  if(!empty($show_on_front)){
    $show_on_front->section='parallax_one_general_section';
    $show_on_front->priority=3;
  }
  if(!empty($page_on_front)){
    $page_on_front->section='parallax_one_general_section';
    $page_on_front->priority=4;
  }
  if(!empty($page_for_posts)){
    $page_for_posts->section='parallax_one_general_section';
    $page_for_posts->priority=5;
  }

  $wp_customize->remove_section('static_front_page');
  $wp_customize->remove_section('title_tagline');

  $nav_menu_locations_primary = $wp_customize->get_control('nav_menu_locations[primary]');
  if(!empty($nav_menu_locations_primary)){
    $nav_menu_locations_primary->section = 'parallax_one_general_section';
    $nav_menu_locations_primary->priority = 6;
  }

  /* Disable preloader */
  $wp_customize->add_setting( 'paralax_one_disable_preloader', array(
    'sanitize_callback' => 'parallax_one_sanitize_text'
  ));
  $wp_customize->add_control(
      'paralax_one_disable_preloader',
      array(
        'type' => 'checkbox',
        'label' => esc_html__('Disable preloader?','parallax-one'),
        'description' => esc_html__('If this box is checked, the preloader will be disabled from homepage.','parallax-one'),
        'section' => 'parallax_one_general_section',
        'priority'    => 7,
      )
  );
}
add_action( 'customize_register', 'parallax_one_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function parallax_one_customize_preview_js() {
  wp_enqueue_script( 'parallax_one_customizer', parallax_get_file('/js/customizer.js'), array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'parallax_one_customize_preview_js' );


function parallax_one_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function parallax_one_sanitize_html( $input ){
  $allowed_html = array(
                'p' => array(),
              'br' => array(),
              'em' => array(),
              'strong' => array(),
              'ul' => array(),
              'li' => array()
            );
  $string = force_balance_tags($input);
  return wp_kses($string, $allowed_html);
}


function parallax_one_customizer_script() {
  wp_enqueue_script( 'parallax_one_customizer_script', parallax_get_file('/js/parallax_one_customizer.js'), array("jquery","jquery-ui-draggable"),'1.0.0', true  );
  wp_register_script( 'parallax_one_buttons', parallax_get_file('/js/parallax_one_buttons_control.js'), array("jquery"), '1.0.0', true  );
  wp_enqueue_script( 'parallax_one_buttons' );

  wp_localize_script( 'parallax_one_buttons', 'objectL10n', array(

    'documentation' => esc_html__( 'Documentation', 'parallax-one' ),
    'support' => esc_html__('Support Forum','parallax-one'),
    'github' => esc_html__('Github','parallax-one')

  ) );
}
add_action( 'customize_controls_enqueue_scripts', 'parallax_one_customizer_script' );

function parallax_one_is_contact_page() {
    return is_page_template('template-contact.php');
};

function parallax_one_show_on_front(){
  if ( 'posts' == get_option( 'show_on_front' ) && is_front_page() ){
    return true;
  }
  return false;
}
