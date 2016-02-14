<?php
the_post();
get_header();
?>
<main class="single wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="single-meta social-media">
      <span class="single-date">
        <?php the_time('d \d\e F \d\e Y'); ?>
      </span>

      <span class="social-sep">
        <hr />
      </span>

      <?php dolores_print_share_buttons(); ?>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>

    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
    </div>
  </article>

  <?php get_sidebar(); ?>
</main>
<?php
get_footer();
?>
