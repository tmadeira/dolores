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
            $url = DoloresAssets::get_image_uri('cam/luciana-80.jpg');
            $style = "background-image: url('$url');";
            ?>
            <div class="destaques-item-image" style="<?php echo $style; ?>">
            </div>
          </div>
          <div class="destaques-item-info">
            <h4 class="destaques-item-subtitle">
              Manifesto
            </h4>
            <h3 class="destaques-item-title">
              Compartilhar a mudança<br />(Por Luciana Genro)
            </h3>
          </div>
        </a>
      </li>
      <?php
      $query = new WP_Query(array(
        'posts_per_page' => 2,
        'tag' => 'destaque'
      ));
      while ($query->have_posts()) {
        $query->the_post();
        list($img) = wp_get_attachment_image_src(
          get_post_thumbnail_id($post->ID),
          'home-destaques'
        );
        $style = "background-image: url('$img');";
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
    <a class="destaques-more" href="/noticias/">
      Ler mais notícias
    </a>
  </div>
</div>
