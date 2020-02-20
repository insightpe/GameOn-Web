<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Template
 *
 * @author furbox
 */
class Template extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model([
            'Configuraciones/Config_model',
        ]);
        
        $this->load->library('Utilities');
		
    }


    public function call_admin_template($data = NULL) {
        $this->load->view('admin_template_v', $data);
    }

    public function call_home_template($data = NULL) {
        $this->load->view('home_template_v', $data);
    }

    public function call_signup_template($data = NULL) {
        $this->load->view('form_signup', $data);
    }

    public function call_signin_template($data = NULL) {
        $this->load->view('form_signin', $data);
    }
    public function call_lost_pass_template($data = NULL) {
        $this->load->view('form_lost_pass', $data);
    }
    
    public function call_email_template($data = NULL) {
        $this->load->view('email_template_v', $data);
    }

}
