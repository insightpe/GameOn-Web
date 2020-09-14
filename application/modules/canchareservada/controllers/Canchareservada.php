<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Canchareservada
 *
 * @author furbox
 */
class Canchareservada extends MY_Controller
{

	//put your code here
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			"Canchareservada_model",
			"Campos/Campos_model"
		]);
		$this->load->library('Utilities');
	}

	function footer_scripts($ui)
	{
		$return = "<script src='" . base_url('assets') . "/js/custom/canchareservada.custom.js'></script>";
		switch ($ui) {
			case "list":
				$return .= "<script src='" . base_url('assets') . "/js/custom/canchareservada.list.custom.js'></script>";
				break;
			case "add":
			case "update":
				$return .= "<script src='" . base_url('assets') . "/js/custom/canchareservada.dataentry.custom.js'></script>";
				break;
		}
		return $return;
	}

	public function list_canchareservada()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_canchareservada');
		$this->acl->acceso('list_canchareservada');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Lista de Reservas";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Reservas";
		$data->header_description = "Lista de Reservas";
		$data->dash_container = "canchareservada/list_canchareservada";
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "canchareservada";
		$data->campos = $this->Campos_model->get();
		$data->deportes = $this->Campos_model->getDeportes($data->campos[0]->campo_id);
		$data->campo_canchas = $this->Campos_model->getCampoCanchasByDeporte($data->campos[0]->campo_id, $data->deportes[0]->deporte_id);
		$data->footer_scripts = $this->footer_scripts("list");

		$this->template->call_admin_template($data);
	}

	public function get_list_canchareservada()
	{
		if ($this->input->is_ajax_request()) {
			$campo_id = $this->input->post('campo_id', TRUE);
			$campo_cancha_id = $this->input->post('campo_cancha_id', TRUE);
			$deporte_id = $this->input->post('deporte_id', TRUE);
			$start = date('Y-m-d H:i:s',  strtotime($this->input->post('start', TRUE)));
			$end = date('Y-m-d H:i:s', strtotime($this->input->post('end', TRUE)));

			$response = $this->Canchareservada_model->listForCalendar($campo_id, $deporte_id, $campo_cancha_id, $start, $end);

			echo json_encode($response);

			exit;
		}
	}

	public function get_list_deportes()
	{
		$campo_id = $this->input->post('campo_id');

		$response = $this->Campos_model->getDeportes($campo_id);

		echo json_encode($response);
	}

	public function get_list_campo_canchas()
	{
		$campo_id = $this->input->post('campo_id');
		$deporte_id = $this->input->post('deporte_id');

		$response = $this->Campos_model->getCampoCanchasByDeporte($campo_id, $deporte_id);

		echo json_encode($response);
	}

	public function get_canchareservada()
	{
		$id_canchareservada = $this->input->post('canchareservada');

		$response = $this->Canchareservada_model->get($id_canchareservada);

		echo json_encode($response);
	}
}
