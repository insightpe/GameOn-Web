<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author furbox
 */
class Users extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model([
            'Users_model',
            'Userinfo_model',
            'Campos/Campos_model',
            'Roles/Roles_model'
        ]);
        $this->load->library('Utilities');
    }

    function footer_scripts($ui){
        $return = "<script src='" . base_url('assets') . "/js/custom/user.custom.js'></script>";
        switch($ui){
            case "list":
                $return .= "<script src='" . base_url('assets') . "/js/custom/user.list.custom.js'></script>";
            break;
            case "add":
            case "update":
            case "profile":
            case "change_pass":
                $return .= "<script src='" . base_url('assets') . "/js/custom/user.dataentry.custom.js'></script>";
            break;
        }
        return $return;
    }


    public function list_users() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_users');
        $this->acl->acceso('list_users');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Lista de Usuarios";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Usuarios";
        $data->header_description = "Lista de Usuarios";
        $data->dash_container = "users/list_users";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "users";
        $data->footer_scripts = $this->footer_scripts("list");
        $tmpl = array('table_open' => '<table id="dt-users" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
        $this->table->set_template($tmpl);
        $this->table->set_heading(["Nombre", "Email", "Rol", "Estatus", "Acciones"]);

        $this->template->call_admin_template($data);
    }

    public function get_list_users(){
        if($this->input->is_ajax_request())
        {
          $response = $this->Users_model->list();
    
          echo $response;
    
          exit;
        }
    }

    public function form_edit_user($id_user = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_users');
        $this->acl->acceso('form_edit_user');
        if ($id_user) {
            $id = $id_user;
        } else {
            $id = $this->uri->segment(2);
        }
        $data = new stdClass();
        if (!$id) {
            $this->session->set_flashdata('message_error', $this->lang->line('users_error_no_valid_user'));
            redirect('listar-usuarios');
        }
        $id = (int) $id;
        if (!is_int($id)) {
            $this->session->set_flashdata('message_error', $this->lang->line('users_error_no_valid_user'));
            redirect('listar-usuarios');
        }
        $user = $this->Users_model->getInfo($id);
        if (!count($user) == 1) {
            $this->session->set_flashdata('message_error', $this->lang->line('users_error_not_found_user'));
            redirect('listar-usuarios');
        }

        $data->title = APP_NAME . " :: Dashboard :: Editar Usuario";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Usuarios";
        $data->header_description = "Editar Usuario";
        $data->dash_container = "users/form_edit_user";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "users";
        $data->footer_scripts = $this->footer_scripts("update");
        $data->roles = $this->Roles_model->get();
        $data->campos = $this->Campos_model->get();
        $data->user = $user;
        $this->template->call_admin_template($data);
    }

    public function form_new_user() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_users');
        $this->acl->acceso('form_new_user');

        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Agregar Usuario";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->header_title = "Módulo de Usuarios";
        $data->header_description = "Agregar Usuario";
        $data->dash_container = "users/form_new_user";
        $data->campos = $this->Campos_model->get();
        $data->footer_scripts = $this->footer_scripts("add");
        $data->active = "users";

        $data->roles = $this->Roles_model->get();

        $this->template->call_admin_template($data);
    }

//registro de usuarios
public function add_user() {
    $this->load->library('form_validation');

    $date = date('Y-m-d H:i:s');
    $activation_code = sha1($date);

    $rol = $this->input->post('user_role');

    if ($this->form_validation->run("new_user") == FALSE) {
        $errors = validation_errors();
        echo json_encode(['error'=>$errors]);
    } else {
        $user_email = $this->security->xss_clean($this->input->post('user_email', TRUE));
        $user_pass = $this->security->xss_clean($this->input->post('user_pass', TRUE));
        $user_name = $this->security->xss_clean($this->input->post('user_name', TRUE));
        $user_lastname = $this->security->xss_clean($this->input->post('user_lastname', TRUE));
        $user_email_share = $this->security->xss_clean($this->input->post('user_email_share', TRUE));
        $campo_id = $this->input->post('campo_id');

        $user_salt = $this->utilities->random_salt();
        $user_date = $date;
        $user_modified = $date;
        $user_activation_code = $activation_code;
        $user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);

        $status = $this->input->post('user_status');
        $rol = $this->input->post('user_role');

        //json_encode lo convierte en formato json
        $user_db = [
            'user_email' => $user_email,
            'user_pass' => $user_pass_hash,
            'user_salt' => $user_salt,
            'user_role_id' => $rol,
            'user_date_created' => $user_date,
            'user_modified' => $user_modified,
            'user_activation_code' => $user_activation_code,
            'user_status_id' => $status,
            'campo_id' => $campo_id == "" ? null : $campo_id
        ];

        $id = $this->Users_model->insert($user_db);
        
        $user_info_db = [
            'id_user' => $id,
            'nombre' => $user_name ,
            'apellido' => $user_lastname ,
            'user_img_profile' => "" ,
        ];

        $id = $this->Userinfo_model->insert($user_info_db);

        if (count($id) > 0) {
            echo json_encode(['redirect'=>base_url("listar-usuarios")]);
        } else {
            echo json_encode(['error'=>$this->lang->line('users_error_add')]);
        }
    }
}

    public function update_user() {
        $this->load->library('form_validation');

        $date = date('Y-m-d H:i:s');
        $id_user = $this->input->post('id');
        if ($this->form_validation->run('update_user') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $user_name = $this->security->xss_clean($this->input->post('user_name', TRUE));
            $user_lastname = $this->security->xss_clean($this->input->post('user_lastname', TRUE));
            $user_modified = $date;

            $status = $this->input->post('user_status');
            $rol = $this->input->post('user_role');
            $campo_id = $this->input->post('campo_id');

            $user_db = [
                'user_role_id' => $rol,
                'user_modified' => $user_modified,
                'user_status_id' => $status,
                'campo_id' => $campo_id == "" ? null : $campo_id
            ];

            $id = $this->Users_model->update($id_user, $user_db);

            $user_info_db = [
                'nombre' => $user_name ,
                'apellido' => $user_lastname ,
            ];
    
            $id = $this->Userinfo_model->update($id_user, $user_info_db);
           
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-usuarios")]);
            } else {
                echo json_encode(['error'=>$this->lang->line('users_error_update')]);
            }
        }
    }

    public function form_change_pass($id_user = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_users');
        $this->acl->acceso('form_change_pass');
        if ($id_user) {
            $id = $id_user;
        } else {
            $id = $this->uri->segment(2);
        }
        $data = new stdClass();
        if (!$id) {
            $this->session->set_flashdata('message_error', $this->lang->line('users_error_no_valid_user'));
            redirect('listar-usuarios');
        }
        $id = (int) $id;
        if (!is_int($id)) {
            $this->session->set_flashdata('message_error', $this->lang->line('users_error_no_valid_info'));
            redirect('listar-usuarios');
        }
        $user = $this->Users_model->get($id);
        if (!count($user) == 1) {
            $this->session->set_flashdata('message_error', $this->lang->line('users_error_not_found_user'));
            redirect('listar-usuarios');
        }

        $data->title = APP_NAME . " :: Dashboard :: Editar Contraseña de Usuario";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->header_title = "Módulo de Usuarios";
        $data->header_description = "Editar Contraseña de Usuario";
        $data->dash_container = "users/form_edit_pass_user";
        $data->footer_scripts = $this->footer_scripts("change_pass");
        $data->active = "users";
        $data->user = $user;
        $this->template->call_admin_template($data);
    }

    public function update_pass() {
        $this->load->library('form_validation');

        $date = date('Y-m-d H:i:s');
        $id_user = $this->input->post('id');
        if ($this->form_validation->run('update_pass_user') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $user = $this->Users_model->get($id_user);

            $user_pass = $this->security->xss_clean($this->input->post('user_pass', TRUE));
            $user_salt = $user->user_salt;
            $user_modified = $date;
            $user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);

            //json_encode lo convierte en formato json
            $user_db = [
                'user_pass' => $user_pass_hash,
                'user_modified' => $user_modified,
            ];

            $id = $this->Users_model->update($id_user, $user_db);
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-usuarios")]);
            } else {
                echo json_encode(['error'=>$this->lang->line('users_error_update_pass')]);
            }
        }
    }

    public function delete_user() {
        $this->utilities->is_session_start();
        $this->acl->accesoJSON('mudule_access_users');
        $this->acl->accesoJSON('delete_user');

        $id = $this->uri->segment(2);

        $data = new stdClass();
        if (!$id) {
            echo json_encode(['error'=>$this->lang->line('users_error_no_valid_user')]);
            return;
        }
        $id = (int) $id;
        if (!is_int($id)) {
            echo json_encode(['error'=>$this->lang->line('users_error_no_valid_info')]);
            return;
        }
        $user = $this->Users_model->get($id);
        if (!count($user) == 1) {
            echo json_encode(['error'=>$this->lang->line('users_error_not_found_user')]);
            return;
        }

        //json_encode lo convierte en formato json
        $user_db = [
            'user_modified' => date('Y-m-d H:i:s'),
            'user_status_id' => 3,
        ];

        $success = $this->Users_model->update($id, $user_db);
        if (count($success) > 0) {
            echo json_encode(['redirect'=>base_url("listar-usuarios")]);
        } else {
            echo json_encode(['error'=>$this->lang->line('users_error_delete')]);
            
        }
    }

    public function form_user_profile() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_users');
        $this->acl->acceso('proflie_user');

        $data = new stdClass();
        $data->title = APP_NAME . " :: Dashboard :: " . $this->lang->line('users_perfil');
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Usuarios";
        $data->header_description = "Perfil";
        $data->dash_container = "users/form_profile";
        $data->active = "profile";
        $data->footer_scripts = $this->footer_scripts("profile");
        $data->user = $this->Users_model->getInfo($_SESSION['user_id']);

        $this->template->call_admin_template($data);
    }

    public function update_user_profile() {
        $this->load->library('form_validation');
        
        $date = date('Y-m-d H:i:s');
        $id_user = $_SESSION['user_id'];
        if ($this->form_validation->run('update_profile') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $user_inf = $this->Userinfo_model->getByUserId($id_user);
            $user_name = $this->security->xss_clean($this->input->post('user_name', TRUE));
           
            if (@$_FILES['userfile']['name'] == NULL) {
                $user_img_profile = $user_inf->user_img_profile;
            } else {

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
                    echo json_encode(['error'=>$errors]);
                    return;
                }
                $config2['source_image'] = './assets/img/users_img/' . $user_img_profile;
                $config2['width'] = 230;
                $config2['height'] = 230;
                $this->load->library('image_lib', $config2);
                if (!$this->image_lib->resize()) {
                    $errors = $this->upload->display_errors();
                    echo json_encode(['error'=>$errors]);
                    return;
                }
                //chmod("./assets/img/users_img/".$user_img_profile, 0755);
            }


            //json_encode lo convierte en formato json
            $user_db = [
                'nombre' => $user_name,
                'user_img_profile' => ($user_img_profile == null ? "" : $user_img_profile),
            ];
      
            $id = $this->Userinfo_model->update($id_user, $user_db);
      
            $_SESSION['user_img'] = $user_img_profile;
            echo json_encode(['redirect'=>base_url("perfil")]);
            
        }
    }

    public function update_pass_user_profile() {
        $this->load->library('form_validation');

        $date = date('Y-m-d H:i:s');
        $id_user = $_SESSION['user_id'];
        if ($this->form_validation->run('update_pass_user') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $user = $this->Users_model->get($id_user);
            $user_pass_old = $this->security->xss_clean($this->input->post('user_old_pass', TRUE));
            $user_salt = $user->user_salt;
            $check_passwd = $this->utilities->check_passwd($user->user_pass, $user->user_salt, $user_pass_old);
            if (!$check_passwd) {
                echo json_encode(['error'=>'Datos invalidos']);
                return;
            }
            $user_pass = $this->security->xss_clean($this->input->post('user_pass', TRUE));
            $user_modified = $date;
            $user_pass_hash = $this->utilities->hash_passwd($user_pass, $user_salt);

            //json_encode lo convierte en formato json
            $user_db = [
                'user_pass' => $user_pass_hash,
                'user_modified' => $user_modified,
            ];

            $id = $this->Users_model->update($id_user, $user_db);
            echo json_encode(['redirect'=>base_url("perfil")]);

        }
    }

    

}
