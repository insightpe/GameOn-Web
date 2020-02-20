<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pdf
 *
 * @author furbox
 */
class Pdf extends TCPDF {
    //put your code here
    public function __destruct() {
        parent::__destruct();
    }
    
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 0, "AyG Outsourcing SAS", 0, 1, 'C', 0, '', 0);
        $this->Cell(0, 0, "Carrera 74 B No. 55-60 - Normandía Occidental - Bogotá - Teléfonos: 4298056-5479378", 0, 1, 'C', 0, '', 0);
        $this->Cell(0, 0, "Móviles: 304 6060562 - 311 8092147 - mail: ayg.outsourcing@gmail.com - NIT: 900932018-6", 0, 1, 'C', 0, '', 0);
    }
}
