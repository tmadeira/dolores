<?php
// Add 'paged' class to body if we're not in the 1st page
if ($paged && $paged != 1) {
  function dolores_add_paged_class($classes) {
    $classes[] = 'paged';
    return $classes;
  }

  add_filter('body_class', 'dolores_add_paged_class');
}
