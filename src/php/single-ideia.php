<?php
the_post();
get_header();

$taxonomy = 'tema';
$terms = get_the_terms($post->ID, $taxonomy);
$tax = null;
$tax_id = null;
$tags = array();
foreach ($terms as $term) {
  if ($term->parent == 0) {
    $tax_id = $term->term_id;
    $link = get_term_link($term, $taxonomy);
    $name = $term->name;
    $tax = "<a href=\"$link\">$name</a>";
  } else {
    $tags[] = array(
      'name' => $term->name,
      'link' => get_term_link($term, $taxonomy)
    );
  }
}
?>
<main class="single wrap">
  <article class="single-content">
    <?php
    if ($tax) {
      echo '<h4 class="single-taxonomy">' . $tax . '</h4>';
    }
    ?>

    <h2 class="single-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

    <?php
    if (count($tags)) {
      ?>
      <p class="grid-ideia-tags">
        <?php
        foreach ($tags as $tag) {
          ?>
          <a class="grid-ideia-tag" href="<?php echo $tag['link']; ?>"
              ><?php echo $tag['name']; ?></a>
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
    if ($tax_id) {
      ?>
      <div class="sidebar-section">
        <h2 class="sidebar-title">Tags mais usadas</h2>

        <div class="tag-cloud">
          <?php
          wp_tag_cloud(array(
            'child_of' => $tax_id,
            'smallest' => 10,
            'largest' => 20,
            'taxonomy' => $taxonomy
          ));
          ?>
        </div>
      </div>
      <?php
    }
    ?>

    <div class="sidebar-section">
      <h2 class="sidebar-title">Outras ideias</h2>
      // TODO: Ideias relacionadas
    </div>
  </section>
</main>
<?php
get_footer();
?>
