<?php
class DoloresAssets {
  public static function get_static_uri($file) {
    return get_template_directory_uri() . '/static/' . $file;
  }

  public static function get_image_uri($file) {
    return DoloresAssets::get_static_uri('images/' . $file);
  }
};
