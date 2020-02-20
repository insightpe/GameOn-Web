<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author furbox
 */
class Auth extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library([
            "Utilities",
            "Captcha",
            "Sendmail",
            "Auth_Ldap",
            "table"
        ]);
        $this->load->module([
            "users"
        ]);
        $this->load->model([
            "Captcha_model",
            "Users/Users_model"
        ]);
        $this->load->helper(['url', "form"]);
    }

    public function signin() {
        $user_email_str = $this->security->xss_clean(addslashes(strip_tags($this->input->post('user_email', TRUE))));
        $user_pass_str = $this->security->xss_clean(addslashes(strip_tags($this->input->post('user_pass', TRUE))));

      $this->load->library('form_validation');

      if ($this->form_validation->run('signin') == FALSE) {
        $errors = validation_errors();
        echo json_encode(['error'=>$errors]);
      } else {
        $user_email = $this->security->xss_clean(addslashes(strip_tags($this->input->post('user_email', TRUE))));
        $user_pass = $this->security->xss_clean(addslashes(strip_tags($this->input->post('user_pass', TRUE))));
		
        $user = $this->Users_model->getUserByEmail($user_email);
   
        if (!$user) {
            echo json_encode(['error'=>$this->lang->line('users_error_signin')]);
            return;
        }

        $check_passwd = $this->utilities->check_passwd($user->user_pass, $user->user_salt, $user_pass);
    
        if (!$check_passwd) {
            echo json_encode(['error'=>$this->lang->line('users_error_signin')]);
            return;
        }
   
        $this->valida_login($user);
        
        $role = $this->Roles_model->get($user->user_role_id);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->nombre;
        $_SESSION['user_email'] = $user->user_email;
        $_SESSION['is_logged_in'] = TRUE;
        $_SESSION['user_role'] = $user->user_role_id;
        $_SESSION['user_role_name'] = $role->role;
        $_SESSION['user_last_login'] = $user->user_date_lastlogin;
        $_SESSION['is_super_admin'] = $user->is_super_admin;
        $_SESSION['user_img'] = $user->user_img_profile;

        //$date = date('Y-d-m H:s:i');
        //$date = date('Y-m-d H:s:i');
        $date = date($this->config->item('log_date_format'));
        
        $db_data = [
            'user_date_lastlogin' => $date,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'navegador' => (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""),
        ];

        $this->Users_model->update($user->id, $db_data);

        $this->load->helper('cookie');

        delete_cookie("login-remember-me");
        delete_cookie("login-user-email");

        if($this->input->post('login-remember-me', TRUE) != null && $this->input->post('login-remember-me', TRUE) == "on"){
        $cookie= array(
            'name'   => 'login-remember-me',
            'value'  => '1',
            'expire' => '10368000',
        );
        $this->input->set_cookie($cookie);

        $cookie= array(
            'name'   => 'login-user-email',
            'value'  => $user->user_email,
            'expire' => '10368000',
        );
        $this->input->set_cookie($cookie);
        }
        
        echo json_encode(['redirect'=> base_url('dashboard')]);
      }
    }

    public function signout() {
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }

            redirect('inicio-sesion');
        } else {
            redirect('inicio-sesion', 'refresh');
        }
    }
    
    public function form_signin() {
        $data = new stdClass();
        $data->title = APP_NAME . " :: Inicio de Sesión";
        $data->header_description = APP_NAME . " :: Inicio de Sesión";
        $data->appname = APP_NAME;
        $data->user_email = ($this->input->cookie("login-user-email", TRUE) == null ? "" : $this->input->cookie("login-user-email", TRUE));
        $data->recuerdame = ($this->input->cookie("login-remember-me", TRUE) == null ? 0 : $this->input->cookie("login-remember-me", TRUE));

        $this->template->call_signin_template($data);
    }

    public function form_lost_pass() {
        $data = new stdClass();
        $data->title = APP_NAME . " :: Recuperación de Contraseña";

        $this->template->call_lost_pass_template($data);
    }

    public function send_lost_pass() {
        if (@$_SESSION['is_logged_in']) {
            redirect('dashboard');
        }
        $email = $this->input->post('user_email');
        $user = $this->Users_model->getUserByEmail($email);
        
        if (count($user) == 1) {
            $pass = $this->utilities->randomString(8);
            $fechaupdate = date('Y-m-d H:i:s');
            $user_pass_hash = $this->utilities->hash_passwd($pass, $user->user_salt);

            $update = [
                'user_pass' => $user_pass_hash,
                'user_modified' => $fechaupdate
            ];
            $this->db->trans_start();
            $success = $this->Users_model->update($user->id, $update);

            if ($success) {
                $subject = "Recuperacion de Contraseña de " . $this->configs->getAppName();
                $message = "Hemos creado una nueva contraseña para ti, te recomendamos cambiarla despues de acceder a tu cuenta, contraseña: " . $pass;

                if ($this->sendmail->sendMail($email, $subject, $message)) {
                    $this->db->trans_complete();
                    $this->session->set_flashdata('message_success',  "Enviamos su nueva contraseña a su correo.");
                    redirect('inicio-sesion');
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message_error', "Ocurrio un error al enviar su contraseña, contacte con el administrador de la pagina o intentelo nuevamente.");
                    redirect('inicio-sesion');
                }
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('message_error', "Ocurrio un error al enviar su contraseña, contacte con el administrador de la pagina o intentelo nuevamente.");
                redirect('inicio-sesion');
            }
        } else {
            $this->session->set_flashdata('message_error', "El usuario no se encuentra en el sistema.");
            redirect('inicio-sesion');
        }
    }

    public function valida_login($data) {
        if ($data->user_status_id == 2 || $data->user_status_id == 3) {
            echo json_encode(['error'=>$this->lang->line('auth_error_user_deleted')]);
            exit();
        }
    }

}
