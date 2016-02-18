<?php
require_once(DOLORES_PATH . '/dlib/posts.php');
require_once(DOLORES_PATH . '/dlib/wp_util/user_meta.php');

the_post();
get_header();

list($cat, $tags) = DoloresPosts::get_post_terms($post->ID);
?>

<main class="wrap default-wrap">
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

    <h2 class="single-title">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="single-meta social-media">
      <span class="single-author">
        <?php
        $id = get_the_author_meta('ID');
        $picture = dolores_get_profile_picture(get_user_by('id', $id));
        $style = ' style="background-image: url(\'' . $picture. '\');"';
        $url = get_author_posts_url(get_the_author_meta('ID'));
        ?>
        <a href="<?php echo $url; ?>">
          <span class="author-picture" <?php echo $style; ?>>
          </span>
          <?php the_author(); ?>
        </a>
      </span>

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

    <?php
    comments_template('/comments-ideia.php');
    ?>
  </article>

  <?php
  get_sidebar();
  ?>
</main>

<?php
get_footer();
?>
