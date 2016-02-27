<?php
the_post();
get_header();
?>

<main class="wrap default-wrap no-sidebar-page">
  <article>
    <h2 class="single-title">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>

    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
    </div>

    <div class="entry">
      <?php the_content(); ?>
    </div>

    <div class="single-meta social-media">
      <?php dolores_print_share_buttons(); ?>
    </div>
  </article>
</main>

<section class="temas-form">
  <div class="wrap default-wrap">
    <h2 class="temas-form-title">
      Assina embaixo?
    </h2>

    <p class="temas-description">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
      veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo consequat.
    </p>

    <form class="temas-form-form" id="form-temas">
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-name">
          Nome
        </label>
        <input
            type="text"
            name="name"
            class="tema-form-input"
            id="tema-form-name"
            placeholder="Nome"
            />
      </div>
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-email">
          E-mail
        </label>
        <input
            type="text"
            name="email"
            class="tema-form-input"
            id="tema-form-email"
            placeholder="E-mail"
            />
      </div>
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-location">
          Bairro
        </label>
        <input
            type="text"
            name="email"
            class="tema-form-input"
            id="tema-form-location"
            placeholder="Bairro"
            />
      </div>
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-occupation">
          Ocupação/Instituição
        </label>
        <input
            type="text"
            name="email"
            class="tema-form-input"
            id="tema-form-occupation"
            placeholder="Ocupação/Instituição"
            />
      </div>
      <div class="tema-form-item">
        <label class="tema-form-label">
          <input type="checkbox" />
          Desejo receber boletins do <strong>Compartilhe a Mudança</strong>
        </label>
      </div>
      <div class="tema-form-item" style="margin-top: 5px; text-align: center;">
        <button class="tema-form-button" type="submit">
          <span class="if-not-sent">Eu apoio</span>
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
