<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Form_validation
 *
 * @author furbox
 */
class MY_Form_validation extends CI_Form_validation
{

	public $CI;

	public function __construct($rules = array())
	{
		parent::__construct($rules);
		$this->CI = &get_instance();
		$this->CI->load->model("Configuraciones/Config_model");
	}

	public function check_password_strength($password)
	{
		$argument = TRUE;
		// (?=.{' . config_item('min_chars_for_password') . ',}) means string should be at least length specified in site definitions hook
		// (?=.*\d) means string should have at least one digit
		// (?=.*[a-z]) means string should have at least one lower case letter
		// (?=.*[A-Z]) means string should have at least one upper case letter
		// (?!.*\s) means no space, tab, or other whitespace chars allowed
		// (?!.*[\\\\\'"]) means no backslash, apostrophe or quote chars are allowed
		// (?=.*[@#$%^&+=]) means there has to be at least one of these characters in the password @ # $ % ^ & + =

		if ($argument[0] === 'FALSE' && empty($password)) {
			// If the password is not required, and if it is empty, no reason to proceed
			return TRUE;
		} else if (preg_match('/^(?=.{8,16})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?!.*[\\\\\'"]).*$/', $password)) {
			return $password;
		} else {
			$this->CI->form_validation->set_message(
				'check_password_strength',
				'<span class="redfield">%s</span> debe contener:
					<ol>
						<li>Al menos 8 caracteres</li>
						<li>No mas de 16 caracteres</li>
						<li>Un Numero</li>
                                                <li>Una letra Minuscula</li>
						<li>Una Letra Mayuscula</li>
						<li>Sin Espacios entre caracteres</li>
						<li>No debe contener Barra invertida, apóstrofe o comillas</li>
					</ol>
				</span>'
			);

			return FALSE;
		}
	}

	public function custom_valid_url($fieldvalue, $params)
	{
		$parameters = explode("||", $params);

		$fieldname = $parameters[0];
		$label = $parameters[1];

		$external_url = $fieldvalue;

		if($external_url == null || $external_url == "") return TRUE;

		if (!filter_var($external_url, FILTER_VALIDATE_URL) === false) {
			return TRUE;
		} else {
			$this->CI->form_validation->set_message('custom_valid_url', 'El campo ' . $label . ' no es una url válida.');
			return FALSE;
		}
	}

	//validacion de folios nuevos
	public function check_folios()
	{
		$this->CI->load->model("Inventory/Inventory_model");
		$alfa = $this->CI->input->post('inventory_alpha');
		$folio_de = $this->CI->input->post('inventory_de');
		$folio_hasta = $this->CI->input->post('inventory_hasta');

		$folios = $this->CI->Inventory_model->getByFolios($alfa, $folio_de, $folio_hasta);
		if (count($folios) > 0) {
			$this->CI->form_validation->set_message('check_folios', 'Algunos o todos los folios ya existen.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_folios_mayor()
	{
		$folio_de = $this->CI->input->post('inventory_de');
		$folio_hasta = $this->CI->input->post('inventory_hasta');
		if ($folio_de > $folio_hasta) {
			$this->CI->form_validation->set_message('check_folios_mayor', 'El folio de, debe ser menor al folio hasta.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_folios_protocolo()
	{
		$folio_de = $this->CI->input->post('inventory_de');
		$folio_hasta = $this->CI->input->post('inventory_hasta');
		$orden = $this->CI->Config_model->getConfigOrden(1);
		if ($orden == 'asc') {
			if ($folio_de > $folio_hasta) {
				$this->CI->form_validation->set_message('check_folios_mayor', 'El folio de, debe ser menor al folio hasta.');
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			if ($folio_de < $folio_hasta) {
				$this->CI->form_validation->set_message('check_folios_mayor', 'El folio de, debe ser mayor al folio hasta.');
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}

	public function valid_folios()
	{
		$this->CI->load->model("Inventory/Inventory_model");
		$folio_de = $this->CI->input->post('printer_de');
		$folio_hasta = $this->CI->input->post('printer_hasta');

		$series = $this->CI->Inventory_model->getSeriesByFolios($folio_de, $folio_hasta);
		if (count($series) > 0) {
			$this->CI->form_validation->set_message('valid_folios', 'No se pueden usar mas de 2 Prefijos');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//validacion de usuario
	public function check_valid_user()
	{
		$this->CI->load->model("Users/Users_model");
		$this->CI->load->library("Utilities");
		$id_user = $this->CI->input->post('assignment_user_id');
		$email_user = $this->CI->input->post('assignment_user');
		$pass_user = $this->CI->input->post('assignment_pass');

		$user = $this->CI->Users_model->getUserByEmail($email_user);
		if (count($user) != 1) {
			$this->CI->form_validation->set_message('check_valid_user', 'El impresor no existe.');
			return FALSE;
		}

		if ($user->id != $id_user) {
			$this->CI->form_validation->set_message('check_valid_user', 'Datos de impresor no validos.');
			return FALSE;
		}

		$check_passwd = $this->CI->utilities->check_passwd($user->user_pass, $user->user_salt, $pass_user);
		if (!$check_passwd) {
			$this->CI->form_validation->set_message('check_valid_user', 'Datos de impresor no validos.');
			return FALSE;
		}

		return TRUE;
	}

	public function custom_is_unique($field_value, $params)
	{
		$parameters = explode("||", $params);

		$table = explode(".", $parameters[0])[0];
		$field = explode(".", $parameters[0])[1];
		$field_id = $parameters[1];
		$control = $parameters[2] == "0" ? "" : $parameters[2];
		$where = $parameters[3];
		$label = $parameters[4];

		$arr_where = null;
		if(count($parameters) > 5){
			$where_pair = explode("£", $parameters[5]);
			$arr_where = [];
			
			for($xI=0;$xI<count($where_pair);$xI=$xI+2){
				$arr_where[$where_pair[$xI]] = $this->CI->input->post($where_pair[$xI+1]);
			}
		}

		//$this->CI->load->model("Configuraciones/Config_model");
		$this->CI->load->library("Utilities");

		$id = 0;

		if ($control != "") {
			$id = $this->CI->input->post($control);
		}
		//var_dump($parameters);
		$rows = $this->CI->Config_model->custom_is_unique($table, $field, $field_id, $where, $id, $field_value, $arr_where);

		if ($rows->count > 0) {
			$this->CI->form_validation->set_message('custom_is_unique', 'El campo ' . $label . ' debe contener un valor único.');
			return FALSE;
		}

		return TRUE;
	}

	public function check_valid_user_control()
	{
		$this->CI->load->model("Users/Users_model");
		$this->CI->load->library("Utilities");
		$id_user = $this->CI->input->post('control_user_id');
		$email_user = $this->CI->input->post('control_email');
		$pass_user = $this->CI->input->post('control_pass');

		$user = $this->CI->Users_model->getUserByEmail($email_user);
		if (count($user) != 1) {
			$this->CI->form_validation->set_message('check_valid_user_control', 'El usuario no existe.');
			return FALSE;
		}

		if ($user->id != $id_user) {
			$this->CI->form_validation->set_message('check_valid_user_control', 'Datos de usuario no validos.');
			return FALSE;
		}

		$check_passwd = $this->CI->utilities->check_passwd($user->user_pass, $user->user_salt, $pass_user);
		if (!$check_passwd) {
			$this->CI->form_validation->set_message('check_valid_user_control', 'Datos de usuario no validos.');
			return FALSE;
		}

		return TRUE;
	}

	public function check_assignment()
	{
		$this->CI->load->model("Users/Users_model");
		$this->CI->load->library("Utilities");
		$de = $this->CI->input->post('assignment_de');
		$hasta = $this->CI->input->post('assignment_hasta');

		if ($de > $hasta) {
			$this->CI->form_validation->set_message('check_assignment', 'El valor DE debe ser menor al valor de HASTA.');
			return FALSE;
		}
		return TRUE;
	}

	public function check_valid_user_auditor()
	{
		$this->CI->load->model("Users/Users_model");
		$this->CI->load->library("Utilities");
		$id_user = $this->CI->input->post('auditor_user_id');
		$email_user = $this->CI->input->post('control_email');
		$pass_user = $this->CI->input->post('control_pass');

		$user = $this->CI->Users_model->getUserByEmail($email_user);
		if (count($user) != 1) {
			$this->CI->form_validation->set_message('check_valid_user_auditor', 'El usuario no existe.');
			return FALSE;
		}

		if ($user->id != $id_user) {
			$this->CI->form_validation->set_message('check_valid_user_auditor', 'Datos de usuario no validos.');
			return FALSE;
		}

		$check_passwd = $this->CI->utilities->check_passwd($user->user_pass, $user->user_salt, $pass_user);
		if (!$check_passwd) {
			$this->CI->form_validation->set_message('check_valid_user_auditor', 'Datos de usuario no validos.');
			return FALSE;
		}

		return TRUE;
	}

	//validacion del captcha
	public function validate_captcha()
	{
		if ($this->CI->security->xss_clean(strip_tags($this->CI->input->post('user_captcha'))) != $this->CI->session->userdata('captcha')) {
			$this->CI->form_validation->set_message('validate_captcha', 'Error de Captcha');
			return false;
		} else {
			return true;
		}
	}
}
