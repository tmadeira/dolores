<?php
require_once(DOLORES_PATH . '/dlib/locations.php');
require_once(DOLORES_PATH . '/dlib/mailer.php');
require_once(DOLORES_PATH . '/dlib/wp_util/user_meta.php');

require_once(DOLORES_PATH . '/dlib/api/DoloresBaseAPI.class.php');

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

    DoloresMailer::update_member(array(
      'type' => 'user',
      'email' => $user->user_email,
      'temas' => is_array($interests) ? implode(", ", $interests) : "",
      'areas' => is_array($collab) ? implode(", ", $collab) : "",
      'nascimento' => $birthdate,
      'profissao' => $occupation,
      'escola' => $school,
      'curso' => $course
    ));

    return array('action' => 'refresh');
  }
};
