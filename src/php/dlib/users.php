<?php
class DoloresUsers {
  public static function getUserByUniqueField($field, $value) {
    $users = get_users(array(
      'meta_key' => $field,
      'meta_value' => $value,
      'fields' => array('ID', 'user_login')
    ));

    if (count($users) === 1) {
      return $users[0];
    }

    return null;
  }

  public static function getUserByFacebookID($fbId) {
    return DoloresUsers::getUserByUniqueField('facebook_id', $fbId);
  }

  public static function getUserByGoogleID($googleId) {
    return DoloresUsers::getUserByUniqueField('google_id', $fbId);
  }
};
