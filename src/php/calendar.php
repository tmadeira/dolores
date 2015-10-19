<?php
/* Template Name: Agenda */
the_post();
$base = get_permalink();

function dolores_temas_grid() {
  global $wp_query, $base;
  $paged = intval(preg_replace('/[^0-9]*/', '', $wp_query->query['page']));
  $paged = max($paged, 1);

  require_once(__DIR__ . '/grid.php');
  $query = new WP_Query(array(
    'category_name' => 'encontros',
    'paged' => $paged
  ));
  dolores_grid($query, $base);
}

if ($_GET['ajax']) {
  dolores_temas_grid();
  die();
}

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/dlib/external/google.php');

$calendar_cache = get_option('dolores_calendar_cache');

if (!is_array($calendar_cache) ||
    $calendar_cache['time'] < time() - 1800 ||
    (is_user_logged_in() && current_user_can('manage_options'))) {
  $google = new DoloresGoogle();
  $client = $google->getAuthenticatedClient();

  $service = new Google_Service_Calendar($client);
  $calendarId = 'ss06he4nh7ulaoa1i26mmkd2fo@group.calendar.google.com';
  $optParams = array(
    'maxResults' => 100,
    'orderBy' => 'startTime',
    'singleEvents' => TRUE,
    'timeMin' => date('c'),
  );

  $results = $service->events->listEvents($calendarId, $optParams);
  $calendar_cache = array(
    'time' => time(),
    'events' => $results->getItems()
  );
  update_option('dolores_calendar_cache', $calendar_cache, 'no');
}

$events = $calendar_cache['events'];

get_header();
?>

<main class="page wrap">
  <article class="single-content">
    <h2 class="single-title">Calendário</h2>

    <div class="single-meta social-media">
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="pt"></a>
    </div>

    <div class="entry">
      <?php
      if (count($events) == 0) {
        echo "<p>Nenhum evento previsto no próximo período.</p>";
      } else {
        ?>
        <table class="calendar-table">
          <tbody>
            <?php
            $date_format = "D d/M";
            $time_format = "H:i";
            foreach ($events as $event) {
              $start = $event->start->dateTime;
              if (empty($start)) {
                $start = $event->start->date;
                $date = date_i18n($date_format, strtotime($start));
                $time = "dia todo";
              } else {
                $date = date_i18n($date_format, strtotime($start));

                $end =  $event->end->dateTime;
                $start_time = date_i18n($time_format, strtotime($start));
                $end_time = date_i18n($time_format, strtotime($end));
                $time = "$start_time &mdash; $end_time";
              }
              ?>
              <tr class="calendar-row">
                <td class="calendar-cell calendar-date">
                  <?php echo $date; ?>
                </td>
                <td class="calendar-cell calendar-time">
                  <i class="fa fa-fw fa-clock-o"></i>
                  <?php echo $time; ?>
                </td>
                <td class="calendar-cell calendar-summary">
                  <h4 class="event-title">
                    <?php echo $event['summary']; ?>
                  </h4>
                  <?php
                  if (array_key_exists('location', $event) &&
                      $event['location']) {
                    ?>
                    <div class="event-location">
                      <i class="fa fa-fw fa-map-marker"></i>
                      <?php echo $event['location']; ?>
                    </div>
                    <?php
                  }
                  if (array_key_exists('description', $event) && $event['description']) {
                    ?>
                    <div class="event-description">
                      <i class="fa fa-fw fa-file-text-o"></i>
                      <?php echo $event['description']; ?>
                    </div>
                    <?php
                  }
                  ?>
                </td>
                <td class="calendar-cell calendar-link-container">
                  <a
                      href="<?php echo $event['htmlLink']; ?>"
                      class="calendar-link"
                      target="_blank"
                      >
                    <i class="fa fa-fw fa-calendar"></i>
                    Ver no Google Agenda
                  </a>
                </td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
        <?php
      }
      ?>
    </div>
  </article>
</main>

<section class="temas-posts">
  <div class="wrap">
    <h2 class="temas-posts-title">
      <span>Encontros que já rolaram</span>
    </h2>

    <?php
    dolores_temas_grid();
    ?>
  </div>
</section>

<?php
get_footer();
