<?php
include_once '../assets/fpdf17/fpdf.php';
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
  $oMysql->conectar();
  $idP = $_POST['id'];
  $oVoMov = new VoMovimientos();
  $oMov = $oMysql->getMovimientos();
  $oVoMov->setRemito_id($idP);
  $data = $oMov->buscarMovRemitos($oVoMov);
  $arreglo = array();
  $cont = 0;
  $fech = $_POST['f'];
   foreach ($data as $key) {
        $numero = $key->getRemito()->getNumero();
        $fechaRemito = $key->getRemito()->getFecha();
        $nomProveedor = $key->getProveedor()->getNombre(); 
        $cuitProveedor = $key->getProveedor()->getCuit(); 
        $domProveedor = $key->getProveedor()->getDomicilio(); 
        $telProveedor = $key->getProveedor()->getTelefono(); 
        $correoProveedor = $key->getProveedor()->getCorreo(); 
  }
  if($cuitProveedor == null){
    $cuitProveedor = '----------';
  }if($domProveedor == null){
    $domProveedor = '----------';
  }if($telProveedor == null){
    $telProveedor = '----------';
  }if($correoProveedor == null){
    $correoProveedor = '----------';
  }
  $fecha = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
      global $fech,$fecha,$numero,$nomProveedor,$cuitProveedor,$domProveedor,$telProveedor,$correoProveedor,$fechaRemito;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg' , 10 ,8, 190 , 0,'JPG', ''); 
        $this->Cell(100); 
        $this->SetFont('Arial','i',8);  
        $this->Cell(90,10,  utf8_decode('DOCUMENTO SIN VALOR LEGAL'),0,0,'R');
        $this->Ln(40);
        $this->SetFont('Arial','i',10);
        $this->Cell(195,10,  utf8_decode($fecha),0,0,'R');
        $this->Ln(12);
        // $this->SetY(15,0);
        // $this->SetX(120,0);
        $this->SetFont('Arial','I',12);
        $this->Cell(195,10,  utf8_decode('Remito Nùmero: '.$numero),0,0,'R');
        $this->Ln(4);
        $this->Cell(195,10,  utf8_decode('Fecha Remito: '.$fechaRemito),0,0,'R');
        $this->SetMargins(10, 0);
        $this->Ln(10);
        $this->SetFont('Arial','B',15);
        $this->Cell(190,8,utf8_decode($nomProveedor),1,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',10);
        $this->Cell(190,6,'Cuit: '.$cuitProveedor,1,0,'C');
        $this->Ln(6);
        $this->SetFont('Arial','I',10);
        $this->Cell(190,6,utf8_decode($domProveedor.'  - Tel:'.$telProveedor.'  - Email: '.$correoProveedor),1,0,'C');
        $this->SetFont('arial', 'B', 10);
        $this->Ln(6);
        $this->SetMargins(10, 0);
  
        $this->SetMargins(10, 0);
        $this->Cell(15, 5, 'ID', 1, 0, 'C');
        $this->Cell(125, 5, 'PRODUCTO', 1, 0, 'C');
        $this->Cell(30, 5, 'COD.', 1, 0, 'C');
        $this->Cell(20, 5,  'CANTIDAD', 1, 0, 'C');
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
    }


}


$a = new PDF('P','mm','A4');
$a->AddPage();

$a->Header();
 foreach ($data as $key) {
        $a->SetFont('Arial','I',10);
        $a->SetMargins(10, 0);
        $a->Ln(4);
        $a->SetMargins(10, 0);
        $a->Cell(15, 5, $key->getProducto_id(), 0, 0, 'C');
        $a->Cell(125, 5, $key->getProducto()->getDescripcion(), 0, 0, 'L');
        $a->Cell(30, 5, $key->getProducto()->getCod_barra(), 0, 0, 'L');
        $a->Cell(20, 5,  $key->getCantidad(), 0, 0, 'C');
        $a->Ln(4);  
  }
$a->Output('plantillaPFD.pdf', 'I');