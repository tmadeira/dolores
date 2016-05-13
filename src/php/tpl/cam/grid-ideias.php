<?php
require_once(DOLORES_PATH . '/dlib/interact.php');
require_once(DOLORES_PATH . '/dlib/posts.php');
require_once(DOLORES_PATH . '/dlib/wp_util/user_meta.php');

function dolores_grid_ideias($query = null) {
  global $wp_query, $post;
  if ($query === null) {
    $query = $wp_query;
  }
  if ($query->have_posts()) {
    ?>
    <section class="site-grid-ideias">
      <div class="wrap default-wrap">
        <ul class="grid-ideias-list">
          <?php
          while ($query->have_posts()) {
            $query->the_post();
            ?>
            <li class="grid-ideia">
              <h3 class="grid-ideia-title">
                <a href="<?php the_permalink(); ?>">
                  <?php the_title(); ?>
                </a>
              </h3>
              <?php
              list($cat, $tags) = DoloresPosts::get_post_terms($post->ID);
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
                $picture = dolores_get_profile_picture(get_user_by('id', $id));
                $style = ' style="background-image: url(\'' . $picture. '\');"';
                $url = get_author_posts_url(get_the_author_meta('ID'));
                ?>
                <a href="<?php echo $url; ?>">
                  <span class="author-picture" <?php echo $style; ?>>
                  </span>
                  <?php the_author(); ?>
                </a>
              </p>
              <div class="grid-ideia-interact">
                <?php
                $interact = new DoloresInteract();
                list($up, $down, $voted) = $interact->get_post_votes($post->ID);
                $data = "href=\"#vote\" data-vote=\"post_id|{$post->ID}\"";

                $upvoted = $downvoted = "";

                $up_string = '0';
                if (count($up) > 0) {
                  $up_string = preg_replace('/ .*/', '', $up[0]['name']);
                  if ($voted === "up") {
                    $up_string = "Você";
                    $upvoted = " voted";
                  }
                  if (count($up) > 1) {
                    $up_string.= ' + ' . (count($up) - 1);
                  }
                }

                $down_string = '0';
                if (count($down) > 0) {
                  $down_string = preg_replace('/ .*/', '', $down[0]['name']);
                  if ($voted === "down") {
                    $down_string = "Você";
                    $downvoted = " voted";
                  }
                  if (count($down) > 1) {
                    $down_string.= ' + ' . (count($down) - 1);
                  }
                }
                ?>
                <a
                    class="grid-ideia-action ideia-upvote<?php echo $upvoted; ?>"
                    <?php echo $data; ?>
                    >
                  <i class="fa fa-lg fa-fw fa-thumbs-up"></i>
                </a>
                <div class="ideia-votes-count">
                  <span><?php echo $up_string; ?></span>
                  <ul class="ideia-votes-list">
                    <?php
                    foreach ($up as $user) {
                      ?>
                      <li>
                        <a href="<?php echo $user['url']; ?>">
                          <div class="ideia-votes-list-pic-container">
                            <div class="ideia-votes-list-pic"
                                style="background-image: url('<?php
                                    echo $user['pic']; ?>');">
                            </div>
                          </div>
                          <div class="ideia-votes-list-name">
                            <?php echo $user['name']; ?>
                          </div>
                        </a>
                      </li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>
                <a
                    class="grid-ideia-action ideia-downvote<?php echo $downvoted; ?>"
                    <?php echo $data; ?>
                    >
                  <i class="fa fa-lg fa-fw fa-thumbs-down"></i>
                </a>
                <div class="ideia-votes-count">
                  <span><?php echo $down_string; ?></span>
                  <ul class="ideia-votes-list">
                    <?php
                    foreach ($down as $user) {
                      ?>
                      <li>
                        <a href="<?php echo $user['url']; ?>">
                          <div class="ideia-votes-list-pic-container">
                            <div class="ideia-votes-list-pic"
                                style="background-image: url('<?php
                                    echo $user['pic']; ?>');">
                            </div>
                          </div>
                          <div class="ideia-votes-list-name">
                            <?php echo $user['name']; ?>
                          </div>
                        </a>
                      </li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>

                <a class="grid-ideia-action grid-ideia-discussion"
                    href="<?php the_permalink(); ?>#comments">
                  <i class="fa fa-lg fa-fw fa-comments"></i>
                  <?php echo get_comments_number(); ?>
                </a>
              </div>
              <a class="grid-ideia-button" href="<?php the_permalink(); ?>">
                Debata &nbsp;
                <i class="fa fa-angle-right"></i>
              </a>
            </li>
            <?php
          }
          ?>
        </ul>
        <?php
        if (is_main_query()) {
          ?>
          <div class="pagination">
            <?php
            echo paginate_links();
            ?>
          </div>
          <?php
        }
        ?>
      </div>
    </section>
    <?php
  } else {
    ?>
    <section class="wrap default-wrap">
      <div class="entry">
        <p>Ainda não há nenhuma proposta cadastrada. Escreva a primeira!</p>
      </div>
    </section>
    <?php
  }
}
