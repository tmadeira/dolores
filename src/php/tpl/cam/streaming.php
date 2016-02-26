<?php
the_post();
get_header();
?>

<main class="streaming">
  <div class="wrap default-wrap no-sidebar-page">
  <?php
  if (DoloresStreaming::get_active()) {
    $title = esc_html(DoloresStreaming::get_title());
    $youtube_id = DoloresStreaming::get_youtube_id();
    $params = "rel=0&amp;showinfo=0&amp;autoplay=1";
    $url = "//youtube.com/embed/${youtube_id}?${params}";
    ?>
    <h2 class="streaming-title"><?php echo $title; ?></h2>
    <iframe
      class="streaming-box"
      src="<?php echo $url; ?>"
      frameborder="0"
      allowfullscreen>
    </iframe>
    <?php
  } else {
    ?>
    <p>
      Não há transmissão ao vivo no momento.
    </p>
    <?php
  }
  ?>
  </div>
</main>

<?php
// TODO: list videos
?>

<?php
get_footer();
?>
