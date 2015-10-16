<?php
require_once(__DIR__ . '/../locations.php');
require_once(__DIR__ . '/../wp_util/user_meta.php');

require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresUserInfoAPI extends DoloresBaseAPI {
  private $fields = array(
    'picture',
    'location',
    'phone',
    'birthdate',
    'occupation',
    'school',
    'course',
    'interests',
    'collaboration'
  );

  function get($request) {
    if (!is_user_logged_in()) {
      $this->_error('Esta ação requer que o usuário esteja autenticado.');
    }

    $user = wp_get_current_user();

    $info = array(
      'name' => $user->display_name,
      'email' => $user->user_email
    );
    foreach ($this->fields as $key) {
      $info[$key] = get_user_meta($user->ID, $key, true);
      if (($key == "interests" || $key == "collaboration") && !$info[$key]) {
        $info[$key] = array();
      }
    }

    return array('data' => $info);
  }

  function post($request) {
    /*
    $email = $request['email'];
    $phone = $request['phone'];
    $location = $request['location'];
    */
    $birthdate = $request['birthdate'];
    $occupation = $request['occupation'];
    $school = $request['school'];
    $course = $request['course'];
    $interests = $request['interests'];
    $collab = $request['collaboration'];

    $form_errors = array();

    /*
    // Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_errors['email'] = 'O e-mail digitado é inválido.';
    } else {
      $user_by_email = get_user_by('email', $value);
      if ($user_by_email !== false) {
        $form_errors['email'] = 'Este e-mail já está cadastrado.';
      }
    }

    // Phone
    if (strlen($phone)) {
      $phone = preg_replace('/[^0-9]/', '', $phone);
      if (strlen($phone) < 10 || strlen($phone) > 11) {
        $form_errors['phone'] = 'O telefone digitado é inválido.';
      }
    }

    // Location
    $locations = DoloresLocations::get_instance();
    if (!$locations->is_valid_location($location)) {
      $form_errors['location'] = 'Escolha uma localização válida.';
    }
    */

    // Birthdate
    if (strlen($birthdate)) {
      list($day, $month, $year) = explode('/', $birthdate);
      $birthdate = sprintf("%04d-%02d-%02d", $year, $month, $day);
      $current_year = date("Y");
      if (!checkdate($month, $day, $year) ||
          $year >= $current_year ||
          $year < $current_year - 150) {
        $form_errors['birthdate'] = 'A data digitada é inválida.';
      }
    }

    if (count($form_errors) > 0) {
      $this->_response(400, array('formErrors' => $form_errors));
    }

    if (!is_user_logged_in()) {
      $this->_error('Erro de autenticação.');
    }

    $user = wp_get_current_user();
    $user_id = $user->ID;

    /*
    if (!dolores_update_user_meta($user_id, 'phone', $phone)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (!dolores_update_user_meta($user_id, 'location', $location)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }
    */

    if (!dolores_update_user_meta($user_id, 'birthdate', $birthdate)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (!dolores_update_user_meta($user_id, 'occupation', $occupation)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (!dolores_update_user_meta($user_id, 'school', $school)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (!dolores_update_user_meta($user_id, 'course', $course)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if ($interests && !is_array($interests)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (!dolores_update_user_meta($user_id, 'interests', $interests)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if ($collab && !is_array($collab)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (!dolores_update_user_meta($user_id, 'collaboration', $collab)) {
      $this->_error('Não foi possível cadastrar algumas informações.');
    }

    if (defined('MAILCHIMP_API_KEY') && defined('MAILCHIMP_LIST_ID')) {
      require_once(__DIR__ . '/../external/mailchimp.php');
      $MailChimp = new DoloresMailChimp(MAILCHIMP_API_KEY);
      $MailChimp->fireAndForget('lists/update-member', array(
        'id' => MAILCHIMP_LIST_ID,
        'email' => array('email' => $user->user_email),
        'merge_vars' => array(
          //'EMAIL' => $email,
          //'CELULAR' => $phone,
          //'BAIRRO' => $location,
          'TEMAS' => is_array($interests) ? implode(", ", $interests) : "",
          'AREAS' => is_array($collab) ? implode(", ", $collab) : "",
          'NASCIMENTO' => $birthdate,
          'PROFISSAO' => $occupation,
          'ESCOLA' => $school,
          'CURSO' => $course
        )
      ));
    }

    /*
    wp_update_user(array(
      'ID' => $user->ID,
      'user_email' => $email
    ));
    */

    return array('action' => 'refresh');
  }
};
