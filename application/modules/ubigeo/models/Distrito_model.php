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
class Distrito_model extends CI_Model {

    //put your code here
    private $table = "ubdistrits";
    private $id = "id";

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
            return $query->row();
        }
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getByProvincia($provincia_id) {
      $this->db->select('d.id, d.name');
      $this->db->from($this->table . ' d');

      $this->db->where("d.ubprov_id", $provincia_id);

      $query = $this->db->get();
      $result = $query->result();
      return $result; //muchas o 0
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



}
