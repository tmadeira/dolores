<?php
/* Template Name: Bairros */

if (empty($_GET['v']) || intval($_GET['v']) < 3) {
  require_once("v2-bairros.php");
  exit();
}

the_post();
get_header();
?>

<main class="flow">
  <div class="wrap">
    <h2 class="flow-title">
      <span>Discuta, imagine e mobilize no seu bairro!</span>
    </h2>
    <ol class="flow-list">
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #1
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #2
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #3
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
      <li class="bairros-flow-item">
        <div class="bairros-flow-item-title-container">
          <h3 class="flow-item-title">
            Etapa #4
          </h3>
        </div>
        <div class="bairros-flow-item-description-container">
          <p class="bairros-flow-item-description">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          </p>
        </div>
      </li>
    </ol>
  </div>
</main>

<section class="temas-form bg-pattern-light-purple">
  <div class="wrap">
    <h2 class="temas-form-title">
      Qual o seu bairro?
    </h2>

    <p class="temas-form-description">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    </p>

    <form class="temas-form-form" id="form-temas">
      <p class="tema-form-item">
        <input
            type="text"
            name="subject"
            class="tema-form-input"
            id="tema-form-title"
            placeholder="Bairro"
        />
      </p>
      <p style="text-align: center;">
        <span class="tema-form-response"></span>
        <button class="tema-form-button" type="submit">
          <span class="if-not-sent">Enviar</span>
          <i class="if-sending fa fa-fw fa-refresh fa-spin"></i>
        </button>
      </p>
    </form>
  </div>
</section>

<section class="locais-map-container">
  <div id="locaisMap"></div>
</section>

<script type="text/javascript">
  window.onload = function() {
    window.addMapMarker({
      position: {lat: -22.8833333, lng: -43.4333333},
      title: "Realengo",
      content: "" +
      "<div class=\"map-marker\">" +
        "<h3 class=\"map-marker-title\">Realengo</h3>" +
        "<p class=\"map-marker-description\">" +
          "<strong>Usuários cadastrados:</strong> 372<br />" +
          "<strong>Ideias propostas:</strong> 228<br />" +
          "<strong>Comentários:</strong> 1072" +
        "</p>" +
        "<p class=\"map-marker-description\">" +
          "<a class=\"map-marker-button\" href=\"#\">Participar</a>" +
        "</p>" +
      "</div>"
    });
  };
</script>

<?php
get_footer();
?>
