<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Chat_model
 *
 * @author furbox
 */
class Chat_model extends CI_Model
{

	//put your code here
	private $table = "chat";
	private $id = "chat_id";

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

		$query = $this->db->get($this->table);
		return $query->result(); //muchas o 0
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

  public function listNewMessages($user_id, $fecha_hora)
	{
    $this->db->select('COUNT(*) AS conteo, c.partido_id, p.nombre');
    $this->db->limit(1);
    $this->db->from($this->table . ' c');
    $this->db->join('partido p', 'c.partido_id = p.partido_id');
    $this->db->where('c.partido_id IN (SELECT DISTINCT partido_id FROM partido_miembros pm WHERE pm.confirmado = 1 AND pm.user_id = ' . $user_id . ')', NULL, FALSE);
    $this->db->where("timestamp >= '$fecha_hora'", NULL, FALSE);
    $this->db->group_by("c.partido_id, p.nombre");
		$query = $this->db->get();
		$result = $query->row();
    //var_dump($this->db->last_query());
		return $result;
	}

	public function listByPartidoId($partido_id)
	{
    $this->db->select('c.chat_id, c.message, c.timestamp, c.status, uis.nombre AS enviador_nombre, uis.user_img_profile AS enviador_img,
    us.es_google_login AS enviador_es_google_login, us.id AS user_id, us.es_facebook_login AS enviador_es_facebook_login');
    //, uir.nombre AS receptor_nombre, uir.user_img_profile AS receptor_img,
    //ur.es_google_login AS receptor_es_google_login, ur.es_facebook_login AS receptor_es_facebook_login
    $this->db->from($this->table . ' c');
    $this->db->join('users us', "us.id = c.sender_user_id");
    //$this->db->join('users ur', "ur.id = c.reciever_user_id");
    $this->db->join('user_info uis', "uis.id_user = c.sender_user_id");
		//$this->db->join('user_info uir', "uir.id_user = c.reciever_user_id");
		$this->db->where('c.partido_id', $partido_id);
    $this->db->order_by("timestamp", "asc");
		$query = $this->db->get();
		$result = $query->result();
    //var_dump($this->db->last_query());
		return $result;
	}
}
