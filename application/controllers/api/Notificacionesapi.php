<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Notificacionesapi extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Notificaciones/Notificaciones_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function list_nuevos_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $fecha_hora = $this->get('fecha_hora');
    $data = $this->Notificaciones_model->list_nuevos($user_id, $fecha_hora);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function list_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $fecha_hora = $this->get('fecha_hora');
    $data = $this->Notificaciones_model->list($user_id);

    $notificacion = [
      "visto" => 1
    ];
    $this->Notificaciones_model->updateVistoByFechaHora($fecha_hora, $user_id, $notificacion);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
}