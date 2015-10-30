<?php
require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresContactAPI extends DoloresBaseAPI {
  function post($request) {
    if (is_user_logged_in()) {
      $user = wp_get_current_user();
      $name = $user->display_name;
      $email = $user->user_email;
    } else {
      $name = $request['data']['name'];
      $email = $request['data']['email'];

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->_error('O e-mail digitado é inválido.');
      }
    }

    $subject = $request['data']['subject'];
    $message = $request['data']['message'];

    $headers = "Content-type: text/plain; charset=utf-8\r\n";
    $headers.= "From: $name <$email>\r\n";

    $to = get_option('admin_email');

    if (!wp_mail($to, $subject, $message, $headers)) {
      $this->_error('Erro ao enviar mensagem.');
    }

    return array();
  }
};
