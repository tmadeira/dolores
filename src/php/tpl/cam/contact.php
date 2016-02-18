<?php
get_header();
?>

<section class="temas-form">
  <div class="wrap default-wrap">
    <h2 class="temas-form-title">
      Entre em contato
    </h2>

    <p class="temas-form-description">
      Para entrar em contato, preencha o formulário abaixo ou envie um e-mail
      para <a href="mailto:contato@compartilheamudanca.com.br">
        contato@compartilheamudanca.com.br</a>.
    </p>

    <form class="temas-form-form contact-form" id="form-temas">
      <?php
      if (!is_user_logged_in()) {
        ?>
        <div class="tema-form-item">
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
        </div>
        <div class="tema-form-item">
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
        </div>
        <?php
      }
      ?>
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-title">
          Assunto
        </label>
        <input
            type="text"
            name="subject"
            class="tema-form-input"
            id="tema-form-title"
            placeholder="Assunto"
            />
      </div>
      <div class="tema-form-item">
        <label class="tema-form-label" for="tema-form-content">
          Mensagem
        </label>
        <textarea
            class="tema-form-textarea"
            name="message"
            id="tema-form-content"
            placeholder="Mensagem"
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
