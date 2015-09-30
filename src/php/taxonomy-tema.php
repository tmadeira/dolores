<?php
// TODO: use get_term_meta($id, 'image') as OpenGraph image
get_header();
$id = get_queried_object_id();

$video = get_term_meta($id, 'video', true);
$more = get_term_meta($id, 'more', true);

$vparams = "rel=0&amp;controls=0&amp;showinfo=0";
?>

<main class="tema">
  <div class="wrap">
    <?php if ($video) { ?>
    <div class="tema-video">
      <iframe
        allowfullscreen
        frameborder="0"
        height="480"
        src="https://youtube.com/embed/<?php echo $video . "?" . $vparams; ?>"
        width="640"
        >
      </iframe>
    </div>
    <?php } ?>

    <div class="tema-info">
      <h2 class="tema-name"><?php single_cat_title(); ?></h2>
      <p><?php echo category_description(); ?></p>
      <?php if ($more) { ?>
        <a class="tema-link-more" href="<?php echo $more; ?>">
          Ver diagnóstico
        </a>
      <?php } ?>
    </div>
  </div>
</main>

<?php
include(__DIR__ . '/grid-ideias.php');
?>

<?php
get_footer();
?>
