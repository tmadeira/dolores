<?php
function dolores_grid($query = null) {
  global $wp_query, $post;
  if ($query === null) {
    $query = $wp_query;
  }
  ?>
  <section class="site-grid">
    <div class="wrap">
      <?php
      if ($query->have_posts()) {
        echo '<ul>';
        while ($query->have_posts()) {
          $query->the_post();
          list($img_src) = wp_get_attachment_image_src(
            get_post_thumbnail_id($post->ID),
            'post-thumbnail'
          );
          $style = "background-image: url('$img_src');";
          ?>
          <li class="grid-post" style="<?php echo $style; ?>">
            <a href="<?php the_permalink(); ?>">
              <h3><?php the_title(); ?></h3>
            </a>
          </li>
          <?php
        }
        echo '</ul>';
      } else {
        echo '<p style="margin: 20px 0; text-align: center; font-size: 16px;">';
        if (is_search()) {
          echo 'Nenhum resultado encontrado.';
        } else {
          echo 'Nenhum post para mostrar.';
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
                $next_link .= '&post_type=post';
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
              Ver mais
            </a>
            <?php
          }
          ?>
        </div>
      <?php
      }
      ?>
    </div>
  </section>
<?php
}
?>
