<ul class="home-temas-grid">
  <?php
  $taxonomy = 'tema';
  add_filter('get_terms_orderby', 'dolores_random_orderby');
  $terms = get_terms($taxonomy, array(
    'hide_empty' => false,
    'number' => 4,
    'parent' => 0
  ));
  remove_filter('get_terms_orderby', 'dolores_random_orderby');
  foreach ($terms as $term) {
    $image = get_term_meta($term->term_id, 'image', true);
    if ($image) {
      $style = ' style="background-image: url(\'' . $image . '\');"';
    } else {
      $style = '';
    }
    $href = get_term_link($term, $taxonomy);
    ?>
    <li<?php echo $style; ?>>
      <a href="<?php echo $href; ?>" class="temas-item">
        <span class="temas-text-container">
          <span class="tema"><?php echo $term->name; ?></span>
        </span>
      </a>
    </li>
    <?php
  }
  ?>
</ul>
