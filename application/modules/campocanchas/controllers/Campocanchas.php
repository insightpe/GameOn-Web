<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CampoCanchas
 *
 * @author furbox
 */
class CampoCanchas extends MY_Controller
{

	//put your code here
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			"CampoCanchas_model",
			"Campos/Campos_model",
			"Campos/Campoestado_model",
			"Deportes/Deportes_model",
			"Canchahorariodiahora_model",
			"Canchahorariodia_model",
		]);
		$this->load->library('Utilities');
	}

	//    public function getCanchae($campocanchas_id = FALSE) {
	//        if ($campocanchas_id) {
	//            return $this->CampoCanchas_model->get($campocanchas_id);
	//        } else {
	//            return $this->CampoCanchas_model->get();
	//        }
	//    }

	function footer_scripts($ui)
	{
		$return = "<script src='" . base_url('assets') . "/js/custom/campocanchas.custom.js'></script>";
		switch ($ui) {
			case "list":
				$return .= "<script src='" . base_url('assets') . "/js/custom/campocanchas.list.custom.js'></script>";
				break;
			case "add":
			case "update":
				$return .= "<script src='" . base_url('assets') . "/js/custom/campocanchas.dataentry.custom.js'></script>";
				break;
		}
		return $return;
	}

	public function list_campocanchas()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_campocanchas');
		$this->acl->acceso('list_campocanchas');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Lista de Canchas";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Canchas";
		$data->header_description = "Lista de Canchas";
		$data->dash_container = "campocanchas/list_campocanchas";
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "campocanchas";
		$data->footer_scripts = $this->footer_scripts("list");
		$data->campos = $this->Campos_model->get();
		$data->deportes = $this->Deportes_model->get();
		$tmpl = array('table_open' => '<table id="dt-campocanchas" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
		$this->table->set_template($tmpl);
		$this->table->set_heading(["Campo", "Nombre", "Deporte", "Estado", "Acciones"]);

		$this->template->call_admin_template($data);
	}

	public function get_list_campocanchas()
	{
		if ($this->input->is_ajax_request()) {
			$campos = $_GET["campo_id"];
			$deportes = $_GET["deporte_id"];
			$response = $this->CampoCanchas_model->list($campos, $deportes);

			echo $response;

			exit;
		}
	}

	public function form_new_campocancha()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_campocanchas');
		$this->acl->acceso('form_new_campocanchas');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Agregar Cancha";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->header_title = "Módulo de Canchas";
		$data->header_description = "Agregar Cancha";
		$data->dash_container = "campocanchas/form_new_campocanchas";
		$data->footer_scripts = $this->footer_scripts("add");
		$data->active = "campocanchas";
		$data->campos = $this->Campos_model->get();
		$data->deportes = $this->Deportes_model->get();
		$data->campo_estados = $this->Campoestado_model->get();
		$data->campocanchas = $this->CampoCanchas_model->get();
		$this->template->call_admin_template($data);
	}

	public function add_campocancha()
	{
		$this->load->library('form_validation');

		if ($this->form_validation->run('add_campocanchas') == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $errors]);
		} else {

			$nombre = $this->security->xss_clean($this->input->post('nombre', TRUE));
			$campo_id = $this->security->xss_clean($this->input->post('campo_id', TRUE));
			$deporte_id = $this->security->xss_clean($this->input->post('deporte_id', TRUE));
			$campo_estado_id = $this->security->xss_clean($this->input->post('campo_estado_id', TRUE));

			$insert = [
				"nombre" => $nombre,
				"campo_id" => $campo_id,
				"deporte_id" => $deporte_id,
				"campo_estado_id" => $campo_estado_id,
			];

			$id = $this->CampoCanchas_model->insert($insert);

			$index = 1;
			for($xI=1; $xI<=7; $xI++){
				for($xZ=0; $xZ<=23; $xZ++){
					$precio = $this->input->post('txthourday_'.$index, TRUE);

					$campocanchadiahora = $this->Canchahorariodiahora_model->getIdByDayHour($id, $xI, $xZ);

					if($campocanchadiahora == null){
						if($precio == null || trim($precio) == "") {$index++;continue;}
						if(!is_numeric($precio)) {$index++;continue;}

						$campocanchashoraridiahora_db = [
							"campo_cancha_id" => $id,
							"dia" => $xI,
							"hora" => $xZ,
							"precio" =>$precio,
						];

						$this->Canchahorariodiahora_model->insert($campocanchashoraridiahora_db);
					}else{
						if($precio == null || trim($precio) == "" || !is_numeric($precio)){
							$campocanchashoraridiahora_db = [
								"campo_cancha_id" => $id,
								"dia" => $xI,
								"hora" => $xZ,
								"precio" => null,
							];
						}else{
							$campocanchashoraridiahora_db = [
								"campo_cancha_id" => $id,
								"dia" => $xI,
								"hora" => $xZ,
								"precio" => $precio,
							];
						}
						$this->Canchahorariodiahora_model->update($campocanchadiahora->cancha_horario_dia_horas_id, $campocanchashoraridiahora_db);
					}
					
					$index++;
				}
			}

			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-campocanchas")]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo crear la Cancha, intentalo de nuevo."]);
			}
		}
	}

	public function form_edit_campocancha($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_campocanchas');
		$this->acl->acceso('form_edit_campocanchas');
		$data = new stdClass();
		if ($id) {
			$id = (int) $id;
		} else {
			$id = (int) $this->uri->segment(2);
		}

		if (!$id) {
			$this->session->set_flashdata('message_error', "Cancha no válida");
			redirect('listar-campocanchas');
		}
		if (!is_int($id)) {
			$this->session->set_flashdata('message_error', "Información no válida");
			redirect('listar-campocanchas');
		}
		$campo_cancha = $this->CampoCanchas_model->get($id);
		if (!count($campo_cancha) == 1) {
			$this->session->set_flashdata('message_error', "Cancha no encontrada");
			redirect('listar-campocanchas');
		}

		$data->title = APP_NAME . " :: Dashboard :: Editar Cancha";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Canchas";
		$data->header_description = "Editar Cancha";
		$data->dash_container = "campocanchas/form_edit_campocanchas";
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "users";
		$data->campos = $this->Campos_model->get();
		$data->deportes = $this->Deportes_model->get();
		$data->campo_estados = $this->Campoestado_model->get();
		$data->campocanchas = $this->CampoCanchas_model->get();
		$data->campocanchadiahoras = $this->Canchahorariodiahora_model->getIdByCampoCanchaId($id);
		$data->footer_scripts = $this->footer_scripts("update");

		$data->campo_cancha = $campo_cancha;
		$this->template->call_admin_template($data);
	}

	public function update_campocancha()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');

		if ($this->form_validation->run('update_campocanchas') == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $errors]);
		} else {
			$nombre = $this->security->xss_clean($this->input->post('nombre', TRUE));
			$campo_id = $this->security->xss_clean($this->input->post('campo_id', TRUE));
			$deporte_id = $this->security->xss_clean($this->input->post('deporte_id', TRUE));
			$campo_estado_id = $this->security->xss_clean($this->input->post('campo_estado_id', TRUE));

			$campocanchas_db = [
				"nombre" => $nombre,
				"campo_id" => $campo_id,
				"deporte_id" => $deporte_id,
				"campo_estado_id" => $campo_estado_id,
			];

			$this->CampoCanchas_model->update($id, $campocanchas_db);

			//"Canchahorariodiahora_model",
			$index = 1;
			for($xI=1; $xI<=7; $xI++){
				for($xZ=0; $xZ<=23; $xZ++){
					$precio = $this->input->post('txthourday_'.$index, TRUE);

					$campocanchadiahora = $this->Canchahorariodiahora_model->getIdByDayHour($id, $xI, $xZ);

					if($campocanchadiahora == null){
						if($precio == null || trim($precio) == "") {$index++;continue;}
						if(!is_numeric($precio)) {$index++;continue;}

						$campocanchashoraridiahora_db = [
							"campo_cancha_id" => $id,
							"dia" => $xI,
							"hora" => $xZ,
							"precio" =>$precio,
						];

						$this->Canchahorariodiahora_model->insert($campocanchashoraridiahora_db);
					}else{
						if($precio == null || trim($precio) == "" || !is_numeric($precio)){
							$campocanchashoraridiahora_db = [
								"campo_cancha_id" => $id,
								"dia" => $xI,
								"hora" => $xZ,
								"precio" => null,
							];
						}else{
							$campocanchashoraridiahora_db = [
								"campo_cancha_id" => $id,
								"dia" => $xI,
								"hora" => $xZ,
								"precio" => $precio,
							];
						}
						$this->Canchahorariodiahora_model->update($campocanchadiahora->cancha_horario_dia_horas_id, $campocanchashoraridiahora_db);
					}
					
					$index++;
				}
			}

			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-campocanchas")]);
			} else {
				echo json_encode(['error' => $this->lang->line('campocanchas_message_error_update')]);
			}
		}
	}

	public function delete_campocancha($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->accesoJSON('mudule_access_campocanchas');
		$this->acl->accesoJSON('delete_campocanchas');
		if (!$id) {
			$id = (int) $this->uri->segment(2);
		} else {
			$id = (int) $id;
		}

		if (!$id) {
			echo json_encode(['error' => "Cancha no válida"]);
			return;
		}
		if (!is_int($id)) {
			echo json_encode(['error' => "Información no Valida"]);
			return;
		}
		$campo_cancha = $this->CampoCanchas_model->get($id);
		if (!count($campo_cancha) == 1) {
			echo json_encode(['error' => "Cancha no encontrada"]);
			return;
		}

		if ($this->CampoCanchas_model->existsCanchaInReserva($id)) {
				echo json_encode(['error'=>"La Cancha no se ha eliminado debido a que esta asignada a una reserva"]);
				return;
		}

		$id = $this->CampoCanchas_model->delete($id);
		if ($id > 0) {
			echo json_encode(['redirect' => base_url("listar-campocanchas")]);
			return;
		} else {
			echo json_encode(['error' => "La Cancha no se ha eliminado."]);
			return;
		}
	}

	public function get_campocancha()
	{
		$id_campocanchas = $this->input->post('campocanchas');

		$response = $this->CampoCanchas_model->get($id_campocanchas);

		echo json_encode($response);
	}
}
