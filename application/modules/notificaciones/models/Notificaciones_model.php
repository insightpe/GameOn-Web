<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Campos_model
 *
 * @author furbox
 */
class Notificaciones_model extends CI_Model
{

	//put your code here
	private $table = "notificaciones";
	private $id = "notificacion_id";

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
			$row = $query->row();

			return $row;
		}
		$query = $this->db->get($this->table);
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

	public function updateVistoByFechaHora($fecha_hora, $user_id, $data)
	{
		$this->db->where("fecha_hora <= '$fecha_hora'", NULL, FALSE);
		$this->db->where("user_id", $user_id);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}

	public function list($user_id)
	{
    $this->db->select('notificacion_id,
		mensaje,
		fecha_hora,
		visto,
		user_id');
    $this->db->limit(20);
		$this->db->from($this->table . ' n');
		
    $this->db->where("n.user_id", $user_id);
    $this->db->order_by("fecha_hora", "desc");
		//$this->db->where("fecha_hora >= '$fecha_hora'", NULL, FALSE);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function list_nuevos($user_id, $fecha_hora)
	{
    $this->db->select('COUNT(*) AS conteo');
    //$this->db->limit(100);
		$this->db->from($this->table . ' n');
		
    $this->db->where("n.user_id", $user_id);
    $this->db->where("n.visto", 0);
    //$this->db->order_by("fecha_hora", "desc");
		//$this->db->where("fecha_hora >= '$fecha_hora'", NULL, FALSE);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
}
