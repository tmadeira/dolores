<?php
require_once(DOLORES_PATH . '/vendor/autoload.php');
require_once(DOLORES_PATH . '/dlib/external/google.php');

class DoloresCalendar {
  public static function get($calendarId, $past = false) {
    $key = $calendarId . '_' . ($past ? 'past' : 'future');
    $calendar_cache = get_option('dolores_calendar_cache_' . $key);

    if (!is_array($calendar_cache) ||
        $calendar_cache['time'] < time() - 1800 ||
        (is_user_logged_in() && current_user_can('manage_options'))) {
      $google = new DoloresGoogle();
      $client = $google->getAuthenticatedClient();

      $service = new Google_Service_Calendar($client);
      $optParams = array(
        'maxResults' => 100,
        'orderBy' => 'startTime',
        'singleEvents' => TRUE
      );

      if ($past) {
        $optParams['timeMax'] = date('c');
      } else {
        $optParams['timeMin'] = date('c');
      }

      $results = $service->events->listEvents($calendarId, $optParams);
      $events = $results->getItems();
      $calendar_cache = array(
        'time' => time(),
        'events' => $past ? array_reverse($events) : $events
      );
      update_option(
        $key,
        $calendar_cache,
        'no'
      );
    }

    return $calendar_cache['events'];
  }
};
