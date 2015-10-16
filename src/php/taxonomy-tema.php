<?php
// TODO: use get_term_meta($term->term_id, 'image') as OpenGraph image
get_header();

if (!$paged || $paged == 1) {
  $term = get_queried_object();

  $video = get_term_meta($term->term_id, 'video', true);
  $image = get_term_meta($term->term_id, 'image', true);
  $more = get_term_meta($term->term_id, 'more', true);

  $vparams = "rel=0&amp;controls=0&amp;showinfo=0";
  ?>

  <main class="tema">
    <div class="wrap">
      <?php if ($video) { ?>
        <div class="tema-video">
          <iframe
            allowfullscreen
            frameborder="0"
            height="480"
            src="https://youtube.com/embed/<?php echo $video . "?" . $vparams; ?>"
            width="640"
            >
          </iframe>
        </div>
      <?php } else if ($image) {
        $style = ' style="background-image: url(\'' . $image . '\');"';
        ?>
        <div class="tema-video">
          <div class="tema-video-image"<?php echo $style;?>> </div>
        </div>
      <?php } ?>

      <div class="tema-info">
        <h2 class="tema-name">
          <?php
          if ($term->parent != 0) {
            echo "#";
          }
          single_cat_title();
          ?>
        </h2>
        <p><?php echo category_description(); ?></p>
        <?php if ($more) { ?>
          <a class="tema-link-more" href="<?php echo $more; ?>">
            Ver diagnóstico
          </a>
        <?php } ?>
      </div>
    </div>
  </main>

  <?php
  if ($term->parent == 0) {
    ?>
    <section class="tema-form bg-pattern-orange">
      <div class="wrap tema-form">
        <div class="tema-form-explanation">
          <h2 class="tema-form-title">
            Se a<br />cidade<br />fosse<br />nossa?
          </h2>
          <p class="tema-form-description">
            Você tem alguma ideia para o tema
            <strong><?php single_cat_title(); ?></strong>?
          </p>
          <p class="tema-form-description">
            Compartilhe usando o formulário!
          </p>
        </div>

        <form class="tema-form-form" id="form-tema">
          <p class="tema-form-item">
            <label class="tema-form-label" for="tema-form-title">
              Título
            </label>
            <input
                type="text"
                name="title"
                class="tema-form-input"
                id="tema-form-title"
                maxlength="100"
                placeholder="Título (max. 100 caracteres)"
                />
          </p>
          <p class="tema-form-item">
            <label class="tema-form-label" for="tema-form-content">
              Escreva sua ideia
            </label>
            <textarea
                class="tema-form-textarea"
                name="text"
                id="tema-form-content"
                maxlength="600"
                placeholder="Ideia (max. 600 caracteres)"
                ></textarea>
          </p>
          <?php
          $subterms = get_categories(array(
            'taxonomy' => 'tema',
            'child_of' => $term->term_id
          ));

          $tags = array();
          foreach ($subterms as $subterm) {
            $tags[] = $subterm->slug . "::" . $subterm->name;
          }
          $available_tags = implode("|", $tags);

          if ($available_tags) {
            ?>
            <p class="tema-form-item">
              <label class="tema-form-label" for="tema-form-tags">
                Tags
              </label>
              <input
                  type="hidden"
                  class="available-tags"
                  value="<?php echo $available_tags; ?>"
                  />
              <span class="tema-tags-container">
                <input
                    type="text"
                    class="tema-form-input"
                    name="dummy-tags"
                    id="tema-form-tags"
                    placeholder="Escolha algumas palavras-chave"
                    />
              </span>
            </p>
            <?php
          }
          ?>
          <p class="tema-form-item" style="margin-top: 5px; text-align: right;">
            <input type="hidden" name="cat" value="<?php echo $term->slug; ?>" />
            <button class="tema-form-button" type="submit">
              <span class="if-not-sent">Enviar</span>
              <i class="if-sending fa fa-fw fa-refresh fa-spin"></i>
            </button>
          </p>
        </form>
      </div>
    </section>
    <?php
  }
  ?>

  <?php
}

require_once(__DIR__ . '/grid-ideias.php');
dolores_grid_ideias();
?>

<?php
get_footer();
?>
