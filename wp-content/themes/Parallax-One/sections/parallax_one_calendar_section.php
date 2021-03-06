<!-- =========================
 SECTION: CALENDAR
========================== -->
<?php

$calendar_title = get_theme_mod('calendar_title', DefCalendar::$title);
$calendar_mode = get_theme_mod('calendar_mode', DefCalendar::$mode);
$calendar_this_week = get_theme_mod('calendar_this_week', DefCalendar::$this_week);
$calendar_next_week = get_theme_mod('calendar_next_week', DefCalendar::$next_week);
$calendar_fallback = get_theme_mod('parallax_one_calendar_fallback', DefCalendar::$fallback);
?>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/app.js"></script>
  
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/controllers/calendarController.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarDayLegendDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarDayLineDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarEventDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarModalEventDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarTimeLegendDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarTimeLineDirective.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarWeekSwitchDirective.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/filters/escapeFilter.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/services/calendarModel.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/services/calendarApi.js"></script>

<section id="calendar" ng-app="4water">    
  <div class="section-overlay-layer">
    <div class="container">
      
        <!-- HEADER -->
      <div class="section-header">
          <h2 class="dark-text"> <?=esc_attr($calendar_title)?></h2>
      </div>
      
      <!-- CALENDAR -->
      <div 
          ng-controller="calendarController as calCtrl" 
          ng-init='calCtrl.init(0, "<?=$calendar_mode?>" === "condensed")'>
        
        <!-- loading wheel -->
        <div class="ajax-wheel-div" ng-show="!loaded">
          <img src="<?= get_bloginfo("template_url"); ?>/images/ajax-loader.gif" class="center-block" />
        </div>
        
        <!-- loading error -->
        <div id='calendar-error' style="display: none;">
          There was an error loading the calendar. 
        </div>
       
        <!-- calendar data -->
        <div ng-show="loaded && !loadError">
          <for-water-calendar 
              ng-repeat="calendar in calendars" 
              ng-show="calendar.weekIndex === weekIndex">
          </for-water-calendar>
          <div class="for-water-calendar-ie" style="display: none;">
<?php
                $static_image = get_theme_mod('image_section_static_image', parallax_get_file(DefImage::$static_image));
                if (isset($static_image) && (!empty($static_image)) && isset($calendar_fallback) && ($calendar_fallback == true)) {
                  echo '<div class="image-section-static-image"><img src="' . $static_image . '" /></div>';
                } else {
?>
                    <div style="padding-bottom: 20px;">Unfortunately, Internet Explorer / Edge cannot render the calendar properly. Please use Google Chrome or Mozilla Firefox to display the calendar.</div>
<?php
                }
?>
              </div>
          <div id="cal-switches">
            <calendar-week-switch></calendar-week-switch>
          </div>
<?php
          if (!empty($calendar_this_week)) {
?>
            <div id="calendar-this-week" style="display: none;"><?php echo $calendar_this_week ?></div>
<?php
          }
          if (!empty($calendar_next_week)) {
?>
            <div id="calendar-next-week" style="display: none;"><?php echo $calendar_next_week ?></div>
<?php
          }
?>
        </div>
      </div>
    </div>
  </div>
</section>
