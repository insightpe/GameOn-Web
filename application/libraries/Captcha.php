<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Captcha
 *
 * @author furbox
 */
class Captcha {

    protected $CI;

    public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI = & get_instance();
    }

    public function genera_captcha() {
        $this->CI->load->library('Utilities');
        $this->CI->load->helper('captcha');
        $ram = $this->CI->utilities->randomString(8);
        $vals = array(
            'word' => $ram,
            'img_path' => './assets/captcha/',
            'img_url' => base_url() . 'assets/captcha/',
            'img_width' => 150,
            'img_height' => 30,
            'expiration' => 7200,
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(150, 255, 200)
            )
        );
        $cap = create_captcha($vals);

        return $cap;
    }

    public function removeAndCheckCaptcha($captcha) {
        $expiration = time() - 600; // Límite de 10 minutos 
        $ip = $this->CI->input->ip_address(); //ip del usuario
        //captcha introducido por el usuario
        //eliminamos los captcha con más de 2 minutos de vida
        $this->CI->load->model('Captcha_model');
        $this->CI->Captcha_model->remove_old_captcha($expiration);
        //comprobamos si es correcta la imagen introducida

        $check = $this->CI->Captcha_model->check($ip, $expiration, $captcha);

        /*
          |si el número de filas devuelto por la consulta es igual a 1
          |es decir, si el captcha ingresado en el campo de texto es igual
          |al que hay en la base de datos, junto con la ip del usuario
          |entonces dejamos continuar porque todo es correcto
         */
        return $check;
    }

}
