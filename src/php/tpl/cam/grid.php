<?php
function dolores_grid($query = null) {
  global $wp_query, $post;
  if ($query === null) {
    $query = $wp_query;
  }
  if ($query->have_posts()) {
    ?>
    <section class="site-grid">
      <div class="wrap">
        <ul class="grid-list">
          <?php
          while ($query->have_posts()) {
            $query->the_post();
            $cats = get_the_category();
            if (count($cats) > 0) {
              $cat = $cats[0]->cat_name;
            }
            list($img) = wp_get_attachment_image_src(
              get_post_thumbnail_id($post->ID),
              'grid-thumbnail'
            );
            ?>
            <li>
              <a href="<?php the_permalink(); ?>" class="grid-post">
              <img class="grid-post-thumb" src="<?php echo $img; ?>" />
              <div class="grid-post-text">
                <?php
                if (!is_category()) {
                  ?>
                  <h4 class="grid-post-category"><?php echo $cat; ?></h4>
                  <?php
                }
                ?>
                <h3 class="grid-post-title"><?php the_title(); ?></h3>
              </div>
              </a>
            </li>
            <?php
            }
          ?>
        </ul>
      </div>
    </section>
    <?php
  } else {
    ?>
    <section class="wrap default-wrap">
      <div class="entry">
        <p>Nenhum post encontrado.</p>
      </div>
    </section>
    <?php
  }
}

function dolores_list($query = null) {
  global $wp_query, $post;
  if ($query === null) {
    $query = $wp_query;
  }
  if ($query->have_posts()) {
    ?>
    <section class="site-list">
      <div class="wrap default-wrap">
        <ul class="list-list">
          <?php
          while ($query->have_posts()) {
            $query->the_post();
            ?>
            <li>
              <a href="<?php the_permalink(); ?>" class="list-post">
                <i class="fa fa-lg fa-check-circle"></i>
                <div class="list-post-info">
                  <h3 class="list-post-title"><?php the_title(); ?></h3>
                  <div class="list-post-author">
                    <?php
                    echo get_post_meta(get_the_ID(), 'autor', true);
                    ?>
                  </div>
                </div>
              </a>
            </li>
            <?php
            }
          ?>
        </ul>
      </div>
    </section>
    <?php
  } else {
    ?>
    <section class="wrap default-wrap">
      <div class="entry">
        <p>Nenhum post encontrado.</p>
      </div>
    </section>
    <?php
  }
}
