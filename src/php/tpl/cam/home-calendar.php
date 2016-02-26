    <?php
    $events = DoloresCalendar::get(CALENDAR_ID);
    if (count($events) > 0) {
      $date_format = "d/m";
      $time_format = "H\\h";
      $event = $events[0];
      $start = $event->start->dateTime;
      $offset = 3600 * get_option('gmt_offset');
      if (empty($start)) {
        $start = strtotime($event->start->date) + $offset;
        $date = date_i18n($date_format, $start);
        $time = "dia todo";
      } else {
        $start = strtotime($start) + $offset;
        $date = date_i18n($date_format, $start);
        $time = date_i18n($time_format, $start);
      }

      $maps = "https://maps.google.com/?q=" . $event['location'];
      $location = preg_replace('/[,.].*/', '', $event['location']);
      ?>
      <div class="home-calendar">
        <div class="wrap">
          <h2 class="home-next-event">
            Próximo <span>evento</span>
          </h2><h3 class="home-event-title">
            <?php echo $event['summary']; ?>
          </h3><div class="home-event-mobile-table"><ul class="home-event-info">
            <li class="home-event-info-li home-event-info-50">
              <i class="fa fa-fw fa-lg fa-calendar"></i><?php echo $date; ?>
            </li><li class="home-event-info-li home-event-info-50">
              <i class="fa fa-fw fa-lg fa-clock-o"></i><?php echo $time; ?>
            </li><li class="home-event-info-li">
              <a class="home-event-location" href="<?php echo $maps; ?>">
                <div class="home-event-icon-container">
                  <i class="fa fa-fw fa-lg fa-map-marker"></i>
                </div>
                <div class="home-event-location-text">
                  <?php echo $location; ?>
                  <br />
                  <small>(ver no mapa)</small>
                </div>
              </a>
            </li>
          </ul><div class="home-calendar-button-container">
            <a class="home-calendar-button" href="/agenda/"
                title="Agenda completa">
              Agenda completa
            </a>
          </div></div>
        </div>
        <?php
      }
      ?>
    </div>
