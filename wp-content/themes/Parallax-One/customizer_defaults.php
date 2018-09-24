<?php

/********************************************************/
/********************* HEADER ***************************/
/********************************************************/

class DefHeader {
  public static $logo = '';
  public static $header_logo = '';
  public static $header_title = 'DANCE, COMMUNITY & CONTRIBUTION';
  public static $header_subtitle = 'Have fun, make friends and help us change the world through dance';
  public static $header_button_text = '';
  public static $header_button_link = '';
  public static $header_award_text = '';
  public static $header_award_image = '';
  public static $header_button_opens_payments = false;
  public static $use_transparent_background = false;
  public static $transparent_background_color = '141414';
};

/********************************************************/
/****************** INTRODUCTION ************************/
/********************************************************/

class DefIntro {
  public static $use_video = true;
  public static $video_link = 'https://www.youtube.com/embed/bs8SU24k8P4';
  public static $video_caption = 'Don\'t believe us? Check the video';
  public static $image = '/images/4water_menu.png';
  public static $image_caption = '4Water';
  public static $title = 'Heeey, welcome on SALSA4WATER GLASGOW!';
  public static $text = 'Lorem ipsum dolor sit amet...';
  public static $under_construction_text = '';
  public static $under_construction_link = '';
  public static $under_construction_link_text = '';
};

/********************************************************/
/****************** WHICH STYLE *************************/
/********************************************************/

class DefWhichStyle {
  public static $title = 'DANCE4WATER STYLES';
  public static $subtitle = 'Introductory text';
  public static $use_videos = true;
  public static $content;  //need to initialize later
};
DefWhichStyle::$content = json_encode(
  array(
    array(
      'style' => esc_html__('CUBAN SALSA','parallax-one'),
      'desc' => esc_html__('Description of the dance and blabla','parallax-one'),
      'url' => esc_html__('https://www.youtube.com/embed/bs8SU24k8P4', 'parallax-one'),
      'image' => parallax_get_file('/images/regular_classes.jpg')
    ),
    array(
      'style' => esc_html__('BACHATA','parallax-one'),
      'desc' => esc_html__('Description of bachata and blabla','parallax-one'),
      'url' => esc_html__('https://www.youtube.com/embed/iCVQmEeBfbU', 'parallax-one'),
      'image' => parallax_get_file('/images/events.jpg')
    ),
    array(
      'style' => esc_html__('ZOUK','parallax-one'),
      'desc' => esc_html__('Description of zouk and blabla','parallax-one'),
      'url' => esc_html__('https://www.youtube.com/embed/_QkP168_Ltc', 'parallax-one'),
      'image' => parallax_get_file('/images/night_out.jpg')
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
  public static $content; //need to initialize later
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
  public static $content; //need to initialize later
  public static $note = 'You\'ll pay at the entrance before each class. We are...';
  public static $student_switch = true;
  public static $option_one = 'Student';
  public static $option_two = 'Non-Student';
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
/********************** TEAM ****************************/
/********************************************************/

class DefTeam {
  public static $hide = true;
  public static $title = 'OUR TEACHERS';
  public static $subtitle = 'Our teachers and volunteers have been gathering skills on congresses and trainings all over the world.';
  public static $content; //need to initialize later
};
DefTeam::$content = json_encode(
  array(
    array(
      'image_url' => parallax_get_file('/images/team/berlin_square_1.jpg'),
      'title_above' => esc_html__('','parallax-one'),
      'title' => esc_html__('Salsa Body Movement - Miriam','parallax-one'),
      'subtitle' => esc_html__('Dancing Salsa is not only moving your feet. Adding some funky circular movements with your hands is nice, but you can still step up your game by working with your whole body. Body isolations can make a big difference in your dance. It will give you more possibilities to interprete the music you\'re dancing on and it\'s basically great fun.','parallax-one')
    ),
    array(
      'image_url' => parallax_get_file('/images/team/berlin_square_2.jpg'),
      'title_above' => esc_html__('','parallax-one'),
      'title' => esc_html__('Salsa Partner Styling - Yaros & Katerina','parallax-one'),
      'subtitle' => esc_html__('Yaros & Katerina will be teaching advanced Partner Styling in Rueda. A combination of Rumba, Salsa, Afro and Styling. This class will be for advanced dancers, who are comfortable with dancing Cuban Salsa on a dance floor.','parallax-one')
    ),
    array(
      'image_url' => parallax_get_file('/images/team/berlin_square_3.jpg'),
      'title_above' => esc_html__('','parallax-one'),
      'title' => esc_html__('Rumba: Columbia - Marvin','parallax-one'),
      'subtitle' => esc_html__('Afro-cuban Rumba consists of 3 different dances: Yambú, Guaguanco and Columbia. Columbia is a direct interaction between rumbero and percussionist. The dancer will alternate between slow and fast and show off his skills within a circle of spectators. Columbia movements are also perfect for pimping up your style while Casino/Timba dancing.','parallax-one')
    ),
    array(
      'image_url' => parallax_get_file('/images/team/berlin_square_4.jpg'),
      'title_above' => esc_html__('','parallax-one'),
      'title' => esc_html__('Introduction to Orishas - Yaros, Katerina & Marvin','parallax-one'),
      'subtitle' => esc_html__('The deities or gods of Yoruba religion are an important part of Cuban culture. When you dance an Orisha, you also tell his story and character by your dancing. Let us introduce you to Elegua, the opener or all roads, Ochún, goddess of beauty, love, sexuality and fresh water and Ogun, god of metal who lives in the jungle.','parallax-one')
    ),
  )
);

/********************************************************/
/****************** ARTICLES ****************************/
/********************************************************/

class DefArticles {
  public static $title = 'INTERESTING FACTS';
  public static $content; //need to initialize later
  public static $hide = true;
};
DefArticles::$content = json_encode(
  array(
    array(
      'image' => parallax_get_file('/images/ethiopia.jpg'),
      'text' => esc_html__('Over 40% of the population have no choice but to collect dirty water from unsafe sources', 'parallax-one'),
      'link_text' => esc_html__('Read more','parallax-one'),
      'link' => esc_html__('http://www.wateraid.org/where-we-work/page/ethiopia','parallax-one')
    ),
    array(
      'image' => parallax_get_file('/images/caught_short.jpg'),
      'text' => esc_html__('How a lack of access to clean water and decent toilets plays a major role in child stunting', 'parallax-one'),
      'link_text' => esc_html__('Read more','parallax-one'),
      'link' => esc_html__('http://www.wateraid.org/news/news/caught-short-how-a-lack-of-clean-water-and-decent-toilets-plays-a-major-role-in-child-stunting','parallax-one')
    )
  )
);

/********************************************************/
/****************** CONTACT ******************************/
/********************************************************/

class DefContact {
  public static $maps_content;  //need to initialize later
  public static $content;  //need to initialize later
  public static $title_above = '';
  public static $use_links = false;
};
DefContact::$maps_content = json_encode(
  array(
    array(
      'shortcode_id' => '',
      'label' => esc_html__('Default', 'parallax-one'),
      'link' => esc_html__('', 'parallax-one')
    )
  )
);
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
  public static $text = '4WATER is a student-led project exchanging a range of skills such as dance, arts and languages
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
  public static $this_week = 'This week';
  public static $next_week = 'Next week';
  public static $fallback = false;
};

/********************************************************/
/****************** CALL TO ACTION **********************/
/********************************************************/

class DefCallToAction {
  public static $title = '£105,354 was raised to date';
  public static $text = 'Dirty water spreads diarrhoeal diseases, killing 900 children every day. We donate 100% of our profits to WaterAid projects in Ethiopia, helping people gain access to clean water, sanitation and hygiene education.';
  public static $content; //need to initialize later
  public static $form = '';
  public static $payments_heading = 'CHOOSE YOUR CLASS AND LEVEL';
  public static $payments_note = '';
  public static $payments_image = '';
  public static $payments; //need to initialize later
  public static $note = 'No money to donate? There are plenty of other ways to get involved';
  public static $note_link = '';
  public static $note_link_text = '';
  public static $big_buttons = false;
  public static $hide = true;
};
DefCallToAction::$content = json_encode(
  array(
    array(
      'text' => esc_html__('Donate', 'parallax-one'),
      'link' => esc_html__('http://uk.virginmoneygiving.com/fundraiser-web/fundraiser/showFundraiserProfilePage.action?userUrl=4water&isTeam=true', 'parallax-one'),
      'is_payment' => esc_html__('no', 'parallax-one')
    ),
    array(
      'text' => esc_html__('Start a 4Water Project', 'parallax-one'),
      'link' => esc_html__('mailto: weare4water@gmail.com', 'parallax-one'),
      'is_payment' => esc_html__('no', 'parallax-one')
    )
  )
);
DefCallToAction::$payments = json_encode(
  array(
    array(
      'hosted_button_id' => esc_html__('UGZLN8MEVH5AN', 'parallax-one'),
      'description' => esc_html__('Hungarian 1 beginners, Tuesday 9-10pm, 10 week course', 'parallax-one'),
      'student_charge' => esc_html__('Student £30.00 GBP', 'parallax-one'),
      'non_student_charge' => esc_html__('Non-student £35.00 GBP', 'parallax-one'),
      'field_description' => esc_html__('Full Name (for class register)', 'parallax-one'),
      'button_text' => esc_html__('Pay with', 'parallax-one'),
      'product_available' => esc_html__('yes', 'parallax-one')
    ),
    array(
      'hosted_button_id' => esc_html__('LKK243PV3QFAQ', 'parallax-one'),
      'description' => esc_html__('Arabic 1 beginners, Wednesdays 6-7pm, 10 week course', 'parallax-one'),
      'student_charge' => esc_html__('Student £30.00 GBP', 'parallax-one'),
      'non_student_charge' => esc_html__('Non-student £35.00 GBP', 'parallax-one'),
      'field_description' => esc_html__('Full Name (for class register)', 'parallax-one'),
      'button_text' => esc_html__('Pay with', 'parallax-one'),
      'product_available' => esc_html__('yes', 'parallax-one')
    ),
    array(
      'hosted_button_id' => esc_html__('E4XSYVJPNB9VJ', 'parallax-one'),
      'description' => esc_html__('Dutch 1 beginners, Monday 8-9pm, 10 week course', 'parallax-one'),
      'student_charge' => esc_html__('Student £30.00 GBP', 'parallax-one'),
      'non_student_charge' => esc_html__('Non-student £35.00 GBP', 'parallax-one'),
      'field_description' => esc_html__('Full Name (for class register)', 'parallax-one'),
      'button_text' => esc_html__('Pay with', 'parallax-one'),
      'product_available' => esc_html__('yes', 'parallax-one')
    ),
  )
);

/********************************************************/
/************************ FAQ ***************************/
/********************************************************/

class DefFaq {
  public static $title = 'F.A.Q.';
  public static $content; //need to initialize later
  public static $hide = true;
};
DefFaq::$content = json_encode(
  array(
    array(
      'question' => esc_html__('Why join Language4water?', 'parallax-one'),
      'answer' => esc_html__('We offer language classes at affordable prices, and by attending a 10-week block of language classes, you will provide two people in need with the access to clean water, sanitation and hygiene education.', 'parallax-one')
    ),
    array(
      'question' => esc_html__('When do the classes start?', 'parallax-one'),
      'answer' => esc_html__('Our 10-week course is starting the week of the 26th of September 2016 running until the one of the 28th of November. We offer classes for 15 different languages from across the world.', 'parallax-one')
    ),
    array(
      'question' => esc_html__('Where are the classes?', 'parallax-one'),
      'answer' => esc_html__('The classes take place in the Queen Margaret Union (22 University Gardens, Glasgow), in the Committee Room 4. Check the map at the bottom of the page.', 'parallax-one')
    )
  )
);

/********************************************************/
/******************* IMAGE SECTION **********************/
/********************************************************/

class DefImage {
  public static $use_static_image = false;
  public static $title_above = '';
  public static $subtitle_above = '';
  public static $title_inside = 'A GLOBAL PHENOMENON';
  public static $text_inside = 'People around the world are using their passion to affect change';
  public static $button_text = '';
  public static $button_link = '';
  public static $ribbon_background = '/images/ribbon_background.jpg';
  public static $static_image = '';
  public static $hide = true;
};

/********************************************************/
/*************** SUBSCRIPTION SECTION *******************/
/********************************************************/

class DefSubscription {
    public static $title = 'Stay tuned';
    public static $subtitle = 'Subscribe to our mailinglist to know about the notable updates to our cause';
    public static $url = '';
    public static $hide = true;
};

/*************************************************/
/*************** VIDEO SECTION *******************/
/*************************************************/

class DefVideo {
    public static $video_link = 'https://www.youtube.com/embed/Rl-CLqAOSTs';
    public static $video_caption = 'Would you enjoy such opportunity? Fill out our form below.';
    public static $title = '4Water Journey';
    public static $text = 'How it all started';
    public static $hide = true;
};