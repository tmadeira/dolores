<div class="map-svg-container">
  <div class="map-title-container">
    <h2 class="map-title">Escolha seu bairro para participar da discussão</h2>

    <div class="local-list-container">
      <select class="local-list">
        <option value="">Lista de bairros&hellip;</option>
        <?php
        $taxonomy = 'local';
        $terms = get_terms($taxonomy, array(
          'hide_empty' => false
        ));
        foreach ($terms as $term) {
          ?>
          <option value="<?php echo $term->slug; ?>">
            <?php echo $term->name; ?>
          </option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>

  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="130 0 580 850" class="map-svg" xml:space="preserve">
  <defs>
    <filter x="0" y="0" width="1" height="1" id="solid">
      <feFlood flood-color="#2C0E28"/>
      <feComposite in="SourceGraphic"/>
    </filter>
  </defs>
  <?php require("svg-map.php"); ?>
  </svg>
</div>
