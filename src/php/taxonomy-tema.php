<?php
get_header();
?>

<main class="page tema">
  <div class="wrap">
    <div class="tema-video">
      <iframe width="640" height="480" src="https://www.youtube.com/embed/0olRnkEj81Q?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
    </div>

    <div class="tema-info">
      <h2 class="tema-name"><?php single_cat_title(); ?></h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <button class="tema-button-more">Ver diagnóstico</button>
    </div>
  </div>
</main>

<?php
include(__DIR__ . '/grid.php');
?>

<?php
get_footer();
?>
