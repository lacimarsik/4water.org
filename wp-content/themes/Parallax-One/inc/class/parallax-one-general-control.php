<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
  return NULL;

function objectToArray($d) {
  if (is_object($d)) {
  // Gets the properties of the given object
  // with get_object_vars function
    $d = get_object_vars($d);
  }

  if (is_array($d)) {
    /*
    * Return array converted to object
    * Using __FUNCTION__ (Magic constant)
    * for recursive call
    */
    return array_map(__FUNCTION__, $d);
  }
  else {
    // Return array
    return $d;
  }
}

class Parallax_One_General_Repeater extends WP_Customize_Control {
  private $options = array();
  private $icons_array = array( 'No Icon','icon-social-blogger','icon-social-blogger-circle','icon-social-blogger-square','icon-social-delicious','icon-social-delicious-circle','icon-social-delicious-square','icon-social-deviantart','icon-social-deviantart-circle','icon-social-deviantart-square','icon-social-dribbble','icon-social-dribbble-circle','icon-social-dribbble-square','icon-social-facebook','icon-social-facebook-circle','icon-social-facebook-square','icon-social-flickr','icon-social-flickr-circle','icon-social-flickr-square','icon-social-googledrive','icon-social-googledrive-alt2','icon-social-googledrive-square','icon-social-googleplus','icon-social-googleplus-circle','icon-social-googleplus-square','icon-social-instagram','icon-social-instagram-circle','icon-social-instagram-square','icon-social-linkedin','icon-social-linkedin-circle','icon-social-linkedin-square','icon-social-myspace','icon-social-myspace-circle','icon-social-myspace-square','icon-social-picassa','icon-social-picassa-circle','icon-social-picassa-square','icon-social-pinterest','icon-social-pinterest-circle','icon-social-pinterest-square','icon-social-rss','icon-social-rss-circle','icon-social-rss-square','icon-social-skype','icon-social-skype-circle','icon-social-skype-square','icon-social-spotify','icon-social-spotify-circle','icon-social-spotify-square','icon-social-stumbleupon-circle','icon-social-stumbleupon-square','icon-social-tumbleupon','icon-social-tumblr','icon-social-tumblr-circle','icon-social-tumblr-square','icon-social-twitter','icon-social-twitter-circle','icon-social-twitter-square','icon-social-vimeo','icon-social-vimeo-circle','icon-social-vimeo-square','icon-social-wordpress','icon-social-wordpress-circle','icon-social-wordpress-square','icon-social-youtube','icon-social-youtube-circle','icon-social-youtube-square','icon-weather-wind-e','icon-weather-wind-n','icon-weather-wind-ne','icon-weather-wind-nw','icon-weather-wind-s','icon-weather-wind-se','icon-weather-wind-sw','icon-weather-wind-w','icon-software-add-vectorpoint','icon-software-box-oval','icon-software-box-polygon','icon-software-crop','icon-software-eyedropper','icon-software-font-allcaps','icon-software-font-kerning','icon-software-horizontal-align-center','icon-software-layout','icon-software-layout-4boxes','icon-software-layout-header','icon-software-layout-header-2columns','icon-software-layout-header-3columns','icon-software-layout-header-4boxes','icon-software-layout-header-4columns','icon-software-layout-header-complex','icon-software-layout-header-complex2','icon-software-layout-header-complex3','icon-software-layout-header-complex4','icon-software-layout-header-sideleft','icon-software-layout-header-sideright','icon-software-layout-sidebar-left','icon-software-layout-sidebar-right','icon-software-paragraph-align-left','icon-software-paragraph-align-right','icon-software-paragraph-center','icon-software-paragraph-justify-all','icon-software-paragraph-justify-center','icon-software-paragraph-justify-left','icon-software-paragraph-justify-right','icon-software-pathfinder-exclude','icon-software-pathfinder-intersect','icon-software-pathfinder-subtract','icon-software-pathfinder-unite','icon-software-pen','icon-software-pencil','icon-software-scale-expand','icon-software-scale-reduce','icon-software-vector-box','icon-software-vertical-align-bottom','icon-software-vertical-distribute-bottom','icon-music-beginning-button','icon-music-bell','icon-music-eject-button','icon-music-end-button','icon-music-fastforward-button','icon-music-headphones','icon-music-microphone-old','icon-music-mixer','icon-music-pause-button','icon-music-play-button','icon-music-rewind-button','icon-music-shuffle-button','icon-music-stop-button','icon-ecommerce-bag','icon-ecommerce-bag-check','icon-ecommerce-bag-cloud','icon-ecommerce-bag-download','icon-ecommerce-bag-plus','icon-ecommerce-bag-upload','icon-ecommerce-basket-check','icon-ecommerce-basket-cloud','icon-ecommerce-basket-download','icon-ecommerce-basket-upload','icon-ecommerce-bath','icon-ecommerce-cart','icon-ecommerce-cart-check','icon-ecommerce-cart-cloud','icon-ecommerce-cart-content','icon-ecommerce-cart-download','icon-ecommerce-cart-plus','icon-ecommerce-cart-upload','icon-ecommerce-cent','icon-ecommerce-colon','icon-ecommerce-creditcard','icon-ecommerce-diamond','icon-ecommerce-dollar','icon-ecommerce-euro','icon-ecommerce-franc','icon-ecommerce-gift','icon-ecommerce-graph1','icon-ecommerce-graph2','icon-ecommerce-graph3','icon-ecommerce-graph-decrease','icon-ecommerce-graph-increase','icon-ecommerce-guarani','icon-ecommerce-kips','icon-ecommerce-lira','icon-ecommerce-money','icon-ecommerce-naira','icon-ecommerce-pesos','icon-ecommerce-pound','icon-ecommerce-receipt','icon-ecommerce-sale','icon-ecommerce-sales','icon-ecommerce-tugriks','icon-ecommerce-wallet','icon-ecommerce-won','icon-ecommerce-yen','icon-ecommerce-yen2','icon-basic-elaboration-briefcase-check','icon-basic-elaboration-briefcase-download','icon-basic-elaboration-browser-check','icon-basic-elaboration-browser-download','icon-basic-elaboration-browser-plus','icon-basic-elaboration-calendar-check','icon-basic-elaboration-calendar-cloud','icon-basic-elaboration-calendar-download','icon-basic-elaboration-calendar-empty','icon-basic-elaboration-calendar-heart','icon-basic-elaboration-cloud-download','icon-basic-elaboration-cloud-check','icon-basic-elaboration-cloud-search','icon-basic-elaboration-cloud-upload','icon-basic-elaboration-document-check','icon-basic-elaboration-document-graph','icon-basic-elaboration-folder-check','icon-basic-elaboration-folder-cloud','icon-basic-elaboration-mail-document','icon-basic-elaboration-mail-download','icon-basic-elaboration-message-check','icon-basic-elaboration-message-dots','icon-basic-elaboration-message-happy','icon-basic-elaboration-tablet-pencil','icon-basic-elaboration-todolist-2','icon-basic-elaboration-todolist-check','icon-basic-elaboration-todolist-cloud','icon-basic-elaboration-todolist-download','icon-basic-accelerator','icon-basic-anticlockwise','icon-basic-battery-half','icon-basic-bolt','icon-basic-book','icon-basic-book-pencil','icon-basic-bookmark','icon-basic-calendar','icon-basic-cards-hearts','icon-basic-case','icon-basic-clessidre','icon-basic-cloud','icon-basic-clubs','icon-basic-compass','icon-basic-cup','icon-basic-display','icon-basic-download','icon-basic-exclamation','icon-basic-eye','icon-basic-gear','icon-basic-geolocalize-01','icon-basic-geolocalize-05','icon-basic-headset','icon-basic-heart','icon-basic-home','icon-basic-laptop','icon-basic-lightbulb','icon-basic-link','icon-basic-lock','icon-basic-lock-open','icon-basic-magnifier','icon-basic-magnifier-minus','icon-basic-magnifier-plus','icon-basic-mail','icon-basic-mail-multiple','icon-basic-mail-open-text','icon-basic-male','icon-basic-map','icon-basic-message','icon-basic-message-multiple','icon-basic-message-txt','icon-basic-mixer2','icon-basic-notebook-pencil','icon-basic-paperplane','icon-basic-photo','icon-basic-picture','icon-basic-picture-multiple','icon-basic-rss','icon-basic-server2','icon-basic-settings','icon-basic-share','icon-basic-sheet-multiple','icon-basic-sheet-pencil','icon-basic-sheet-txt','icon-basic-tablet','icon-basic-todo','icon-basic-webpage','icon-basic-webpage-img-txt','icon-basic-webpage-multiple','icon-basic-webpage-txt','icon-basic-world','icon-arrows-check','icon-arrows-circle-check','icon-arrows-circle-down','icon-arrows-circle-downleft','icon-arrows-circle-downright','icon-arrows-circle-left','icon-arrows-circle-minus','icon-arrows-circle-plus','icon-arrows-circle-remove','icon-arrows-circle-right','icon-arrows-circle-up','icon-arrows-circle-upleft','icon-arrows-circle-upright','icon-arrows-clockwise','icon-arrows-clockwise-dashed','icon-arrows-down','icon-arrows-down-double-34','icon-arrows-downleft','icon-arrows-downright','icon-arrows-expand','icon-arrows-glide','icon-arrows-glide-horizontal','icon-arrows-glide-vertical','icon-arrows-keyboard-alt','icon-arrows-keyboard-cmd-29','icon-arrows-left','icon-arrows-left-double-32','icon-arrows-move2','icon-arrows-remove','icon-arrows-right','icon-arrows-right-double-31','icon-arrows-rotate','icon-arrows-plus','icon-arrows-shrink','icon-arrows-slim-left','icon-arrows-slim-left-dashed','icon-arrows-slim-right','icon-arrows-slim-right-dashed','icon-arrows-squares','icon-arrows-up','icon-arrows-up-double-33','icon-arrows-upleft','icon-arrows-upright','icon-browser-streamline-window','icon-bubble-comment-streamline-talk','icon-caddie-shopping-streamline','icon-computer-imac','icon-edit-modify-streamline','icon-home-house-streamline','icon-locker-streamline-unlock','icon-lock-locker-streamline','icon-link-streamline','icon-man-people-streamline-user','icon-speech-streamline-talk-user','icon-settings-streamline-2','icon-settings-streamline-1','icon-arrow-carrot-left','icon-arrow-carrot-right','icon-arrow-carrot-up','icon-arrow-carrot-right-alt2','icon-arrow-carrot-down-alt2','icon-arrow-carrot-left-alt2','icon-arrow-carrot-up-alt2','icon-arrow-carrot-2up','icon-arrow-carrot-2right-alt2','icon-arrow-carrot-2up-alt2','icon-arrow-carrot-2right','icon-arrow-carrot-2left-alt2','icon-arrow-carrot-2left','icon-arrow-carrot-2down-alt2','icon-arrow-carrot-2down','icon-arrow-carrot-down','icon-arrow-left','icon-arrow-right','icon-arrow-triangle-down','icon-arrow-triangle-left','icon-arrow-triangle-right','icon-arrow-triangle-up','icon-adjust-vert','icon-bag-alt','icon-box-checked','icon-camera-alt','icon-check','icon-chat-alt','icon-cart-alt','icon-check-alt2','icon-circle-empty','icon-circle-slelected','icon-clock-alt','icon-close-alt2','icon-cloud-download-alt','icon-cloud-upload-alt','icon-compass-alt','icon-creditcard','icon-datareport','icon-easel','icon-lightbulb-alt','icon-laptop','icon-lock-alt','icon-lock-open-alt','icon-link','icon-link-alt','icon-map-alt','icon-mail-alt','icon-piechart','icon-star-half','icon-star-half-alt','icon-star-alt','icon-ribbon-alt','icon-tools','icon-paperclip','icon-adjust-horiz','icon-social-blogger','icon-social-blogger-circle','icon-social-blogger-square','icon-social-delicious','icon-social-delicious-circle','icon-social-delicious-square','icon-social-deviantart','icon-social-deviantart-circle','icon-social-deviantart-square','icon-social-dribbble','icon-social-dribbble-circle','icon-social-dribbble-square','icon-social-facebook','icon-social-facebook-circle','icon-social-facebook-square','icon-social-flickr','icon-social-flickr-circle','icon-social-flickr-square','icon-social-googledrive','icon-social-googledrive-alt2','icon-social-googledrive-square','icon-social-googleplus','icon-social-googleplus-circle','icon-social-googleplus-square','icon-social-instagram','icon-social-instagram-circle','icon-social-instagram-square','icon-social-linkedin','icon-social-linkedin-circle','icon-social-linkedin-square','icon-social-myspace','icon-social-myspace-circle','icon-social-myspace-square','icon-social-picassa','icon-social-picassa-circle','icon-social-picassa-square','icon-social-pinterest','icon-social-pinterest-circle','icon-social-pinterest-square','icon-social-rss','icon-social-rss-circle','icon-social-rss-square','icon-social-share','icon-social-share-circle','icon-social-share-square','icon-social-skype','icon-social-skype-circle','icon-social-skype-square','icon-social-spotify','icon-social-spotify-circle','icon-social-spotify-square','icon-social-stumbleupon-circle','icon-social-stumbleupon-square','icon-social-tumbleupon','icon-social-tumblr','icon-social-tumblr-circle','icon-social-tumblr-square','icon-social-twitter','icon-social-twitter-circle','icon-social-twitter-square','icon-social-vimeo','icon-social-vimeo-circle','icon-social-vimeo-square','icon-social-wordpress','icon-social-wordpress-circle','icon-social-wordpress-square','icon-social-youtube','icon-social-youtube-circle','icon-social-youtube-square','icon-aim','icon-aim-alt','icon-amazon','icon-app-store','icon-apple','icon-behance','icon-creative-commons','icon-dropbox','icon-digg','icon-last','icon-paypal','icon-rss','icon-sharethis','icon-skype','icon-squarespace','icon-technorati','icon-whatsapp','icon-windows','icon-reddit','icon-foursquare','icon-soundcloud','icon-w3','icon-wikipedia','icon-grid-2x2','icon-grid-3x3','icon-menu-square-alt','icon-menu','icon-cloud-alt','icon-tags-alt','icon-tag-alt','icon-gift-alt','icon-comment-alt','icon-icon-phone','icon-icon-mobile','icon-icon-house-alt','icon-icon-house','icon-icon-desktop');

  public function __construct( $manager, $id, $args = array() ) {
    parent::__construct( $manager, $id, $args );
    $this->options = $args;
  }

  private function render_box($box_data, $box_number, $fields) { 
    
    //this (in our case) will make an array object out of stdClass object 
    $box_data = get_object_vars($box_data); ?>

    <div class="parallax_one_general_control_repeater_container parallax_one_draggable">
      <div class="parallax-customize-control-title">
        <?php esc_html_e('Entry','parallax-one')?>
      </div>
      <div class="parallax-box-content-hidden">
        <?php
        foreach ($fields as $key => $field) {
          if ($field['type'] == 'image') { ?>
            <span class="customize-control-title"><?php esc_html_e($field['label'],'parallax-one')?></span>
            <p class="parallax_one_image_control">
              <input 
                  type="text" 
                  class="widefat custom_media_url repeater_value" 
                  data-key="<?=$key?>"
                  value="<?php if(!empty($box_data[$key])) {echo esc_attr($box_data[$key]);} ?>">
              <input 
                  type="button" 
                  class="button button-primary custom_media_button_parallax_one" 
                  value="<?php esc_html_e('Upload Image','parallax-one'); ?>" />
            </p>
            <?php
          }
          elseif ($field['type'] == 'icon') { ?>
            <span class="customize-control-title"><?php esc_html_e($field['label'],'parallax-one')?></span>
            <select 
                name="<?php echo esc_attr($this->id); ?>" 
                class="parallax_one_icon_control repeater_value"
                data-key="<?=$key?>">
              <?php 
              foreach($this->icons_array as $contact_icon) {
                echo '<option value="'.esc_attr($contact_icon).'" '.selected($box_data[$key],$contact_icon).'">'.esc_attr($contact_icon).'</option>';
              } ?>
            </select>
            <?php
          }
          elseif ($field['type'] == 'text') { ?>
            <span class="customize-control-title"><?php esc_html_e($field['label'],'parallax-one')?></span>
            <input 
              type="text" 
              value="<?php if(!empty($box_data[$key])) echo esc_attr($box_data[$key]); ?>" 
              class="parallax_one_text_control repeater_value" 
              data-key="<?=$key?>"
              placeholder="<?= esc_html_e(!empty($field['placeholder']) ? $field['placeholder'] : 'Text', 'parallax-one'); ?>"/>
            <?php
          }
          elseif ($field['type'] == 'textarea') { ?>
            <span class="customize-control-title"><?php esc_html_e($field['label'],'parallax-one')?></span>
            <textarea 
                placeholder="<?= esc_html_e(!empty($field['placeholder']) ? $field['placeholder'] : 'More text', 'parallax-one'); ?>"
                data-key="<?=$key?>"
                class="parallax_one_textarea_control repeater_value"><?php if(!empty($box_data[$key])) {echo esc_attr($box_data[$key]);} ?></textarea>
            <?php
          }
        } ?>

        <button 
            type="button" 
            class="parallax_one_general_control_remove_field button" 
            <?php if ($box_number == 0) echo 'style="display:none;"'; ?>>
              <?php esc_html_e('Delete field','parallax-one'); ?>
        </button>
      </div>
    </div>
    <?php
  }
  
  public function render_content() {
    $this_default = json_decode($this->setting->default);

    $values = $this->value();
    $json = json_decode($values);
    if(!is_array($json)) {
      $json = array($json);
    }

    $options = $this->options;
    if (!empty($options['fields'])) {
      $fields = $options['fields'];
    } else {
      $fields = array();
    } ?>

    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <div class="parallax_one_general_control_repeater parallax_one_general_control_droppable">
      <?php 
      $it = 0;
      if (!empty($json)) {
        foreach ($json as $box_data){
          $this->render_box($box_data, $it, $fields);
          $it++;
        }
      } 
      elseif (!empty($this_default)) {
        foreach ($this_default as $box_data) {
          $this->render_box($box_data, $it, $fields);
          $it++;
        }
      }

      if (!empty($this_default) && empty($json)) { ?>
        <input 
            type="hidden" 
            id="parallax_one_<?php echo $options['section']; ?>_repeater_colector" 
            <?php $this->link(); ?> class="parallax_one_repeater_colector" 
            value="<?php  echo esc_textarea( json_encode($this_default )); ?>" />
        <?php 
      } 
      else { ?>
        <input 
            type="hidden" 
            id="parallax_one_<?php echo $options['section']; ?>_repeater_colector" 
            <?php $this->link(); ?> 
            class="parallax_one_repeater_colector" 
            value="<?php echo esc_textarea( $this->value() ); ?>" />
        <?php 
      } ?>
    </div>
    <button type="button" class="button add_field parallax_one_general_control_new_field"><?php esc_html_e('Add new field','parallax-one'); ?></button>
<?php
  }
}
