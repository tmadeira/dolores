<?php
require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresSubscribeAPI extends DoloresBaseAPI {
  function post($request) {
    $email = $request['data']['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->_error('O e-mail digitado é inválido.');
    }

    $phone = '';
    if (array_key_exists('phone', $request['data'])) {
      $phone = $request['data']['phone'];
    }

    $location = '';
    if (array_key_exists('location', $request['data'])) {
      $location = $request['data']['location'];
    }

    $origin = 'Sidebar';
    if (array_key_exists('origin', $request['data'])) {
      $origin = $request['data']['origin'];
    }

    // TODO: Check Mailchimp duplicate subscribes
    if (defined('MAILCHIMP_API_KEY') && defined('MAILCHIMP_LIST_ID')) {
      require_once(DOLORES_PATH . '/dlib/external/mailchimp.php');
      $MailChimp = new DoloresMailChimp(MAILCHIMP_API_KEY);
      $MailChimp->fireAndForget('lists/subscribe', Array(
        'id' => MAILCHIMP_LIST_ID,
        'email' => array('email' => $email),
        'merge_vars' => array(
          'ORIGEM' => 'Site',
          'CADASTRO' => $origin,
          'CELULAR' => $phone,
          'BAIRRO' => $location
        ),
        'double_optin' => false
      ));
    }

    return array();
  }
};
