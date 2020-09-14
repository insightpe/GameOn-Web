<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'/libraries/REST_Controller.php');
class Partidoapi extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model([
        'Partido/Partidos_model',
        'Partido/Partidodeportes_model',
        'Partido/Partidomiembros_model',
        'Canchareservada/Canchareservada_model',
        'Users/Users_model',
        'Chat/Chat_model',
        'Notificaciones/Notificaciones_model'
    ]);
    $this->load->library('Utilities');
    if(!$this->utilities->is_valid_token()){
      $this->response("Unauthorized", REST_Controller::HTTP_UNAUTHORIZED);
      exit;
    }
  }

  public function get_get(){
    $partido_id = $this->get('partido_id');
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Partidos_model->getPartido($partido_id);

    if($data->fecha_desde != null && $data->fecha_desde != ""){
      $data->fecha_desde = date("d/m/Y H:i", strtotime($data->fecha_desde));
    }

    $data->deportes = $this->Partidos_model->getPartidoDeportes($partido_id);
    $miembro = $this->Partidos_model->esMiembro($partido_id, $user_id);
    $miembro_invitado = $this->Partidomiembros_model->getByUserIdPartido($partido_id, $user_id);
    $data->es_miembro = $miembro != null;
    $data->es_admin = ($miembro != null ? $miembro->es_admin == 1 : false);
    $data->es_invitado = ($miembro_invitado != null ? $miembro_invitado->es_invitado == 1 : false);
    $data->invitado_partido_miembro_id = ($miembro_invitado != null ? $miembro_invitado->partido_miembro_id : 0);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function unirse_post(){
    $partido_id = $this->post('partido_id');
    $user_id = $this->utilities->getDecodedToken()->user_id;

    $partido = $this->Partidos_model->getPartido($partido_id);

    $existe_solicitud = $this->Partidomiembros_model->existeSolicitudPartido($partido_id, $user_id);

    if($existe_solicitud != null){
      $this->set_response(['result' => 'error', 'error'=>"Ya enviaste una solicitud para unirte al partido, por favor espera a que tu solicitud sea aceptada o rechazada."], REST_Controller::HTTP_OK);
      return;
    }

    $partido_miembro_db = [
      'partido_id' => $partido_id,
      'user_id' => $user_id,
      'confirmado' => 0,
      'es_admin' => 0
    ];

    $id = $this->Partidomiembros_model->insert($partido_miembro_db);

    $now = new DateTime(null, new DateTimeZone('America/Lima'));
    $fecha_hora = $now->format('Y-m-d H:i:s') ;

    $notificaciones_db = [
        'mensaje' => "Tienes una solicitud pendiente de revisión para el partido " . $partido->nombre . ". <a href='grupo-solicitudes.html?partido_id=" . $partido_id . "'>Ir a la solicitud</a>",
        'fecha_hora' => $fecha_hora,
        'visto' => 0,
        'user_id' => $partido->creador_user_id,
    ];

    $this->Notificaciones_model->insert($notificaciones_db);

    if (count($id) > 0) {
      $this->response(['result' => 'success'], REST_Controller::HTTP_OK); 
    } else {
      $this->response(['result' => 'error', 'error'=>"Ocurrio un error al crear el miembro."], REST_Controller::HTTP_OK); 
    }
  }

  public function agregar_miembro_post(){
    $partido_id = $this->post('partido_id');
    $user_id = $this->post('user_id');
    $partido = $this->Partidos_model->getPartido($partido_id);
    //$user_email = $this->utilities->getDecodedToken()->user_email;
    $user_info = $this->Users_model->getInfo($user_id);
    $partido_miembro_db = [
      'partido_id' => $partido_id,
      'user_id' => $user_id,
      'confirmado' => 0,
      'es_admin' => 0,
      'es_invitado' => 1
    ];

    $content_email = file_get_contents('./assets/templates/email/mensaje-invitacion-partido.html');
    $content_email = str_replace("[Partido]", $partido->nombre, $content_email);
    $content_email = str_replace("[Nombre]", $user_info->nombre . ' ' . $user_info->apellido, $content_email);
    
    if($partido->cancha_reservada_id == null || $partido->cancha_reservada_id == "0"){
      $content_email = str_replace("[Reserva]", "Sin reserva", $content_email);
    }else{
      $campo_cancha = $this->Canchareservada_model->getCanchaReservada($partido->cancha_reservada_id);
      $campo_cancha->fecha = date("d/m/Y", strtotime($campo_cancha->fecha));
      $content_email = str_replace("[Reserva]", "Con reserva en la cancha <b>" . $campo_cancha->nombre . ' - ' . 
      $campo_cancha->cancha_nombre . "</b> para el dia <b>" . $campo_cancha->fecha . "</b> de <b>" . $campo_cancha->rango_hora . "</b>", $content_email);
    }

    $user = $this->Users_model->getInfo($user_id);

    $this->utilities->sendMail($user->user_email, "GAME ON! - Invitación a partido ".$partido->nombre, $content_email);

    $id = $this->Partidomiembros_model->insert($partido_miembro_db);

    $now = new DateTime(null, new DateTimeZone('America/Lima'));
    $fecha_hora = $now->format('Y-m-d H:i:s') ;

    $notificaciones_db = [
        'mensaje' => "Tienes una invitación pendiente de revisión para el partido " . $partido->nombre . ". <a href='grupo-item.html?partido_id=" . $partido_id . "'>Ir a la invitación</a>",
        'fecha_hora' => $fecha_hora,
        'visto' => 0,
        'user_id' => $user_id,
    ];

    $this->Notificaciones_model->insert($notificaciones_db);

    if (count($id) > 0) {
      $this->response(['result' => 'success'], REST_Controller::HTTP_OK); 
    } else {
      $this->response(['result' => 'error', 'error'=>"Ocurrio un error al crear el miembro."], REST_Controller::HTTP_OK); 
    }
  }

  public function list_miembros_get(){
    $partido_id = $this->get('partido_id');
    
    $data = $this->Partidomiembros_model->getMiembros($partido_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function list_solicitudes_get(){
    $partido_id = $this->get('partido_id');
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $miembro = $this->Partidomiembros_model->getByUserIdPartido($partido_id, $user_id);
    $data = $this->Partidomiembros_model->getMiembrosSolicitudes($partido_id, $miembro->es_admin);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function eliminar_miembro_get(){
    $partido_miembro_id = $this->get('partido_miembro_id');
    $id = $this->Partidomiembros_model->delete($partido_miembro_id);
		if ($id > 0) {
			$this->response(['result' => 'success', 'data' => $id], REST_Controller::HTTP_OK);
			return;
		} else {
      $this->response(['result' => 'error', 'error'=>"El miembro no ha podido ser eliminado."], REST_Controller::HTTP_OK); 
			return;
		}
  }

  public function set_admin_post(){
    $partido_miembro_id = $this->post('partido_miembro_id');
    $admin = $this->post('admin');
    $partido_miembro_db = [
      'es_admin' => (int)$admin
    ];

    $this->Partidomiembros_model->update($partido_miembro_id, $partido_miembro_db);

    $this->response(['result' => 'success', 'data' => $partido_miembro_id], REST_Controller::HTTP_OK); 
  }

  public function aceptar_post(){
    $partido_miembro_id = $this->post('partido_miembro_id');
    $partido_miembro_db = [
      'confirmado' => 1
    ];

    $this->Partidomiembros_model->update($partido_miembro_id, $partido_miembro_db);

    $this->response(['result' => 'success', 'data' => $partido_miembro_id], REST_Controller::HTTP_OK); 
  }

  public function buscar_miembros_get(){
    $partido_id = $this->get('partido_id');
    $buscarPor = $this->get('buscar_por');
    if($buscarPor == ""){
      $data = [];
    }else{
      $data = $this->Partidomiembros_model->buscarMiembros($partido_id, $buscarPor);
    }
    
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function chat_mensajes_nuevos_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $fecha_hora = $this->get('fecha_hora');
    $data = $this->Chat_model->listNewMessages($user_id, $fecha_hora);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function list_by_partido_id_get(){
    $partidoId = $this->get('partido_id');
    $data = $this->Chat_model->listByPartidoId($partidoId);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function invitar_miembro_externo_post(){
    $correo = $this->post('correo');
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $user_info = $this->Users_model->getInfo($user_id);

    $content_email = file_get_contents('./assets/templates/email/mensaje-invitacion-externa.html');
    $content_email = str_replace("[Nombre]", $user_info->nombre . ' ' . $user_info->apellido, $content_email);

    $this->utilities->sendMail($correo, "GAME ON! - Invitación", $content_email);

    $this->response(['result' => 'success', 'data' => $correo], REST_Controller::HTTP_OK); 
  }

  public function list_get(){
    $deporte = $this->get('deporte');
    $provincia = $this->get('provincia');
    $distrito = $this->get('distrito');
    $fecha_desde = $this->get('fecha_desde');
    $fecha_hasta = $this->get('fecha_hasta');
    $reservado = $this->get('reservado');
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Partidos_model->getPartidos($deporte, $provincia, $distrito, $fecha_desde, $fecha_hasta, $user_id, $reservado);
    foreach($data as $partido){
      if($partido->partido_id == null){ continue; }
      if($partido->fecha_desde != null && $partido->fecha_desde != ""){
        $partido->fecha_desde = date("d/m/Y H:i", strtotime($partido->fecha_desde));
      }
    }
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function get_ultimo_partido_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Partidos_model->getUltimoPartido($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function get_proximo_partido_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Partidos_model->getProximoPartido($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function mis_partidos_get(){
    $user_id = $this->utilities->getDecodedToken()->user_id;
    $data = $this->Partidos_model->getMisPartidos($user_id);
    $this->response(['result' => 'success', 'data' => $data], REST_Controller::HTTP_OK); 
  }

  public function enviar_mensaje_post(){
    

    $mensaje = $this->post('mensaje');
    $partido_id = $this->post('partido_id');
    $fecha_hora = $this->post('fecha_hora');

    $partido = $this->Partidos_model->getPartido($partido_id);

    $user_id = $this->utilities->getDecodedToken()->user_id;

    $chat_db = [
        'message' => $mensaje,
        'timestamp' => $fecha_hora,
        'sender_user_id' => $user_id,
        'status' => 1,
        'partido_id' => $partido_id,
    ];

    $id = $this->Chat_model->insert($chat_db);

    $miembros = $this->Partidomiembros_model->getMiembros($partido_id);

    foreach($miembros as $miembro){
      if($miembro->user_id != $user_id){
        $notificaciones_db = [
          'mensaje' => "Un mensaje de chat ha sido enviado. <a href='grupo-chat.html?partido_id=" . $partido_id . "'>Ir al chat " . $partido->nombre . "</a>",
          'fecha_hora' => $fecha_hora,
          'visto' => 0,
          'user_id' => $miembro->user_id,
        ];
    
        $this->Notificaciones_model->insert($notificaciones_db);
      }
    }

    if (count($id) > 0) {
      $this->response(['result' => 'success'], REST_Controller::HTTP_OK); 
    } else {
      $this->response(['result' => 'error', 'error'=>"Ocurrio un error al enviar el chat."], REST_Controller::HTTP_OK); 
    }
  }
  
  public function crear_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());


    $date = date('Y-m-d H:i:s');

    if ($this->form_validation->run("new_partido_api") == FALSE) {
        $errors = $this->validation_errors();
        $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
        $nombregrupo = $this->post('nombregrupo');
        $deportesgrupo = $this->post('deportesgrupo');
        $participantesgrupo = $this->post('participantesgrupo');
        $canchagrupo = $this->post('canchagrupo');
        $visibilidadgrupo = $this->post('visibilidadgrupo');
        $user_id = $this->utilities->getDecodedToken()->user_id;
        $deportes = [];
        if($deportesgrupo != ""){
          $deportes = json_decode($deportesgrupo);
        }
        
        $user_img_profile = null;

        if (@$_FILES['userfile']['name'] != NULL) {
          $ram = $this->utilities->randomString(25);
          $file_name = $_FILES['userfile']['name'];
          $tmp = explode('.', $file_name);
          $extension_img = end($tmp);
  
          $user_img_profile = $ram . '.' . $extension_img;
  
          $config['upload_path'] = './assets/img/partidos_img/';
          //              'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp",
          $config['allowed_types'] = 'gif|jpg|jpeg|png';
          $config['max_size'] = '5000000';
          $config['quality'] = '90%';
          $config['file_name'] = $user_img_profile;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload()) {
            $errors = $this->upload->display_errors();
            $this->response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK); 
            return;
          }
        }

        

        //json_encode lo convierte en formato json
        $partido_db = [
            'nombre' => $nombregrupo,
            'num_participantes' => $participantesgrupo,
            'cancha_reservada_id' => $canchagrupo == "" ? null : $canchagrupo,
            'privado' => $visibilidadgrupo == "on" ? 0 : 1,
            'creador_user_id' => $user_id,
        ];

        if (@$_FILES['userfile']['name'] != NULL) {
          $partido_db["imagen"] = $user_img_profile;
        }

        $id = $this->Partidos_model->insert($partido_db);

        foreach($deportes as $deporte){
          $paritdo_deporte_db = [
            'partido_id' => $id,
            'deporte_id' => $deporte->id,
          ];

          $this->Partidodeportes_model->insert($paritdo_deporte_db);
        }

        $partido_miembro_db = [
          'partido_id' => $id,
          'user_id' => $user_id,
          'confirmado' => 1,
          'es_admin' => 1
        ];

        $this->Partidomiembros_model->insert($partido_miembro_db);

        if (count($id) > 0) {
          $this->response(['result' => 'success'], REST_Controller::HTTP_OK); 
        } else {
          $this->response(['result' => 'error', 'error'=>"Ocurrio un error al crear el partido."], REST_Controller::HTTP_OK); 
        }
    }
  }

  public function editar_post(){
    $this->load->library('form_validation');
    $this->form_validation->set_data($this->post());


    $date = date('Y-m-d H:i:s');

    if ($this->form_validation->run("update_partido_api") == FALSE) {
        $errors = $this->validation_errors();
        $this->set_response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK);
    } else {
        $partido_id = $this->post('partido_id');
        $nombregrupo = $this->post('nombregrupo');
        $deportesgrupo = $this->post('deportesgrupo');
        $participantesgrupo = $this->post('participantesgrupo');
        $canchagrupo = $this->post('canchagrupo');
        $visibilidadgrupo = $this->post('visibilidadgrupo');
        $user_id = $this->utilities->getDecodedToken()->user_id;
        $deportes = [];
        if($deportesgrupo != ""){
          $deportes = json_decode($deportesgrupo);
        }

        $user_img_profile = null;

        if (@$_FILES['userfile']['name'] != NULL) {
          $ram = $this->utilities->randomString(25);
          $file_name = $_FILES['userfile']['name'];
          $tmp = explode('.', $file_name);
          $extension_img = end($tmp);
  
          $user_img_profile = $ram . '.' . $extension_img;
  
          $config['upload_path'] = './assets/img/partidos_img/';
          //              'allowed_types' => "gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp",
          $config['allowed_types'] = 'gif|jpg|jpeg|png';
          $config['max_size'] = '5000000';
          $config['quality'] = '90%';
          $config['file_name'] = $user_img_profile;
          $this->load->library('upload', $config);
          if (!$this->upload->do_upload()) {
            $errors = $this->upload->display_errors();
            $this->response(['result' => 'error', 'error'=>$errors], REST_Controller::HTTP_OK); 
            return;
          }
        }

        

        //json_encode lo convierte en formato json
        $partido_db = [
            'nombre' => $nombregrupo,
            'num_participantes' => $participantesgrupo,
            'cancha_reservada_id' => $canchagrupo == "" ? null : $canchagrupo,
            'privado' => $visibilidadgrupo == "on" ? 0 : 1,
            'creador_user_id' => $user_id,
        ];
        if (@$_FILES['userfile']['name'] != NULL) {
          $partido_db["imagen"] = $user_img_profile;
        }

        $id = $this->Partidos_model->update($partido_id, $partido_db);


        $this->Partidodeportes_model->deleteByPartidoId($partido_id);

        foreach($deportes as $deporte){
          $paritdo_deporte_db = [
            'partido_id' => $partido_id,
            'deporte_id' => $deporte->id,
          ];

          $this->Partidodeportes_model->insert($paritdo_deporte_db);
        }

        $this->response(['result' => 'success'], REST_Controller::HTTP_OK); 

    }
  }
}