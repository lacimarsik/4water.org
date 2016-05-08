<!-- =========================
 SECTION: CALENDAR
========================== -->
<?php
require_once __DIR__ . '/../inc/calendar/calendar_api.php';

define('ALMOST_DAY', 23.999);

$calendar_title = get_theme_mod('calendar_title', DefCalendar::$title);

/*
 * Make an array of hours where one/more events that will be displayed start or 
 * end.
 * 
 * The hours in the array are rounded and sorted in ascending order
 */
function getTimePoints($events) {
  $hours2count = array();
  
  $addToHours = function($hour) use (&$hours2count) {
    if (!array_key_exists($hour, $hours2count)) {
      $hours2count[$hour] = 0;
    }
    $hours2count[$hour]++;
  };
  
  foreach ($events as $event) {
    if (!$event['display']) continue;
    
    $start = intval(round($event['start-hour-frac']));
    $end = intval(round($event['end-hour-frac']));
    
    $addToHours($start);
    $addToHours($end);
  }
  
  $hours = array_keys($hours2count);
  sort($hours);
  return $hours;
}

function processEvents($events) {
  handleConcurrentEvents($events);
  
  tagDisplayableEvents($events);
  
  return $events;
}

function tagDisplayableEvents(&$events) {
  foreach ($events as $key => $event) {
    $events[$key]['display'] = true;
    
    if ($event['duration-hours'] > ALMOST_DAY) {
//        $event['concurrent-out-of'] > 3) { todo
      $events[$key]['display'] = false;
    }
  }
}

/*
 * For each event, assigns three values:
 * - concurrent-order - the display order of the event (from left) among concurrent events
 * - concurrent-out-of - how many are there concurrent columns (not necessarily concurrent events)
 * - concurrent-width - in terms of concurrent columns
 * 
 * http://stackoverflow.com/questions/11311410/visualization-of-calendar-events-algorithm-to-layout-events-with-maximum-width
 */
function handleConcurrentEvents(&$events) {
  $placedEvents = array();
  
  $eventsOverlap = function($eventA, $eventB) {
    return !($eventA['start-day-frac'] >= $eventB['end-day-frac'] || 
             $eventA['end-day-frac'] <= $eventB['start-day-frac']);
  };
  
  foreach ($events as $key => $event) {
    if ($event['duration-hours'] > ALMOST_DAY) continue;
    
    $overlapped = array();
    $levels = array_fill(1, count($placedEvents) + 1, 0);
    $maxOutOf = 0;
    
    //find all overlapping and their levels
    foreach ($placedEvents as $placedKey) {
      if ($eventsOverlap($event, $events[$placedKey])) {
        array_push($overlapped, $placedKey);
        
        $outOf = $events[$placedKey]['concurrent-out-of'];
        $maxOutOf = max($outOf, $maxOutOf);
        
        $levelB = $events[$placedKey]['concurrent-order'];
        $levels[$levelB]++;
      }
    }
        
    //find first free gap, if any
    $freeGap = 1;
    while ($levels[$freeGap] != 0) $freeGap++;
    $events[$key]['concurrent-order'] = $freeGap;
    $events[$key]['concurrent-width'] = 1;
    
    if ($freeGap <= $maxOutOf) { //it was a gap
      $events[$key]['concurrent-out-of'] = $maxOutOf;
    }
    else { //no gap -> a new concurrent column
      $events[$key]['concurrent-out-of'] = $maxOutOf + 1;
      
      //update overlapping events
      foreach ($overlapped as $overlapKey) {
        $events[$overlapKey]['concurrent-out-of']++;
      }
    }
    
    array_push($placedEvents, $key);
  }
  
  //widen the widths of events where possible
  foreach ($placedEvents as $placedKeyA) {
    $levelA = $events[$placedKeyA]['concurrent-order'];
    $nextLevel = $events[$placedKeyA]['concurrent-out-of'] + 1;
    
    foreach ($placedEvents as $placedKeyB) {
      if ($eventsOverlap($events[$placedKeyA], $events[$placedKeyB])) {
        $levelB = $events[$placedKeyB]['concurrent-order'];
        if ($levelB <= $levelA) continue;
        $nextLevel = min($nextLevel, $levelB);
      }
    }
    
    if ($nextLevel < 999) {
      $events[$placedKeyA]['concurrent-width'] = $nextLevel - $levelA;
    }
  }
}

function getCalendarInfoJson($calendarApi, $weeksFromNow) {
  $events = $calendarApi->getEventsForWeek($weeksFromNow);

//  echo '<pre>'; print_r($events); echo '</pre>';
  $procEvents = processEvents($events);
  $timePoints = getTimePoints($procEvents);
  
  return json_encode(
    array(
      "procEvents" => json_encode($procEvents),
      "timePoints" => json_encode($timePoints)
    )
  );
}

function getCalendarInfoJsons($startWeek) {
  $calendarApi = new CalendarApi();
  
  $weeks = [$startWeek, $startWeek + 1];
  
  $result = array();
  foreach ($weeks as $week) {
    $calInfoJson = getCalendarInfoJson($calendarApi, $week);
    array_push($result, $calInfoJson);
  }
   
  return json_encode($result);
} 

function zzz(WP_REST_Request $request) {
	$param = $request->get_param('weekStart');
  return getCalendarInfoJsons($param);
}



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
          ng-init='calCtrl.initBetter(0)'>
        
        <!-- loading wheel -->
        <img 
            src="<?= get_bloginfo("template_url"); ?>/images/ajax-loader.gif"
            class='center-block'
            ng-show="!loaded" />
        
        <!-- loading error -->
        <div id='calendar-error' ng-show="loadError">
          There was an error loading the calendar: 
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