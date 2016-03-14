<?php
the_post();
get_header();
?>

<main class="wrap default-wrap no-sidebar-page">
  <h2 class="temas-title">Que mudanças você quer?</h2>

  <p class="temas-description">
    Aqui você encontra a lista de temas que estão sendo debatidos na plataforma.
    Você também vai encontrar, dentro de cada tema, um espaço para dar as suas
    sugestões.
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

<section class="temas-form">
  <div class="wrap default-wrap">
    <h2 class="temas-form-title">
      Quer discutir outro tema?
    </h2>

    <p class="temas-form-description">
      Tem propostas para algum tema que não esteja na lista acima? Preencha o
      formulário abaixo.
    </p>

    <form class="temas-form-form" id="form-temas">
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-title">
          Título
        </label>
        <input
            type="text"
            name="subject"
            class="tema-form-input"
            id="tema-form-title"
            placeholder="Título"
            />
      </div>
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-content">
          Escreva sua proposta
        </label>
        <textarea
            class="tema-form-textarea"
            name="message"
            id="tema-form-content"
            placeholder="Proposta"
            ></textarea>
      </div>
      <div class="tema-form-item" style="margin-top: 5px; text-align: center;">
        <button class="tema-form-button" type="submit">
          <span class="if-not-sent">Enviar</span>
          <i class="if-sending fa fa-refresh fa-spin"></i>
        </button>
      </div>
      <div class="temas-form-description tema-form-response"></div>
    </form>
  </div>
</section>

<?php
get_footer();
?>
