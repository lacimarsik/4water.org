<?php

/********************************************************/
/********************* HEADER ***************************/
/********************************************************/

class DefHeader {
  public static $logo = '';
  public static $header_logo = '';
  public static $header_title = 'DANCE, COMMUNITY & CONTRIBUTION';
  public static $header_subtitle = 'Experience the excitement of the 4Water community. Make friends, get fit, have fun and help us change the world through dance.';
  public static $header_button_text = '';
  public static $header_button_link = '';
};

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
DefWhyUs::$content = json_encode(
  array(
    array(
      'image' => parallax_get_file('/images/why-us-shoe.png'),
      'reason' => esc_html__('NO DRESS CODE', 'parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
    ),
    array(
      'image' => parallax_get_file('/images/why-us-clock.png'),
      'reason' => esc_html__('JOIN US ANYTIME','parallax-one'),
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
/****************** MANY THINGS TO DO ******************************/
/********************************************************/

class DefManyThings {
  public static $title = 'MANY THINGS TO DO';
  public static $content;  //need to initialize later
};
DefManyThings::$content = json_encode(
  array(
    array(
      'image' => parallax_get_file('/images/regular_classes.jpg'),
      'title' => esc_html__('REGULAR CLASSES', 'parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
      'link_text' => esc_html__('more >','parallax-one'),
      'link' => esc_html__('','parallax-one')
    ),
    array(
      'image' => parallax_get_file('/images/events.jpg'),
      'title' => esc_html__('EVENTS','parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
      'link_text' => esc_html__('more >','parallax-one'),
      'link' => esc_html__('','parallax-one')
    ),
    array(
      'image' => parallax_get_file('/images/night_out.jpg'),
      'title' => esc_html__('NIGHT OUT','parallax-one'),
      'desc' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...','parallax-one'),
      'link_text' => esc_html__('more >','parallax-one'),
      'link' => esc_html__('','parallax-one')
    )
  )
);

/********************************************************/
/****************** PRICES ******************************/
/********************************************************/

class DefPrices {
  public static $title = 'PRICES';
  public static $content;  //need to initialize later
  public static $note = 'You\'ll pay at the entrance before each class. We are...'; 
};
DefPrices::$content = json_encode(
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

/********************************************************/
/****************** CONTACT ******************************/
/********************************************************/

class DefContact {
  public static $content;  //need to initialize later
};
DefContact::$content = json_encode(
  array(
    array(
      'text' => esc_html__('dance4water.prague@gmail.com', 'parallax-one'),
      'link' => esc_html__('mailto: dance4water.prague@gmail.com', 'parallax-one'),
      'icon_value' => esc_html__('icon-basic-mail','parallax-one')
    ),
    array(
      'text' => esc_html__('Křižkovského 4, 130 00 Prague', 'parallax-one'),
      'link' => esc_html__('https://www.google.cz/maps/place/Křížkovského+2420%2F4,+Žižkov,+130+00+Praha-Praha+3/', 'parallax-one'),
      'icon_value' => esc_html__('icon-basic-geolocalize-01','parallax-one')
    ),
    array(
      'text' => esc_html__('Dance4Water Prague', 'parallax-one'),
      'link' => esc_html__('https://www.facebook.com/dance4water.prague', 'parallax-one'),
      'icon_value' => esc_html__('icon-social-facebook-square','parallax-one')
    )
  )
);

/********************************************************/
/****************** FOOTER ******************************/
/********************************************************/

class DefFooter {
  public static $heading = 'ABOUT OUR ORGANIZATION';
  public static $text = '4WATER is a student-led project exchanging a range of skills such as dance, art and languages
  for charitable donations, which are given to WaterAid.';
  public static $copyright = 'Copyright 2016. Dance4Water Prague';
  public static $image_caption = 'WaterAid';
  public static $image_link = 'http://www.wateraid.org/';
  public static $image = '/images/wateraid.png';

}

class DefSocial {
  public static $text = 'Find us on';
  public static $content;  //need to initialize later
};

DefSocial::$content = json_encode(
  array(
    array(
      'icon_value' =>'icon-social-facebook',
      'link' => '#'
    ),
    array(
      'icon_value' =>'icon-social-twitter',
      'link' => '#'
    ),
    array(
      'icon_value' =>'icon-social-googleplus',
      'link' => '#')
  )
);

/********************************************************/
/****************** CALENDAR ****************************/
/********************************************************/

class DefCalendar {
  public static $title = 'WHEN and WHERE?';
  public static $mode = 'condensed';
};