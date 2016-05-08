<?php
  /* From what I understood, there's a two step authorisation before this application
   * can access the google calendar:
   * 
   * 1.) First, we need to get client_secret.json file, which can be generated
   * on the Google Developer Console -> API manager -> Credentials. We click
   * Create Credentials, choose "OAuth Client ID" -> Other, then type in the name
   * of the client (something like "4water-calendar-client"). Once we generate
   * the credentials, we download the file and store it in this folder. However, 
   * we do not have access to the calendar yet. For that, we need the second step
   * 
   * 2.) We run this script, which uses the client_secret to generate Auth. URL. 
   * That one links to the google account where the calendar resides. We open it 
   * up in browser, click "allow this app to get acces..." and then we get a 
   * verification code. That is then converted to access token and stored in a 
   * file - credentials.json. Wooohoo! Next time, we just use that file to get
   * it back and we should have access to the calendar!
   * 
   * Schematically:
   * 
   * Our 4water app                                             Google
   * ------------------------------         -----------------------------------
   *                                                Generate client_secret.json 
   * 
   * use client_secret.json    ----Auth-URL--->     get verification code
   * 
   * verif. code --> access token
   * access token --> credentials.json
   * 
   * 
   * 
   * All of the above is mimicking the tutorial on 
   * https://developers.google.com/google-apps/calendar/quickstart/php
   * 
   * Hopefully, none of the two steps will need to be repeated again, but in
   * case.. :- )
   * 
   * To run this file in command line, just do:
   * php credentials_generator.php
   */

  include_once 'calendar_api.php';

  $calendarApi = new GoogleCalendarApi();
  
  $authUrl = $calendarApi->getAuthUrl();
  printf("Open the following link in your browser:\n%s\n", $authUrl);
  print 'Enter verification code: ';
  $verifCode = trim(fgets(STDIN));
  
  $calendarApi->createCredentialsFile($verifCode);