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
    $events[$key]['concurrent-out-of'] = $endFracs->count();

    foreach (clone $endFracs as $overlappingKey) {
      $events[$overlappingKey]['concurrent-out-of']++;
    }

    $endFracs->insert($key, -$event['end-day-frac']);
  }
}

function constructCalendarHere($weeksFromNow) {
  $calendarApi = new CalendarApi();

  $events = $calendarApi->getEventsForWeek($weeksFromNow);
  $procEvents = processEvents($events);
  $timePoints = getTimePoints($procEvents);

  $id = 'for-water-calendar-'.$weeksFromNow;?>

  <div class="for-water-calendar" id="<?=$id?>"></div>

  <script src="<?= get_bloginfo("template_url"); ?>/inc/calendar/calendar.js"></script>
  <script>          
    var procEvents = <?php echo json_encode($procEvents); ?>;
    var timePoints = <?php echo json_encode($timePoints); ?>;
    
    populateCalendar(<?=$id?>, procEvents, timePoints);
  </script> <?php
} ?>
  
<section id="calendar">
  <div class="section-overlay-layer">
    <div class="container">
      <?php constructCalendarHere($thisWeekEvents); ?>
    </div>
  </div>
</section>