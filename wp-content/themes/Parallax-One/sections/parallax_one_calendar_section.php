<!-- =========================
 SECTION: CALENDAR
========================== -->
<?php

$calendar_title = get_theme_mod('calendar_title', DefCalendar::$title);

?>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/app.js"></script>
  
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/controllers/calendarController.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarModeSwitchDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarWeekSwitchDirective.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/filters/escapeFilter.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/services/calendarModel.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/services/calendarApi.js"></script>

<section id="calendar">    
  <div class="section-overlay-layer">
    <div class="container">
      
        <!-- HEADER -->
      <div class="section-header">
          <h2 class="dark-text"> <?=esc_attr($calendar_title)?></h2>
      </div>
      
      <!-- CALENDAR -->
      <div 
          ng-controller="calendarController as calCtrl" 
          ng-init='calCtrl.init(-2)'> <!-- TODO - change this to 0 once on real calendar -->
        
        <!-- loading wheel -->
        <div class="ajax-wheel-div" ng-show="!loaded">
          <img src="<?= get_bloginfo("template_url"); ?>/images/ajax-loader.gif" class="center-block" />
        </div>
        
        <!-- loading error -->
        <div id='calendar-error' ng-show="loadError">
          There was an error loading the calendar. 
        </div>
       
        <!-- calendar data -->
        <div ng-show="loaded && !loadError">
          <for-water-calendar 
              ng-repeat="calendar in calendars" 
              ng-show="calendar.weekIndex === weekIndex && calendar.condensed === condensed">
          </for-water-calendar>
          <div id="cal-switches">
            <calendar-mode-switch></calendar-mode-switch>
            <calendar-week-switch></calendar-week-switch>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>