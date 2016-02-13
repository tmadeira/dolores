<?php
the_post();
get_header();
?>
<main class="page wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="single-meta social-media">
      <span class="social-buttons">
        <a class="social-button share-facebook" href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-facebook"></i>
          Compartilhar
        </a>
        <a class="social-button share-twitter" href="https://twitter.com/share?text=<?php esc_attr_e(get_the_title()); ?>&amp;url=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-twitter"></i>
          Tuitar
        </a>
      </span>
    </div>

    <div class="entry">
      <?php the_content(); ?>

      <?php
      global $show_signin_button;
      if ($show_signin_button) {
        ?>
        <div class="grid-ideias-pagination">
          <button
              class="grid-ideias-button"
              onclick="DoloresAuthenticator.signIn(null, function() { location.href = '/temas'; })"
              >
            Gostou? Clique aqui para participar!
          </button>
        </div>
        <?php
      }
    ?>
    </div>

    <div class="single-meta social-media">
      <span class="social-buttons">
        <a class="social-button share-facebook" href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-facebook"></i>
          Compartilhar
        </a>
        <a class="social-button share-twitter" href="https://twitter.com/share?text=<?php esc_attr_e(get_the_title()); ?>&amp;url=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-twitter"></i>
          Tuitar
        </a>
      </span>
    </div>
  </article>

  <?php get_sidebar(); ?>
</main>
<?php
get_footer();
?>
