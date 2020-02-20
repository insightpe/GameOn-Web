<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rolepermissions
 *
 * @author furbox
 */
class Rolepermissions extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model([
            "Rolepermissions_model",
            "Permissions/Permissions_model",
            "Roles/Roles_model"
        ]);
        $this->load->library('Utilities');
    }

//    public function getRolePermission($id = FALSE) {
//        if ($id) {
//            return $this->Rolepermissions_model->get($id);
//        } else {
//            return $this->Rolepermissions_model->get();
//        }
//    }

    function footer_scripts($ui){
        $return = "<script src='" . base_url('assets') . "/js/custom/rolepermission.custom.js'></script>";
        switch($ui){
            case "list":
                $return .= "<script src='" . base_url('assets') . "/js/custom/rolepermission.list.custom.js'></script>";
            break;
        }
        return $return;
    }

    public function getRolePermissions($id) {
        $data = $this->Rolepermissions_model->getByRoleID($id);
        return array_merge($this->Permissions_model->getAll(), $data);
    }
//
    public function delete($role_id, $permission_id) {
        return $this->Rolepermissions_model->delete($role_id, $permission_id);
    }

    public function edit($role_id, $permission_id, $status) {
        $row = $this->Rolepermissions_model->get($role_id, $permission_id);

        $data = [
            "id_role" => $role_id,
            "id_permission" => $permission_id,
            "status" => $status,
        ];

        if($row == null){
            return $this->Rolepermissions_model->insert($data);
        }else{
            return $this->Rolepermissions_model->update($role_id, $permission_id, $data);
        } 
    }

    public function role_permissions($role_id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_roles_permissions');
        $this->acl->acceso('role_permissions');
        if ($role_id) {
            $id = (int) $role_id;
        } else {
            $id = (int) $this->uri->segment(2);
        }
        if ($id === 0) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_true'));
            redirect('listar-roles');
        }
        if (!$id) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_true'));
            redirect('listar-roles');
        }
        if (!is_int($id)) {
            $this->session->set_flashdata('message_error', $this->lang->line('general_message_error_no_valid_info'));
            redirect('listar-roles');
        }
        $rol = $this->Roles_model->get($id);
        if (count($rol) == 0) {
            $this->session->set_flashdata("message_error", $this->lang->line('role_message_error_delete_find'));
            redirect('listar-roles');
        }

        $rolepermissions = $this->getRolePermissions($role_id);
        if (count($rolepermissions) == 0) {
            $this->session->set_flashdata("message_error", $this->lang->line('role_message_error_delete_find'));
            redirect('listar-roles');
        }
        $data = new stdClass();
        
        $data->title = APP_NAME . " :: Dashboard :: Permisos de Rol";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->header_title = "Módulo de Roles";
        $data->header_description = "Permisos de Rol";
        $data->dash_container = "rolepermissions/permissions_role";
        $data->footer_scripts = $this->footer_scripts("list");

        $data->active = "roles";
        
        $data->rol = $rol;
        $data->permisos = $rolepermissions;

        $this->template->call_admin_template($data);
    }

    public function update_role_permissions() {
        $id = $this->uri->segment(2);
        
        $values = array_keys($this->input->post());
        $replace = [];
        $eliminar = [];

        for ($i = 0; $i < count($values); $i++) {
            if (substr($values[$i], 0, 5) == 'perm_') {
                if ((int) substr($values[$i], -1) > 0 && (int) substr($values[$i], -1) < 10) {
                    $id_perm = substr($values[$i], -1);
                }
                if ((int) substr($values[$i], -2) > 9 && (int) substr($values[$i], -2) < 100) {
                    $id_perm = substr($values[$i], -2);
                }
                if ((int) substr($values[$i], -3) > 99 && (int) substr($values[$i], -3) < 1000) {
                    $id_perm = substr($values[$i], -3);
                }
                if ((int) substr($values[$i], -4) > 999 && (int) substr($values[$i], -4) < 10000 ) {
                    $id_perm = substr($values[$i], -4);
                }

                if ($this->input->post($values[$i]) == 'x') {
                    $eliminar[] = [
                        'id_role' => $id,
                        'id_permission' => $id_perm
                    ];
                } else {
                    if ((int) $this->input->post($values[$i]) == 1) {
                        $v = 1;
                    } else {
                        $v = 0;
                    }

                    $replace[] = [
                        'id_role' => $id,
                        'id_permission' => $id_perm,
                        'status' => $v
                    ];
                }
            }
        }
        for ($i = 0; $i < count($eliminar); $i++) {
            $this->delete($eliminar[$i]['id_role'], $eliminar[$i]['id_permission']);
        }

        for ($i = 0; $i < count($replace); $i++) {
            $this->edit($replace[$i]['id_role'], $replace[$i]['id_permission'], $replace[$i]['status']);
        }
        echo json_encode(['redirect'=>base_url("listar-roles")]);
    }

    public function getRolePermissionsUser($id) {
        $acl = new Acl($id);
        return $acl->getRolePermissions();
    }

}
