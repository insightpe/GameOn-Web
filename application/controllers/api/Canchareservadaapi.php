<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Canchareservadaapi extends REST_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Canchareservada/Canchareservada_model',
        'Campocanchas/Campocanchas_model',
        'Users/Users_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function get_mis_reservas_get(){
    $partido_id = $this->get('partido_id');
    if($partido_id == null) $partido_id = 0;
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Canchareservada_model->getMisReservas($user_id, $partido_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function get_mis_canchas_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Canchareservada_model->getMisCanchas($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function get_cancha_reservada_get(){
    $cancha_reservada_id = $this->get('cancha_reservada_id');
    $data = $this->Canchareservada_model->getCanchaReservada($cancha_reservada_id);
    $data->fecha = date("d/m/Y", strtotime($data->fecha));
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function add_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());

		if ($this->form_validation->run('add_cancha_reservada_api') == FALSE) {
			$errors = $this->validation_errors();
      $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
		} else {
      $user_id = $this->utilities->getDecodedToken()->user_id;
      $user_info = $this->Users_model->getInfo($user_id);
      $fecha = $this->security->xss_clean($this->input->post('fecha', TRUE));
      $horas = $this->security->xss_clean($this->input->post('horas', TRUE));
      $precio = $this->security->xss_clean($this->input->post('precio', TRUE));
      $culqi_token = $this->security->xss_clean($this->input->post('culqi_token', TRUE));
      $campo_cancha_id = $this->security->xss_clean($this->input->post('campo_cancha_id', TRUE));
      $campo_cancha = $this->Campocanchas_model->getCampoCancha($campo_cancha_id);
      $cancha_horario_dia_horas_id = $this->security->xss_clean($this->input->post('cancha_horario_dia_horas_id', TRUE));
      $hora_desde = explode(' - ', $horas)[0];
      $hora_hasta = explode(' - ', $horas)[1];


			$insert = [
				"campo_cancha_id " => $campo_cancha_id,
				"pagado " => 1,
				"creador_user_id " => $user_id,
				"cancha_horario_dia_hora_id " => $cancha_horario_dia_horas_id,
        "fecha_desde " => $fecha . " " . $hora_desde,
        "fecha_hasta " => $fecha . " " . $hora_hasta,
        "nro_operacion " => $culqi_token,
        "precio " => $precio,
			];

      $id = $this->Canchareservada_model->insert($insert);
      

      $content_email = file_get_contents('./assets/templates/email/mensaje-pago.html');
      $content_email = str_replace("[Nombre]", $user_info->nombre . ' ' . $user_info->apellido, $content_email);
      $content_email = str_replace("[Cancha]", $campo_cancha->campo_nombre . ' - ' . $campo_cancha->nombre, $content_email);
      $content_email = str_replace("[DIA]", $fecha, $content_email);
      $content_email = str_replace("[HORA]", $hora_desde, $content_email);
      $this->utilities->sendMail($user_info->user_email, "GAME ON! - Reserva Exitosa", $content_email);

      $data = [
        "cancha_reservada_id" => $id
      ];
			if (count($id) > 0) {
        $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
			} else {
				$this->response(['result' => 'error', 'error' => "De alguna manera fallo la reserva de Cancha, intentalo de nuevo."], REST_Controller::HTTP_OK); 
			}
		}
  }
}