<?php
get_header();
?>

<section class="temas-form">
  <div class="wrap default-wrap">
    <h2 class="temas-form-title">
      Seja um voluntário
    </h2>

    <p class="temas-form-description">
      Quer ser voluntário e compartilhar a mudança em Porto Alegre? Coloque
      seu talento à disposição da mudança! Nós queremos realizar atividades
      nos bairros da cidade, reuniões e encontros presenciais para levar a
      mudança até as localidades e compartilhar direitos com a população.
      Nos diga como você pode ajudar neste processo!
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
        <label class="tema-form-label" for="tema-form-content">
          Quero ser um voluntário!
        </label>
        <textarea
            class="tema-form-textarea"
            name="message"
            id="tema-form-content"
            placeholder="Como você pode ajudar neste processo?"
            ></textarea>
      </div>
      <div class="tema-form-item" style="margin-top: 5px; text-align: center;">
        <input type="hidden" name="subject" value="Quero ser um voluntário!" />
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
