<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Partidos_model
 *
 * @author furbox
 */
class Partidodeportes_model extends CI_Model
{

	//put your code here
	private $table = "partido_deportes";
	private $id = "partido_deporte_id";

	public function __construct()
	{
		parent::__construct();
	}

	public function delete($id)
	{
		$this->db->delete($this->table, array($this->id => $id));
		return $this->db->affected_rows();
	}


	public function deleteByPartidoId($partido_id)
	{
		$this->db->delete($this->table, array("partido_id" => $partido_id));
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
}
