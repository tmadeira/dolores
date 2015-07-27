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
    $query = "SELECT name, latitude, longitude FROM dolores_locations";
    $this->locations = $wpdb->get_results($query, OBJECT_K);
  }

  public function is_valid_location($value) {
    return array_key_exists($value, $this->locations);
  }
};
