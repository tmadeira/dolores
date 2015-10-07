<?php
/* Template Name: Temas */
require_once(__DIR__ . '/dlib/assets.php');

get_header();

$flow1 = DoloresAssets::get_image_uri('temas-flow-1.png');
$flow2 = DoloresAssets::get_image_uri('temas-flow-2.png');
$flow3 = DoloresAssets::get_image_uri('temas-flow-3.png');
$flow4 = DoloresAssets::get_image_uri('temas-flow-4.png');
?>

<main class="flow">
  <div class="wrap">
    <ol class="flow-list">
      <li class="temas-flow-item bg-pattern-orange">
        <img class="flow-image" src="<?php echo $flow1; ?>" />
        <div class="temas-flow-item-description-container">
          <p class="temas-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
        <div class="temas-flow-item-title-container">
          <h3 class="flow-item-title">
            <strong>#1</strong> Encontro presencial
          </h3>
        </div>
      </li>
      <li class="temas-flow-item bg-pattern-teal">
        <img class="flow-image" src="<?php echo $flow2; ?>" />
        <div class="temas-flow-item-description-container">
          <p class="temas-flow-item-description">
            Sit amet, adipiscing elit, sed do eiusmod tempor incididunt ut
            labore.
          </p>
        </div>
        <div class="temas-flow-item-title-container">
          <h3 class="flow-item-title">
            <strong>#2</strong> Discussão online
          </h3>
        </div>
      </li>
      <li class="temas-flow-item bg-pattern-light-purple">
        <img class="flow-image" src="<?php echo $flow3; ?>" />
        <div class="temas-flow-item-description-container">
          <p class="temas-flow-item-description">
            Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua.
          </p>
        </div>
        <div class="temas-flow-item-title-container">
          <h3 class="flow-item-title">
            <strong>#3</strong> Sistematização
          </h3>
        </div>
      </li>
      <li class="temas-flow-item bg-pattern-dark-purple">
        <img class="flow-image" src="<?php echo $flow4; ?>" />
        <div class="temas-flow-item-description-container">
          <p class="temas-flow-item-description">
            Color sit amet, consectetur adipiscing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna.
          </p>
        </div>
        <div class="temas-flow-item-title-container">
          <h3 class="flow-item-title">
            <strong>#4</strong> Lançamento das propostas
          </h3>
        </div>
      </li>
    </ol>
  </div>
</main>

<main class="grid-temas">
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

<section class="temas-form bg-pattern-teal">
  <div class="wrap">
    <h2 class="temas-form-title">
      Quer discutir outro tema?
    </h2>

    <p class="temas-form-description">
      Duis eu tincidunt metus. Proin tempor ante eget.
    </p>

    <form class="temas-form-form">
      <p class="tema-form-item">
        <label class="tema-form-label" for="tema-form-title">
          Título
        </label>
        <input
            type="text"
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
            id="tema-form-content"
            maxlength="600"
            placeholder="Ideia (max. 600 caracteres)"
            ></textarea>
      </p>
      <p class="tema-form-item" style="margin-top: 5px; text-align: right;">
        <button class="tema-form-button" onclick="alert('Em construção.')">
          Enviar
        </button>
      </p>
    </form>
  </div>
</section>

<?php
get_footer();
?>
