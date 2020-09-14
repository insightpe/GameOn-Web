<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Canchahorariodiahora_model
 *
 * @author furbox
 */
class Canchahorariodiahora_model extends CI_Model {

    //put your code here
    private $table = "cancha_horario_dia_horas";
    private $id = "cancha_horario_dia_horas_id";

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

    public function getIdByDayHour($campo_cancha_id, $dia, $hour) {
        $this->db->from($this->table);
        $this->db->where(["campo_cancha_id" => $campo_cancha_id, "dia" => $dia, "hora" => $hour]);
        $this->db->order_by("dia", "asc");
        $this->db->order_by("hora", "asc");
        $query = $this->db->get(); 
        return $query->row();
    }

    public function getIdByCampoCanchaId($campo_cancha_id) {
        $query = $this->db->get_where($this->table, ["campo_cancha_id" => $campo_cancha_id]);
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

    public function getHorasDisponibles($campo_cancha_id, $fecha, $day)
	{
		$this->db->select("chdh.cancha_horario_dia_horas_id, precio, CONCAT(LPAD(hora, 2, 0), ':00 - ', LPAD(hora + 1, 2, 0), ':00') AS rango_hora");
		$this->db->from($this->table . ' chdh');
		$this->db->where('chdh.campo_cancha_id',  $campo_cancha_id);
        $this->db->where('chdh.dia',  $day);
        $this->db->where("NOT precio IS NULL", NULL, FALSE);
        $this->db->where("NOT cancha_horario_dia_horas_id IN (SELECT cancha_horario_dia_hora_id FROM cancha_resevada cr
        WHERE campo_cancha_id = chdh.campo_cancha_id AND cr.fecha_desde >= '$fecha 00:00' AND cr.fecha_desde <= '$fecha 23:59')");
		$query = $this->db->get();
		return $query->result();
	}
}
