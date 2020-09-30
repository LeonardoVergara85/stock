<?php
include_once '../assets/fpdf17/fpdf.php';
session_name('stock');
session_start();


require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
 $idp = $_GET['idp'];
 $oMysql->conectar();
 $oProdProv = new VoProvProd();
 $mPp = $oMysql->getProveedorProducto();
 $oProdProv->setProveedor_id($idp);
 $prod = $mPp->buscar($oProdProv);
 foreach ($prod as $val) {
    $proveedornom = $val->getProveedor()->getNombre();
 }


$fecha = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
      global $fecha,$proveedornom;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg' , 10 ,8, 190 , 0,'JPG', ''); 
        $this->Cell(100);  
        $this->Ln(50);
        $this->SetFont('Arial','i',10);
        $this->Cell(195,10,  utf8_decode($fecha),0,0,'R');


        $this->SetMargins(10, 0);
        $this->Ln(10);
        $this->SetFont('Arial','B',12);
        $this->Cell(190,6,$proveedornom.' - LISTADO DE PRODUCTOS',1,0,'C');
        $this->SetFont('arial', 'B', 10);
        $this->Ln(6);
  
        $this->SetMargins(10, 0);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(110, 5, utf8_decode('Descripción'), 1, 0, 'C');
        $this->Cell(30, 5, 'Fecha Precio', 1, 0, 'C');
        $this->Cell(20, 5,  'Precio', 1, 0, 'C');
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
 foreach ($prod as $valores) {
        $cont++;
        $a->SetFont('Arial','I',10);
        $a->SetMargins(10, 0);
        $a->Ln(2);
        $a->SetMargins(10, 0);
        $a->SetFont('Arial','I',10);
        $a->Cell(30, 5, utf8_decode($valores->getProducto()->getCod_barra()), 'B', 0, 'C');
        $a->SetFont('Arial','I',9);
        $a->Cell(110, 5, utf8_decode($valores->getProducto()->getDescripcion()), 'B', 0, 'L');
        $a->SetFont('Arial','I',10); 
        $a->Cell(30, 5, $valores->getPrecio()->getFecha(), 'B', 0, 'C'); 
        $a->SetFont('Arial','I',10);
        $a->Cell(20, 5, '$ '.$valores->getPrecio()->getPrecio(), 'B', 0, 'C'); 
        $a->SetFont('Arial','I',10);
        $a->Ln(5);
  }
 $a->Ln(10);
  $a->Cell(190, 5, 'Cantidad de Productos: '.$cont, 1, 0, 'C');  
$a->Output('productosProveedorPFD.pdf', 'I');