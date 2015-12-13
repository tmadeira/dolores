<?php
/* Template Name: Bairros */

if (empty($_GET['v']) || intval($_GET['v']) < 3) {
  require_once("v2-bairros.php");
  exit();
}

require_once(__DIR__ . '/dlib/locations.php');

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

    <?php
    if (is_user_logged_in()) {
      $user = wp_get_current_user();
      $bairro = get_user_meta($user->ID, 'location', true);
      $missing = DoloresLocations::get_instance()->get_missing($bairro);
      ?>
      <h2 class="temas-form-title">
        <?php echo $bairro; ?>
      </h2>

      <p class="bairros-form-description">
        Faltam <strong><?php echo $missing; ?></strong> pessoas para desbloquear
        seu bairro.
      </p>

      <p class="bairros-button-container">
        <button
            class="bairros-button"
            onclick="FB.ui({method: 'send', link: '<?php
              echo site_url("/bairros/");
            ?>'});">
          Convide seus amigos
        </button>
      </p>
      <?php
    } else {
      ?>
      <h2 class="temas-form-title">
        Qual o seu bairro?
      </h2>

      <p class="temas-form-description">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
      </p>

      <div id="form-bairros"></div>
      <?php
    }
    ?>
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
