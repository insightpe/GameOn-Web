<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Deporteapi extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Deportes/Deportes_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function list_get(){
    $data = $this->Deportes_model->get();
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
}