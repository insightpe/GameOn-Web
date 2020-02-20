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
class Userinfo_model extends CI_Model {

    //put your code here
    private $table = "user_info";
    private $id = "id_user_info";

    public function __construct() {
        parent::__construct();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->id => $id));
        return $this->db->affected_rows();
    }

    public function getByUserId($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, ["id_user" => $id]);
            return $query->row();
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function get($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, [$this->id => $id]);
            return $query->row();
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where("id_user", $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }



}
