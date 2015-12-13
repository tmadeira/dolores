<?php
require_once(__DIR__ . '/dlib/posts.php');

function dolores_grid_ideias($query = null, $show_tax = false) {
  global $wp_query, $post;
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
            list($cat, $tags) = DoloresPosts::get_post_terms($post->ID);
            if ($show_tax && $cat) {
              $tax = array(
                  'link' => get_term_link($cat, $cat->taxonomy),
                  'name' => $cat->name,
                  'image' => get_term_meta($cat->term_id, 'image', true)
              );

              list($img_src) = wp_get_attachment_image_src(
                  get_post_thumbnail_id($post->ID),
                  'post-thumbnail'
              );
              if ($img_src) {
                $tax['image'] = $img_src;
              }
              $tax['bg'] = "background-image: url('{$tax['image']}');";
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
            ?>
            <h3 class="grid-ideia-title">
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h3>
            <?php
            if (count($tags)) {
              ?>
              <p class="grid-ideia-tags">
                <?php
                foreach ($tags as $tag) {
                  ?>
                  <a class="grid-ideia-tag"
                     href="<?php echo get_term_link($tag, $tag->taxonomy); ?>"
                  ><?php echo $tag->name; ?></a>
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
              list($up, $down, $voted) = $interact->get_post_votes($post->ID);
              $data = "href=\"#vote\" data-vote=\"post_id|{$post->ID}\"";
              $upvoted = $downvoted = "";
              if ($voted === "up") {
                $upvoted = " voted";
              } else if ($voted === "down") {
                $downvoted = " voted";
              }
              ?>
              <a
                  class="grid-ideia-action ideia-upvote<?php echo $upvoted; ?>"
                  <?php echo $data; ?>
                  >
                <i class="fa fa-fw fa-thumbs-up"></i>
                <span class="number"><?php echo $up; ?></span>
              </a>
              <a
                  class="grid-ideia-action ideia-downvote<?php echo $downvoted; ?>"
                  <?php echo $data; ?>
                  >
                <i class="fa fa-fw fa-thumbs-down"></i>
                <span class="number"><?php echo $down; ?></span>
              </a>
              <a class="grid-ideia-action grid-ideia-discussion"
                  href="<?php the_permalink(); ?>#comments">
                <i class="fa fa-fw fa-comments"></i>
                <?php echo get_comments_number(); ?>
              </a>
            </p>
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
        if (is_search()) {
          echo 'Nenhum resultado encontrado.';
        } else {
          echo 'Nenhuma ideia para mostrar.';
        }
        echo '</p>';
      }

      if ($query->is_main_query() || is_search()) {
        $paged = $query->get('paged', 1);
        if (!$paged) {
          $paged = 1;
        }

        $prev_page = intval($paged) - 1;
        $next_page = intval($paged) + 1;
        ?>
        <div class="grid-ideias-pagination">
          <?php
          if ($next_page <= $query->max_num_pages) {
            if (is_search()) {
              $next_link = $_SERVER['REQUEST_URI'];
              if (strpos($next_link, 'post_type=') === false) {
                $next_link .= '&post_type=ideia';
              }
              if (strpos($next_link, 'page=') !== false) {
                $next_link = preg_replace(
                  '/page=[0-9]*/',
                  'page=' . $next_page,
                  $next_link
                );
              } else {
                $next_link .= '&page=' . $next_page;
              }
            } else {
              $next_link = get_next_posts_page_link();
            }
            ?>
            <a
                class="grid-ideias-button ajax-load-more"
                href="<?php echo $next_link; ?>"
                >
              Ver mais ideias
            </a>
            <?php
          }
          ?>

          <?php if (is_tax('tema')) { ?>
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
