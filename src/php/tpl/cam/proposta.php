<?php
the_post();
get_header();
?>

<main class="proposta-main">
  <article class="proposta-content">
    <h1>
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h1>

    <h2>Por Luciana Genro</h2>

    <div class="proposta-entry">
      <?php the_content(); ?>
    </div>

    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
    </div>
  </article>
</main>

<?php
get_footer();
?>
