<?php
class DoloresUsers {
  public static function getUserByFacebookID($fbId) {
    $users = get_users(array(
      'meta_key' => 'facebook_id',
      'meta_value' => $fbId,
      'fields' => array('ID', 'user_login')
    ));

    if (count($users) === 1) {
      return $users[0];
    }

    return null;
  }
};
