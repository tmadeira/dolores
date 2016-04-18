<?php
require_once(DOLORES_PATH . '/dlib/assets.php');
?>
<div class="home-destaques">
  <div class="wrap">
    <ul class="destaques-list">
      <li class="destaques-item destaques-item-manifesto">
        <a href="/manifesto/">
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
              <span>
                Manifesto
              </span>
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
        <a href="<?php the_permalink(); ?>">
            <div class="destaques-item-image-container">
              <div class="destaques-item-image" style="<?php echo $style; ?>">
              </div>
            </div>
            <div class="destaques-item-info">
              <h3 class="destaques-item-title">
                <?php the_title(); ?>
              </h3>
            </div>
          </a>
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
