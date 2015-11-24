<?php
require_once(__DIR__ . '/dlib/wp_admin/settings/opengraph.php');
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

      <span class="social-buttons">
        <a class="social-button share-facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-facebook"></i>
          Compartilhar
        </a>
        <a class="social-button share-twitter" href="http://twitter.com/share?text=<?php esc_attr_e(get_the_title()); ?>&amp;url=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-twitter"></i>
          Tuitar
        </a>
      </span>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>

    <div class="single-meta social-media">
      <span class="social-buttons">
        <a class="social-button share-facebook" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-facebook"></i>
          Compartilhar
        </a>
        <a class="social-button share-twitter" href="http://twitter.com/share?text=<?php esc_attr_e(get_the_title()); ?>&amp;url=<?php the_permalink(); ?>" target="_blank">
          <i class="fa fa-fw fa-lg fa-twitter"></i>
          Tuitar
        </a>
      </span>
    </div>
  </article>

  <section class="single-sidebar">
    <?php
    $author_url = DoloresOGSettings::get_author_url();
    if ($author_url) {
      ?>
      <div class="sidebar-section">
        <h2 class="sidebar-title">Curta no Facebook</h2>
        <div class="fb-page" data-href="<?php echo $author_url; ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false" style="height: 215px;"></div>
      </div>
      <?php
    }
    ?>

    <?php
    $yarpp_args = array(
      'template' => 'yarpp-template-posts.php'
    );
    if (function_exists('yarpp_related') && yarpp_related_exist($yarpp_args)) {
      ?>
      <div class="sidebar-section">
        <h2 class="sidebar-title">Leia também</h2>
        <?php
        yarpp_related($yarpp_args);
        ?>
      </div>
      <?php
    }
    ?>

    <div class="sidebar-section">
      <h2 class="sidebar-title">Participe</h2>
      <div style="text-align:center;">
        <button
            class="grid-ideias-button"
            onclick="DoloresAuthenticator.signIn(null, function() { location.href = '/temas'; })"
            >
          Dê suas ideias para a cidade!
        </button>
      </div>
    </div>

  </section>
</main>
<?php
get_footer();
?>
