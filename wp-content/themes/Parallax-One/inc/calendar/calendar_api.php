<?php
  require __DIR__ . '/../../composer/vendor/autoload.php';

  define('APPLICATION_NAME', '4water-calendar');
  define('CREDENTIALS_PATH', __DIR__ . '/credentials.json');
  define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
  define('SCOPES', implode(' ', array(Google_Service_Calendar::CALENDAR_READONLY)));
  
  $c = new CalendarApi();
  $c->getThisWeekEvents();
  exit;
  
  class CalendarApi {
    //----------------------------------------------
    // Data
    //---------------------------------------------
    
    private $service;
    private $client;
    
    //----------------------------------------------
    // Constructor
    //---------------------------------------------
    
    public function __construct() {
      $this->client = $this->getClient();
      $this->service = $this->getCalendarService();
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
      $this->service = $this->getCalendarService();
    }
    
    public function getThisWeekEvents() {
      if (!$this->serviceReady()) {
        return null;
      }

      $now = $this->getNow();
      $timeMin = $this->getWeekStart($now);
      $timeMax = $this->getWeekEnd($now);
      
      $calendarId = 'primary';
      $optParams = array(
        'maxResults' => 50,
        'orderBy' => 'startTime',
        'singleEvents' => TRUE,
        'timeMin' => $timeMin->format(DateTime::ISO8601),
        'timeMax' => $timeMax->format(DateTime::ISO8601),
      );
      $results = $this->service->events->listEvents($calendarId, $optParams);
      
      foreach ($results->getItems() as $event) {
        $start = $event->start->dateTime;
        if (empty($start)) {
          $start = $event->start->date;
        }
        printf("What: (%s)\n", $event->getSummary());
        printf("Description: (%s)\n", $event->description);
        printf("When: (%s)\n", $event->start->dateTime);
        printf("Color: (%s)\n", $event->colorId);
      }
      
      return $results;
    }

    public function getNextWeekEvents() {
      if (!$this->serviceReady()) {
        return null;
      }
    }
    
    //----------------------------------------------
    // Implementation
    //---------------------------------------------

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

    private function getCalendarService() {      
      try {
        $this->authorizeClient();    
      }
      catch (Exception $e) {
        return null;
      }
      
      $service = new Google_Service_Calendar($this->client);
      return $service;
    }
  }
  
  
 