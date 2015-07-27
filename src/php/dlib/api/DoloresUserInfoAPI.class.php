<?php
require_once(__DIR__ . '/../wp_util/user_meta.php');

require_once(__DIR__ . '/DoloresBaseAPI.class.php');

class DoloresUserInfoAPI extends DoloresBaseAPI {
  function post($request) {
    $name = $request['full_name'];
    $phone = $request['phone'];
    $birthdate = $request['birthdate'];
    $occupation = $request['occupation'];
    $school = $request['school'];
    $course = $request['course'];

    $errors = array();

    if (strlen($phone)) {
      $phone = preg_replace('/[^0-9]/', '', $phone);
      if (strlen($phone) < 10 || strlen($phone) > 11) {
        $errors['phone'] = 'O telefone digitado é inválido.';
      }
    }

    if (strlen($birthdate)) {
      list($day, $month, $year) = explode('/', $birthdate);
      $birthdate = sprintf("%04d-%02d-%02d", $year, $month, $day);
      $current_year = date("Y");
      if (!checkdate($month, $day, $year) ||
          $year >= $current_year ||
          $year < $current_year - 150) {
        $errors['birthdate'] = 'A data digitada é inválida.';
      }
    }

    if (count($errors) > 0) {
      $this->_response(400, $errors);
    }

    if (!is_user_logged_in()) {
      $this->_error('Erro de autenticação.');
    }

    $user = wp_get_current_user();
    $user_id = $user->ID;

    if (strlen($name)) {
      $update = wp_update_user(array(
        'ID' => $user_id,
        'nickname' => $name,
        'display_name' => $name
      ));

      if (is_wp_error($update)) {
        $this->_error($update->get_error_message());
      }
    }

    if (strlen($phone)) {
      if (!dolores_update_user_meta($user_id, 'phone', $phone)) {
        $this->_error('Não foi possível cadastrar seu telefone.');
      }
    }

    if (strlen($birthdate)) {
      if (!dolores_update_user_meta($user_id, 'birthdate', $birthdate)) {
        $this->_error('Não foi possível cadastrar sua data de nascimento.');
      }
    }

    if (strlen($occupation)) {
      if (!dolores_update_user_meta($user_id, 'occupation', $occupation)) {
        $this->_error('Não foi possível cadastrar sua profissão.');
      }
    }

    if (strlen($school)) {
      if (!dolores_update_user_meta($user_id, 'school', $school)) {
        $this->_error('Não foi possível cadastrar sua instituição de ensino.');
      }
    }

    if (strlen($course)) {
      if (!dolores_update_user_meta($user_id, 'course', $course)) {
        $this->_error('Não foi possível cadastrar seu curso.');
      }
    }

    return array();
  }
};
