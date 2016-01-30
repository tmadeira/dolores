<?php
require_once(DOLORES_PATH . '/dlib/interact.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresVoteAPI extends DoloresBaseAPI {
  function post($request) {
    $post_id = array_key_exists('post_id', $request) ? $request['post_id'] : 0;
    $comment_id =
      array_key_exists('comment_id', $request) ? $request['comment_id'] : 0;

    $post_id = intval($post_id);
    $comment_id = intval($comment_id);

    $interact = new DoloresInteract();
    $vote = $interact->vote($post_id, $comment_id, $request['action']);

    if (is_array($vote) && array_key_exists('error', $vote)) {
      $this->_error($vote['error']);
    }

    return $this->get($request);
  }

  function get($request) {
    $post_id = array_key_exists('post_id', $request) ? $request['post_id'] : 0;
    $comment_id =
      array_key_exists('comment_id', $request) ? $request['comment_id'] : 0;

    $post_id = intval($post_id);
    $comment_id = intval($comment_id);

    $interact = new DoloresInteract();
    if ($post_id) {
      $votes = $interact->get_post_votes($post_id);
    } else {
      $votes = $interact->get_comment_votes($comment_id);
    }

    return array(
      'up' => $votes[0],
      'down' => $votes[1],
      'voted' => $votes[2]
    );
  }
};
