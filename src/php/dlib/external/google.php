<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

class DoloresGoogle {
  public function __construct() {
    $this->client = new Google_Client();
    $this->client->setClientId(GOOGLE_CLIENT_ID);
    $this->client->setClientSecret(GOOGLE_CLIENT_SECRET);
    $this->client->setRedirectUri('http://' . $_SERVER['HTTP_HOST']);
  }

  public function authenticate($code) {
    $this->client->authenticate($code);
    $ticket = $this->client->verifyIdToken();
    if (!$ticket) {
      return array('error' => 'Erro na autenticação com Google.');
    }

    $data = $ticket->getAttributes();
    $googleId = $data['payload']['sub'];

    $plus = new Google_Service_Plus($this->client);
    $me = $plus->people->get(
      'me',
      array('fields' => 'displayName,emails/value,image/url')
    );

    return array(
      'type' => 'google',
      'id' => $googleId,
      'name' => $me['displayName'],
      'email' => $me['emails'][0]['value'],
      'picture' => str_replace('sz=50', 'sz=300', $me['image']['url']),
    );
  }

  public function getAuthenticatedClient() {
    $this->client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    $accessToken = get_option('google_access_token');
    $this->client->setAccessToken($accessToken);
    if ($this->client->isAccessTokenExpired()) {
      $this->client->refreshToken($this->client->getRefreshToken());
      $accessToken = $this->client->getAccessToken();
      update_option('google_access_token', $accessToken, 'no');
    }
    return $this->client;
  }
};
