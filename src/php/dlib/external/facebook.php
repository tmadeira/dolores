<?php
require_once(DOLORES_PATH . '/vendor/autoload.php');

class DoloresFacebook {
  public function __construct() {
    $this->fb = new Facebook\Facebook(array(
      'app_id' => FACEBOOK_APP_ID,
      'app_secret' => FACEBOOK_APP_SECRET,
      'default_graph_version' => 'v2.4'
    ));
  }

  public function authenticate($token) {
    $oAuth2Client = $this->fb->getOAuth2Client();
    $accessToken = new Facebook\Authentication\AccessToken($token);

    try {
      $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\Exception $e) {
      return array('error' => 'Erro na autenticação com Facebook.');
    }

    $fields = 'id,name,email,picture.type(large)';
    try {
      $response = $this->fb->get('/me?fields=' . $fields, $accessToken);
      $fbUser = $response->getGraphUser();
    } catch (Facebook\Exceptions\Exception $e) {
      return array('error' => 'Erro ao solicitar informações para o Facebook.');
    }

    return array(
      'type' => 'facebook',
      'id' => $fbUser['id'],
      'name' => $fbUser['name'],
      'email' => $fbUser['email'],
      'picture' => $fbUser['picture']['url']
    );
  }
};
