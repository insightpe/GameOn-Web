<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissions_model
 *
 * @author furbox
 */
class Permissions_model extends CI_Model{
    //put your code here
    private $table = "permissions";
    private $id = "id_permission";
    
    public function __construct() {
        parent::__construct();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->id => $id));
        return $this->db->affected_rows();
    }
    
    public function getAll(){
        if($_SESSION['is_super_admin'] == "0"){
          $this->db->where('is_only_for_super_admin != 1');
        }
        $query = $this->db->get($this->table);
        foreach ($query->result() as $permission){
            if($permission->name==''){
                continue;
            }
            $data[$permission->name] = [
                "name" => $permission->name,
                "status" => 'x',
                "title" => $permission->title,
                "id_permission" => $permission->id_permission
            ];
        }
        return $data;
    }

    

    public function getByName($name) {
        $query = $this->db->get_where($this->table, ["name" => $name]);
        return $query->row();
    }

    public function get($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, [$this->id => $id]);
            return $query->row();
        }
        if($_SESSION['is_super_admin'] == "0"){
          $this->db->where('is_only_for_super_admin != 1');
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function list() {
        $this->datatables->select('title, name, id_permission');
        $this->datatables->from($this->table . ' p' );
        if($_SESSION['is_super_admin'] == "0"){
            $this->datatables->where('is_only_for_super_admin != 1');
        }
        $result = $this->datatables->generate();
  
        return $result;
      }
}
