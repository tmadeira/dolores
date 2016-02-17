<?php
add_image_size('grid-thumbnail', 350, 230, true);
require_once(DOLORES_TEMPLATE_PATH . '/grid.php');

function dolores_random_orderby() {
  return "RAND()";
}
