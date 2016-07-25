<?php
require_once(DOLORES_PATH . '/dlib/assets.php');
?>
<div class="home-destaques">
  <div class="wrap">
    <ul class="destaques-list">
      <li class="destaques-item destaques-item-manifesto">
        <a href="/proposta/">
          <div class="destaques-item-image-container">
            <?php
            $url = DoloresAssets::get_image_uri('cam/luciana-90.jpg');
            $style = "background-image: url('$url');";
            ?>
            <div class="destaques-item-image" style="<?php echo $style; ?>">
            </div>
          </div>
          <div class="destaques-item-info">
            <h4 class="destaques-item-subtitle">
              <div><span>Proposta para</span></div>
              <div><span>Porto Alegre</span></div>
            </h4>
            <h3 class="destaques-item-title">
              Por Luciana Genro
            </h3>
          </div>
        </a>
      </li>
      <?php
      $query = new WP_Query(array(
        'posts_per_page' => 3,
        'tag' => 'destaque'
      ));
      for ($i = 0; $query->have_posts(); $i++) {
        $query->the_post();
        list($img) = wp_get_attachment_image_src(
          get_post_thumbnail_id($post->ID),
          'home-destaques'
        );
        $style = "background-image: url('$img');";
        if ($i == 1) {
          ?>
          </ul>
          <ul class="destaques-list">
          <?php
        }
        ?>
        <li class="destaques-item">
          <div>
            <div class="destaques-item-image-container">
              <a href="<?php the_permalink(); ?>">
                <div class="destaques-item-image" style="<?php echo $style; ?>">
                </div>
              </a>
            </div>
            <div class="destaques-item-info">
              <a href="<?php the_permalink(); ?>">
                <h3 class="destaques-item-title">
                  <?php the_title(); ?>
                </h3>
              </a>

              <div class="destaques-item-interact">
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
            </div>
          </div>
        </li>
        <?php
      }
      ?>
    </ul>
    <a class="destaques-more" href="/noticias/" title="Ler mais notícias">
      <i class="fa fa-fw fa-angle-right"></i>
      <span>Ler mais notícias</span>
    </a>
  </div>
</div>
