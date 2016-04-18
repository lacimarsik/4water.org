<!-- =========================
 SECTION: CALENDAR
========================== -->
<?php
require_once __DIR__ . '/../inc/calendar/calendar_api.php';

$calendar_title = get_theme_mod('calendar_title', DefCalendar::$title);

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
  tagConcurrentEvents($events);
  
  tagDisplayableEvents($events);
  
  return $events;
}

function tagDisplayableEvents(&$events) {
  foreach ($events as $key => $event) {
    $events[$key]['display'] = true;
    
    if ($event['duration-hours'] > 23.999 ||
        $event['concurrent-out-of'] > 3) {
      $events[$key]['display'] = false;
    }
  }
}

function tagConcurrentEvents(&$events) {
  $endFracs = new SplPriorityQueue(); //max heap
  $endFracs->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
  
  foreach ($events as $key => $event) {
    if ($event['duration-hours'] > 23.999) continue;

    while (!$endFracs->isEmpty() && -$endFracs->top()['priority'] <= $event['start-day-frac']) {
      $endFracs->extract();
    }

    $events[$key]['concurrent-order'] = $endFracs->count();
    $events[$key]['concurrent-out-of'] = $endFracs->count() + 1;

    foreach (clone $endFracs as $overlappingKey) {
      $events[$overlappingKey]['concurrent-out-of']++;
    }

    $endFracs->insert($key, -$event['end-day-frac']);
  }
}

function constructCalendarHere($weeksFromNow) {
  $calendarApi = new CalendarApi();

  $events = $calendarApi->getEventsForWeek($weeksFromNow);
//  echo '<pre>'; print_r($events); echo '</pre>';
  $procEvents = processEvents($events);
  $timePoints = getTimePoints($procEvents);

//  echo '<pre>';
//  print_r($procEvents);
//  print_r($timePoints);
//  echo '</pre>';
  
  $id = 'for-water-calendar-'.$weeksFromNow;?>

  <div class="for-water-calendar" id="<?=$id?>"></div>

  <script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/calendar.js"></script>
  <script>              
    $(document).ready(function() {       
        var procEvents = <?php echo json_encode($procEvents); ?>;
        var timePoints = <?php echo json_encode($timePoints); ?>;
        
        $('#<?=$id?>').hide();
        var calendarDiv = new CalendarDiv('#<?=$id?>', procEvents, timePoints);
        calendarDiv.populate(true);
        
        var $condensedOptions = $('.condensed-switch-option');
        $('.condensed-switch-option').on('click', function() {
          if ($(this).hasClass('switch-selected')) {
            return;
          }
          $condensedOptions.toggleClass('switch-selected');
          calendarDiv.populate($(this).data('condensed'));
        });
    });
    
  </script> <?php
} 

function constructCalendars($startWeek) {
  $weeks = [$startWeek, $startWeek + 1];
  $id = 'for-water-calendar-'.$weeksFromNow;
  
  constructCalendarHere($weeks[0]);
  constructCalendarHere($weeks[1]); ?>
  
  <script>              
    $(document).ready(function() {               
        var $weekOptions = $('.week-switch-option');
        $('.week-switch-option').on('click', function() {
          if ($(this).hasClass('switch-selected')) {
            return;
          }
          $weekOptions.toggleClass('switch-selected');
          
        });
    });
    
  </script>
  
  <?php
}











function getCalendarInfoJson($calendarApi, $weeksFromNow) {
  $events = $calendarApi->getEventsForWeek($weeksFromNow);

//  echo '<pre>'; print_r($events); echo '</pre>';
  $procEvents = processEvents($events);
  $timePoints = getTimePoints($procEvents);

//  echo '<pre>';
//  print_r($procEvents);
//  print_r($timePoints);
//  echo '</pre>';
  
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
} ?>
  

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/controllers/calendarController.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarModeSwitchDirective.js"></script>
<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/directives/calendarWeekSwitchDirective.js"></script>

<script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/frontend/services/calendarModel.js"></script>

<section id="calendar">
  <div class="section-overlay-layer">
    <div class="container" ng-controller="calendarController as calCtrl" ng-init="init(<?= getCalendarInfoJsons(-3) ?>)">
      <calendar-mode-switch></calendar-mode-switch>
      <calendar-week-switch></calendar-week-switch>
      <for-water-calendar 
          ng-repeat="calendar in calendars" 
          ng-show="calendar.weekIndex === $scope.weekIndex && calendar.condensed === $scope.condensed"></for-water-calendar>
    </div>
  </div>
</section>