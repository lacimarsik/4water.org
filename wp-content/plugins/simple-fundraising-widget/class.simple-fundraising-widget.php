<?php

// Widget class
class simple_fundraising_widget extends WP_Widget
{
  function __construct()
  {
    parent::__construct(
      'simple_fundraising_widget',

      // Widget name for UI
      __('Simple Fundraising Widget', 'simple_fundraising_widget_domain'),

      // Widget description
      array('description' => __('Widget for showing raised amount for a custom charity', 'simple_fundraising_widget_domain'))
    );

    // Add Widget styles to head
    if (is_active_widget(false, false, $this->id_base)) {
      add_action('wp_head', array($this,'css'));
    }
  }

  // Widget front-end
  public function widget($args, $instance) {
    $instance = wp_parse_args((array) $instance, self::get_defaults());
?>
    <div class="sf-widget-wrapper">
<?php
      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if (!empty($title)) {
        echo $args['before_title'] . $instance['title'] . $args['after_title'];
      }

      // Widget body:
      $formatter = new NumberFormatter('en_US',  NumberFormatter::CURRENCY);
?>
      <div class="sf-widget-text">
        <em class="sf-widget-emphasize"><?php echo $formatter->formatCurrency($instance['raised'], $instance['currency']) ?></em> <?php echo $instance['text'] ?>
      </div>
    </div>
<?php
    echo $args['after_widget'];
  }

  // Widget back-end
  public function form($instance)
  {
    $instance = wp_parse_args((array) $instance, self::get_defaults());

    // Widget admin form
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
             name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>"
             name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($instance['text']); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('raised'); ?>"><?php _e('Amount raised:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('raised'); ?>"
             name="<?php echo $this->get_field_name('raised'); ?>" type="text" value="<?php echo esc_attr($instance['raised']); ?>"/>
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('currency'); ?>"><?php _e('Currency:'); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id('currency'); ?>"
             name="<?php echo $this->get_field_name('currency'); ?>" type="text" value="<?php echo esc_attr($instance['currency']); ?>"/>
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $new_instance = wp_parse_args((array) $new_instance, self::get_defaults());
    $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
    $instance['text'] = (!empty($new_instance['text'])) ? strip_tags($new_instance['text']) : '';
    $instance['raised'] = (!empty($new_instance['raised'])) ? strip_tags($new_instance['raised']) : '';
    $instance['currency'] = (!empty($new_instance['currency'])) ? strip_tags($new_instance['currency']) : '';

    return $instance;
  }

  // Default values for widget
  private static function get_defaults() {
    $defaults = array(
      'title' => 'Charity organisation',
      'text' => 'raised till now',
      'raised' => 1000,
      'currency' => 'GBP'
    );

    return $defaults;
  }

  // Widget CSS
  function css() {
?>
    <style type="text/css">
      .sf-widget-wrapper h3.widget-title {
        font-size: 14px;
        margin: 0;
      }

      .sf-widget-wrapper .sf-widget-text {
        line-height: 18px;
        padding-left: 8px;
        font-size: 10px;
      }

      .sf-widget-wrapper .sf-widget-text .sf-widget-emphasize {
        font-style: normal;
      }
    </style>
<?php
  }
}

// Register and load the widget
function simple_fundraising_widget_load() {
  register_widget('simple_fundraising_widget');
}
add_action('widgets_init', 'simple_fundraising_widget_load' );
?>