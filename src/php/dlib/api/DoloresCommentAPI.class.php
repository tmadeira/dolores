<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

require_once(__DIR__ . '/../posts.php');

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
