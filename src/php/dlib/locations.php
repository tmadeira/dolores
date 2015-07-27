<?php
class DoloresLocations {
  private static $instance;
  private $locations;

  public static function get_instance() {
    if (null === static::$instance) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  private function __construct() {
    global $wpdb;
    $query = "SELECT name, latitude, longitude FROM dolores_locations
              ORDER BY name ASC";
    $this->locations = $wpdb->get_results($query, OBJECT_K);

    foreach ($this->locations as $key => $obj) {
      $obj->clean_name = remove_accents($key);
    }
  }

  public function is_valid_location($value) {
    return array_key_exists($value, $this->locations);
  }

  public function get_suggestions($value) {
    $value = remove_accents($value);
    $suggestions = array();
    foreach ($this->locations as $key => $obj) {
      if (stripos($obj->clean_name, $value) !== FALSE) {
        $suggestions[] = $key;
      }
    }
    return $suggestions;
  }
};
