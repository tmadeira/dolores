<?php
require_once(__DIR__ . '/assets.php');

define('THRESHOLD_TO_ACTIVATE_LOCATION', 50);

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

  public function get_user_count($location) {
    global $wpdb;

    if (is_string($location)) {
      if (!isset($this->locations[$location])) {
        return 0;
      }
      $location = $this->locations[$location];
    }

    $sql = <<<SQL
SELECT COUNT(user_id)
  FROM {$wpdb->usermeta}
  WHERE meta_key = 'location' AND meta_value = %s
SQL;

    $query = $wpdb->prepare($sql, $location->name);
    return intval($wpdb->get_var($query));
  }

  public function get_missing($location) {
    if (is_string($location)) {
      if (!isset($this->locations[$location])) {
        return 0;
      }
      $location = $this->locations[$location];
    }
    $missing = THRESHOLD_TO_ACTIVATE_LOCATION - $this->get_user_count($location);
    if ($missing <= 0) {
      update_term_meta($location->term_id, 'active', 1);
      $missing = 1;
    }
    return $missing;
  }

  public function get_active() {
    return get_terms('local', array(
        'hide_empty' => false,
        'meta_query' => array(
          array(
            'key' => 'active',
            'value' => '1'
          )
        )
    ));
  }

  public function get_ranking() {
    global $wpdb;

    $sql = <<<SQL
SELECT meta_value AS location, COUNT(user_id) AS count
  FROM {$wpdb->usermeta}
  WHERE meta_key = 'location'
  GROUP BY meta_value
  ORDER BY count DESC
SQL;

    return $wpdb->get_results($sql);
  }
};
