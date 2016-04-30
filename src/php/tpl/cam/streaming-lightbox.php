<?php
if (!is_page_template('streaming.php') && DoloresStreaming::get_active()) {
  $title = esc_attr(DoloresStreaming::get_title());
  $youtube_id = DoloresStreaming::get_youtube_id();
  $seen = 'seen-' . md5($title . $youtube_id);
  if (is_front_page() || !$_SESSION[$seen]) {
    $_SESSION[$seen] = true;
    $link = '//youtu.be/' . $youtube_id;
    ?>
    <div
      id="streaming-lightbox"
      ref="<?php echo $link; ?>"
      title="<?php echo $title; ?>">
    </div>
    <?php
  }
}
