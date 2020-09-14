<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Campocanchaapi extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Campocanchas/Campocanchas_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function list_by_campo_get(){
    $campo_id = $this->get('campo_id');
    $deporte_id = $this->get('deporte_id');
    $data = $this->Campocanchas_model->getCanchas($campo_id, $deporte_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
}