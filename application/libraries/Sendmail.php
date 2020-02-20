<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sendmail
 *
 * @author furbox
 */
require dirname(__FILE__) . '/vendor/autoload.php';
include dirname(__FILE__) . "/lib/SendGrid.php";

class Sendmail extends SendGrid {
    private $CI;
    public function __construct() {
        $this->CI = & get_instance();
        $api_key = $this->CI->configuraciones->getSengGridApiKey();
        //echo $api_key;
        parent::__construct($api_key);
        
    }

    public function sendMail($to, $subject, $html) {
        $send_email = $this->CI->configuraciones->getSendEmail();
        $email = new SendGrid\Email();
        $email
                ->addTo($to)
                ->setFrom($send_email)
                ->setSubject($subject)
                ->setHtml($html)
        ;
//$sendgrid->send($email);
// Or catch the error

        try {
            $this->send($email);
            return TRUE;
        } catch (\SendGrid\Exception $e) {
            /*echo $e->getCode();
            foreach ($e->getErrors() as $er) {
                echo $er;
            }*/
        }
    }

}
