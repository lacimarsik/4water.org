<?php

// Widget class
class simple_fundraising_widget_small_screens extends WP_Widget {
  function __construct() {
    parent::__construct(
      'simple_fundraising_widget_small_screens',

      // Widget name for UI
      __('Simple Fundraising Widget small screens', 'simple_fundraising_widget_domain'),

      // Widget description
      array('description' => __( 'Widget to link to a custom charity', 'simple_fundraising_widget_domain'))
    );

    // Add Widget styles to head
    if (is_active_widget(false, false, $this->id_base)) {
      add_action('wp_head', array($this,'css'));
    }
  }

  // Widget front-end
  public function widget($args, $instance) {
?>
    <div class="sf-widget-small-screens-wrapper">
<?php
      // Widget title: will be CSS-hidden for Simple fundraising widget
      $title = apply_filters( 'widget_title', $instance['title'] );
      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if (!empty($title)) {
        echo $args['before_title'] . $title . $args['after_title'];
      }

      // Widget body:
      $for_water_logo = get_theme_mod('4water_logo', parallax_get_file('/images/4Water_menu.png') );
?>
      <img class="sf-widget-small-screens-logo" src="<?php echo $for_water_logo ?>" />
    </div>
<?php
    echo $args['after_widget'];
  }

  // Widget back-end
  public function form($instance) {
    if (isset($instance['title'])) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __('Charity organisation', 'simple_fundraising_widget_domain');
    }

    // Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update($new_instance, $old_instance) {
    $instance = array();
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    return $instance;
  }

  // Widget CSS
  function css()
  {
?>
    <style type="text/css">
      /* Not shown on big screens */
      .sf-widget-small-screens-wrapper {
        display: none;
      }

      @media (max-width: 767px) {
        /* Shown on small screens */
        .sf-widget-small-screens-wrapper {
          display: inline;
        }

        .sf-widget-small-screens-wrapper .widget-title {
          display: none;
        }

        .sf-widget-small-screens-wrapper .sf-widget-small-screens-logo {
          padding-bottom: 12px;
          width: 80px;
          line-height: 18px;
        }
      }
    </style>
<?php
  }
}

// Register and load the widget
function simple_fundraising_widget_small_screens_load() {
  register_widget('simple_fundraising_widget_small_screens');
}
add_action('widgets_init', 'simple_fundraising_widget_small_screens_load' );
?>