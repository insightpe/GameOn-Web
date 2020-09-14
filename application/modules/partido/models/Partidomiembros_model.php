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
class Partidomiembros_model extends CI_Model
{

	//put your code here
	private $table = "partido_miembros";
	private $id = "partido_miembro_id";

	public function __construct()
	{
		parent::__construct();
	}

	public function delete($id)
	{
		$this->db->delete($this->table, array($this->id => $id));
		return $this->db->affected_rows();
	}

	public function existeSolicitudPartido($partido_id, $user_id)
	{

			$query = $this->db->get_where($this->table, ["user_id" => $user_id, "partido_id" => $partido_id, "confirmado" => 0, "es_admin" => 0]);
			$row = $query->row();

			return $row;

  }

	public function getByUserIdPartido($partido_id, $user_id)
	{

			$query = $this->db->get_where($this->table, ["user_id" => $user_id, "partido_id" => $partido_id]);
			$row = $query->row();

			return $row;

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
  
  public function getMiembros($partido_id)
	{
    $this->db->select('pm.partido_miembro_id, p.partido_id, pm.user_id, p.nombre, u.es_google_login, u.es_facebook_login, u.user_name, CONCAT(ui.nombre, \' \', IFNULL(ui.apellido, \'\')) AS usuario_nombre, ui.user_img_profile, pm.es_admin, 
    (SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM user_deportes ud INNER JOIN deporte d ON d.deporte_id = ud.deporte_id WHERE ud.user_id = ui.id_user) AS user_deportes');
		$this->db->from($this->table . ' pm');
		$this->db->join('partido p', 'p.partido_id = pm.partido_id');
		$this->db->join('users u', 'u.id = pm.user_id');
    $this->db->join('user_info ui', 'ui.id_user = pm.user_id');
	
		$this->db->where("p.partido_id", $partido_id);
		$this->db->where("pm.confirmado", 1);
		
		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
	}
	
	public function getMiembrosSolicitudes($partido_id, $es_admin)
	{
    $this->db->select('pm.partido_miembro_id, p.partido_id, pm.user_id, p.nombre, u.es_google_login, u.es_facebook_login, u.user_name, CONCAT(ui.nombre, \' \', IFNULL(ui.apellido, \'\')) AS usuario_nombre, ui.user_img_profile, pm.es_admin, 
    (SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM user_deportes ud INNER JOIN deporte d ON d.deporte_id = ud.deporte_id WHERE ud.user_id = ui.id_user) AS user_deportes');
		$this->db->from($this->table . ' pm');
		$this->db->join('partido p', 'p.partido_id = pm.partido_id');
		$this->db->join('users u', 'u.id = pm.user_id');
		$this->db->join('user_info ui', 'ui.id_user = pm.user_id');
	
		$this->db->where("p.partido_id", $partido_id);
		$this->db->where("IFNULL(pm.confirmado, 0) = 0");
		if($es_admin == 1){
			$this->db->where("pm.es_invitado", 0);
		}
		
		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
  }
  
  public function buscarMiembros($partido_id, $buscarPor)
	{
    $this->db->select('u.id, CONCAT(ui.nombre, \' \', IFNULL(ui.apellido, \'\')) AS usuario_nombre, ui.user_img_profile, u.user_name, u.es_google_login, u.es_facebook_login, 
    (SELECT GROUP_CONCAT(DISTINCT d.nombre) FROM user_deportes ud INNER JOIN deporte d ON d.deporte_id = ud.deporte_id WHERE ud.user_id = u.id) AS user_deportes');
		$this->db->from('users u');
    $this->db->join('user_info ui', 'ui.id_user = u.id');
    $this->db->where('NOT u.id IN (SELECT user_id FROM ' . $this->table . ' pm WHERE pm.partido_id = ' . $partido_id .  ')', NULL, FALSE);
    $this->db->where("u.user_role_id", USER_ROLE);
    if($buscarPor != ""){
      $this->db->group_start();
      $this->db->like("u.user_email", $buscarPor);
      $this->db->or_like("CONCAT(ui.nombre, ' ',  IFNULL(ui.apellido, ''))", $buscarPor);
      $this->db->group_end();
    }

		$query = $this->db->get();
		$result = $query->result();
		//var_dump($this->db->last_query());
		return $result;
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
    //var_dump($this->db->last_query());
		return $this->db->affected_rows();
	}
}
