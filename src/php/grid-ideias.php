<section class="site-grid-ideias">
  <div class="wrap">
    <?php
    if (have_posts()) {
      echo '<ul class="grid-ideias-list">';
      while (have_posts()) {
        the_post();
        ?>
        <li class="grid-ideia">
          <h3 class="grid-ideia-title">
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h3>
          <p class="grid-ideia-tags">
            <a class="grid-ideia-tag" href="#">Direito à cidade</a>
            <a class="grid-ideia-tag" href="#">Educação</a>
            <a class="grid-ideia-tag" href="#">Tecnologia</a>
          </p>
          <p class="grid-ideia-author">
            <a href="#">
              <span class="grid-ideia-author-picture" style="background-image:url('https://scontent-gru1-1.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/1901483_720556658028384_5264385726517126128_n.jpg?oh=985c32534d9ed1019ad6fee2caf0d6f3&oe=568D58A8');"></span>
              Honório Oliveira
            </a>
          </p>
          <p class="grid-ideia-interact">
            <a class="grid-ideia-action grid-ideia-upvote" href="#">403</a>
            <a class="grid-ideia-action grid-ideia-downvote" href="#">2</a>
            <a class="grid-ideia-action grid-ideia-discussion" href="#">51</a>
          </p>
          <!-- TODO: share -->
          <a class="grid-ideia-button" href="#">Opine</a>
        </li>
        <?php
      }
      echo '</ul>';
    }

    if (!$paged) {
      $paged = 1;
    }

    $prev_page = intval($paged) - 1;
    $next_page = intval($paged) + 1;

    ?>
    <div class="grid-pagination">
      <?php

      if ($prev_page > 0) {
        $prev_link = get_previous_posts_page_link();
        ?>
        <a class="btn-prev-page" href="<?php echo $prev_link; ?>"></a>
        <?php
      }

      if ($next_page <= $wp_query->max_num_pages) {
        $next_link = get_next_posts_page_link();
        ?>
        <a class="btn-next-page" href="<?php echo $next_link; ?>"></a>
        <?php
      }
      ?>
    </div>
  </div>
</section>
