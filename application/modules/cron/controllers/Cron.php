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
class Cron extends MY_Controller {

    //put your code here
    public function __construct() {
      parent::__construct();

      $this->load->library("Utilities");
      $this->utilities->is_session_start();

      $this->load->model([
          'Afiliado/Afiliado_model',
          "Empresa/Empresa_model",
          "Estado/Estado_model",
          "Departamento/Departamento_model",
          "Municipio/Municipio_model",
          "Lineanegocio/Lineanegocio_model",
          "Riesgo/Riesgo_model",
          "Fondopension/Fondopension_model",
          "Eps/Eps_model",
          "Arl/Arl_model",
          "Cajacompensacion/Cajacompensacion_model",
          "Tipoidentificacion/Tipoidentificacion_model",
          "Afiliado/Afiliadonota_model",
          "Afiliado/Afiliadobeneficiario_model"
      ]);

    }


    public function index() {
     
    }
    
    public function run_afiliado_estado()
    {
      $fecha_consultar = date('Y-m-d',strtotime('-1 days'));
      
      $afiliados = $this->Afiliado_model->listar_con_fecha_retiro($fecha_consultar);
      
      foreach($afiliados as $afiliado){
        $afiliado_update = [
            "estado_id" => ESTADO_INACTIVO,
        ];
        
        $this->Afiliado_model->update($afiliado->afiliado_id, $afiliado_update);
      }
      
      $afiliados = $this->Afiliado_model->listar_con_fecha_desde($fecha_consultar);
      
      foreach($afiliados as $afiliado){
        $afiliado_update = [
            "estado_id" => ESTADO_ACTIVO,
            "fecha_retiro" => null,
        ];
        
        $this->Afiliado_model->update($afiliado->afiliado_id, $afiliado_update);
      }
      
      echo "OK";
    }

}
