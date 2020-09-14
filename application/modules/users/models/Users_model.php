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
class Users_model extends CI_Model {

    //put your code here
    private $table = "users";
    private $id = "id";

    public function __construct() {
        parent::__construct();
    }
  
    public function getInfo($id = FALSE) {
      $this->db->join('user_info ui', 'ui.id_user = ' . $this->table . ".id");
      if ($id) {
          $query = $this->db->get_where($this->table, [$this->id => $id]);
          return $query->row();
      }

      $query = $this->db->get($this->table);
      return $query->result();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->id => $id));
        return $this->db->affected_rows();
    }

    public function getUserByEmailF($email) {
      $this->db->select('u.*, ui.nombre, ui.apellido, ui.user_img_profile,r.role, e.Nombre AS estado_nombre');
      $this->db->from('users u, user_info ui, roles r, estado e');
      $this->db->where('u.id = ui.id_user AND u.user_role_id = r.role_id AND e.EstadoID = u.user_status_id');
      $this->db->where('user_email', $email);
      $this->db->where('es_facebook_login', 1);

      $query = $this->db->get();
    //$query = $this->db->get_where($this->table, ['user_email' => $email]);
    return $query->row();
  }

    public function getUserByEmailG($email) {
      $this->db->select('u.*, ui.nombre, ui.apellido, ui.user_img_profile,r.role, e.Nombre AS estado_nombre');
      $this->db->from('users u, user_info ui, roles r, estado e');
      $this->db->where('u.id = ui.id_user AND u.user_role_id = r.role_id AND e.EstadoID = u.user_status_id');
      $this->db->where('user_email', $email);
      $this->db->where('es_google_login', 1);

      $query = $this->db->get();
    //$query = $this->db->get_where($this->table, ['user_email' => $email]);
    return $query->row();
  }

    public function getUserByEmail($email) {
        $this->db->select('u.*, ui.nombre, ui.apellido, ui.user_img_profile,r.role, e.Nombre AS estado_nombre, es_google_login, es_facebook_login');
        $this->db->from('users u, user_info ui, roles r, estado e');
        $this->db->where('u.id = ui.id_user AND u.user_role_id = r.role_id AND e.EstadoID = u.user_status_id');
        $this->db->where('user_email', $email);
  
        $query = $this->db->get();
      //$query = $this->db->get_where($this->table, ['user_email' => $email]);
      return $query->row();
    }

    public function getUserByCode($code) {
      $this->db->select('u.*, ui.nombre, ui.apellido, ui.user_img_profile,r.role, e.Nombre AS estado_nombre');
      $this->db->from('users u, user_info ui, roles r, estado e');
      $this->db->where('u.id = ui.id_user AND u.user_role_id = r.role_id AND e.EstadoID = u.user_status_id');
      $this->db->where('user_activation_code', $code);

      $query = $this->db->get();
    //$query = $this->db->get_where($this->table, ['user_email' => $email]);
    return $query->row();
    }

    public function get($id = FALSE) {
        if ($id) {
            $query = $this->db->get_where($this->table, [$this->id => $id]);
            $row = $query->row();

            return $row;
        }
        $query = $this->db->get($this->table);
        return $query->result();
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
    
    public function getDeportes($user_id) {
      $this->db->select('d.deporte_id, d.nombre');
      $this->db->from('user_deportes ud');
      $this->db->join('deporte d', 'd.deporte_id = ud.deporte_id');
      $this->db->where('ud.user_id', $user_id);
      $query = $this->db->get();
      return $query->result();
    }

    public function getUsers() {
        $this->db->select('u.*, ui.nombre,r.role, e.Nombre AS estado_nombre');
        $this->db->from('users u, user_info ui, roles r, estado e');
        $this->db->where('u.user_role_id = r.role_id AND e.EstadoID = u.user_status_id');
        if($_SESSION['is_super_admin'] == "0"){
          $this->db->where('u.is_super_admin != 1');
        }

        $query = $this->db->get();
        return $query->result();
    }

   
  public function getAllUsersId() {
    $this->db->select('u.id');
    $this->db->from('users u');
    $query = $this->db->get();
    return $query->result();
  }

  public function getAllUsers() {
    $this->db->select();
    $this->db->from('users u');
    $query = $this->db->get();
    return $query->result();
  }

    public function getUser($id) {
        $this->db->select('u.user_email,r.role');
        $this->db->from('users u, roles r');
        $this->db->where('u.user_role_id = r.role_id and u.id = ' . $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getByRole($role_id) {
        $query = $this->db->get_where($this->table, ['user_role_id' => $role_id]);
        return $query->result();
    }

    public function getActivesByRole($role_id) {
      $query = $this->db->get_where($this->table, ['user_role_id' => $role_id]);
      return $query->result();
    }

    public function list() {
      $this->datatables->select('id, user_email, nombre, role, estado, user_status_id');
      $this->datatables->from('get_list_user u' );

      $result = $this->datatables->generate();

      return $result;
    }
}
