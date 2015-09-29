<?php
/* Template Name: Temas */

get_header();
?>

<main class="page grid-temas">
  <div class="wrap">
    <ul class="grid-temas-list">
      <?php
      $taxonomy = 'tema';
      $terms = get_terms($taxonomy, array(
        'hide_empty' => false,
        'parent' => 0
      ));
      foreach ($terms as $term) {
        $link = get_term_link($term, $taxonomy);
        $image = get_term_meta($term->term_id, 'image', true);
        if ($image) {
          $style = ' style="background-image: url(\'' . $image . '\');"';
        } else {
          $style = '';
        }
        ?>
        <li class="grid-tema"<?php echo $style; ?>>
          <a href="<?php echo $link; ?>" class="grid-tema-link">
            <div class="grid-tema-wrap">
              <h3 class="grid-tema-name"><?php echo $term->name; ?></h3>
              <button class="grid-tema-action">Participe</button>
            </div>
          </a>
        </li>
        <?php
      }
      ?>
    </ul>
  </div>
</main>

<?php
get_footer();
?>
