<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Userapi extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Users/Users_model',
        'Users/Userinfo_model',
        'Roles/Roles_model',
        'Users/Usuariodeportes_model',
    ]);
    $this->load->library('Utilities');
  }

  public function list_deportes_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = new stdClass();
    $data->deportes = $this->Users_model->getDeportes($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function get_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Users_model->getInfo($user_id);
    $data->deportes = $this->Users_model->getDeportes($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function registration_google_post(){
    $date = date('Y-m-d H:i:s');
    $user_email = $this->post('email');
    $user_pass = $this->post('gtoken');
    $user_first_name = $this->post('nombre');
    $user_last_name = $this->post('apellido');
    $user_img_profile = $this->post('user_img');
    //$user_sport = $this->post('deporte');
    $user_salt = $this->utilities->random_salt();
    $user_date = $date;
    $user_modified = $date;
    $user_activation_code = null;
    //$user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);
    $status = USER_STATUS_ACTIVE;

    $user = $this->Users_model->getUserByEmail($user_email);

    if($user != null && ($user->es_google_login == null || $user->es_google_login == 0)){
        $this->set_response(['result' => 'error', 'error'=>"Su cuenta ya ha sido creada."], REST_Controller::HTTP_OK);
        return;
    }

    $user = $this->Users_model->getUserByEmailG($user_email);

    if (!$user) {
      //json_encode lo convierte en formato json
      

      $user_db = [
        'es_google_login' => 1,
        'user_email' => $user_email,
        'user_salt' => $user_salt,
        'user_pass' => $user_pass,
        'user_role_id' => USER_ROLE,
        'user_date_created' => $user_date,
        'user_modified' => $user_modified,
        'user_activation_code' => $user_activation_code,
        'user_status_id' => $status,
      ];

      $id = $this->Users_model->insert($user_db);

      $nombre_usuario = $this->google_generate_nickname($id);

      $user_db = [
        'user_name' => $nombre_usuario
      ];

      $this->Users_model->update($id, $user_db);
      
      $user_info_db = [
          'id_user' => $id,
          'nombre' => $user_first_name ,
          'apellido' => $user_last_name ,
          'deporte' => null,
          'user_img_profile' => $user_img_profile
      ];

      $id = $this->Userinfo_model->insert($user_info_db);

      $content_email = file_get_contents('./assets/templates/email/mensaje-bienvenida.html');
      $content_email = str_replace("[Nombre]", $user_first_name . ' ' . $user_last_name, $content_email);
      $this->utilities->sendMail($user_email, "GAME ON! - Usuario Registrado", $content_email);

      $user = $this->Users_model->getUserByEmailG($user_email);
    }else{
      if(strpos($user_img_profile, "/") !== false){
        $user_info_db = [
          'user_img_profile' => $user_img_profile
        ];
        
        $id = $this->Userinfo_model->update($user->id, $user_info_db);
      }
    }

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
    $tokenData['es_google_login'] = 1;
    $tokenData['es_facebook_login'] = 0;
    $tokenData['user_img'] = $user->user_img_profile;
    
    $output['token'] = AUTHORIZATION::generateToken($tokenData);
    $output['deporte_id_default'] = DEPORTE_ID_DEFAULT;
    $output['user_id'] = $user->id;
    $output['user_name'] = $user->nombre;
    $output['nickname'] = $user->user_name;
    $output['user_email'] = $user->user_email;
    $output['user_role'] = $user->user_role_id;
    $output['es_google_login'] = 1;
    $output['es_facebook_login'] = 0;
    $output['user_img'] = $user->user_img_profile;
    $output['result'] = 'success';  
  
    $this->set_response($output, REST_Controller::HTTP_OK);
  }

  public function google_generate_nickname($id){
    return "userg" . $id;
  }

  public function facebook_generate_nickname($id){
    return "userf" . $id;
  }

  public function registration_facebook_post(){
    $date = date('Y-m-d H:i:s');
    $user_email = $this->post('email');
    $user_pass = $this->post('fid');
    $user_first_name = $this->post('nombre');
    $user_last_name = $this->post('apellido');
    $user_img_profile = $this->post('user_img');
    //$user_sport = $this->post('deporte');
    $user_salt = $this->utilities->random_salt();
    $user_date = $date;
    $user_modified = $date;
    $user_activation_code = null;
    //$user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);
    $status = USER_STATUS_ACTIVE;

    $user = $this->Users_model->getUserByEmail($user_email);
    

    if($user != null && ($user->es_facebook_login == null || $user->es_facebook_login == 0)){
        $this->set_response(['result' => 'error', 'error'=>"Su cuenta ya ha sido creada."], REST_Controller::HTTP_OK);
        return;
    }
    
    $user = $this->Users_model->getUserByEmailF($user_email);

    if (!$user) {
      //json_encode lo convierte en formato json

      $user_db = [
        'es_facebook_login' => 1,
        'user_email' => $user_email,
        'user_salt' => $user_salt,
        'user_pass' => $user_pass,
        'user_role_id' => USER_ROLE,
        'user_date_created' => $user_date,
        'user_modified' => $user_modified,
        'user_activation_code' => $user_activation_code,
        'user_status_id' => $status,
      ];

      $id = $this->Users_model->insert($user_db);
      
      $nombre_usuario = $this->facebook_generate_nickname($id);

      $user_db = [
        'user_name' => $nombre_usuario
      ];

      $this->Users_model->update($id, $user_db);

      $user_info_db = [
          'id_user' => $id,
          'nombre' => $user_first_name ,
          'apellido' => $user_last_name ,
          'deporte' => null,
          'user_img_profile' => $user_img_profile
      ];

      $id = $this->Userinfo_model->insert($user_info_db);

      $content_email = file_get_contents('./assets/templates/email/mensaje-bienvenida.html');
      $content_email = str_replace("[Nombre]", $user_first_name . ' ' . $user_last_name, $content_email);
      $this->utilities->sendMail($user_email, "GAME ON! - Usuario Registrado", $content_email);

      $user = $this->Users_model->getUserByEmailF($user_email);
    }else{
      if(strpos($user_img_profile, "/") !== false){
        $user_info_db = [
          'user_img_profile' => $user_img_profile
        ];
        
        $id = $this->Userinfo_model->update($user->id, $user_info_db);
      }
    }

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
    $tokenData['es_google_login'] = 0;
    $tokenData['es_facebook_login'] = 1;
    $tokenData['user_img'] = $user->user_img_profile;
    
    $output['token'] = AUTHORIZATION::generateToken($tokenData);
    $output['deporte_id_default'] = DEPORTE_ID_DEFAULT;
    $output['user_id'] = $user->id;
    $output['user_name'] = $user->nombre;
    $output['nickname'] = $user->user_name;
    $output['user_email'] = $user->user_email;
    $output['user_role'] = $user->user_role_id;
    $output['es_google_login'] = 0;
    $output['es_facebook_login'] = 1;
    $output['user_img'] = $user->user_img_profile;
    $output['result'] = 'success';  
  
    $this->set_response($output, REST_Controller::HTTP_OK);
  }
  
  public function actualizar_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());


    $date = date('Y-m-d H:i:s');

    if ($this->form_validation->run("actualizar_user_api") == FALSE) {
        $errors = $this->validation_errors();
        $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
      /*var_dump(@$_FILES['userfile']['name'] != NULL);
      exit();*/
      $user_id = $this->utilities->getDecodedToken()->user_id;
      $user_pass = $this->post('contrasena');
      $user_first_name = $this->post('nombre');
      $user_last_name = $this->post('apellido');
      $user_phone = $this->post('telefono');
      $nombre_usuario = $this->post('nombre_usuario');
      $deportes = $this->post('deportes');
      $user_birthdate = ($this->post('nacimiento') == "" ? null : $this->post('nacimiento'));
      //var_dump($user_birthdate);exit();
      //$user_sport = $this->post('deporte');
      $user_salt = $this->utilities->random_salt();
      $user_date = $date;
      $user_modified = $date;
      $user_activation_code = null;
      $user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);

      $deportes_arr = [];
      if($deportes_arr != ""){
        $deportes_arr = json_decode($deportes);
      }

      $user_img_profile = null;

      if (@$_FILES['userfile']['name'] != NULL) {
        $ram = $this->utilities->randomString(25);
        $file_name = $_FILES['userfile']['name'];
        $tmp = explode('.', $file_name);
        $extension_img = end($tmp);

        $user_img_profile = $ram . '.' . $extension_img;

        $config['upload_path'] = './assets/img/users_img/';
        //              'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp",
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '5000000';
        $config['quality'] = '90%';
        $config['file_name'] = $user_img_profile;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()) {
          $errors = $this->upload->display_errors();
          $this->response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK); 
          return;
        }
      }

      //json_encode lo convierte en formato json
      $user_db = [
          'user_modified' => $user_modified,
          'user_name' => $nombre_usuario,
      ];

      if($user_pass != null && $user_pass != ""){
        $user_db["user_pass"] = $user_pass_hash;
        $user_db["user_salt"] = $user_salt;
      }

      $this->Users_model->update($user_id, $user_db);
      
      $user_info_db = [
          'id_user' => $user_id,
          'nombre' => $user_first_name ,
          'apellido' => $user_last_name ,
          'telefono' => $user_phone ,
          'fec_nacimiento' => $user_birthdate ,
          'deporte' => null,
      ];

      if (@$_FILES['userfile']['name'] != NULL) {
        $user_info_db["user_img_profile"] = $user_img_profile;
      }

      $this->Userinfo_model->update($user_id, $user_info_db);

      $this->Usuariodeportes_model->deleteByUserId($user_id);

      if($deportes_arr != null && $deportes_arr != ""){
        foreach($deportes_arr as $deporte){
          $usuario_deporte_db = [
            'user_id' => $user_id,
            'deporte_id' => $deporte->id,
          ];
  
          $this->Usuariodeportes_model->insert($usuario_deporte_db);
        }
      }
      

      $userId = $this->Users_model->get($user_id);
      $user = $this->Users_model->getUserByEmail($userId->user_email);
      $role = $this->Roles_model->get($user->user_role_id);

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
      $tokenData['es_google_login'] = $user->es_google_login == 1 ? 1 : 0;
      $tokenData['es_facebook_login'] = $user->es_facebook_login == 1 ? 1 : 0;
      $tokenData['user_img'] = $user->user_img_profile;
      
      $output['token'] = AUTHORIZATION::generateToken($tokenData);
      $output['deporte_id_default'] = DEPORTE_ID_DEFAULT;
      $output['user_id'] = $user->id;
      $output['user_name'] = $user->nombre;
      $output['nickname'] = $user->user_name;
      $output['user_email'] = $user->user_email;
      $output['user_role'] = $user->user_role_id;
      $output['es_google_login'] = $user->es_google_login == 1 ? 1 : 0;
      $output['es_facebook_login'] = $user->es_facebook_login == 1 ? 1 : 0;
      $output['user_img'] = $user->user_img_profile;
      $output['result'] = 'success';  
    
      $this->set_response($output, REST_Controller::HTTP_OK);
    }
  }

  public function registration_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());


    $date = date('Y-m-d H:i:s');

    if ($this->form_validation->run("new_user_api") == FALSE) {
        $errors = $this->validation_errors();
        /* poner error customizado para email Su cuenta ya ha sido creada*/
        for($xI=0;$xI<count($errors);$xI++){
          if($errors[$xI] == "El campo Correo Electronico debe contener un valor único."){
            $errors[$xI] = "Su cuenta ya ha sido creada.";
          }
        }
        $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
        $user_email = $this->post('email');
        $nombre_usuario = $this->post('nombre_usuario');
        $user_pass = $this->post('contrasena');
        $user_first_name = $this->post('nombre');
        $user_last_name = $this->post('apellido');
        $user_phone = $this->post('telefono');
        $deportes = $this->post('deportes');
        $user_birthdate = ($this->post('nacimiento') == "" ? null : $this->post('nacimiento'));
        //$user_sport = $this->post('deporte');
        $user_salt = $this->utilities->random_salt();
        $user_date = $date;
        $user_modified = $date;
        $user_activation_code = null;
        $user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);
        $status = USER_STATUS_ACTIVE;

        $deportes_arr = [];
        if($deportes_arr != ""){
          $deportes_arr = json_decode($deportes);
        }

        $user_img_profile = null;

        if (@$_FILES['userfile']['name'] != NULL) {
          $ram = $this->utilities->randomString(25);
          $file_name = $_FILES['userfile']['name'];
          $tmp = explode('.', $file_name);
          $extension_img = end($tmp);

          $user_img_profile = $ram . '.' . $extension_img;

          $config['upload_path'] = './assets/img/users_img/';
          //              'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp",
          $config['allowed_types'] = 'gif|jpg|jpeg|png';
          $config['max_size'] = '5000000';
          $config['quality'] = '90%';
          $config['file_name'] = $user_img_profile;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload()) {
            $errors = $this->upload->display_errors();
            $this->response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK); 
            return;
          }
        }/*else{
          $this->response(['result' => 'error', 'error'=>"La imágen es requerida"], REST_Controller::HTTP_OK); 
          return;
        }*/

        //json_encode lo convierte en formato json
        $user_db = [
            'user_email' => $user_email,
            'user_name' => $nombre_usuario,
            'user_pass' => $user_pass_hash,
            'user_salt' => $user_salt,
            'user_role_id' => USER_ROLE,
            'user_date_created' => $user_date,
            'user_modified' => $user_modified,
            'user_activation_code' => $user_activation_code,
            'user_status_id' => $status,
        ];

        $id = $this->Users_model->insert($user_db);
        
        $user_info_db = [
            'id_user' => $id,
            'nombre' => $user_first_name ,
            'apellido' => $user_last_name ,
            'telefono' => $user_phone ,
            'fec_nacimiento' => $user_birthdate ,
            'deporte' => null,
        ];

        if (@$_FILES['userfile']['name'] != NULL) {
          $user_info_db["user_img_profile"] = $user_img_profile;
        }

        $id = $this->Userinfo_model->insert($user_info_db);

        if($deportes_arr != null && $deportes_arr != ""){
          foreach($deportes_arr as $deporte){
            $usuario_deporte_db = [
              'user_id' => $id,
              'deporte_id' => $deporte->id,
            ];
  
            $this->Usuariodeportes_model->insert($usuario_deporte_db);
          }
        }
        


        $content_email = file_get_contents('./assets/templates/email/mensaje-bienvenida.html');
        $content_email = str_replace("[Nombre]", $user_first_name . ' ' . $user_last_name, $content_email);
        $this->utilities->sendMail($user_email, "GAME ON! - Usuario Registrado", $content_email);

        if (count($id) > 0) {
          $this->response(['result' => 'success'], REST_Controller::HTTP_OK); 
        } else {
          $this->response(['result' => 'error', 'error'=>$this->lang->line('users_error_add')], REST_Controller::HTTP_OK); 
        }
    }
  }
  
}