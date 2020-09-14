<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Campos
 *
 * @author furbox
 */
class Campos extends MY_Controller
{

	//put your code here
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Campos_model");
		$this->load->model("Campoimagenes_model");
		$this->load->model("Campoestado_model");
		$this->load->model("Ubigeo/Departamento_model");
		$this->load->model("Ubigeo/Provincia_model");
		$this->load->model("Ubigeo/Distrito_model");
		$this->load->library('Utilities');
	}

	function footer_scripts($ui)
	{
		$return = "<script src='" . base_url('assets') . "/js/custom/campo.custom.js'></script>";
		switch ($ui) {
			case "list":
				$return .= "<script src='" . base_url('assets') . "/js/custom/campo.list.custom.js'></script>";
				break;
			case "add":
			case "update":
				$return .= "<script src='" . base_url('assets') . "/js/custom/campo.dataentry.custom.js'></script>";
				break;
		}
		return $return;
	}

	public function list_campos()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_campos');
		$this->acl->acceso('list_campos');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Lista de Centros Deportivos";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Centros Deportivos";
		$data->header_description = "Lista de Centros Deportivos";
		$data->dash_container = "campos/list_campos";
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "campos";
		$data->footer_scripts = $this->footer_scripts("list");
		$tmpl = array('table_open' => '<table id="dt-campos" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
		$this->table->set_template($tmpl);
		$this->table->set_heading(["Nombre", "Ubicación", "Estado", "Acciones"]);

		$this->template->call_admin_template($data);
	}

	public function get_list_campos()
	{
		if ($this->input->is_ajax_request()) {

			$response = $this->Campos_model->list();

			echo $response;

			exit;
		}
	}

	public function get_list_detallefotos()
	{
		if ($this->input->is_ajax_request()) {
			$campo_id = $_GET["campo_id"];
			$response = $this->Campoimagenes_model->list($campo_id);

			echo $response;

			exit;
		}
	}

	public function form_new_campo()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_campos');
		$this->acl->acceso('form_new_campo');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Agregar Centro Deportivo";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->header_title = "Módulo de Centros Deportivos";
		$data->header_description = "Agregar Centro Deportivo";
		$data->dash_container = "campos/form_new_campo";
		$data->footer_scripts = $this->footer_scripts("add");
		$data->active = "campos";
		$data->campo_estados = $this->Campoestado_model->get();
		$data->departamentos = $this->Departamento_model->get();
		$data->provincias = $this->Provincia_model->getByDepartamento(0);
		$data->distritos = $this->Distrito_model->getByProvincia(0);
		$data->campos = $this->Campos_model->get();
		$this->template->call_admin_template($data);
	}

	public function add_campo()
	{
		$this->load->library('form_validation');

		if ($this->form_validation->run('add_campo') == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $errors]);
		} else {

			$nombre = $this->security->xss_clean($this->input->post('nombre', TRUE));
			$ubicacion = $this->security->xss_clean($this->input->post('ubicacion', TRUE));
			$lat = $this->security->xss_clean($this->input->post('lat', TRUE));
			$lng = $this->security->xss_clean($this->input->post('lng', TRUE));
			$campo_estado_id = $this->security->xss_clean($this->input->post('campo_estados', TRUE));
			$external_url = $this->security->xss_clean($this->input->post('external_url', TRUE));
			$campo_departamentos = $this->security->xss_clean($this->input->post('campo_departamentos', TRUE));
			$campo_provincias = $this->security->xss_clean($this->input->post('campo_provincias', TRUE));
			$campo_distritos = $this->security->xss_clean($this->input->post('campo_distritos', TRUE));
			$datos_adicionales = $this->security->xss_clean($this->input->post('datos_adicionales', TRUE));

			$insert = [
				"nombre " => $nombre,
				"ubicacion " => $ubicacion,
				"lat " => $lat,
				"lng " => $lng,
				"campo_estado_id " => $campo_estado_id,
				"external_url " => $external_url,
				"ubdepa_id " => $campo_departamentos,
				"ubprov_id " => $campo_provincias,
				"ubdistri_id " => $campo_distritos,
				"datos_adicionales" => $datos_adicionales
			];

			$id = $this->Campos_model->insert($insert);

			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-campos"), 'id' => $id]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo crear el Centro Deportivo, intentalo de nuevo."]);
			}
		}
	}

	public function form_edit_campo($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_campos');
		$this->acl->acceso('form_edit_campo');
		$data = new stdClass();
		if ($id) {
			$id = (int) $id;
		} else {
			$id = (int) $this->uri->segment(2);
		}

		if (!$id) {
			$this->session->set_flashdata('message_error', "Centro Deportivo no válido");
			redirect('listar-campos');
		}
		if (!is_int($id)) {
			$this->session->set_flashdata('message_error', "Información no Válida");
			redirect('listar-campos');
		}
		$campo = $this->Campos_model->get($id);
		if (!count($campo) == 1) {
			$this->session->set_flashdata('message_error', "Centro Deportivo no encontrado");
			redirect('listar-campos');
		}

		$data->title = APP_NAME . " :: Dashboard :: Editar Centro Deportivo";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Centros Deportivos";
		$data->header_description = "Editar Centro Deportivo";
		$data->dash_container = "campos/form_edit_campo";
		$data->campo = $campo;
		$data->campo_estados = $this->Campoestado_model->get();
		$data->departamentos = $this->Departamento_model->get();
		$data->provincias = $this->Provincia_model->getByDepartamento($campo->ubdepa_id);
		$data->distritos = $this->Distrito_model->getByProvincia($campo->ubprov_id);
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "users";
		$data->footer_scripts = $this->footer_scripts("update");

		$this->template->call_admin_template($data);
	}

	public function get_by_provincias()
	{
		$departamento_id = $this->input->post('departamento_id', TRUE);
		$provincias = $this->Provincia_model->getByDepartamento($departamento_id);
		echo json_encode($provincias);
	}

	public function get_by_distritos()
	{
		$provincia_id = $this->input->post('provincia_id', TRUE);
		$distritos = $this->Distrito_model->getByProvincia($provincia_id);
		echo json_encode($distritos);
	}

	public function update_campo()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('campo_id');

		if ($this->form_validation->run('update_campo') == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $errors]);
		} else {
			$nombre = $this->security->xss_clean($this->input->post('nombre', TRUE));
			$ubicacion = $this->security->xss_clean($this->input->post('ubicacion', TRUE));
			$lat = $this->security->xss_clean($this->input->post('lat', TRUE));
			$lng = $this->security->xss_clean($this->input->post('lng', TRUE));
			$campo_estado_id = $this->security->xss_clean($this->input->post('campo_estados', TRUE));
			$external_url = $this->security->xss_clean($this->input->post('external_url', TRUE));
			$campo_departamentos = $this->security->xss_clean($this->input->post('campo_departamentos', TRUE));
			$campo_provincias = $this->security->xss_clean($this->input->post('campo_provincias', TRUE));
			$campo_distritos = $this->security->xss_clean($this->input->post('campo_distritos', TRUE));
			$datos_adicionales = $this->security->xss_clean($this->input->post('datos_adicionales', TRUE));

			$campoe_db = [
				"nombre " => $nombre,
				"ubicacion " => $ubicacion,
				"lat " => $lat,
				"lng " => $lng,
				"campo_estado_id " => $campo_estado_id,
				"external_url " => $external_url,
				"ubdepa_id " => $campo_departamentos,
				"ubprov_id " => $campo_provincias,
				"ubdistri_id " => $campo_distritos,
				"datos_adicionales" => $datos_adicionales,
			];

			$id = $this->Campos_model->update($id, $campoe_db);
			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-campos")]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo la actualizacion del Centro Deportivo, intentalo de nuevo."]);
			}
		}
	}

	public function add_campo_imagen()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('campo_imagenes_id');


			$id_campo = $this->security->xss_clean($this->input->post('id_campo', TRUE));
			$url = $this->security->xss_clean($this->input->post('url', TRUE));
			$activado = $this->security->xss_clean($this->input->post('activado', TRUE));

			$user_img_profile = null;

			if (@$_FILES['userfile']['name'] != NULL) {
				$ram = $this->utilities->randomString(25);
				$file_name = $_FILES['userfile']['name'];
				$tmp = explode('.', $file_name);
				$extension_img = end($tmp);

				$user_img_profile = $ram . '.' . $extension_img;

				$config['upload_path'] = './assets/img/campos_img/';
				//              'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp",
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '5000000';
				$config['quality'] = '90%';
				$config['file_name'] = $user_img_profile;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload()) {
					$errors = $this->upload->display_errors();
					echo json_encode(['error' => $errors]);
					return;
				}
			}else{
				echo json_encode(['error' => "La imágen es requerida."]);
				return;
			}

			$campoe_db = [
				"campo_id " => $id_campo,
				"external_url" => $url,
				"defecto " => $activado == "on"
			];

			if (@$_FILES['userfile']['name'] != NULL) {
				$campoe_db["imagen"] = $user_img_profile;
			}

			$id = $this->Campoimagenes_model->insert($campoe_db);
			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-campos"), 'id' => $id]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo el registro de la Imágen, intentalo de nuevo."]);
			}
		
	}

	public function edit_campo_imagen($id){
		echo json_encode($this->Campoimagenes_model->get($id));
	}

	public function update_campo_imagen()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('campo_imagenes_id');


			$id_campo = $this->security->xss_clean($this->input->post('id_campo', TRUE));
			$url = $this->security->xss_clean($this->input->post('url', TRUE));
			$activado = $this->security->xss_clean($this->input->post('activado', TRUE));

			$user_img_profile = null;

			if (@$_FILES['userfile']['name'] != NULL) {
				$ram = $this->utilities->randomString(25);
				$file_name = $_FILES['userfile']['name'];
				$tmp = explode('.', $file_name);
				$extension_img = end($tmp);

				$user_img_profile = $ram . '.' . $extension_img;

				$config['upload_path'] = './assets/img/campos_img/';
				//              'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp",
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '5000000';
				$config['quality'] = '90%';
				$config['file_name'] = $user_img_profile;
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload()) {
					$errors = $this->upload->display_errors();
					echo json_encode(['error' => $errors]);
					return;
				}
			}

			$campoe_db = [
				"campo_id " => $id_campo,
				"external_url" => $url,
				"defecto " => $activado == "on"
			];

			if (@$_FILES['userfile']['name'] != NULL) {
				$campoe_db["imagen"] = $user_img_profile;
			}

			$id = $this->Campoimagenes_model->update($id, $campoe_db);
			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-campos")]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo la actualización de la Imágen, intentalo de nuevo."]);
			}
		
	}

	public function delete_campo_imagen($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->accesoJSON('mudule_access_campos');
		if (!$id) {
			$id = (int) $this->uri->segment(2);
		} else {
			$id = (int) $id;
		}

		if (!$id) {
			echo json_encode(['error' => "Imágen no valido"]);
			return;
		}
		if (!is_int($id)) {
			echo json_encode(['error' => "Información no Valida"]);
			return;
		}

		$campo = $this->Campoimagenes_model->get($id);
		if (!count($campo) == 1) {
			echo json_encode(['error' => "Centro Deportivo no encontrado"]);
			return;
		}

		$id = $this->Campoimagenes_model->delete($id);
		if ($id > 0) {
			echo json_encode(['redirect' => base_url("listar-campos")]);
			return;
		} else {
			echo json_encode(['error' => "El Imágen no se ha eliminado."]);
			return;
		}
	}

	public function delete_campo($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->accesoJSON('mudule_access_campos');
		$this->acl->accesoJSON('delete_campo');
		if (!$id) {
			$id = (int) $this->uri->segment(2);
		} else {
			$id = (int) $id;
		}

		if (!$id) {
			echo json_encode(['error' => "Centro Deportivo no valido"]);
			return;
		}
		if (!is_int($id)) {
			echo json_encode(['error' => "Información no Valida"]);
			return;
		}

		if ($this->Campos_model->existsCampoInCampoCancha($id)) {
			echo json_encode(['error' => "El Centro Deportivo no se ha eliminado debido a que esta asignado a un usuario"]);
			return;
		}

		$campo = $this->Campos_model->get($id);
		if (!count($campo) == 1) {
			echo json_encode(['error' => "Centro Deportivo no encontrado"]);
			return;
		}

		$id = $this->Campos_model->delete($id);
		if ($id > 0) {
			echo json_encode(['redirect' => base_url("listar-campos")]);
			return;
		} else {
			echo json_encode(['error' => "El Centro Deportivo no se ha eliminado."]);
			return;
		}
	}

	public function get_campo()
	{
		$id_campo = $this->input->post('role');

		$response = $this->Campos_model->get($id_campo);

		echo json_encode($response);
	}
}
