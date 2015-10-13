<?php
function dolores_grid_ideias($query = null, $show_tax = false) {
  global $wp_query;
  if ($query === null) {
    $query = $wp_query;
  }
  ?>
  <section class="site-grid-ideias">
    <div class="wrap">
      <?php
      if ($query->have_posts()) {
        echo '<ul class="grid-ideias-list">';
        while ($query->have_posts()) {
          $query->the_post();
          ?>
          <li class="grid-ideia<?php if ($show_tax) { echo " with-tax"; } ?>">
            <?php
            if ($show_tax) {
              $taxonomy = 'tema';
              $terms = get_the_terms($post->ID, $taxonomy);
              $tax = array();
              foreach ($terms as $term) {
                if ($term->parent == 0) {
                  $tax['link'] = get_term_link($term, $taxonomy);
                  $tax['name'] = $term->name;
                  $tax['image'] = get_term_meta($term->term_id, 'image', true);
                  $tax['bg'] = "background-image: url('{$tax['image']}');";
                  break;
                }
              }
              if ($tax['name']) {
                ?>
                <div class="grid-ideia-tax" style="<?php echo $tax['bg']; ?>">
                  <h4 class="grid-ideia-tax-title">
                    <a href="<?php echo $tax['link']; ?>">
                      <?php echo $tax['name']; ?>
                    </a>
                  </h4>
                </div>
                <?php
              }
            }
            ?>
            <h3 class="grid-ideia-title">
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
            <?php
            $taxonomy = 'tema';
            $terms = get_the_terms($post->ID, $taxonomy);
            $tags = array();
            foreach ($terms as $term) {
              if ($term->parent != 0) {
                $tags[] = array(
                  'name' => $term->name,
                  'link' => get_term_link($term, $taxonomy)
                );
              }
            }
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
            <p class="grid-ideia-author">
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
            </p>
            <p class="grid-ideia-interact">
              <?php
              require_once(__DIR__ . '/dlib/interact.php');
              $interact = new DoloresInteract();
              list($up, $down) = $interact->get_post_votes($post->ID);
              $data = "href=\"#\" data-vote=\"post_id|{$post->ID}\"";
              ?>
              <a class="grid-ideia-action ideia-upvote" <?php echo $data; ?>>
                <i class="fa fa-fw fa-thumbs-up"></i>
                <span class="number"><?php echo $up; ?></span>
              </a>
              <a class="grid-ideia-action ideia-downvote" <?php echo $data; ?>>
                <i class="fa fa-fw fa-thumbs-down"></i>
                <span class="number"><?php echo $down; ?></span>
              </a>
              <a class="grid-ideia-action grid-ideia-discussion"
                  href="<?php the_permalink(); ?>#comments">
                <i class="fa fa-fw fa-comments"></i>
                <?php echo get_comments_number(); ?>
              </a>
            </p>
            <!-- TODO: share -->
            <a class="grid-ideia-button" href="<?php the_permalink(); ?>">
              Opine &nbsp;
              <i class="fa fa-angle-right"></i>
            </a>
          </li>
          <?php
        }
        echo '</ul>';
      } else {
        echo '<p style="margin: 20px 0; text-align: center;">';
        echo 'Nenhuma ideia cadastrada.';
        echo '</p>';
      }

      if ($query->is_main_query()) {
        if (!$paged) {
          $paged = 1;
        }

        $prev_page = intval($paged) - 1;
        $next_page = intval($paged) + 1;

        ?>
        <div class="grid-ideias-pagination">
          <?php
          if ($next_page <= $query->max_num_pages) {
            $next_link = get_next_posts_page_link();
            ?>
            <a class="grid-ideias-button" href="<?php echo $next_link; ?>">
              Ver mais ideias
            </a>
            <?php
          }
          ?>

          <?php if (is_tax()) { ?>
          <a class="grid-ideias-button" href="/temas">
            Ver todos os temas
          </a>
          <?php } ?>
        </div>
        <?php
      }
      ?>
    </div>
  </section>
<?php
}
?>
