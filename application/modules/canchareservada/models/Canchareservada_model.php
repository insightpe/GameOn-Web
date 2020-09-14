<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Canchareservada_model
 *
 * @author furbox
 */
class Canchareservada_model extends CI_Model
{

	//put your code here
	private $table = "cancha_resevada";
	private $id = "cancha_reservada_id";

	public function __construct()
	{
		parent::__construct();
	}

	public function delete($id)
	{
		$this->db->delete($this->table, array($this->id => $id));
		return $this->db->affected_rows();
	}

	public function get($id = FALSE)
	{
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

	public function getCanchaReservada($id = FALSE)
	{
		$this->db->select("cr.cancha_reservada_id, cc.nombre AS cancha_nombre, c.lat, d.deporte_id, c.lng, CAST(cr.fecha_desde AS DATE) AS fecha, d.nombre AS deporte_nombre, c.nombre, c.ubicacion, CONCAT(LPAD(hora, 2, 0), ':00 - ', LPAD(hora + 1, 2, 0), ':00') AS rango_hora");
		$this->db->from($this->table . ' cr');
		$this->db->join('cancha_horario_dia_horas chdh', "chdh.cancha_horario_dia_horas_id = cr.cancha_horario_dia_hora_id");
		$this->db->join('campo_canchas cc', 'cr.campo_cancha_id = cc.campo_cancha_id');
		$this->db->join('deporte d', 'cc.deporte_id = d.deporte_id');
		$this->db->join('campo c', 'c.campo_id = cc.campo_id');
		$this->db->where('cr.cancha_reservada_id', $id);

		$query = $this->db->get();
		return $query->row();
	}

	public function getMisReservas($user_id, $partido_id)
	{
		$this->db->select("cr.cancha_reservada_id, CONCAT(c.nombre, ' - ', cr.fecha_desde) AS nombre_fechahora ");
		$this->db->from($this->table . ' cr');
		$this->db->join('campo_canchas cc', 'cr.campo_cancha_id = cc.campo_cancha_id');
		$this->db->join('campo c', 'c.campo_id = cc.campo_id');
		$this->db->where('cr.creador_user_id', $user_id);
		$this->db->where("NOT cr.cancha_reservada_id IN (SELECT IFNULL(cancha_reservada_id, 0) FROM partido p WHERE p.partido_id != $partido_id AND p.creador_user_id = $user_id )",NULL,FALSE);
		$this->db->order_by("fecha_desde", "desc");

		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
	}

	public function getMisCanchas($user_id)
	{
		$this->db->select("cr.cancha_reservada_id, ci.imagen, cc.campo_cancha_id, d.nombre AS deporte_nombre, c.nombre, c.ubicacion, cr.precio");
		$this->db->from($this->table . ' cr');
		$this->db->join('campo_canchas cc', 'cr.campo_cancha_id = cc.campo_cancha_id');
		$this->db->join('deporte d', 'cc.deporte_id = d.deporte_id');
		$this->db->join('campo c', 'c.campo_id = cc.campo_id');
		$this->db->join('campo_imagenes ci', 'ci.campo_id = c.campo_id AND ci.defecto = 1');
		$this->db->where('cr.creador_user_id', $user_id);
		$this->db->limit(20);
		$this->db->order_by("fecha_desde", "desc");

		$query = $this->db->get();
		return $query->result();
	}

	public function insert($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$this->db->where($this->id, $id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function listForCalendar($campo_id, $deporte_id, $campo_cancha_id, $start, $end)
	{
		$this->db->select('cr.cancha_reservada_id, c.nombre AS campo_nombre, chdh.precio, chdh.campo_cancha_id, chdh.cancha_horario_dia_horas_id, chdh.cancha_horario_dia_id, cr.fecha_desde, cr.fecha_hasta, ui.nombre, ui.apellido, cc.nombre AS cancha_nombre');
		$this->db->from($this->table . ' cr');
		$this->db->join('cancha_horario_dia_horas chdh', "chdh.cancha_horario_dia_horas_id = cr.cancha_horario_dia_hora_id");
		$this->db->join('campo_canchas cc', "cc.campo_cancha_id = chdh.campo_cancha_id");
		$this->db->join('campo c', "c.campo_id = cc.campo_id");
		$this->db->join('user_info ui', "ui.id_user = cr.creador_user_id");

		$this->db->where("cc.campo_id", $campo_id);

		if($deporte_id != null && $deporte_id != ""){
			$this->db->where("cc.deporte_id", $deporte_id);
		}
		
		if($campo_cancha_id != null && $campo_cancha_id != ""){
			$this->db->where("cc.campo_cancha_id", $campo_cancha_id);
		}
		
		$this->db->where("cr.fecha_desde >= '$start'");
		$this->db->where("cr.fecha_hasta <= '$end'");

		$query = $this->db->get();
		$result = $query->result();
		return $result; //muchas o 0
	}

	public function list()
	{
		$this->datatables->select('cr.cancha_reservada_id, c.nombre AS campo_nombre, chdh.precio, chdh.campo_cancha_id, chdh.cancha_horario_dia_horas_id, chdh.cancha_horario_dia_id, cr.fecha_desde, cr.fecha_hasta, ui.nombre, ui.apellido, cc.nombre AS cancha_nombre');
		$this->datatables->from($this->table . ' cr');
		$this->datatables->join('cancha_horario_dia_horas chdh', "chdh.cancha_horario_dia_horas_id = cr.cancha_horario_dia_hora_id");
		$this->datatables->join('campo_canchas cc', "cc.campo_cancha_id = chdh.campo_cancha_id");
		$this->datatables->join('campo c', "c.campo_id = cc.campo_id");
		$this->datatables->join('user_info ui', "ui.id_user = cr.creador_user_id");

		$result = $this->datatables->generate();

		return $result;
	}
}
