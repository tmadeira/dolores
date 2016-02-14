<?php
the_post();
get_header();
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
      <?php the_content(); ?>
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
