<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author furbox
 */
class Acl extends MY_Controller {

    //put your code here
    private $_id_user;
    private $_id_role;
    private $_permisos;

    public function __construct($id = FALSE) {
        parent::__construct();
        
        $this->load->model([
            "Roles/Roles_model",
            "Users/Users_model",
            "Rolepermissions/Rolepermissions_model",
            "Permissions/Permissions_model"
            
        ]);
        
        if ($id) {
            $this->_id_user = (int) $id;
        } else {
            if (@$_SESSION['user_id']) {
                $this->_id_user = $_SESSION['user_id'];
            } else {
                $this->_id_user = 0;
            }
        }
        $this->_id_role = $this->getRole();
        $this->_permisos = $this->getRolePermissions();
		//var_dump($this->_id_role);
		//var_dump($this->_permisos);
        $this->compilarAcl();
    }
    
    public function compilarAcl() {
      /*  $this->_permisos = array_merge(
                $this->_permisos, $this->getUserPermissions()
        );*/
    }

    //devuelve el rol del usuario
    public function getRole() {
        if ((int) $this->_id_user === 0) {
            $rol = '';
        } else {
            $role = $this->Users_model->get($this->_id_user);
            $rol = $role->user_role_id;
        }
        return $rol;
    }

    //devuelve los permisos del rol que tiene asignado el usuario
    public function getRolePermissionsIds() {
        if ($this->_id_role === '') {
            $ids = [];
        } else {
            $ids = $this->Rolepermissions_model->get($this->_id_role);
        }
        $id = [];
        foreach ($ids as $id_permission) {
            $id[] = $id_permission->id_permission;
        }
        return $id;
    }

    //devuelve los permisos habilitados o deshabilitados del rol
    public function getRolePermissions() {
        if ($this->_id_role === '') {
            $rolePermissions = [];
        } else {
            $rolePermissions = $this->Rolepermissions_model->getByRoleIDACL($this->_id_role);
        }
        $data = [];
        foreach ($rolePermissions as $rolePermission) {
            $permission_name = $this->getPermissionName($rolePermission->id_permission);
            if ($permission_name == '') {
                continue;
            }
            if ($rolePermission->status == 1) {
                $v = TRUE;
            } else {
                $v = FALSE;
            }

            $data[$permission_name] = [
                'name' => $permission_name,
                'permission' => $this->getPermissionTitle($rolePermission->id_permission),
                'status' => $v,
                'inherited' => TRUE,
                'id_permission' => $rolePermission->id_permission
            ];
        }
        return $data;
    }

    public function getPermissionName($id_permission) {
        $permission_id = (int) $id_permission;
        $permission = $this->Permissions_model->get($permission_id);
        return $permission->name;
    }

    public function getPermissionTitle($id_permission) {
        $permission_id = (int) $id_permission;
        $permission = $this->Permissions_model->get($permission_id);
        return $permission->title;
    }

    public function getUserPermissions() {
        $ids = $this->getRolePermissionsIds();

        if (count($ids) > 0) {
            $userPermissions = $this->Userpermissions_model->getPermissions($this->_id_user,$ids);
        } else {
            $userPermissions = [];
        }


        $data = [];

        foreach ($userPermissions as $userPermission) {
            $permission_name = $this->getPermissionName($userPermission->id_permission);
            if ($permission_name == '') {
                continue;
            }
            if ($userPermission->status == 1) {
                $v = TRUE;
            } else {
                $v = FALSE;
            }

            $data[$permission_name] = [
                'name' => $permission_name,
                'permission' => $this->getPermissionTitle($userPermission->id_permission),
                'status' => $v,
                'inherited' => FALSE,
                'id_permission' => $userPermission->id_permission
            ];
        }
        return $data;
    }

    public function getPermissions() {
        if (isset($this->_permisos) && count($this->_permisos)) {
            return $this->_permisos;
        }
    }

    public function permission($name) {
        if (array_key_exists($name, $this->_permisos)) {
            if ($this->_permisos[$name]['status'] == TRUE || $this->_permisos[$name]['status'] == 1) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function acceso($name) {
        if ($this->permission($name)) {
            return;
        }
        $this->session->set_flashdata("message_error", $this->lang->line('invalid_access'));
        redirect(base_url());
    }

    public function accesoJSON($name) {
        if ($this->permission($name)) {
            return;
        }
        echo json_encode(['error'=>$this->lang->line('invalid_access')]);
        exit();
    }
    
    public function control_acceso($name) {
        if ($this->permission($name)) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

}
