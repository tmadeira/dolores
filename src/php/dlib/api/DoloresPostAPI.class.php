<?php
require_once(DOLORES_PATH . '/dlib/posts.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresPostAPI extends DoloresBaseAPI {
  function post($request) {
    $post = DoloresPosts::add_new_post(
      $request['data']['title'],
      $request['data']['text'],
      $request['data']['tema'],
      $request['data']['local'],
      $request['data']['tags']
    );

    if (is_array($post) && array_key_exists('error', $post)) {
      $this->_error($post['error']);
    }

    return $post;
  }
};
