<?php
class DoloresPosts {
  const taxonomy = 'tema';
  const type = 'ideia';

  public static function add_new_post($title, $text, $cat, $tags) {
    if (!is_user_logged_in()) {
      return array('error' => 'Apenas usuários cadastrados podem fazer isto.');
    }

    $user = wp_get_current_user();

    $title = trim($title);
    if (strlen($title) < 10 || strlen($title) > 100) {
      return array('error' => 'O título deve ter entre 10 e 100 caracteres.');
    }
    $title = str_replace('<', '&lt;', $title);
    $title = str_replace('>', '&gt;', $title);

    $text = trim($text);
    if (strlen($text) > 600) {
      return array('error' => 'O texto deve ter no máximo 600 caracteres.');
    }
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);

    $post = array(
      'post_title' => $title,
      'post_content' => $text,
      'post_status' => 'publish',
      'post_type' => DoloresPosts::type,
      'post_author' => $user->ID,
      'ping_status' => 'closed'
    );

    $inserted = wp_insert_post($post);
    if (!$inserted) {
      return array('error' => 'Erro ao cadastrar ideia.');
    }

    // TODO: validate terms

    $terms = array_merge(array($cat), explode(',', $tags));
    wp_set_object_terms($inserted, $terms, DoloresPosts::taxonomy);

    return array('url' => get_permalink($inserted));
  }

  public static function add_new_comment($text, $post_id, $parent = 0) {
    global $_SERVER;

    if (!is_user_logged_in()) {
      return array('error' => 'Apenas usuários cadastrados podem fazer isto.');
    }

    $user = wp_get_current_user();

    if (!comments_open($post_id)) {
      return array('error' => 'Esta ideia não aceita comentários.');
    }

    $text = trim($text);
    if (strlen($text) > 600) {
      return array('error' => 'O texto deve ter no máximo 600 caracteres.');
    }
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);

    $comment = array(
      'user_id' => $user->ID,
      'comment_author' => $user->display_name,
      'comment_author_email' => $user->user_email,
      'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
      'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
      'comment_post_ID' => $post_id,
      'comment_parent' => $parent,
      'comment_content' => $text
    );

    if (!wp_insert_comment($comment)) {
      return array('error' => 'Erro ao cadastrar comentário.');
    }

    return array();
  }
};
