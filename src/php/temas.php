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
        ?>
        <li class="grid-tema" style="background-image:url('http://www.jb.com.br/media/fotos/2010/10/04/900x510both/04india1.JPG');">
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
