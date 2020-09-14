<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Deportes
 *
 * @author furbox
 */
class Deportes extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model("Deportes_model");
        $this->load->library('Utilities');
    }

    function footer_scripts($ui){
        $return = "<script src='" . base_url('assets') . "/js/custom/deporte.custom.js'></script>";
        switch($ui){
            case "list":
                $return .= "<script src='" . base_url('assets') . "/js/custom/deporte.list.custom.js'></script>";
            break;
            case "add":
            case "update":
                $return .= "<script src='" . base_url('assets') . "/js/custom/deporte.dataentry.custom.js'></script>";
            break;
        }
        return $return;
    }

    public function list_deportes() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_deportes');
        $this->acl->acceso('list_deportes');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Lista de Deportes";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Deportes";
        $data->header_description = "Lista de Deportes";
        $data->dash_container = "deportes/list_deportes";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "deportes";
        $data->footer_scripts = $this->footer_scripts("list");
        $tmpl = array('table_open' => '<table id="dt-deportes" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">');
        $this->table->set_template($tmpl);
        $this->table->set_heading(["Nombre", "Acciones"]);
        
        $this->template->call_admin_template($data);
    }

    public function get_list_deportes(){
        if($this->input->is_ajax_request())
        {   
            
          $response = $this->Deportes_model->list();
    
          echo $response;
    
          exit;
        }
    }

    public function form_new_deporte() {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_deportes');
        $this->acl->acceso('form_new_deporte');
        $data = new stdClass();

        $data->title = APP_NAME . " :: Dashboard :: Agregar Deporte";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->header_title = "Módulo de Deportes";
        $data->header_description = "Agregar Deporte";
        $data->dash_container = "deportes/form_new_deporte";
        $data->footer_scripts = $this->footer_scripts("add");
        $data->active = "deportes";
        $data->deportes = $this->Deportes_model->get();
        $this->template->call_admin_template($data);
    }

    public function add_deporte() {
        $this->load->library('form_validation');

        if ($this->form_validation->run('add_deporte') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {

            $deportee_name = $this->security->xss_clean($this->input->post('nombre', TRUE));

            $insert = [
                "nombre " => $deportee_name,
            ];

            $id = $this->Deportes_model->insert($insert);
         
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-deportes")]);
            } else {
                echo json_encode(['error'=>"De alguna manera fallo crear el Deporte, intentalo de nuevo."]);
            }
        }
    }

    public function form_edit_deporte($id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_deportes');
        $this->acl->acceso('form_edit_deporte');
        $data = new stdClass();
        if ($id) {
            $id = (int) $id;
        } else {
            $id = (int) $this->uri->segment(2);
        }

        if (!$id) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_true'));
            redirect('listar-deportes');
        }
        if (!is_int($id)) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_information'));
            redirect('listar-deportes');
        }
        $deporte = $this->Deportes_model->get($id);
        if (!count($deporte) == 1) {
            $this->session->set_flashdata('message_error', $this->lang->line('role_message_error_delete_find'));
            redirect('listar-deportes');
        }

        $data->title = APP_NAME . " :: Dashboard :: Editar Deporte";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Deportes";
        $data->header_description = "Editar Deporte";
        $data->dash_container = "deportes/form_edit_deporte";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "users";
        $data->footer_scripts = $this->footer_scripts("update");

        $data->deporte = $deporte;
        $this->template->call_admin_template($data);
    }

    public function update_deporte() {
        $this->load->library('form_validation');
        $id = $this->input->post('id');

        if ($this->form_validation->run('update_deporte') == FALSE) {
            $errors = validation_errors();
            echo json_encode(['error'=>$errors]);
        } else {
            $deportee_name = $this->security->xss_clean($this->input->post('nombre', TRUE));

            $deportee_db = [
                'nombre' => $deportee_name,
            ];

            $id = $this->Deportes_model->update($id, $deportee_db);
            if (count($id) > 0) {
                echo json_encode(['redirect'=>base_url("listar-deportes")]);
            } else {
                echo json_encode(['error'=>"De alguna manera fallo la actualizacion del Deporte, intentalo de nuevo."]);
            }
        }
    }

    public function delete_deporte($id = FALSE) {
        $this->utilities->is_session_start();
        $this->acl->accesoJSON('mudule_access_deportes');
        $this->acl->accesoJSON('delete_deporte');
        if (!$id) {
            $id = (int) $this->uri->segment(2);
        } else {
            $id = (int) $id;
        }

        if (!$id) {
            echo json_encode(['error'=>"Deporte no valido"]);
            return;
        }
        if (!is_int($id)) {
            echo json_encode(['error'=>"Información no Valida"]);
            return;
        }

        $deporte = $this->Deportes_model->get($id);
        if (!count($deporte) == 1) {
            echo json_encode(['error'=>"Deporte no encontrado"]);
            return;
        }

        if ($this->Deportes_model->existsDeporteInUser($id)) {
            echo json_encode(['error'=>"El Deporte no se ha eliminado debido a que esta asignado a un usuario"]);
            return;
        }

        $id = $this->Deportes_model->delete($id);
        if ($id > 0) {
            echo json_encode(['redirect'=>base_url("listar-deportes")]);
                return;
        } else {
            echo json_encode(['error'=>"El Deporte no se ha eliminado."]);
            return;
        }
    }

    public function get_deporte() {
        $id_deporte = $this->input->post('role');

        $response = $this->Deportes_model->get($id_deporte);

        echo json_encode($response);
    }

}
