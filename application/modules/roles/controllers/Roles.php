<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Roles
 *
 * @author furbox
 */
class Roles extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model("Roles_model");
        $this->load->model("Users/Users_model");
        $this->load->library('Utilities');
    }

//    public function getRole($role_id = FALSE) {
//        if ($role_id) {
//            return $this->Roles_model->get($role_id);
//        } else {
//            return $this->Roles_model->get();
//        }
//    }

    function footer_scripts($ui){
        $return = "<script src='" . base_url('assets') . "/js/custom/role.custom.js'></script>";
        switch($ui){
            case "list":
                $return .= "<script src='" . base_url('assets') . "/js/custom/role.list.custom.js'></script>";
            break;
            case "add":
            case "update":
                $return .= "<script src='" . base_url('assets') . "/js/custom/role.dataentry.custom.js'></script>";
            break;
        }
        return $return;
    }

    public function list_roles() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_roles');
        $this->acl->acceso('list_roles');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Lista de Roles";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Roles";
        $data->header_description = "Lista de Roles";
        $data->dash_container = "roles/list_roles";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "roles";
        $data->footer_scripts = $this->footer_scripts("list");
        $tmpl = array('table_open' => '<table id="dt-roles" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
        $this->table->set_template($tmpl);
        $this->table->set_heading(["Nombre", "Acciones"]);
        
        $this->template->call_admin_template($data);
    }

    public function get_list_roles(){
        if($this->input->is_ajax_request())
        {   
          $response = $this->Roles_model->list();
    
          echo $response;
    
          exit;
        }
    }

    public function form_new_role() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_roles');
        $this->acl->acceso('form_new_role');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Agregar Rol";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->header_title = "Módulo de Roles";
        $data->header_description = "Agregar Rol";
        $data->dash_container = "roles/form_new_role";
        $data->footer_scripts = $this->footer_scripts("add");
        $data->active = "roles";
        $data->roles = $this->Roles_model->get();
        $this->template->call_admin_template($data);
    }

    public function add_role() {
        $this->load->library('form_validation');

        if ($this->form_validation->run('add_role') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {

            $role_name = $this->security->xss_clean($this->input->post('rol_name', TRUE));
            $lista_roles = $this->security->xss_clean($this->input->post('lista_roles', TRUE));

            $insert = [
                "role" => $role_name,
            ];

            $id = $this->Roles_model->insert($insert);

            if($lista_roles != ""){
                $rolesPermissions = $this->Rolepermissions_model->getByRoleIDToClone($lista_roles);

                $insert = [];
                foreach ($rolesPermissions as $rolesPermission) {
                    $insert[] = [
                        "id_role" => $id,
                        "id_permission" => $rolesPermission->id_permission,
                        "status" => $rolesPermission->status,
                    ];
                }
    
                $this->Rolepermissions_model->insertMultiple($insert);
            }
            
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-roles")]);
            } else {
                echo json_encode(['error'=>$this->lang->line('role_message_error_add')]);
            }
        }
    }

    public function form_edit_role($id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_roles');
        $this->acl->acceso('form_edit_role');
        $data = new stdClass();
        if ($id) {
            $id = (int) $id;
        } else {
            $id = (int) $this->uri->segment(2);
        }

        if (!$id) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_true'));
            redirect('listar-roles');
        }
        if (!is_int($id)) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_information'));
            redirect('listar-roles');
        }
        $rol = $this->Roles_model->get($id);
        if (!count($rol) == 1) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_find'));
            redirect('listar-roles');
        }

        $data->title = APP_NAME . " :: Dashboard :: Editar Rol";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Roles";
        $data->header_description = "Editar Rol";
        $data->dash_container = "roles/form_edit_rol";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "users";
        $data->footer_scripts = $this->footer_scripts("update");

        $data->rol = $rol;
        $this->template->call_admin_template($data);
    }

    public function update_role() {
        $this->load->library('form_validation');
        $id = $this->input->post('id');

        if ($this->form_validation->run('update_role') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $role_name = $this->security->xss_clean($this->input->post('rol_name', TRUE));

            $role_db = [
                'role' => $role_name,
            ];

            $id = $this->Roles_model->update($id, $role_db);
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-roles")]);
            } else {
                echo json_encode(['error'=>$this->lang->line('role_message_error_update')]);
            }
        }
    }

    public function delete_role($id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->accesoJSON('mudule_access_roles');
        $this->acl->accesoJSON('delete_role');
        if (!$id) {
            $id = (int) $this->uri->segment(2);
        } else {
            $id = (int) $id;
        }

        if (!$id) {
            echo json_encode(['error'=>$this->lang->line('role_message_error_delete_true')]);
            return;
        }
        if (!is_int($id)) {
            echo json_encode(['error'=>$this->lang->line('role_message_error_delete_information')]);
            return;
        }
        $rol = $this->Roles_model->get($id);
        if (!count($rol) == 1) {
            echo json_encode(['error'=>$this->lang->line('role_message_error_delete_find')]);
            return;
        }
        $users = $this->Users_model->getByRole($rol->role_id);
        if (count($users) > 0) {
            echo json_encode(['error'=>$this->lang->line('role_message_error_delete_cant')]);
            return;
        }
        $select = $this->Rolepermissions_model->get($rol->role_id);
        if (count($select) > 0) {
            $delete = $this->Rolepermissions_model->deletebyRol($rol->role_id);
            if (count($delete) > 0) {
                $id = $this->Roles_model->delete($id);
                if ($id > 0) {
                    echo json_encode(['redirect'=>base_url("listar-roles")]);
                    return;
                }
            } else {
                echo json_encode(['error'=>$this->lang->line('role_message_error_delete')]);
                return;
            }
        } else {
            $id = $this->Roles_model->delete($id);
            if ($id > 0) {
                echo json_encode(['redirect'=>base_url("listar-roles")]);
                    return;
            } else {
                echo json_encode(['error'=>$this->lang->line('role_message_error_delete')]);
                return;
            }
        }
    }

    public function get_role() {
        $id_role = $this->input->post('role');

        $response = $this->Roles_model->get($id_role);

        echo json_encode($response);
    }

}
