<?php
the_post();
get_header();
?>
<main class="single wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="single-meta">
      <span class="single-date">
        <?php the_time('d \d\e F \d\e Y'); ?>
      </span>
    </p>

    <div class="entry">
      <?php the_content(); ?>
    </div>
  </article>
</main>
<?php
get_footer();
?>
