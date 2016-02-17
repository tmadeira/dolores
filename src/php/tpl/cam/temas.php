<?php
the_post();
get_header();
?>

<main class="wrap default-wrap no-sidebar-page">
  <h2 class="temas-title">Entre no debate</h2>

  <p class="temas-description">
    Aqui você encontra a lista de temas que estão sendo debatidos na plataforma.
    Se você quiser discutir outro assunto, entre em contato através do
    formulário disponível no final da página.
  </p>

  <ul class="temas-grid">
    <?php
    $taxonomy = 'tema';
    $terms = get_terms($taxonomy, array(
      'hide_empty' => false,
      'parent' => 0
    ));
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
</main>

<?php
get_footer();
?>
