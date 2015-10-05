<?php
class DoloresAuthCache {
  public function __construct() {
    global $wpdb;
    $this->table_name = $wpdb->prefix . 'dolores_auth_cache';

    if (!$this->table_exists()) {
      $this->create_table();
    }
  }

  private function create_table() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = <<<SQL
CREATE TABLE {$this->table_name} (
  auth CHAR(64) PRIMARY KEY,
  serialized_data text,
  cache_date timestamp DEFAULT CURRENT_TIMESTAMP
) {$charset_collate};
SQL;
    $wpdb->query($sql);
  }

  private function table_exists() {
    global $wpdb;
    $sql = "SHOW TABLES LIKE '{$this->table_name}'";
    return $wpdb->get_var($sql) === $this->table_name;
  }

  private function hash_auth($auth) {
    return hash("sha256", "{$auth['type']}/{$auth['code']}");
  }

  public function store($auth, $data) {
    global $wpdb;
    $fields = array(
      'auth' => $this->hash_auth($auth),
      'serialized_data' => serialize($data)
    );
    $wpdb->insert($this->table_name, $fields);
  }

  public function get($auth) {
    global $wpdb;
    $hash = $this->hash_auth($auth);
    $sql = "SELECT serialized_data FROM {$this->table_name} WHERE
      auth = '{$hash}'";
    $result = $wpdb->get_var($sql);
    return $result ? unserialize($result) : null;
  }
};
