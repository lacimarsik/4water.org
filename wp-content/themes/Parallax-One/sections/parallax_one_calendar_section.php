<!-- =========================
 SECTION: CALENDAR
========================== -->
<?php
  require __DIR__ . '/../vendor/autoload.php';
  
  define('APPLICATION_NAME', 'salsa4water-web');
  define('CREDENTIALS_PATH', __DIR__ . '/../credentials.json');
  define('CLIENT_SECRET_PATH', __DIR__ . '/../client_secret.json');
  define('SCOPES', implode(' ', array(
    Google_Service_Calendar::CALENDAR_READONLY)
  ));

  /**
   * Returns an authorized API client.
   * @return Google_Client the authorized client object
   */
  function getClient() {
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setScopes(SCOPES);
    $client->setAuthConfigFile(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
    if (file_exists($credentialsPath)) {
      $accessToken = file_get_contents($credentialsPath);
    } else {
      // Request authorization from the user.
//      $authUrl = $client->createAuthUrl();
      printf("Open the following link in your browser:\n%s\n", $authUrl);
      print 'Enter verification code: ';
      $authCode = trim('4/HtwaQVvrlDnORuntuAviyT2r7YOIjx9ci_MEMERwbrM');
//      $authCode = '4/B7-r9uvNLtfrA01hjNiBVVM4SqrWIDSk1IQMgZLmJGE';

      // Exchange authorization code for an access token.
      $accessToken = $client->authenticate($authCode);

      // Store the credentials to disk.
      if(!file_exists(dirname($credentialsPath))) {
        mkdir(dirname($credentialsPath), 0700, true);
      }
      file_put_contents($credentialsPath, $accessToken);
      printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
      $client->refreshToken($client->getRefreshToken());
      file_put_contents($credentialsPath, $client->getAccessToken());
    }
    return $client;
  }

  /**
   * Expands the home directory alias '~' to the full path.
   * @param string $path the path to expand.
   * @return string the expanded path.
   */
  function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
      $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
    }
    return str_replace('~', realpath($homeDirectory), $path);
  }

  // Get the API client and construct the service object.
  $client = getClient();
  
  $service = new Google_Service_Calendar($client);

  $now = new DateTime("now", new DateTimeZone('Europe/Prague'));
  echo($now->format('Y-m-d H:i:s'));
  $day_of_week = date('w', strtotime($date));
  echo($day_of_week);
  $first_day_of_week = date('c', mktime(0, 0, 0, date('m'), date('d') - $day_of_week, date('Y')));
  $last_day_of_week = date('c', mktime(0, 0, 0, date('m'), date('d') + 7 - $day_of_week, date('Y')));
  echo $first_day_of_week;
  echo $last_day_of_week;
  
  // Print the next 10 events on the user's calendar.
  $calendarId = 'primary';
  $optParams = array(
    'maxResults' => 20,
    'orderBy' => 'startTime',
    'singleEvents' => TRUE,
    'timeMin' => $first_day_of_week,
  );
  $results = $service->events->listEvents($calendarId, $optParams);

  if (count($results->getItems()) == 0) {
    print "No upcoming events found.\n";
  } else {
    print "Upcoming events:\n";
    foreach ($results->getItems() as $event) {
      $start = $event->start->dateTime;
      if (empty($start)) {
        $start = $event->start->date;
      }
      printf("%s (%s)\n", $event->getSummary(), $start);
    }
  }

  
  
  
  
  $calendar_title = get_theme_mod('calendar_title', DefCalendar::$title);
  
  if(!empty($calendar_title)) { ?>
    <section id="calendar">
      <div class="section-overlay-layer">
        <div class="container">
          Here will be calendar
        </div>  
      </div>
    </section> <?php
  } ?>