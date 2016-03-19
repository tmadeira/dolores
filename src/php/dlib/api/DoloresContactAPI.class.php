<?php
require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

class DoloresContactAPI extends DoloresBaseAPI {
  function post($request) {
    if (is_user_logged_in()) {
      $user = wp_get_current_user();
      $name = $user->display_name;
      $email = $user->user_email;
      $phone = get_user_meta($user->ID, 'phone', true);
    } else {
      $name = $request['data']['name'];
      $email = $request['data']['email'];
      $phone = $request['data']['phone'];

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->_error('O e-mail digitado é inválido.');
      }
    }

    $subject = $request['data']['subject'];
    $message = $request['data']['message'];

    $message.= "<br />\n<br />\n";
    $message.= "--<br />\n";
    $message.= "Mensagem enviada através de formulário de contato.<br />\n";
    $message.= "<br />\n";
    $message.= "Nome: $nome<br />\n";
    $message.= "E-mail: $email<br />\n";
    $message.= "Telefone: $phone<br />\n";
    $message.= "Endereço IP: {$_SERVER['REMOTE_ADDR']}<br />\n";
    $message.= "Navegador: {$_SERVER['HTTP_USER_AGENT']}\n";

    $headers = "Content-type: text/plain; charset=utf-8\r\n";
    $headers.= "From: $name <noreply@compartilheamudanca.com.br>\r\n";
    $headers.= "Reply-To: $name <$email>\r\n";

    $to = get_option('admin_email');

    if (!wp_mail($to, $subject, $message, $headers)) {
      $this->_error('Erro ao enviar mensagem.');
    }

    return array();
  }
};
