<?php
require_once(DOLORES_PATH . '/dlib/posts.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresCommentAPI extends DoloresBaseAPI {
  function post($request) {
    $comment = DoloresPosts::add_new_comment(
      $request['text'],
      $request['postId'],
      $request['parent']
    );

    if (is_array($comment) && array_key_exists('error', $comment)) {
      $this->_error($comment['error']);
    }

    return $comment;
  }
};
