<?php
  require __DIR__ . '/../../composer/vendor/autoload.php';

  define('APPLICATION_NAME', '4water-calendar');
  define('CREDENTIALS_PATH', __DIR__ . '/credentials.json');
  define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
  define('SCOPES', implode(' ', array(Google_Service_Calendar::CALENDAR_READONLY)));
  
  /*
   * This class provides a wrapper API to access Google calendar data
   */
  class GoogleCalendarApi {
    //----------------------------------------------
    // Constants
    //---------------------------------------------
    
    private $DAY_NAMES = [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday",
      "Saturday",
      "Sunday"
    ];
    
    private $YMD_FORMAT = 'Y-m-d H:i:s';
    
    //----------------------------------------------
    // Data
    //---------------------------------------------
    
    private $service;
    private $colors;
    private $client;
    
    //----------------------------------------------
    // Constructor
    //---------------------------------------------
    
    public function __construct() {
      $this->client = $this->getClient();
      $this->makeCalendarService();
    }
    
    //----------------------------------------------
    // Interface
    //---------------------------------------------
    
    /*
     * Returns true if we have an autorised, ready to use calendar service
     */
    public function serviceReady() {
      return (!empty($this->service));
    }
    
    /*
     * Obtains a URL on which we can get the authorisation/verification code
     */
    public function getAuthUrl() {
      return $this->client->createAuthUrl();
    }
    
    /*
     * Makes a credentials.json file using the authorisation (verification) code
     */
    public function createCredentialsFile($authCode) {
      //exchange authorization code for an access token
      $accessToken = $this->client->authenticate(trim($authCode));

      //store the credentials to disk
      file_put_contents(CREDENTIALS_PATH, $accessToken);
      
      //try to make the service now
      $this->makeCalendarService();
    }
    
    public function getEventsForWeek($weeksFromNow) {
      $now = $this->getNow();
      
      $weekFromNowString = date('Y-m-d 00:00:00', strtotime($now->format('Y-m-d').'+'.strval(7*$weeksFromNow).' days'));
      $weekFromNow = DateTime::createFromFormat('Y-m-d H:i:s', $weekFromNowString);
      return $this->getWeekEvents($weekFromNow);
    }
    
    public function getThisWeekEvents() {
      return $this->getEventsForWeek(0);
    }

    public function getNextWeekEvents() {
      return $this->getEventsForWeek(1);
    }
    
    //----------------------------------------------
    // Implementation
    //---------------------------------------------

    private function getWeekEvents($timeInWeek) {
      if (!$this->serviceReady()) {
        return null;
      }
      
      $timeMin = $this->getWeekStart($timeInWeek);
      $timeMax = $this->getWeekEnd($timeInWeek);
      
      $calendarId = 'primary';
      $optParams = array(
        'maxResults' => 50,
        'orderBy' => 'startTime',
        'singleEvents' => TRUE,
        'timeMin' => $timeMin->format(DateTime::ISO8601),
        'timeMax' => $timeMax->format(DateTime::ISO8601),
      );
      $results = $this->service->events->listEvents($calendarId, $optParams);
            
      return $this->toOurCalendarFormat($results->getItems());
    }
    
    /*
     * Get hex code for given color ID from the event
     */
    private function colorId2HexCode($colorId) {
      if (empty($colorId)) {
        return '';
      }
      return $this->colors[$colorId]->getBackground();
    }
    
    /*
     * Makes a datetime from the retrieved calendar event start or end
     */
    private function getDateTimeFromBoundary($boundary) {
      if (empty($boundary->dateTime)) {
        $res = DateTime::createFromFormat('Y-m-d H:i:s', $boundary->date . ' 00:00:00');
        return $res;
      }
      else {
        $res = DateTime::createFromFormat('Y-m-d\TH:i:sT', $boundary->dateTime);
        return $res;
      }
    }
    
    private static function sortCmpTime($a, $b) {
      if ($a['start-hour-frac'] == $b['start-hour-frac']) {
        if ($a['end-hour-frac'] == $b['end-hour-frac']) {
          return 0;
        }

        return ($a['end-hour-frac'] < $b['end-hour-frac']) ? -1 : 1;
      }

      return ($a['start-hour-frac'] < $b['start-hour-frac']) ? -1 : 1;
    }
    
    private static function sortCmpDateTime($a, $b) {
      if ($a['start'] == $b['start']) {
        if ($a['end'] == $b['end']) {
          return 0;
        }

        return ($a['end'] < $b['end']) ? -1 : 1;
      }

      return ($a['start'] < $b['start']) ? -1 : 1;
    }
    
    /*
     * 
     */
    private function toOurCalendarFormat($eventsIn) {
      $dayEvents = array();
      $all = array();
      
      for ($i = 0; $i < 7; $i++) {
        $dayEvents[] = array();
      }
      
      //construct events
      foreach ($eventsIn as $eventIn) {
        $event = array();
        
        $event['title'] = $eventIn->getSummary();
        $event['desc'] = $eventIn->description;
        $event['start'] = $this->getDateTimeFromBoundary($eventIn->start);
        $event['end'] = $this->getDateTimeFromBoundary($eventIn->end);
        $event['color'] = $this->colorId2HexCode($eventIn->colorId);
        $event['location'] = $eventIn->location;
        
        //additional stuff for easier manipulation
        $dayNumber = $this->getDayNumber($event['start']);
        $endDayOffset = $this->getDayDiff($event['end'], $event['start']);
        $startHourFrac = $this->dayTime2Sec($event['start'])/3600;
        $endHourFrac = $this->dayTime2Sec($event['end'])/3600;
        $startDayFrac = $dayNumber + $startHourFrac/24;
        $endDayFrac = $dayNumber + $endDayOffset + $endHourFrac/24;
        
        $event['start-day'] = $dayNumber;
        $event['end-day-offset'] = $endDayOffset;
        $event['start-hour-frac'] = $startHourFrac;
        $event['end-hour-frac'] = $endHourFrac;
        $event['start-day-frac'] = $startDayFrac;
        $event['end-day-frac'] = $endDayFrac;
        $event['duration-hours'] = 24*($endDayFrac - $startDayFrac);
        $event['url'] = $eventIn->htmlLink;
        
        array_push($dayEvents[$dayNumber], $event);
        array_push($all, $event);
      }
      
      //sort in each day
      for ($i = 0; $i < 7; $i++) {
        usort($dayEvents[$i], array('GoogleCalendarApi', 'sortCmpTime'));
      }
      usort($all, array('GoogleCalendarApi', 'sortCmpDateTime'));
      
      $result = array();
      $result['days'] = $dayEvents;
      $result['all'] = $all;
      
      return $result['all'];
    }
    
    /*
     * Returns the number of seconds since the start of the day
     */
    private function dayTime2Sec($dateTime) {
      $time = $dateTime->format('H:i:s');
      $dt = new DateTime("1970-01-01 $time", new DateTimeZone('UTC'));
      return (int)$dt->getTimestamp();
    }
    
    /*
     * Returns the day difference between two dates. Essentially, how many times
     * clock strike midnight between the two moments. 
     */
    private function getDayDiff($dateTimeA, $dateTimeB) {
      $dateA = DateTime::createFromFormat('Y-m-d', $dateTimeA->format('Y-m-d'));
      $dateB = DateTime::createFromFormat('Y-m-d', $dateTimeB->format('Y-m-d'));
      return intval($dateB->diff($dateA)->format('%a'));
    }
    
    /*
     * Get current date/time for Prague
     */
    private function getNow() {
      return new DateTime("now", new DateTimeZone('Europe/Prague'));
    }
    
    /*
     * Gets the DateTime of the start of the week $dateTime is in. 
     * 
     * So e.g. for 19th. feb 2016 (Friday), it would return 15th Feb 2016, 00:00:00
     */
    private function getWeekStart($dateTime) {
      $dayNumber = $this->getDayNumber($dateTime);
      $weekStartString = date('Y-m-d 00:00:00', strtotime($dateTime->format('Y-m-d').'-'.$dayNumber.' days'));
      return DateTime::createFromFormat('Y-m-d H:i:s', $weekStartString);
    }
    
    /*
     * Gets the DateTime of the end of the week $dateTime is in. 
     * 
     * So e.g. for 19th. feb 2016 (Friday), it would return 21st Feb 2016, 23:59:59
     */
    private function getWeekEnd($dateTime) {
      $dayNumber = $this->getDayNumber($dateTime);
      $weekStartString = date('Y-m-d 23:59:59', strtotime($dateTime->format('Y-m-d').'+'.(6 - $dayNumber).' days'));
      return DateTime::createFromFormat('Y-m-d H:i:s', $weekStartString);
    }
    
    /*
     * Gets the day number for the datetime. 0 = monday. 6 = sunday
     */
    private function getDayNumber($dateTime) {
      return (date('w', $dateTime->getTimestamp()) + 6) % 7;
    }
    
    private function getClient() {
      $client = new Google_Client();
      $client->setApplicationName(APPLICATION_NAME);
      $client->setScopes(SCOPES);
      $client->setAuthConfigFile(CLIENT_SECRET_PATH);
      $client->setAccessType('offline');

      return $client;
    }
    
    private function authorizeClient() {
      //load previously authorized credentials from a file.
      if (file_exists(CREDENTIALS_PATH)) {
        $accessToken = file_get_contents(CREDENTIALS_PATH);
      } else {
        throw new Exception('No credentials file for the calendar!');
      }

      $this->client->setAccessToken($accessToken);

      //refresh the token if it's expired.
      if ($this->client->isAccessTokenExpired()) {
        $this->client->refreshToken($this->client->getRefreshToken());
        file_put_contents(CREDENTIALS_PATH, $this->client->getAccessToken());
      }
    }

    private function makeCalendarService() {      
      try {
        $this->authorizeClient();    
      }
      catch (Exception $e) {
        return null;
      }
      
      $this->service = new Google_Service_Calendar($this->client);
      $this->colors = $this->service->colors->get()->getEvent();
    }
  }
  
  
 