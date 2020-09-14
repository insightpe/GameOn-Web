<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CampoCanchas_model
 *
 * @author furbox
 */
class CampoCanchas_model extends CI_Model {

    //put your code here
    private $table = "campo_canchas";
    private $id = "campo_cancha_id";

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

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function existsCanchaInReserva($id) {
        $this->db->select('COUNT(*) AS count');
        $this->db->from('cancha_resevada cr');
        $this->db->where('cr.campo_cancha_id',  $id);  
        $query = $this->db->get();
        $row = $query->row();
        return $row->count > 0; //muchas o 0
    }

    public function getCampoCancha($campo_cancha_id){
        $this->db->select('cc.nombre, cc.campo_cancha_id, c.nombre AS campo_nombre');
        $this->db->from($this->table . ' cc');
        $this->db->join('campo c', 'cc.campo_id = c.campo_id');
        $this->db->where('cc.campo_cancha_id',  $campo_cancha_id);

        $query = $this->db->get();
        return $query->row();
    }

    public function getCanchas($campo_id, $deporte_id){
        $this->db->select('cc.nombre, cc.campo_cancha_id');
        $this->db->from($this->table . ' cc');
        $this->db->where('cc.campo_id',  $campo_id);
        $this->db->where('cc.campo_estado_id',  1);

        if($deporte_id != ""){
            $this->db->where('cc.deporte_id',  $deporte_id);
        }else{
            $this->db->where('cc.deporte_id',  DEPORTE_ID_DEFAULT);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    public function list($campos, $deportes) {
        $this->datatables->select('c.nombre AS campo_nombre, campo_cancha_id, cc.nombre, cc.deporte_id, d.nombre AS deporte_nombre, cc.campo_estado_id, ce.nombre AS campo_estado_nombre');
        $this->datatables->from($this->table . ' cc' );
        $this->datatables->join('campo c', "c.campo_id = cc.campo_id");
        $this->datatables->join('deporte d', "d.deporte_id = cc.deporte_id");
        $this->datatables->join('campo_estado ce', "ce.campo_estado_id = cc.campo_estado_id");
  
        if($campos != ""){
            $this->datatables->where("cc.campo_id", $campos);
				}
				
				if($deportes != ""){
						$this->datatables->where("cc.deporte_id", $deportes);
				}

        $result = $this->datatables->generate();
  
        return $result;
      }
}
