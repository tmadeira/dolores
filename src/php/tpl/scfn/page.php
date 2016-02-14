<?php
the_post();
get_header();
?>
<main class="page wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
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
      <?php dolores_print_share_buttons(); ?>
    </div>
  </article>

  <?php get_sidebar(); ?>
</main>
<?php
get_footer();
?>
