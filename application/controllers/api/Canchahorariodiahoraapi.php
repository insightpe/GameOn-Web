<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Canchahorariodiahoraapi extends REST_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Campocanchas/Canchahorariodiahora_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function list_by_campo_cancha_fecha_get(){
    $campo_cancha_id = $this->get('campo_cancha_id');
    $fecha = $this->get('fecha');
    //$hora = explode(' - ', $this->get('hora'))[0];
    //$fechahora = $fecha . ' ' . $hora;
    $day = date('w',strtotime($fecha));
    $data = $this->Canchahorariodiahora_model->getHorasDisponibles($campo_cancha_id, $fecha, $day);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
}