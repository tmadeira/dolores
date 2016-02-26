<?php
$yarpp_args = array(
  'post_type' => 'post',
  'template' => 'yarpp-template-posts.php'
);
if (function_exists('yarpp_related') && yarpp_related_exist($yarpp_args)) {
  ?>
  <div class="sidebar-section">
    <h2 class="sidebar-title">
      <span class="bg-red">Posts relacionados</span>
    </h2>

    <?php
    yarpp_related($yarpp_args);
    ?>
  </div>
  <?php
}
