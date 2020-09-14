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
class Partidos_model extends CI_Model
{

	//put your code here
	private $table = "partido";
	private $id = "partido_id";

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

	public function getCampo($id = FALSE, $deporte_id)
	{
		$this->db->select('c.campo_id, c.nombre, c.ubicacion, c.lat, c.lng, imagen, GROUP_CONCAT(DISTINCT d.nombre) AS deporte_nombre');
		$this->db->from('campo c');
		$this->db->join('campo_imagenes ci', 'c.campo_id = ci.campo_id AND ci.defecto = 1');
		$this->db->join('campo_canchas cc', 'cc.campo_id = c.campo_id');
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

	public function getUltimoPartido($user_id){
		$this->db->select('p.partido_id');
		$this->db->from('partido p');
		$this->db->join('cancha_resevada cr', 'cr.cancha_reservada_id = p.cancha_reservada_id');
		$this->db->where("$user_id IN (SELECT user_id FROM partido_miembros pm WHERE pm.partido_id = p.partido_id AND pm.confirmado = 1)", NULL, FALSE);
		$this->db->where("fecha_desde <= '" . date('Y-m-d H:s:i') . "'", NULL, FALSE);
		$this->db->order_by("cr.fecha_desde", "desc");
		
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->row();
		//var_dump($this->db->last_query());
		return $result;
	}

	public function getProximoPartido($user_id){
		$this->db->select('p.partido_id');
		$this->db->from('partido p');
		$this->db->join('cancha_resevada cr', 'cr.cancha_reservada_id = p.cancha_reservada_id');
		$this->db->where("$user_id IN (SELECT user_id FROM partido_miembros pm WHERE pm.partido_id = p.partido_id AND pm.confirmado = 1)", NULL, FALSE);
		$this->db->where("fecha_desde >= '" . date('Y-m-d H:s:i') . "'", NULL, FALSE);
		$this->db->order_by("cr.fecha_desde", "asc");
		
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->row();
		//var_dump($this->db->last_query());
		return $result;
	}

	public function getPartido($partido_id){
		$this->db->select('p.partido_id, p.nombre, p.creador_user_id, num_participantes, (SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM partido_deportes pd 
    INNER JOIN deporte d ON pd.deporte_id = d.deporte_id
		WHERE pd.partido_id = p.partido_id) AS deporte_nombre, privado, p.imagen, c.nombre AS campo_nombre,  cr.fecha_desde,
		c.ubicacion, CONCAT(ui.nombre, \' \', IFNULL(ui.apellido, \'\')) AS usuario_nombre, IFNULL(p.cancha_reservada_id, 0) AS cancha_reservada_id');
		$this->db->from('partido p');
		$this->db->join('user_info ui', 'ui.id_user = p.creador_user_id');
		$this->db->join('cancha_resevada cr', 'cr.cancha_reservada_id = p.cancha_reservada_id', 'left');
		$this->db->join('campo_canchas cc', 'cc.campo_cancha_id = cr.campo_cancha_id', 'left');
		$this->db->join('campo c', 'c.campo_id = cc.campo_id', 'left');

		$this->db->where("p.partido_id", $partido_id);

		$query = $this->db->get();
		$result = $query->row();
		//var_dump($this->db->last_query());
		return $result;
	}
	

	public function getMisPartidos($user_id)
	{
		$this->db->select('p.partido_id, p.nombre, p.imagen, (SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM partido_deportes pd 
    INNER JOIN deporte d ON pd.deporte_id = d.deporte_id
		WHERE pd.partido_id = p.partido_id) AS deporte_nombre, cr.fecha_desde, CONCAT(ui.nombre, \' \', IFNULL(ui.apellido, \'\')) AS usuario_nombre, 
		IFNULL(p.cancha_reservada_id, 0) AS cancha_reservada_id');
		$this->db->from('partido p');
		$this->db->join('user_info ui', 'ui.id_user = p.creador_user_id');
		$this->db->join('cancha_resevada cr', 'cr.cancha_reservada_id = p.cancha_reservada_id', 'left');
		$this->db->join('campo_canchas cc', 'cc.campo_cancha_id = cr.campo_cancha_id', 'left');
		$this->db->join('campo c', 'c.campo_id = cc.campo_id', 'left');

		$this->db->where("$user_id IN (SELECT user_id FROM partido_miembros pm WHERE pm.partido_id = p.partido_id AND pm.confirmado = 1)", NULL, FALSE);

		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
	}

	public function getPartidoDeportes($partido_id){
		$this->db->select('d.deporte_id, d.nombre');
		$this->db->from('partido_deportes pd');
		$this->db->join('deporte d', 'd.deporte_id = pd.deporte_id');

		$this->db->where("pd.partido_id", $partido_id);

		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
	}

	public function esMiembro($partido_id, $user_id){
		$this->db->select('user_id, es_admin');
		$this->db->from('partido_miembros pm');
		$this->db->where("pm.partido_id", $partido_id);
		$this->db->where("pm.confirmado", 1);
		$this->db->where("pm.user_id", $user_id);

		$query = $this->db->get();
		$result = $query->row();
		//var_dump($this->db->last_query());
		return $result;
	}

	public function getPartidos($deporte, $provincia, $distrito, $fecha_desde, $fecha_hasta, $user_id, $reservado)
	{
		$this->db->select('p.partido_id, p.creador_user_id, p.nombre, p.imagen, (SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM partido_deportes pd 
    INNER JOIN deporte d ON pd.deporte_id = d.deporte_id
    WHERE pd.partido_id = p.partido_id) AS deporte_nombre, fecha_desde,
		CONCAT(ui.nombre, \' \', IFNULL(ui.apellido, \'\')) AS usuario_nombre, IFNULL(p.cancha_reservada_id, 0) AS cancha_reservada_id');
		$this->db->from('partido p');
		$this->db->join('user_info ui', 'ui.id_user = p.creador_user_id');
		$this->db->join('cancha_resevada cr', 'cr.cancha_reservada_id = p.cancha_reservada_id', 'left');
		$this->db->join('campo_canchas cc', 'cc.campo_cancha_id = cr.campo_cancha_id', 'left');
		$this->db->join('campo c', 'c.campo_id = cc.campo_id', 'left');

		$this->db->where("(p.privado = 0 OR (p.privado = 1 AND " .  $user_id . " IN (SELECT user_id FROM partido_miembros pm WHERE pm.partido_id = p.partido_id)))", NULL, FALSE);
		
		$this->db->where("cr.cancha_reservada_id " . ($reservado == 1 ? "IS NOT NULL" : "IS NULL"), NULL, FALSE);
		
		if($deporte != ""){
			$this->db->where($deporte . " IN (SELECT d.deporte_id FROM partido_deportes pd JOIN deporte d ON pd.deporte_id = d.deporte_id WHERE pd.partido_id = p.partido_id)", null, FALSE);
		}

		if($provincia != ""){
			$this->db->where('c.ubprov_id', $provincia);;
		}

		if($distrito != ""){
			$this->db->where('c.ubdistri_id', $distrito);;
		}
		
		if($reservado == 1){
			$str_fecha_desde = (strpos($fecha_desde, ":") > 0 ? $fecha_desde : $fecha_desde . " 00:00");
			$this->db->where("cr.fecha_desde >= '" . $str_fecha_desde . "'");
			$this->db->where("cr.fecha_desde <= '$fecha_hasta 23:59'");
		}
		
		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
	}
}
