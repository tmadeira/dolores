<?php
get_header();
?>

<section
    class="temas-form bg-pattern-teal"
    style="padding-top: 40px; padding-bottom: 80px;"
    >
  <div class="wrap">
    <h2 class="temas-form-title">
      Entre em contato
    </h2>

    <!--
    <p class="temas-form-description">
      Tem ideias sobre algum tema que ainda não está em aberto? Escreva abaixo.
      Assim que abrirmos um ciclo de discussão sobre o tema, te convidaremos!
    </p>
    -->

    <form class="temas-form-form contact-form">
      <?php
      if (!is_user_logged_in()) {
        ?>
        <p class="tema-form-item">
          <label class="tema-form-label" for="tema-form-name">
            Seu nome
          </label>
          <input
              type="text"
              name="name"
              class="tema-form-input"
              id="tema-form-name"
              placeholder="Nome"
              />
        </p>
        <p class="tema-form-item">
          <label class="tema-form-label" for="tema-form-email">
            Seu e-mail
          </label>
          <input
              type="text"
              name="email"
              class="tema-form-input"
              id="tema-form-email"
              placeholder="E-mail"
              />
        </p>
        <?php
      }
      ?>
      <p class="tema-form-item">
        <label class="tema-form-label" for="tema-form-title">
          Assunto
        </label>
        <input
            type="text"
            name="subject"
            class="tema-form-input"
            id="tema-form-title"
            placeholder="Título"
            />
      </p>
      <p class="tema-form-item">
        <label class="tema-form-label" for="tema-form-content">
          Mensagem
        </label>
        <textarea
            class="tema-form-textarea"
            name="message"
            id="tema-form-content"
            placeholder="Mensagem"
            ></textarea>
      </p>
      <p class="tema-form-item" style="margin-top: 5px; text-align: right;">
        <span class="tema-form-response"></span>
        <button class="tema-form-button" type="submit">
          <span class="if-not-sent">Enviar</span>
          <i class="if-sending fa fa-fw fa-refresh fa-spin"></i>
        </button>
      </p>
    </form>
  </div>
</section>

<?php
get_footer();
?>
