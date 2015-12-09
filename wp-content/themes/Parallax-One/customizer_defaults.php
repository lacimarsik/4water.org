<?php

/********************************************************/
/****************** INTRODUCTION ************************/
/********************************************************/

class DefIntro {
  public static $video_link = 'https://www.youtube.com/embed/bs8SU24k8P4';
  public static $video_caption = 'Don\'t believe us? Check the video';
  public static $title = 'Heeey, welcome on SALSA4WATER GLASGOW!';
  public static $text = 'Lorem ipsum dolor sit amet...';
};

/********************************************************/
/****************** WHICH STYLE *************************/
/********************************************************/

class DefWhichStyle {
  public static $title = 'DANCE4WATER STYLES';
  public static $subtitle = 'Introductory text';
  public static $content;  //need to initialize later
};
DefWhichStyle::$content = json_encode(
  array(
    array(
      'style' => esc_html__('CUBAN SALSA','parallax-one'),
      'desc' => esc_html__('Description of the dance and blabla','parallax-one'),
      'url' => esc_html__('https://www.youtube.com/embed/bs8SU24k8P4', 'parallax-one'),
    ),
    array(
      'style' => esc_html__('BACHATA','parallax-one'),
      'desc' => esc_html__('Description of bachata and blabla','parallax-one'),
      'url' => esc_html__('https://www.youtube.com/embed/iCVQmEeBfbU', 'parallax-one'),
    ),
    array(
      'style' => esc_html__('ZOUK','parallax-one'),
      'desc' => esc_html__('Description of zouk and blabla','parallax-one'),
      'url' => esc_html__('https://www.youtube.com/embed/_QkP168_Ltc', 'parallax-one'),
    )
  )
);

/********************************************************/
/****************** WHY US ******************************/
/********************************************************/

class DefWhyUs {
  public static $title = 'WHY DANCE WITH US?';
  public static $content;  //need to initialize later
};
DefWhichStyle::$content = json_encode(
  array(
    array(
      'image' => parallax_get_file('/images/why-us-shoe.png'),
      'reason' => esc_html__('NO DRESS CODE', 'parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
    ),
    array(
      'image_url' => parallax_get_file('/images/why-us-clock.png'),
      'title' => esc_html__('JOIN US ANYTIME','parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
    ),
    array(
      'image' => parallax_get_file('/images/why-us-paper.png'),
      'reason' => esc_html__('NO REGISTRATION','parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
    )
  )
);

/********************************************************/
/****************** HOW WE TEACH ************************/
/********************************************************/

class DefHowTeach {
  public static $caption1 = 'No partner needed';
  public static $img1 = '/images/no-partner.png';
  public static $caption2 = 'Rueda de casino';
  public static $img2 = '/images/rueda.png';
  public static $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...';
};

/********************************************************/
/****************** PRICES ******************************/
/********************************************************/

class DefPrices {
  public static $title = 'PRICES';
  public static $prices_content;  //need to initialize later
};
DefPrices::$prices_content = json_encode(
  array(
    array(
      'type' => esc_html__('ONE TIME ENTRY', 'parallax-one'),
      'desc' => esc_html__('Come and taste our vibrant atmosphere...', 'parallax-one'),
      'length' => esc_html__('1 day (2 lessons in a row)','parallax-one'),
      'student_price' => esc_html__('70 CZK','parallax-one'),
      'non_student_price' => esc_html__('100 CZK','parallax-one'),
    ),
    array(
      'type' => esc_html__('WORKSHOP', 'parallax-one'),
      'desc' => esc_html__('New to Salsa or already veteran? Enjoy...', 'parallax-one'),
      'length' => esc_html__('Whole day (4 lessons)','parallax-one'),
      'student_price' => esc_html__('100 CZK','parallax-one'),
      'non_student_price' => esc_html__('150 CZK','parallax-one'),
    ),
    array(
      'type' => esc_html__('VOUCHER 10x', 'parallax-one'),
      'desc' => esc_html__('10 entries...', 'parallax-one'),
      'length' => esc_html__('10 lessons','parallax-one'),
      'student_price' => esc_html__('500 CZK','parallax-one'),
      'non_student_price' => esc_html__('750 CZK','parallax-one'),
    )
  )
);
