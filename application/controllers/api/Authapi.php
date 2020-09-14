<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

/*
 * Changes:
 * 1. This project contains .htaccess file for windows machine.
 *    Please update as per your requirements.
 *    Samples (Win/Linux): http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva
 *
 * 2. Change 'encryption_key' in application\config\config.php
 *    Link for encryption_key: http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/
 * 
 * 3. Change 'jwt_key' in application\config\jwt.php
 *
 */

class Authapi extends REST_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->library([
        "Utilities",
        "Captcha",
        "Auth_Ldap",
        "table"
    ]);
    $this->load->model([
        "Captcha_model",
        "Users/Users_model",
        'Deportes/Deportes_model'
    ]);
    $this->load->helper(['url', "form"]);
}

  public function deportes_list_get(){
    $data = $this->Deportes_model->get();
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function forgot_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());

    if ($this->form_validation->run('forgot_api') == FALSE) {
      $errors = $this->validation_errors();
      $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
      $user_email = $this->post('email');

      $user = $this->Users_model->getUserByEmail($user_email);

      if (!$user || $user->es_google_login == 1 || $user->es_facebook_login == 1) {
        $this->set_response(['result' => 'error', 'error'=>"Correo no registrado."], REST_Controller::HTTP_OK);
        return;
      }

      $user_activation_code = rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);

      $db_data = [
        'user_activation_code' => $user_activation_code
      ];

      $this->Users_model->update($user->id, $db_data);

      $content_email = file_get_contents('./assets/templates/email/reestablecer.html');
      $content_email = str_replace("[Nombre]", $user->nombre . ' ' . $user->apellido, $content_email);
      $content_email = str_replace("[000]", $user_activation_code, $content_email);
      $this->utilities->sendMail($user_email, "GAME ON! - Código para restablecimiento de contraseña", $content_email);

      $this->set_response(['result' => 'success', 'email' => $user->user_email], REST_Controller::HTTP_OK);
    }
  }

  public function validate_code_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());

    if ($this->form_validation->run('validate_code_api') == FALSE) {
      $errors = $this->validation_errors();
      $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
      $codigo = $this->post('codigo');

      $user = $this->Users_model->getUserByCode($codigo);

      if (!$user) {
        $this->set_response(['result' => 'error', 'error'=>"Código no válido."], REST_Controller::HTTP_OK);
        return;
      }

      $db_data = [
        'user_activation_code' => null
      ];

      $this->Users_model->update($user->id, $db_data);

      $this->set_response(['result' => 'success', 'email' => $user->user_email], REST_Controller::HTTP_OK);
    }
  }

  public function confirm_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());

    if ($this->form_validation->run('confirm_api') == FALSE) {
      $errors = $this->validation_errors();
      $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
      $contrasena = $this->post('password');
      $email = $this->post('email');

      $user = $this->Users_model->getUserByEmail($email);

      if (!$user) {
        $this->set_response(['result' => 'error', 'error'=>"Correo no es válido."], REST_Controller::HTTP_OK);
        return;
      }

      $user_salt = $this->utilities->random_salt();
      $user_pass_hash = $this->utilities->hash_passwd($contrasena, $user_salt);

      $db_data = [
        'user_pass' => $user_pass_hash,
      ];

      $this->Users_model->update($user->id, $db_data);

      $this->set_response(['result' => 'success'], REST_Controller::HTTP_OK);
    }
  }

  public function signin_post()
  {
    //var_dump($this->auth);
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());

    if ($this->form_validation->run('signin_api') == FALSE) {
      $errors = $this->validation_errors();
      $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
      $user_email = $this->post('usuario');
      $user_pass = $this->post('contraseña');

      $user = $this->Users_model->getUserByEmail($user_email);

      if (!$user) {
        $this->set_response(['result' => 'error', 'error'=>$this->lang->line('users_error_signin')], REST_Controller::HTTP_OK);
        return;
      }

      $check_passwd = $this->utilities->check_passwd($user->user_pass, $user->user_salt, $user_pass);

      if (!$check_passwd) {
        $this->set_response(['result' => 'error', 'error'=>$this->lang->line('users_error_signin')], REST_Controller::HTTP_OK);
        return;
      }

      $this->valida_login($user);
      
      $role = $this->Roles_model->get($user->user_role_id);

      

      //$date = date('Y-d-m H:s:i');
      //$date = date('Y-m-d H:s:i');
      $date = date($this->config->item('log_date_format'));
      
      $db_data = [
          'user_date_lastlogin' => $date,
          'ip' => $_SERVER['REMOTE_ADDR'],
          'navegador' => (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""),
      ];

      $this->Users_model->update($user->id, $db_data);

      $tokenData = array();
      $tokenData['user_id'] = $user->id;
      $tokenData['user_name'] = $user->nombre;
      $tokenData['nickname'] = $user->user_name;
      $tokenData['user_email'] = $user->user_email;
      $tokenData['is_logged_in'] = TRUE;
      $tokenData['user_role'] = $user->user_role_id;
      $tokenData['user_role_name'] = $role->role;
      $tokenData['user_last_login'] = $user->user_date_lastlogin;
      $tokenData['is_super_admin'] = $user->is_super_admin;
      $tokenData['user_img'] = $user->user_img_profile;
      $tokenData['es_google_login'] = 0;
      $tokenData['es_facebook_login'] = 0;
      
      $output['token'] = AUTHORIZATION::generateToken($tokenData);
      $output['deporte_id_default'] = DEPORTE_ID_DEFAULT;
      $output['user_id'] = $user->id;
      $output['user_name'] = $user->nombre;
      $output['nickname'] = $user->user_name;
      $output['user_email'] = $user->user_email;
      $output['user_role'] = $user->user_role_id;
      $output['user_img'] = $user->user_img_profile;
      $output['result'] = 'success'; 
      $output['es_google_login'] = 0;
      $output['es_facebook_login'] = 0;

      
      $this->set_response($output, REST_Controller::HTTP_OK);
    }
  }

  public function valida_login($data) {
    if ($data->user_status_id == 2 || $data->user_status_id == 3) {
      $this->set_response(['result' => 'error', 'error'=>$this->lang->line('auth_error_user_deleted')], REST_Controller::HTTP_OK);
      exit();
    }
  }
}