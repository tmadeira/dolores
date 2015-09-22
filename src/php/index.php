<?php
if (dolores_get_version() < 2) {
  require("v1_index.php");
} else {
  require("v2_index.php");
}
