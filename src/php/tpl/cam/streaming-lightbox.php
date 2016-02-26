<?php
if (!is_page_template('streaming.php') && DoloresStreaming::get_active()) {
  $title = esc_attr(DoloresStreaming::get_title());
  $seen = 'seen-' . md5($title);
  if (!$_SESSION[$seen]) {
    $_SESSION[$seen] = true;
    ?>
    <div id="streaming-lightbox" title="<?php echo $title; ?>"></div>
    <?php
  }
}
