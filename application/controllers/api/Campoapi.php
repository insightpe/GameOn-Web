<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Campoapi extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Campos/Campos_model',
        'Ubigeo/Provincia_model',
        'Ubigeo/Distrito_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function get_campo_frecuente_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Campos_model->getCampoFrecuente($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function get_by_provincias_get()
	{
		$departamento_id = 15;
    $provincias = $this->Provincia_model->getByDepartamento($departamento_id);
    $this->response(['result' => 'success', 'data' => $provincias], REST_Controller::HTTP_OK); 
	}

	public function get_by_distritos_get()
	{
		$provincia_id = $this->get('provincia_id');
    $distritos = $this->Distrito_model->getByProvincia($provincia_id);
    $this->response(['result' => 'success', 'data' => $distritos], REST_Controller::HTTP_OK); 
	}

  public function list_get(){
    $deporte = $this->get('deporte');
    $provincia = $this->get('provincia');
    $distrito = $this->get('distrito');
    $data = $this->Campos_model->getCampos($deporte, $provincia, $distrito);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
  
  public function get_get(){
    $id = $this->get('id');
    $deporte_id = $this->get('deporte_id');
    $data = $this->Campos_model->getCampo($id, $deporte_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
  
  public function get_imagenes_get(){
    $id = $this->get('id');
    $data = $this->Campos_model->getImagenes($id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }
}