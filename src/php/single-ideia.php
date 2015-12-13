<?php
require_once(__DIR__ . '/dlib/posts.php');

the_post();
get_header();

list($cat, $tags) = DoloresPosts::get_post_terms($post->ID);
?>
<main class="single wrap">
  <article class="single-content">
    <?php
    if ($cat) {
      ?>
      <h4 class="single-taxonomy">
        <a href="<?php echo get_term_link($cat, $cat->taxonomy); ?>">
          <?php echo $cat->name; ?>
        </a>
      </h4>
      <?php
    }
    ?>

    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

    <?php
    if (count($tags)) {
      ?>
      <p class="grid-ideia-tags">
        <?php
        foreach ($tags as $tag) {
          $link = get_term_link($tag, $tag->taxonomy);
          ?>
          <a class="grid-ideia-tag" href="<?php echo $link; ?>"><?php
              echo $tag->name;
          ?></a>
          <?php
        }
        ?>
      </p>
      <?php
    }
    ?>

    <div class="single-meta social-media">
      <span class="single-author">
        <?php
        $id = get_the_author_meta('ID');
        require_once(__DIR__ . '/dlib/wp_util/user_meta.php');
        $picture = dolores_get_profile_picture(get_user_by('id', $id));
        $style = ' style="background-image: url(\'' . $picture. '\');"';
        $url = get_author_posts_url(get_the_author_meta('ID'));
        ?>
        <a href="<?php echo $url; ?>">
          <span class="grid-ideia-author-picture" <?php echo $style; ?>>
          </span>
          <?php the_author(); ?>
        </a>
      </span>
      <span class="single-meta-sep">·</span>
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

    <?php
    comments_template('/comments-ideia.php');
    ?>
  </article>

  <section class="single-sidebar">
    <?php
    if ($cat && $cat->taxonomy == 'temas') {
      ?>
      <div class="sidebar-section">
        <h2 class="sidebar-title">Tags mais usadas</h2>

        <div class="tag-cloud">
          <?php
          wp_tag_cloud(array(
            'child_of' => $cat->term_id,
            'smallest' => 10,
            'largest' => 20,
            'taxonomy' => $cat->taxonomy
          ));
          ?>
        </div>
      </div>
      <?php
    }
    ?>

    <?php
    $yarpp_args = array(
      'post_type' => 'ideia',
      'template' => 'yarpp-template-ideias.php'
    );
    if (function_exists('yarpp_related') && yarpp_related_exist($yarpp_args)) {
      ?>
      <div class="sidebar-section">
        <h2 class="sidebar-title">Outras ideias</h2>
        <?php
        yarpp_related($yarpp_args);
        ?>
      </div>
      <?php
    }
    ?>
  </section>
</main>
<?php
get_footer();
?>
