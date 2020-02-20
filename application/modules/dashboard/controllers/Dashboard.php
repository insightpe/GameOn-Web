<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author furbox
 */
class Dashboard extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->library("Utilities");
        $this->utilities->is_session_start();
        /*if (!$this->acl->control_acceso('mudule_access_admin')) {
            redirect('dashboard');
        }*/
        
        $this->acl->acceso('mudule_access_admin');
    }

    function footer_scripts(){
        return "<script src='" . base_url('assets') . "/js/custom/dashboard.custom.js'></script>";
    }

    public function index() {
        //$this->acl->acceso('admin_access');
        $data = new stdClass();
        $data->title = APP_NAME . " :: Dashboard";
        $data->appname = APP_NAME;
        $data->appnameabbrev = APP_NAME_ABBREV;
        $data->header_title = "Tablero de Control";
        $data->header_description = "Area de Trabajo";
        $data->dash_container = "dashboard/home";
        $data->type_layout = LAYOUT_TYPE_DASHBOARD;
        
        $data->active = "home";
        $data->footer_scripts = $this->footer_scripts();

        $this->template->call_admin_template($data);
    }

}
