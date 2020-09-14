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
class Campos_model extends CI_Model
{

	//put your code here
	private $table = "campo";
	private $id = "campo_id";

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

	public function getImagenes($id = FALSE)
	{
		$this->db->select('ci.imagen');
		$this->db->from('campo_imagenes ci');
		$this->db->where('ci.campo_id', $id);
		$this->db->order_by("defecto", "desc");
		$this->db->limit(3);
		$query = $this->db->get();
		return $query->result();
	}

	public function getCampo($id = FALSE, $deporte_id)
	{
		$this->db->select('c.campo_id, c.nombre, c.ubicacion, ud.name AS distrito_name, c.lat, c.lng, imagen, 
		GROUP_CONCAT(DISTINCT d.nombre) AS deporte_nombre, datos_adicionales');
		$this->db->from('campo c');
		$this->db->join('campo_imagenes ci', 'c.campo_id = ci.campo_id AND ci.defecto = 1');
		$this->db->join('campo_canchas cc', 'cc.campo_id = c.campo_id');
		$this->db->join('ubdistrits ud', 'ud.id = c.ubdistri_id');
		$this->db->join('deporte d', 'cc.deporte_id = d.deporte_id');
		$this->db->where('c.campo_estado_id', CAMPO_ESTADO_ACTIVO);
		$this->db->where('cc.campo_estado_id', CAMPO_ESTADO_ACTIVO);
		$this->db->where('c.campo_id', $id);

		if($deporte_id != null && $deporte_id != ""){
			$this->db->where('cc.deporte_id', $deporte_id);
		}
		
		$query = $this->db->get();
		return $query->row();
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

	public function getCampoCanchasByDeporte($campo_id, $deporte_id)
	{
		$this->db->distinct();
		$this->db->select('cc.campo_cancha_id, cc.nombre');
		$this->db->from('campo c');
		$this->db->join('campo_canchas cc', 'cc.campo_id = c.campo_id');
		$this->db->join('deporte d', 'd.deporte_id = cc.deporte_id');
		$this->db->where('c.campo_id', $campo_id);
		$this->db->where('d.deporte_id', $deporte_id);

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function getDeportes($campo_id)
	{
		$this->db->distinct();
		$this->db->select('d.deporte_id, d.nombre');
		$this->db->from('campo c');
		$this->db->join('campo_canchas cc', 'cc.campo_id = c.campo_id');
		$this->db->join('deporte d', 'd.deporte_id = cc.deporte_id');
		$this->db->where('c.campo_id', $campo_id);

		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function getCampoFrecuente($user_id)
	{
		$this->db->select('cc.campo_id');
		$this->db->from('cancha_resevada cr');
		$this->db->join('campo_canchas cc', 'cc.campo_cancha_id = cr.campo_cancha_id');
		$this->db->where('cr.creador_user_id', $user_id);
		$this->db->group_by("cc.campo_id");
		$this->db->order_by("COUNT(cr.cancha_reservada_id)", "DESC");
		$this->db->limit(1);

		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	public function getCampos($deporte, $provincia, $distrito)
	{
		$this->db->select('c.campo_id, c.nombre, c.lat, c.lng, c.ubicacion, imagen, d.name AS distrito_name,
		( SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM campo_canchas cc JOIN deporte d ON cc.deporte_id = d.deporte_id WHERE cc.campo_id = c.campo_id AND cc.campo_estado_id =' . CAMPO_ESTADO_ACTIVO . ')
		AS deporte_nombre');
		$this->db->from('campo c');
		$this->db->join('campo_imagenes ci', 'c.campo_id = ci.campo_id AND ci.defecto = 1');
		$this->db->join('ubdistrits d', 'd.id = c.ubdistri_id');
		$this->db->where('c.campo_estado_id', CAMPO_ESTADO_ACTIVO);
		
		if($deporte != ""){
			$this->db->where($deporte . " IN (SELECT d.deporte_id FROM campo_canchas cc JOIN deporte d ON cc.deporte_id = d.deporte_id WHERE cc.campo_id = c.campo_id AND cc.campo_estado_id = " . CAMPO_ESTADO_ACTIVO . ")", null, FALSE);
		}

		if($provincia != ""){
			$this->db->where('c.ubprov_id', $provincia);;
		}

		if($distrito != ""){
			$this->db->where('c.ubdistri_id', $distrito);;
		}
		
		$this->db->order_by("c.nombre", "asc");
		$query = $this->db->get();
		$result = $query->result();
		
		//var_dump($this->db->last_query());
		return $result;
	}

	public function list()
	{
		$this->datatables->select('campo_id, c.nombre, ubicacion, c.campo_estado_id, ce.nombre AS estado_nombre, external_url');
		$this->datatables->from($this->table . ' c');
		$this->datatables->join('campo_estado ce', 'ce.campo_estado_id = c.campo_estado_id');

		$result = $this->datatables->generate();

		return $result;
	}

	public function existsCampoInCampoCancha($id) {
		$this->db->select('COUNT(*) AS count');
		$this->db->from('campo_canchas cc');
		$this->db->where('cc.campo_id',  $id);  
		$query = $this->db->get();
		$row = $query->row();
		return $row->count > 0; //muchas o 0
	}
}
