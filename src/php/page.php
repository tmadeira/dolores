<?php
the_post();
get_header();
?>
<main class="page wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="single-meta">
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>
  </article>
</main>
<?php
get_footer();
?>
