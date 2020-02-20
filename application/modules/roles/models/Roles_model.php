<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Roles_model
 *
 * @author furbox
 */
class Roles_model extends CI_Model {

    //put your code here
    private $table = "roles";
    private $id = "role_id";

    public function __construct() {
        parent::__construct();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->id => $id));
        return $this->db->affected_rows();
    }

    public function get($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, [$this->id => $id]);
            return $query->row(); //1 o 0
        }
        /*if($_SESSION['is_super_admin'] == "0"){
          $this->db->where('role_id != 1');
        }*/
        $query = $this->db->get($this->table);
        return $query->result(); //muchas o 0
    }

    public function getByUser($id) {
        $query = $this->db->get_where($this->table, ['UsuarioID' => $id]);
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
        $this->datatables->select('role_id, role');
        $this->datatables->from($this->table . ' r' );
  
        $result = $this->datatables->generate();
  
        return $result;
      }
}
