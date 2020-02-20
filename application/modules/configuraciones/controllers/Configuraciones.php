<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author furbox
 */
class Configuraciones extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model([
            'Config_model',           
        ]);
        $this->load->library('Utilities', 'form_validation');
    }

    function footer_scripts(){
        return "<script src='" . base_url('assets') . "/js/pages/uiTables.js'></script>
        <script src='" . base_url('assets') . "/js/custom/configuraciones.custom.js'></script>
        <script>$(function(){ UiTables.init(); });</script>";
    }


    public function form_edit_config() {
        $id_config=1;
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_configuraciones');
        $this->acl->acceso('form_edit_configuraciones');
        if ($id_config) {
            $id = $id_config;
        } else {
            $id = $this->uri->segment(2);
        }
        $data = new stdClass();
 

        $data->title = APP_NAME . " :: Dashboard :: Editar Configuraciones";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Configuraciones";
        $data->header_description = "Editar Configuraciones";
        $data->dash_container = "configuraciones/form_edit";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "config";
        $data->footer_scripts = $this->footer_scripts();        
        $data->config = $this->Config_model->get($id);
     
        $this->template->call_admin_template($data);
    }

    public function cambiar_tema(){
        $id_config = 1;
        $theme = $_POST["theme"];
        $navbar = $_POST["navbar"];
        $sidebar = $_POST["sidebar"];
        $classname = $_POST["classname"];
    
        $config_db = [
            //'id_config'=>$id_config,
            'theme' => $theme,
            'theme_navbar' => $navbar,
            'theme_sidebar' => $sidebar,
            'theme_class' => $classname,
        ];

        $this->Config_model->update($id_config, $config_db);
  
        echo "OK";
  
        exit;
    }

    public function form_edit_configError($config) {
        $this->utilities->is_session_start();
        $this->acl->acceso('mudule_access_configuraciones');
        $this->acl->acceso('form_edit_configuraciones');
       
        $data = new stdClass();
      

        $data->title = APP_NAME . " :: Dashboard :: Editar Configuraciones";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Módulo de Configuraciones";
        $data->header_description = "Editar Configuraciones";
        $data->dash_container = "configuraciones/form_edit";
        $data->type_layout = LAYOUT_TYPE_GENERAL;
        $data->active = "config";
        $data->footer_scripts = $this->footer_scripts();        
        $data->config = $config;
        $this->template->call_admin_template($data);
    }

    public function update_config() {
        $date = date($this->config->item('log_date_format'));
        $id_config = $this->input->post('id');

        $application_name = $this->security->xss_clean($this->input->post('application_name', TRUE));
        $author = $this->input->post('author');
        $mail_server = $this->input->post('mail_server');
        $file_system_server = $this->input->post('file_system_server');
        $database_server = $this->input->post('database_server');
        $company_name = $this->input->post('company_name');
        $company_address = $this->input->post('company_address');
        $main_person = $this->input->post('main_person');
        $permisos_trd = $this->input->post('permisos_trd');


        
        $config_db = [
            //'id_config'=>$id_config,
            'application_name' => $application_name,
            'author' => $author,
            'mail_server' => $mail_server,
            'file_system_server' => $file_system_server,
            'database_server' => $database_server,
            'company_name' => $company_name,
            'company_address' => $company_address,
            'main_person' => $main_person,
            'permisos_trd' => ($permisos_trd == "on" ? 1 : 0)
        ];
           


        if ($this->form_validation->run('update_config') == FALSE) {
            $oconfig=(object)$config_db;
            $oconfig->id_config=$id_config;
            $this->form_edit_configError($oconfig);
        } 
        
        else {
            if($id_config == "0"){
                $id = $this->Config_model->insert($config_db);
            }else{
                $id = $this->Config_model->update($id_config, $config_db);
            }
            
           
            if (count($id) > 0) {
                $this->session->set_flashdata('message_success', $this->lang->line('configuraciones_success_update'));
                redirect('editar-configuraciones');
            } else {
                $this->session->set_flashdata('message_error', $this->lang->line('configuraciones_error_update'));
                redirect('editar-configuraciones');
            }
       }
    }
   
    public function getSengGridApiKey(){
        return "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";
    }
  
    public function getSendEmail(){
        return "no-reply@cavipetrol.com";
    }
}
