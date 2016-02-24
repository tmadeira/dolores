<section class="single-sidebar">
  <?php
  if (is_singular('post')) {
    require(DOLORES_TEMPLATE_PATH . '/sidebar-related-posts.php');
  } else if (is_singular('ideia')) {
    require(DOLORES_TEMPLATE_PATH . '/sidebar-related-ideias.php');
  }

  require(DOLORES_TEMPLATE_PATH . '/sidebar-signup.php');
  require(DOLORES_TEMPLATE_PATH . '/sidebar-subscribe.php');
  require(DOLORES_TEMPLATE_PATH . '/sidebar-facebook.php');
  ?>
</section>
