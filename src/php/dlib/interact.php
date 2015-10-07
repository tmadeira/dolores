<?php
class DoloresInteract {
  private $field_up = 'dolores_votes_up';
  private $field_down = 'dolores_votes_down';

  public function __construct() {
    global $wpdb;
    $this->table_name = $wpdb->prefix . 'dolores_interact';

    if (!$this->table_exists()) {
      $this->create_table();
    }
  }

  private function create_table() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $sql = <<<SQL
CREATE TABLE {$this->table_name} (
  user_id BIGINT(20) UNSIGNED NOT NULL,
  post_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  comment_id BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
  action ENUM('up', 'down') NOT NULL,
  time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, post_id, comment_id)
) {$charset_collate};
SQL;
    $wpdb->query($sql);
  }

  private function table_exists() {
    global $wpdb;
    $sql = "SHOW TABLES LIKE '{$this->table_name}'";
    return $wpdb->get_var($sql) === $this->table_name;
  }

  private function update_count($object) {
    $post_id = array_key_exists('post_id', $object) ? $object['post_id'] : 0;
    $comment_id =
      array_key_exists('comment_id', $object) ? $object['comment_id'] : 0;

    $post = get_post(intval($post_id));
    $comment = get_comment(intval($comment_id));

    if ($post) {
      list($up, $down) = $this->get_post_votes($post->ID, true);
      update_post_meta($post->ID, $this->field_up, $up);
      update_post_meta($post->ID, $this->field_down, $down);
    }

    if ($comment) {
      list($up, $down) = $this->get_comment_votes($comment->ID, true);
      update_comment_meta($comment->ID, $this->field_up, $up);
      update_comment_meta($comment->ID, $this->field_down, $down);
    }
  }

  public function get_post_votes($post_id, $calculate = false) {
    global $wpdb;
    $post_id = intval($post_id);

    if (!$calculate) {
      $up = get_post_meta($post_id, $this->field_up, true);
      $down = get_post_meta($post_id, $this->field_down, true);
      return array($up ? intval($up) : 0, $down ? intval($down) : 0);
    }

    $sql = <<<SQL
SELECT action, COUNT(*) AS count FROM {$this->table_name} WHERE
  post_id = '$post_id' GROUP BY action
SQL;

    $votes = array('up' => 0, 'down' => 0);
    $results = $wpdb->get_results($sql);
    foreach ($results as $result) {
      $votes[$result->action] = intval($result->count);
    }
    return array($votes['up'], $votes['down']);
  }

  public function get_comment_votes($comment_id, $calculate = false) {
    global $wpdb;
    $comment_id = intval($comment_id);

    if (!$calculate) {
      $up = get_comment_meta($comment_id, $this->field_up, true);
      $down = get_comment_meta($comment_id, $this->field_down, true);
      return array($up ? intval($up) : 0, $down ? intval($down) : 0);
    }

    $sql = <<<SQL
SELECT action, COUNT(*) AS count FROM {$this->table_name} WHERE
  comment_id = '$comment_id' GROUP BY action
SQL;

    $votes = array('up' => 0, 'down' => 0);
    $results = $wpdb->get_results($sql);
    foreach ($results as $result) {
      $votes[$result->action] = intval($result->count);
    }
    return array($votes['up'], $votes['down']);
  }

  public function vote($object) {
    global $wpdb;

    if (!is_user_logged_in()) {
      return array('error' => 'Você precisa estar loggado para fazer isto.');
    }

    $post_id = array_key_exists('post_id', $object) ? $object['post_id'] : 0;
    $comment_id =
      array_key_exists('comment_id', $object) ? $object['comment_id'] : 0;
    $action = $object['action'];

    if ($action !== 'up' && $action !== 'down') {
      return array('error' => 'Ação não encontrada.');
    }

    $post = get_post(intval($post_id));
    $comment = get_comment(intval($comment_id));

    if ((!$post && !$comment) || ($post && $comment)) {
      return array('error' => 'Comentário não encontrado.');
    }

    $fields = array(
      'user_id' => wp_get_current_user()->ID,
      'post_id' => $post ? $post->ID : 0,
      'comment_id' => $comment ? $comment->ID : 0,
      'action' => $action
    );

    $wpdb->insert($this->table_name, $fields);
    $this->update_count($fields);
  }

  public function voted($object) {
    global $wpdb;

    if (!is_user_logged_in()) {
      return array('error' => 'Você precisa estar loggado para fazer isto.');
    }

    $user_id = wp_get_current_user()->ID;
    $post_id = array_key_exists('post_id', $object) ? $object['post_id'] : 0;
    $comment_id =
      array_key_exists('comment_id', $object) ? $object['comment_id'] : 0;

    $post_id = intval($post_id);
    $comment_id = intval($comment_id);

    $post = get_post($post_id);
    $comment = get_comment($comment_id);

    if ((!$post && !$comment) || ($post && $comment)) {
      return array('error' => 'Comentário não encontrado.');
    }

    $sql = <<<SQL
SELECT COUNT(*) FROM {$this->table_name} WHERE
  user_id = '$user_id' AND
  post_id = '$post_id' AND
  comment_id = '$comment_id'
SQL;

    return $wpdb->get_var($sql) === 1;
  }

  public function unvote($object) {
    global $wpdb;
    $voted = $this->voted($object);
    if (is_array($voted) && array_key_exists('error', $voted)) {
      return $voted;
    }

    if ($voted) {
      $object['user_id'] = wp_get_current_user()->ID;
      $wpdb->delete($this->table_name, $object);
      $this->update_count($object);
    }
  }
};
