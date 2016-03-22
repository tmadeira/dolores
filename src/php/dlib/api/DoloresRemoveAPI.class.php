<?php
require_once(DOLORES_PATH . '/dlib/interact.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresRemoveAPI extends DoloresBaseAPI {
  function post($request) {
    $post_id = array_key_exists('post_id', $request) ? $request['post_id'] : 0;
    $comment_id =
      array_key_exists('comment_id', $request) ? $request['comment_id'] : 0;

    $post_id = intval($post_id);
    $comment_id = intval($comment_id);

    $interact = new DoloresInteract();
    $remove = $interact->remove($post_id, $comment_id);

    if (is_array($remove) && array_key_exists('error', $remove)) {
      $this->_error($remove['error']);
    }

    return array();
  }
};
