<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users_model
 *
 * @author furbox
 */
class Config_model extends CI_Model {

    //put your code here
    private $table = "config";
    private $id = "id_config";

    public function __construct() {
        parent::__construct();
    }

   
    public function get($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, [$this->id => $id]);
            $row = $query->row();

            return $row;
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

    public function custom_is_unique($table, $field, $field_id, $where, $id, $field_value){
        $this->db->select('count(*) AS count');
      $this->db->from($table);
      $this->db->where($field_id . " !=", $id);
      
      if($where != null && $where != ""){
        $this->db->where($where); 
      }
      
      $this->db->where($field, $field_value); 
      $query = $this->db->get();
      $result = $query->row();

      return $result;
    }
}
