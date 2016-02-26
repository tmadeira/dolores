<?php
require_once(DOLORES_PATH . '/dlib/calendar.php');

the_post();
get_header();

$calendarUrl = '//calendar.google.com/calendar/render?cid=' . CALENDAR_ID;
$events = DoloresCalendar::get(CALENDAR_ID);
?>

<main class="wrap default-wrap">
  <article class="single-content">
    <h2 class="single-title">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
    </div>

    <div class="entry">
      <p>
        Para acompanhar nossa agenda através do Google Calendar,
        <a href="<?php echo $calendarUrl; ?>">clique aqui</a>.
      </p>

      <h3>Próximos eventos</h3>

      <?php
      if (count($events) == 0) {
        echo "<p>Nenhum evento previsto no próximo período.</p>";
      } else {
        ?>
        <ul class="calendar-events">
          <?php
          $date_format = "D d/M";
          $time_format = "H:i";
          foreach ($events as $event) {
            $start = $event->start->dateTime;
            $offset = 3600 * get_option('gmt_offset');
            if (empty($start)) {
              $start = strtotime($event->start->date) + $offset;
              $date = date_i18n($date_format, $start);
              $time = "dia todo";
            } else {
              $start = strtotime($start) + $offset;
              $date = date_i18n($date_format, $start);

              $end = strtotime($event->end->dateTime) + $offset;
              $start_time = date_i18n($time_format, $start);
              $end_time = date_i18n($time_format, $end);
              $time = "$start_time &mdash; $end_time";
            }
            ?>
            <li class="calendar-event">
              <div class="event-date">
                <?php echo $date; ?>
              </div>
              <div class="event-info">
                <div class="event-time">
                  <i class="fa fa-fw fa-clock-o"></i>
                  <?php echo $time; ?>
                </div>
                <div class="event-title">
                  <?php echo $event['summary']; ?>
                </div>
                <?php
                if (array_key_exists('location', $event) && $event['location']) {
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
                    <?php echo nl2br($event['description']); ?>
                  </div>
                  <?php
                }
                ?>
                <div class="event-link-container">
                  <a
                      href="<?php echo $event['htmlLink']; ?>"
                      class="event-link"
                      target="_blank"
                      >
                    <i class="fa fa-fw fa-calendar"></i>
                    Ver no Google Calendar
                  </a>
                </div>
              </div>
            </li>
            <?php
          }
          ?>
        </ul>
        <?php
      }
      ?>
    </div>

    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
    </div>
  </article>

  <?php
  get_sidebar();
  ?>
</main>

<?php
get_footer();
?>
