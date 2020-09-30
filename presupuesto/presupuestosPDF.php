<?php
include_once '../assets/fpdf17/fpdf.php';
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
  $oMysql->conectar();
  $oPresu = $oMysql->getPresupuestos();
  $oDetallePresu = $oMysql->getDetallePresupuestos();
  $oVoPresu = new VoPresupuestos();
  $oVoDetallePresu = new VoDetallePresupuestos();
  $oVoPresu->setId($_POST['id']);
  $detalle = $oPresu->buscar($oVoPresu);
  $arreglo = array();
  $cont = 0;
  $num = 0;
  $solicitnate = '';
  $contacto = '';
  $fecha = '';
  $usu = '';
  $usuname = '';
  foreach ($detalle as $detail) {
    if($detail->getDetalle()->getPresupuesto_id() != null){
      $num = $arreglo['id'] = $detail->getDetalle()->getPresupuesto_id();
    }
    if($detail->getSolicitante() != null){
      $solicitante = $arreglo['solicitante'] = $detail->getSolicitante();
     }else{
        $solicitante = '-';
     } 
    if($detail->getContacto() != null){
      $contacto = $arreglo['contacto'] = $detail->getContacto();
     }else{
      $contacto = '-';
     }
    $fecha = $arreglo['fecha'] = $detail->getFecha();
    $usu = $arreglo['usuario'] = $detail->getUsuario_id();
    $usuname = $arreglo['usuarioname'] = $detail->getUsuario()->getNombre();
      $cont++;
  }
  $fechah = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
      global $num,$solicitante,$contacto,$fecha,$fechah,$usu,$usuname;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg' , 10 ,8, 190 , 0,'JPG', ''); 
        $this->Cell(100); 
        $this->SetFont('Arial','i',8);  
        $this->Cell(90,10,  utf8_decode($fechah.'   DOCUMENTO SIN VALOR LEGAL'),0,0,'R');
        $this->Ln(40);
        $this->SetFont('Arial','i',10);
        $this->Cell(195,10,  utf8_decode($fechah),0,0,'R');
        $this->Ln(12);
        // $this->SetY(15,0);
        // $this->SetX(120,0);
        $this->SetFont('Arial','I',12);
        $this->Cell(195,10,  utf8_decode('Presupuesto Nùmero: '.$num),0,0,'R');
        $this->Ln(4);
        $this->Cell(195,10,  utf8_decode('Fecha Presupuesto: '.$fecha),0,0,'R');
        $this->SetMargins(10, 0);
        $this->Ln(10);
        $this->SetFont('Arial','B',15);
        $this->Cell(190,8,utf8_decode($solicitante),1,0,'C');
        $this->Ln(8);
        $this->SetFont('Arial','B',10);
        $this->Cell(190,6,'Contacto: '.$contacto,1,0,'C');
        $this->Ln(6);
        $this->SetFont('Arial','I',10);
        $this->Cell(190,6,utf8_decode('cargado por '.$usuname),1,0,'C');
        $this->SetFont('arial', 'B', 10);
        $this->Ln(6);
        $this->SetMargins(10, 0);
  
        $this->SetMargins(10, 0);
        $this->Cell(100, 5, 'Producto', 1, 0, 'C');
        $this->Cell(30, 5,utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(20, 5, 'Precio u.', 1, 0, 'C');
        $this->Cell(20, 5,  'Cantidad', 1, 0, 'C');
        $this->Cell(20, 5,  'Total', 1, 0, 'C');
        $this->Ln(5);
      
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
$cont = 0;
$total = 0;
$cantotal = 0;
$totalpresu = 0;
$a->SetFont('arial', 'I', 10);
  foreach ($detalle as $detail) {
        $total = $detail->getDetalle()->getPrecio() * $detail->getDetalle()->getCantidad();
        $totalpresu = $totalpresu+$total;
        $cantotal = $cantotal+$detail->getDetalle()->getCantidad();
        $a->SetMargins(10, 0);
        $a->Cell(100, 5, $detail->getProducto()->getDescripcion(), 1, 0, 'L');
        $a->Cell(30, 5,$detail->getProducto()->getCod_barra(), 1, 0, 'C');
        $a->Cell(20, 5,'$ '.$detail->getDetalle()->getPrecio(), 1, 0, 'C');
        $a->Cell(20, 5,$detail->getDetalle()->getCantidad(), 1, 0, 'C');
        $a->Cell(20, 5,'$ '.$total, 1, 0, 'C');
        $a->Ln(5);
      $cont++;
  }
  $a->SetFont('arial', 'B', 10);
  $a->Cell(150, 5,'', 0, 0, 'C');
  $a->Cell(20, 5,$cantotal, 0, 0, 'C');
  $a->Cell(20, 5,'$ '.$totalpresu, 0, 0, 'C');
$a->Output('plantillaPFD.pdf', 'I');