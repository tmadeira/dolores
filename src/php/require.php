<?php
if (file_exists(DOLORES_TEMPLATE_PATH . '/' . basename(__FILE__))) {
  require(DOLORES_TEMPLATE_PATH . '/' . basename(__FILE__));
} else {
  Header('HTTP/1.1 404 Not Found');
  require(DOLORES_PATH . '/404.php');
}
