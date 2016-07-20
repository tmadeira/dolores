<?php
function dolores_mail($to, $template, $args) {
  $tpl_path = 'templates/' . DOLORES_TEMPLATE . '/' . $template;
  $template = DoloresAssets::get_static_path($tpl_path);
  if (!file_exists($template)) {
    return 0;
  }

  $message = file_get_contents($template);
  if ($message === FALSE) {
    return 0;
  }

  foreach ($args as $key => $value) {
    $message = str_replace('{' . $key . '}', $value, $message);
  }

  preg_match('|<title>(.*)</title>|', $message, $match);
  if (count($match) != 2) {
    return 0;
  }
  $subject = $match[1];

  $headers = "Content-type: text/html; charset=utf-8";
  return wp_mail($to, $subject, $message, $headers);
}

class DoloresMailer {
  public static function subscribe($fields) {
    // Use PPL/MailerLite
    if (defined('USE_PPL') && class_exists('PPL')) {
      $ppl = new PPL(
        PPL_DB_HOST,
        PPL_DB_USER,
        PPL_DB_PASS,
        PPL_DB_NAME,
        MAILERLITE_API_KEY
      );

      $group_id = MAILERLITE_SUBSCRIBERS_GROUP_ID;
      if ($fields['type'] == 'user') {
        $group_id = MAILERLITE_USERS_GROUP_ID;
      }

      $ppl->subscribe($fields, $group_id, false);
      return;
    }

    // If we are not using PPL, we require an email address.
    if (!array_key_exists('email', $fields)) {
      return;
    }

    // Use pure MailerLite
    if (defined('USE_MAILERLITE') && defined('MAILERLITE_API_KEY')) {
      require_once(DOLORES_PATH . '/vendor/autoload.php');
      $api = (new MailerLiteApi\MailerLite(MAILERLITE_API_KEY))->groups();

      $group_id = MAILERLITE_SUBSCRIBERS_GROUP_ID;
      if ($fields['type'] == 'user') {
        $group_id = MAILERLITE_USERS_GROUP_ID;
      }

      $subscriber = array(
        'email' => $fields['email'],
        'fields' => array(
          'name' => $fields['name'],
          'phone' => $fields['phone'],
          'bairro' => $fields['bairro']
        )
      );

      $response = $api->addSubscriber($group_id, $subscriber);
      return;
    }

    // Use MailChimp
    if (defined('MAILCHIMP_API_KEY')) {
      require_once(DOLORES_PATH . '/dlib/external/mailchimp.php');
      $MailChimp = new DoloresMailChimp(MAILCHIMP_API_KEY);
      $MailChimp->fireAndForget('lists/subscribe', array(
        'id' => MAILCHIMP_LIST_ID,
        'email' => array('email' => $fields['email']),
        'merge_vars' => array(
          'ORIGEM' => 'Site',
          'CADASTRO' => $fields['type'] == 'user' ? '' : $fields['origin'],
          'NOME' => $fields['name'],
          'CELULAR' => $fields['phone'],
          'BAIRRO' => $fields['bairro']
        ),
        'double_optin' => false
      ));
    }
  }

  public static function update_member($fields) {
    if (!array_key_exists('email', $fields)) {
      return;
    }

    // Use MailerLite
    if (defined('USE_MAILERLITE')) {
      require_once(DOLORES_PATH . '/vendor/autoload.php');
      $api = (new MailerLiteApi\MailerLite(MAILERLITE_API_KEY))->subscribers();

      $data = array(
        'fields' => array(
          'temas' => $fields['temas'],
          'areas_de_atuacao' => $fields['areas'],
          'data_de_nascimento' => $fields['nascimento'],
          'profissao' => $fields['profissao'],
          'escola' => $fields['escola'],
          'curso' => $fields['curso']
        )
      );

      $api->update($fields['email'], $data);
      return;
    }

    // Use MailChimp
    if (defined('MAILCHIMP_API_KEY')) {
      require_once(DOLORES_PATH . '/dlib/external/mailchimp.php');
      $MailChimp = new DoloresMailChimp(MAILCHIMP_API_KEY);
      $MailChimp->fireAndForget('lists/update-member', array(
        'id' => MAILCHIMP_LIST_ID,
        'email' => array('email' => $fields['email']),
        'merge_vars' => array(
          'TEMAS' => $fields['temas'],
          'AREAS' => $fields['areas'],
          'NASCIMENTO' => $fields['nascimento'],
          'PROFISSAO' => $fields['profissao'],
          'ESCOLA' => $fields['escola'],
          'CURSO' => $fields['curso']
        ),
        'double_optin' => false
      ));
    }
  }
};
