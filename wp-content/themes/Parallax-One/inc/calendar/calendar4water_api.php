<?php

require_once 'google_calendar_api.php';

  /*
   * This class provides methods to get calendar data for Calendar4water 
   * frontend in expected form. First GoogleCalendarAPI is queried. The results
   * are then split into short-term events and long-term events which are further
   * processed, mostly to determine their order if the events run concurrently.
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
    * Make an array of hours where one/more short-term event starts or 
    * ends.
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
        if (!$event['short-term']) continue;

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
      Calendar4WaterApi::handleConcurrentShortTermEvents($events);
      Calendar4WaterApi::handleLongTermEvents($events);

      return $events;
    }

    private static function tagEventsByLength(&$events) {
      foreach ($events as $key => $event) {
        $events[$key]['short-term'] = true;

        if ($event['duration-hours'] > Calendar4WaterApi::$ALMOST_DAY) {
          $events[$key]['short-term'] = false;
        }
      }
    }

    /*
     * Each long-term event is split on per-day basis and gets these values:
     * - concurrent-order - the display order of the event (from top) among concurrent events
     * - concurrent-out-of - how many are there concurrent events
     */
    private static function handleLongTermEvents(&$events) {      
      //split long-term events per-day
      $toRemove = array();
      $toAdd = array();
      foreach ($events as $key => $event) {
        if ($event['short-term']) continue;
        
        array_push($toRemove, $key);
        for ($i = $event['start-day']; $i < $event['start-day'] + $event['end-day-offset']; $i++) {
          $event['day'] = $i;
          array_push($toAdd, $event);
        }
      }
      foreach ($toRemove as $key) {
        unset($events[$key]);
      }
      $events = array_values($events);
      foreach ($toAdd as $event) {
        array_push($events, $event);
      }
      
      //group by days
      $dayEvents = array();
      for ($i = 0; $i < 7; $i++) {
        $dayEvents[] = array();
      }
      foreach ($events as $key => $event) {
        if ($event['short-term']) continue;
        
        array_push($dayEvents[$event['day']], $key);
      }
      
      //compute order/out-of
      for ($i = 0; $i < 7; $i++) {
        for ($j = 0; $j < count($dayEvents[$i]); $j++) {
          $key = $dayEvents[$i][$j];
          $events[$key]['concurrent-order'] = $j;
          $events[$key]['concurrent-out-of'] = count($dayEvents[$i]);
        }
      }
    }
    
    /*
     * For each short-term event, assigns three values:
     * - concurrent-order - the display order of the event (from left) among concurrent events
     * - concurrent-out-of - how many are there concurrent columns (not necessarily concurrent events)
     * - concurrent-width - the widht of the event, in terms of concurrent columns
     * 
     * Based on
     * http://stackoverflow.com/questions/11311410/visualization-of-calendar-events-algorithm-to-layout-events-with-maximum-width
     */
    private static function handleConcurrentShortTermEvents(&$events) {
      $placedEvents = array();

      //place events greedily to the left
      foreach ($events as $key => $event) {
        if (!$event['short-term']) continue;
        Calendar4WaterApi::placeEvent($placedEvents, $key, $events);
      }

      //widen the widths of events where possible
      foreach ($placedEvents as $placedKeyA) {
        Calendar4WaterApi::widenIfPossible($placedEvents, $placedKeyA, $events);
      }
    }
    
    private static function eventsOverlap($eventA, $eventB) {
        return !($eventA['start-day-frac'] >= $eventB['end-day-frac'] || 
                 $eventA['end-day-frac'] <= $eventB['start-day-frac']);
    }
    
    private static function widenIfPossible(&$placedEvents, $placedKeyA, &$events) {
      $levelA = $events[$placedKeyA]['concurrent-order'];
      $nextLevel = $events[$placedKeyA]['concurrent-out-of'] + 1;

      foreach ($placedEvents as $placedKeyB) {
        if (Calendar4WaterApi::eventsOverlap($events[$placedKeyA], $events[$placedKeyB])) {
          $levelB = $events[$placedKeyB]['concurrent-order'];
          if ($levelB <= $levelA) continue;
          $nextLevel = min($nextLevel, $levelB);
        }
      }

      if ($nextLevel < 999) {
        $events[$placedKeyA]['concurrent-width'] = $nextLevel - $levelA;
      }
    }
    
    private static function placeEvent(&$placedEvents, $key, &$events) {
      $event = $events[$key];
      $overlapped = array();
      $levels = array_fill(1, count($placedEvents) + 1, 0);
      $maxOutOf = 0;

      //find all overlapping and their levels
      foreach ($placedEvents as $placedKey) {
        if (Calendar4WaterApi::eventsOverlap($event, $events[$placedKey])) {
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

    private static function getCalendarInfoJson($googleCalendarApi, $weeksFromNow) {
      $events = $googleCalendarApi->getEventsForWeek($weeksFromNow);

      Calendar4WaterApi::tagEventsByLength($events);
      
      $procEvents = Calendar4WaterApi::processEvents($events);
      $timePoints = Calendar4WaterApi::getTimePoints($procEvents);
//      echo '<pre>'; print_r($procEvents); echo '</pre>';

      return array(
        "procEvents" => $procEvents,
        "timePoints" => $timePoints
      );
    }
  }