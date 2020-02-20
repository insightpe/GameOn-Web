<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissions
 *
 * @author furbox
 */
class Permissions extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model("Permissions_model");
        $this->load->library('Utilities');
    }

//    public function getPermission($permission_id = FALSE) {
//        if ($permission_id) {
//            return $this->Permissions_model->get($permission_id);
//        } else {
//            return $this->Permissions_model->get();
//        }
//    }

//    public function getPermissionsAll() {
//        return $this->Permissions_model->getAll();
//    }

    function footer_scripts($ui){
        $return = "<script src='" . base_url('assets') . "/js/custom/permission.custom.js'></script>";
        switch($ui){
            case "list":
                $return .= "<script src='" . base_url('assets') . "/js/custom/permission.list.custom.js'></script>";
            break;
            case "add":
            case "update":
                $return .= "<script src='" . base_url('assets') . "/js/custom/permission.dataentry.custom.js'></script>";
            break;
        }
        return $return;
    }

    public function list_permissions() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_permissions');
        $this->acl->acceso('list_permissions');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Lista de Permisos";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Permisos";
        $data->header_description = "Lista de Permisos";
        $data->dash_container = "permissions/list_permissions";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->footer_scripts = $this->footer_scripts("list");
        $data->active = "permissions";
        $tmpl = array('table_open' => '<table id="dt-permissions" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
        $this->table->set_template($tmpl);
        $this->table->set_heading(["Nombre", "Llave de Permiso", "Acciones"]);
  
        $this->template->call_admin_template($data);
    }

    public function get_list_permissions(){
        if($this->input->is_ajax_request())
        {   
          $response = $this->Permissions_model->list();
    
          echo $response;
    
          exit;
        }
    }

    public function form_new_permissions() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_permissions');
        $this->acl->acceso('form_new_permissions');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Agregar Permiso";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->header_title = "Módulo de Permisos";
        $data->header_description = "Agregar Permiso";
        $data->dash_container = "permissions/form_new_permissions";
        $data->footer_scripts = $this->footer_scripts("add");

        $data->active = "permissions";
        $this->template->call_admin_template($data);
    }

    public function add_permissions() {
        $this->load->library('form_validation');

        if ($this->form_validation->run('add_permissions') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {

            $permissions_name = $this->security->xss_clean($this->input->post('permissions_name', TRUE));
            $permissions_key = $this->security->xss_clean($this->input->post('permissions_key', TRUE));

            $insert = [
                "title" => $permissions_name,
                "name" => $permissions_key
            ];

            $id = $this->Permissions_model->insert($insert);
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-permiso")]);
            } else {
                echo json_encode(['error'=>$this->lang->line('permission_message_error_add')]);
            }
        }
    }

    public function form_edit_permission($id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_permissions');
        $this->acl->acceso('form_edit_permission');
        $data = new stdClass();
        if ($id) {
            $id = (int) $id;
        } else {
            $id = (int) $this->uri->segment(2);
        }

        if (!$id) {
            $this->session->set_flashdata('message_error', $this->lang->line('permission_message_error_delete_true'));
            redirect('listar-permiso');
        }
        if (!is_int($id)) {
            $this->session->set_flashdata('message_error', $this->lang->line('permission_message_error_delete_information'));
            redirect('listar-permiso');
        }
        $permission = $this->Permissions_model->get($id);
        if (!count($permission) == 1) {
            $this->session->set_flashdata('message_error', $this->lang->line('permission_message_error_delete_find'));
            redirect('listar-permiso');
        }

        $data->title = APP_NAME . " :: Dashboard :: Editar Permiso";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Permisos";
        $data->header_description = "Editar Permiso";
        $data->dash_container = "permissions/form_edit_permissions";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->footer_scripts = $this->footer_scripts("update");

        $data->active = "permissions";
        $data->permission = $permission;

        $this->template->call_admin_template($data);
    }

    public function update_permission() {
        $this->load->library('form_validation');

        $id = $this->input->post('id');

        if ($this->form_validation->run('add_permissions') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {

            $permission_title = $this->security->xss_clean($this->input->post('permissions_name', TRUE));
            $permission_name = $this->security->xss_clean($this->input->post('permissions_key', TRUE));

            $update = [
                "title" => $permission_title,
                "name" => $permission_name
            ];

            $id = $this->Permissions_model->update($id, $update);
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-permiso")]);
            } else {
                echo json_encode(['error'=>$this->lang->line('permission_message_error_update')]);
            }
        }
    }

    public function delete_permission($id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_permissions');
        $this->acl->acceso('delete_permission');
        if (!$id) {
            $id = (int) $this->uri->segment(2);
        } else {
            $id = (int) $id;
        }

        if (!$id) {
            echo json_encode(['error'=>$this->lang->line('permission_message_error_delete_true')]);
            return;
        }
        if (!is_int($id)) {
            echo json_encode(['error'=>$this->lang->line('permission_message_error_delete_information')]);
            return;
        }
        $permission = $this->Permissions_model->get($id);
        if (!count($permission) == 1) {
            echo json_encode(['error'=>$this->lang->line('permission_message_error_delete_find')]);
            return;
        }
        $roles = $this->Rolepermissions_model->getByPermission($id);
        if (count($roles) > 0) {
            echo json_encode(['error'=>$this->lang->line('permission_message_error_delete_cant')]);
            return;
        }

        $success = $this->Permissions_model->delete($id);
        if ($success > 0) {
            echo json_encode(['redirect'=>base_url("listar-permiso")]);
        }
    }

}
