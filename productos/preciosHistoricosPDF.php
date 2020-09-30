<?php
include_once '../assets/fpdf17/fpdf.php';
session_name('stock');
session_start();


require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
 $idp = $_GET['idp'];
 $oMysql->conectar();
 $oPP = $oMysql->getProveedorProducto();
 $oVoPP = new VoProvProd();
 $oVoPP->setProducto_id($idp);
 $datos = $oPP->buscarPrecioHistorico($oVoPP);
 $arreglo = array();
 $cont = 0;
 foreach ($datos as $key) {
        $cont = $cont + 1;
        $nombreProducto = $key->getProducto()->getDescripcion();
        $codigoProducto = $key->getProducto()->getCod_barra();

    }


$fecha = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
      global $fecha,$nombreProducto,$codigoProducto;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg' , 10 ,8, 190 , 0,'JPG', ''); 
        $this->Cell(100);  
        $this->Ln(50);
        $this->SetFont('Arial','i',10);
        $this->Cell(195,10,  utf8_decode($fecha),0,0,'R');

        $this->SetMargins(10, 0);
        $this->Ln(10);
        $this->SetFont('Arial','I',12);
        $this->Cell(190,6,utf8_decode('Precios Históricos'),1,0,'C');
        $this->Ln(6);
        $this->SetFont('Arial','B',12);
        $this->Cell(190,6,$codigoProducto.' - '.$nombreProducto,1,0,'C');
        $this->SetFont('arial', 'B', 10);
        $this->Ln(6);
  
        $this->SetMargins(10, 0);
        $this->Cell(100, 5, utf8_decode('Proveedor'), 1, 0, 'C');
        $this->Cell(25, 5, utf8_decode('Fecha'), 1, 0, 'C');
        $this->Cell(22, 5, '% inc. costo', 1, 0, 'C');
        $this->Cell(25, 5,  'Precio costo', 1, 0, 'C');
        $this->Cell(18, 5,  'Vigente', 1, 0, 'C');
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
$cont = 0;
$vig = '';
 foreach ($datos as $valores) {
        $cont++;
        if($valores->getPrecio()->getVigente() == 'S'){$vig = 'Si';}else{$vig = 'No';}
        $a->SetFont('Arial','I',10);
        $a->SetMargins(10, 0);
        $a->Ln(2);
        $a->SetMargins(10, 0);
        $a->SetFont('Arial','I',9);
        $a->Cell(100, 5, utf8_decode($valores->getProveedor()->getNombre()), 'B', 0, 'L');
        $a->SetFont('Arial','I',9);
        $a->Cell(25, 5, utf8_decode($valores->getPrecio()->getfecha()), 'B', 0, 'C');
        $a->Cell(22, 5, '% '.$valores->getPrecio()->getPorcentaje(), 'B', 0, 'C'); 
        $a->Cell(25, 5, '$ '.$valores->getPrecio()->getPrecio(), 'B', 0, 'C');  
        $a->Cell(18, 5, $vig, 'B', 0, 'C'); 
        $a->SetFont('Arial','I',10);
        $a->Ln(5);
  }
 $a->Ln(10);
 
 $a->Output('productosProveedorPFD.pdf', 'I');