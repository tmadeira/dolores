<?php
require_once(__DIR__ . '/assets.php');

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
    $terms = get_terms('local', array('hide_empty' => false));

    if (count($terms) == 0) {
      $this->setup_locations();
      $terms = get_terms('local', array('hide_empty' => false));
    }

    $this->locations = array();
    foreach ($terms as $location) {
      $location->clean_name = remove_accents($location->name);
      $this->locations[$location->name] = $location;
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

  public function setup_locations() {
    $data_files = array('bairros.csv', 'favelas.csv', 'municipios.csv');
    foreach ($data_files as $file) {
      $path = DoloresAssets::get_static_path('data/locations/' . $file);
      $this->insert_csv($path);
    }
  }

  public function insert_csv($file) {
    $lines = file($file);
    foreach ($lines as $line) {
      list($name, $lat, $lng) = explode(",", $line);
      $this->insert_location($name, $lat, $lng);
    }
  }

  public function insert_location($name, $lat, $lng) {
    $term = wp_insert_term($name, 'local');
    if (is_wp_error($term)) {
      return false;
    }
    update_term_meta($term['term_id'], 'lat', $lat);
    update_term_meta($term['term_id'], 'lng', $lng);
    return true;
  }
};
