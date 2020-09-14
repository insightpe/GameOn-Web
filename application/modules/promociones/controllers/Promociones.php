<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Promociones
 *
 * @author furbox
 */
class Promociones extends MY_Controller
{

	//put your code here
	public function __construct()
	{
		parent::__construct();
		$this->load->model("Promociones_model");
		$this->load->library('Utilities');
	}

	function footer_scripts($ui)
	{
		$return = "<script src='" . base_url('assets') . "/js/custom/promocion.custom.js'></script>";
		switch ($ui) {
			case "list":
				$return .= "<script src='" . base_url('assets') . "/js/custom/promocion.list.custom.js'></script>";
				break;
			case "add":
			case "update":
				$return .= "<script src='" . base_url('assets') . "/js/custom/promocion.dataentry.custom.js'></script>";
				break;
		}
		return $return;
	}

	public function list_promociones()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_promociones');
		$this->acl->acceso('list_promociones');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Lista de Promociones";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Promociones";
		$data->header_description = "Lista de Promociones";
		$data->dash_container = "promociones/list_promociones";
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "promociones";
		$data->footer_scripts = $this->footer_scripts("list");
		$tmpl = array('table_open' => '<table id="dt-promociones" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
		$this->table->set_template($tmpl);
		$this->table->set_heading(["Título", "Subtítulo", "Imagen", "Url", "Activado", "Acciones"]);

		$this->template->call_admin_template($data);
	}

	public function get_list_promociones()
	{
		if ($this->input->is_ajax_request()) {
			$response = $this->Promociones_model->list();

			echo $response;

			exit;
		}
	}

	public function form_new_promocion()
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_promociones');
		$this->acl->acceso('form_new_promocion');
		$data = new stdClass();

		$data->title = APP_NAME . " :: Dashboard :: Agregar Promoción";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->header_title = "Módulo de Promociones";
		$data->header_description = "Agregar Promoción";
		$data->dash_container = "promociones/form_new_promocion";
		$data->footer_scripts = $this->footer_scripts("add");
		$data->active = "promociones";
		$data->promociones = $this->Promociones_model->get();
		$this->template->call_admin_template($data);
	}

	public function add_promocion()
	{
		$this->load->library('form_validation');

		if ($this->form_validation->run('add_promocion') == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $errors]);
		} else {
			$titulo = $this->security->xss_clean($this->input->post('titulo', TRUE));
			$subtitulo = $this->security->xss_clean($this->input->post('subtitulo', TRUE));
			$url = $this->security->xss_clean($this->input->post('url', TRUE));
			$activado = $this->security->xss_clean($this->input->post('activado', TRUE));
			$user_img_profile = null;

			if (@$_FILES['userfile']['name'] != NULL) {
				$ram = $this->utilities->randomString(25);
				$file_name = $_FILES['userfile']['name'];
				$tmp = explode('.', $file_name);
				$extension_img = end($tmp);

				$user_img_profile = $ram . '.' . $extension_img;

				$config['upload_path'] = './assets/img/promociones_img/';
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


			$insert = [
				"titulo " => $titulo,
				"subtitulo " => $subtitulo,
				"url " => $url,
				"activado " => $activado == "on",
				"imagen" => $user_img_profile
			];

			$id = $this->Promociones_model->insert($insert);

			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-promociones")]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo crear el Promoción, intentalo de nuevo."]);
			}
		}
	}

	public function form_edit_promocion($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->acceso('mudule_access_promociones');
		$this->acl->acceso('form_edit_promocion');
		$data = new stdClass();
		if ($id) {
			$id = (int) $id;
		} else {
			$id = (int) $this->uri->segment(2);
		}

		if (!$id) {
			$this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_true'));
			redirect('listar-promociones');
		}
		if (!is_int($id)) {
			$this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_information'));
			redirect('listar-promociones');
		}
		$promocion = $this->Promociones_model->get($id);
		if (!count($promocion) == 1) {
			$this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_find'));
			redirect('listar-promociones');
		}

		$data->title = APP_NAME . " :: Dashboard :: Editar Promoción";
		$data->appname = APP_NAME;
		$data->appnameabbrev = APP_NAME_ABBREV;
		$data->header_title = "Módulo de Promociones";
		$data->header_description = "Editar Promoción";
		$data->dash_container = "promociones/form_edit_promocion";
		$data->type_layout = LAYOUT_TYPE_GENERAL;
		$data->active = "users";
		$data->footer_scripts = $this->footer_scripts("update");

		$data->promocion = $promocion;
		$this->template->call_admin_template($data);
	}

	public function update_promocion()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');

		if ($this->form_validation->run('update_promocion') == FALSE) {
			$errors = validation_errors();
			echo json_encode(['error' => $errors]);
		} else {


			$titulo = $this->security->xss_clean($this->input->post('titulo', TRUE));
			$subtitulo = $this->security->xss_clean($this->input->post('subtitulo', TRUE));
			$url = $this->security->xss_clean($this->input->post('url', TRUE));
			$activado = $this->security->xss_clean($this->input->post('activado', TRUE));
			$user_img_profile = null;

			if (@$_FILES['userfile']['name'] != NULL) {
				$ram = $this->utilities->randomString(25);
				$file_name = $_FILES['userfile']['name'];
				$tmp = explode('.', $file_name);
				$extension_img = end($tmp);

				$user_img_profile = $ram . '.' . $extension_img;

				$config['upload_path'] = './assets/img/promociones_img/';
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

			$promocione_db = [
				"titulo " => $titulo,
				"subtitulo " => $subtitulo,
				"url " => $url,
				"activado " => $activado == "on"
			];

			if (@$_FILES['userfile']['name'] != NULL) {
				$promocione_db["imagen"] = $user_img_profile;
			}

			$id = $this->Promociones_model->update($id, $promocione_db);
			if (count($id) > 0) {
				echo json_encode(['redirect' => base_url("listar-promociones")]);
			} else {
				echo json_encode(['error' => "De alguna manera fallo la actualizacion del Promoción, intentalo de nuevo."]);
			}
		}
	}

	public function delete_promocion($id = FALSE)
	{
		$this->utilities->is_session_start();
		$this->acl->accesoJSON('mudule_access_promociones');
		$this->acl->accesoJSON('delete_promocion');
		if (!$id) {
			$id = (int) $this->uri->segment(2);
		} else {
			$id = (int) $id;
		}

		if (!$id) {
			echo json_encode(['error' => "Promoción no valido"]);
			return;
		}
		if (!is_int($id)) {
			echo json_encode(['error' => "Información no Valida"]);
			return;
		}

		$promocion = $this->Promociones_model->get($id);
		if (!count($promocion) == 1) {
			echo json_encode(['error' => "Promoción no encontrado"]);
			return;
		}

		$id = $this->Promociones_model->delete($id);
		if ($id > 0) {
			echo json_encode(['redirect' => base_url("listar-promociones")]);
			return;
		} else {
			echo json_encode(['error' => "El Promoción no se ha eliminado."]);
			return;
		}
	}

	public function get_promocion()
	{
		$id_promocion = $this->input->post('role');

		$response = $this->Promociones_model->get($id_promocion);

		echo json_encode($response);
	}
}
