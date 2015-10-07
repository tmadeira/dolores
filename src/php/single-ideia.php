<?php
the_post();
get_header();

$taxonomy = 'tema';
$terms = get_the_terms($post->ID, $taxonomy);
$tax = null;
$tags = array();
foreach ($terms as $term) {
  if ($term->parent == 0) {
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
      <span class="single-meta-sep">·</span>
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="recommend" data-show-faces="false" data-share="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="pt"></a>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>

    <?php
    comments_template('/comments-ideia.php');
    ?>
  </article>
</main>
<?php
get_footer();
?>
