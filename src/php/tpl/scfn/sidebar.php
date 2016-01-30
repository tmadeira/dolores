<section class="single-sidebar">
  <?php
  $author_url = DoloresOGSettings::get_author_url();
  if ($author_url) {
    ?>
    <div class="sidebar-section">
      <h2 class="sidebar-title">Curta no Facebook</h2>
      <div class="fb-page" data-href="<?php echo $author_url; ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false" style="height: 215px;"></div>
    </div>
    <?php
  }
  ?>

  <?php
  if (is_single()) {
    $yarpp_args = array(
        'post_type' => 'post',
        'template' => 'yarpp-template-posts.php'
    );
    if (function_exists('yarpp_related') && yarpp_related_exist($yarpp_args)) {
      ?>
      <div class="sidebar-section">
        <h2 class="sidebar-title">Leia também</h2>
        <?php
        yarpp_related($yarpp_args);
        ?>
      </div>
      <?php
    }
  }
  ?>

  <div class="sidebar-section">
    <h2 class="sidebar-title">Participe</h2>
    <div style="text-align:center;">
      <button
          class="grid-ideias-button"
          onclick="DoloresAuthenticator.signIn(null, function() { location.href = '/temas'; })"
      >
        Dê suas ideias para a cidade!
      </button>
    </div>
  </div>
</section>