<?php
the_post();
get_header();
?>
<main class="page wrap">
  <article class="single-content">
    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="single-meta social-media">
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="pt"></a>
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
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="pt"></a>
    </div>
  </article>
</main>
<?php
get_footer();
?>
