<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresSigninAPI extends DoloresBaseAPI {
  function post($request) {
    if ($request['type'] == 'facebook') {
      return $this->signinViaFacebook($request);
    }
    return array('request' => $request);
  }

  function signinViaFacebook($request) {
    $accessToken = $request['token'];

    $url = 'https://graph.facebook.com/oauth/access_token?client_id=<app_id>' .
        '&client_secret=<app_secret>&fb_exchange_token=<token>' .
        '&grant_type=fb_exchange_token';

    $url = str_replace('<app_id>', FACEBOOK_APP_ID, $url);
    $url = str_replace('<app_secret>', FACEBOOK_APP_SECRET, $url);
    $url = str_replace('<token>', $accessToken, $url);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);

    if (strpos($result, 'error') !== false ||
        strpos($result, 'access_token') !== 0) {
      $this->_error('Erro na autenticação com Facebook.');
    }

    // TODO: Get/store token
    // https://developers.facebook.com/docs/php/howto/example_facebook_login/4.0.0
    // TODO: Get ID and basic user info
    // "/me?fields=id,name,email,picture.type(large)"
    // TODO: If ID in DB, sign in user and tell client to "refresh"
    // TODO: Else, send info to client

    return array('curl_response' => $result);
  }
};
