<?php

require_once 'google_calendar_api.php';

/*
   * This class provides a wrapper API to access Google calendar data
   */
  class Calendar4WaterApi {   
    //----------------------------------------------
    // Constants
    //---------------------------------------------
    
    private static $ALMOST_DAY = 23.999;
    
    //----------------------------------------------
    // Interface
    //---------------------------------------------
    
    public static function getCalendarInfoJsons($startWeek) {
      $googleCalendarApi = new GoogleCalendarApi();

      $weeks = [$startWeek, $startWeek + 1];

      $result = array();
      foreach ($weeks as $week) {
        $calInfoJson = Calendar4WaterApi::getCalendarInfoJson($googleCalendarApi, $week);
        array_push($result, $calInfoJson);
      }

      return $result;
    } 
    
    //----------------------------------------------
    // Implementation
    //---------------------------------------------
    
    /*
    * Make an array of hours where one/more events that will be displayed start or 
    * end.
    * 
    * The hours in the array are rounded and sorted in ascending order
    */
    private static function getTimePoints($events) {
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

    private static function processEvents($events) {
      Calendar4WaterApi::handleConcurrentEvents($events);

      Calendar4WaterApi::tagDisplayableEvents($events);

      return $events;
    }

    private static function tagDisplayableEvents(&$events) {
      foreach ($events as $key => $event) {
        $events[$key]['display'] = true;

        if ($event['duration-hours'] > Calendar4WaterApi::$ALMOST_DAY) {
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
    private static function handleConcurrentEvents(&$events) {
      $placedEvents = array();

      $eventsOverlap = function($eventA, $eventB) {
        return !($eventA['start-day-frac'] >= $eventB['end-day-frac'] || 
                 $eventA['end-day-frac'] <= $eventB['start-day-frac']);
      };

      foreach ($events as $key => $event) {
        if ($event['duration-hours'] > Calendar4WaterApi::$ALMOST_DAY) continue;

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

    private static function getCalendarInfoJson($googleCalendarApi, $weeksFromNow) {
      $events = $googleCalendarApi->getEventsForWeek($weeksFromNow);

    //  echo '<pre>'; print_r($events); echo '</pre>';
      $procEvents = Calendar4WaterApi::processEvents($events);
      $timePoints = Calendar4WaterApi::getTimePoints($procEvents);

      return array(
        "procEvents" => $procEvents,
        "timePoints" => $timePoints
      );
    }
  }