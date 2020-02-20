<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author furbox
 */
class MY_Controller extends MX_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        // Load the form validation library
        $this->load->library('form_validation');
        $this->load->module([
            "acl",
            "template",
            "users",
            "configuraciones"
        ]);
    }

}
