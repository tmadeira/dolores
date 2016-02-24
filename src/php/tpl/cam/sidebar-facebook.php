<?php
$author_url = DoloresOGSettings::get_author_url();
if ($author_url) {
  ?>
  <div class="sidebar-section">
    <h2 class="sidebar-title">
      <span class="bg-red">Curta no Facebook</span>
    </h2>
    <div class="fb-page" data-href="<?php echo $author_url; ?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false" style="height: 215px;"></div>
  </div>
  <?php
}
