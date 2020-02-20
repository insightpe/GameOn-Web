<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rolepermissions_model
 *
 * @author furbox
 */
class Rolepermissions_model extends CI_Model {

    //put your code here
    private $table = "role_permissions";
    private $id = "id_role";

    public function __construct() {
        parent::__construct();
    }

    public function delete($id, $id2) {
        $this->db->delete($this->table, [$this->id => $id, 'id_permission' => $id2]);
        return $this->db->affected_rows();
    }

    public function deletebyRol($id) {
        $this->db->delete($this->table, [$this->id => $id]);
        return $this->db->affected_rows();
    }

    public function edit($role_id, $permission_id, $status) {
        $data = [
            "id_role" => $role_id,
            "id_permission" => $permission_id,
            "status" => $status
        ];

        return $this->db->replace($this->table, $data);
    }

    public function getByPermission($id) {
        $query = $this->db->get_where($this->table, ['id_permission' => $id]);
        return $query->result();
    }

    public function get($id = FALSE, $id2 = FALSE) {
        if ($id && $id2) {
            $query = $this->db->get_where($this->table, [$this->id => $id, 'id_permission' => $id2]);
            return $query->row();
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }
	
	public function getByRoleIDACL($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, [$this->id => $id]);
            return $query->result();
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getByRoleIDToClone($roleid) {
        $query = $this->db->get_where($this->table, ['id_role' => $roleid]);
        return $query->result();
    }

    public function getByRoleID($id) {
        $data = [];
        $this->db->select('rp.*');
        if($_SESSION['is_super_admin'] == "0"){
          $this->db->where('p.is_only_for_super_admin != 1');
        }
        $this->db->where([$this->id => $id]);
        $this->db->from($this->table . ' rp');
        $this->db->join("permissions p", "p.id_permission = rp.id_permission");
        $query = $this->db->get();
        $result = $query->result();
        foreach ($result as $permission) {
            $name = $this->acl->getPermissionName($permission->id_permission);
            if ($name == '') {
                continue;
            }
            if ($permission->status == 1) {
                $v = 1;
            } else {
                $v = 0;
            }

            $data[$name] = [
                "name" => $name,
                "status" => $v,
                "title" => $this->acl->getPermissionTitle($permission->id_permission),
                "id_permission" => $permission->id_permission
            ];
        }
        return $data;
    }

    public function getPermissionsByNameAndPermitido($role_id, $name) {
        $this->db->select('p.name');
        $this->db->from($this->table . " rp");        
        $this->db->join("permissions p", "p.id_permission = rp.id_permission");   
        $this->db->where('rp.id_role', $role_id);  
        $this->db->like('p.name', $name, 'after');  
        $query = $this->db->get();
        $result = $query->result();
     
        return $result;
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return 1;
    }

    public function insertMultiple($data) {
        $this->db->insert_batch($this->table, $data);
        return $this->db->affected_rows();
    }

    public function update($id, $id2, $data) {
        $this->db->update($this->table, $data, [$this->id => $id, 'id_permission' => $id2]);
        return $this->db->affected_rows();
    }

}
