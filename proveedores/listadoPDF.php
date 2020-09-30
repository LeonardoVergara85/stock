<?php
include_once '../assets/fpdf17/fpdf.php';
session_name('stock');
session_start();


require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProveedores();
$oVoProv = new VoProveedores();
$data = $oProv->buscar();
  
$fecha = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
      global $fecha;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg' , 10 ,8, 190 , 0,'JPG', ''); 
        $this->Cell(100);  
        $this->Ln(50);
        $this->SetFont('Arial','i',10);
        $this->Cell(195,10,  utf8_decode($fecha),0,0,'R');


        $this->SetMargins(10, 0);
        $this->Ln(10);
        $this->SetFont('Arial','B',15);
        $this->Cell(190,6,'LISTADO DE PROVEEDORES',1,0,'C');
        $this->SetFont('arial', 'B', 10);
        $this->Ln(6);
  
        $this->SetMargins(10, 0);
        $this->Cell(45, 5, 'Nombre', 1, 0, 'C');
        $this->Cell(45, 5, 'Domicilio', 1, 0, 'C');
        $this->Cell(30, 5, 'Telefono', 1, 0, 'C');
        $this->Cell(40, 5,  'Correo', 1, 0, 'C');
        $this->Cell(30, 5,  'Cuit', 1, 0, 'C');
        $this->Ln(4);
      
    }
    function Footer()
    {
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print current and total page numbers
    $this->Cell(0,10,  utf8_decode('Página '.$this->PageNo()),0,0,'C');
    $this->Cell(0,10,  utf8_decode('EMPORIO DE LA ELECTRICIDAD'),0,0,'R');
    }


}


$a = new PDF('P','mm','A4');
$a->AddPage();

$a->Header();
 foreach ($data as $key) {
        $a->SetFont('Arial','I',10);
        $a->SetMargins(10, 0);
        $a->Ln(2);
        $a->SetMargins(10, 0);
        $a->SetFont('Arial','B',10);
        $a->Cell(45, 5, utf8_decode($key->getNombre()), 0, 0, 'L');
        $a->SetFont('Arial','I',8);
        $a->Cell(45, 5, utf8_decode($key->getDomicilio()), 0, 0, 'L');
        $a->SetFont('Arial','I',10); 
        $a->Cell(30, 5, $key->getTelefono(), 0, 0, 'L'); 
        $a->SetFont('Arial','I',8);
        $a->Cell(40, 5, $key->getCorreo(), 0, 0, 'L'); 
        $a->SetFont('Arial','I',10);
        $a->Cell(30, 5, $key->getCuit(), 0, 0, 'C'); 
        $a->Ln(5);
        $a->Cell(190, 5, utf8_decode($key->getComentario()), 'B', 1, 'L'); 
        $a->Ln(2);
  }
$a->Output('plantillaPFD.pdf', 'I');