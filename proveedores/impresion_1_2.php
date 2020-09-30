<?php

include_once '../assets/fpdf17/fpdf.php';
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);

$fecha = date('d/m/Y');
$w = 200;

class PDF extends FPDF {

    function Header() {
        global $fecha, $w, $proveedor;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg', 10, 8, 190, 0, 'JPG', '');
        $this->Ln(50);
        $this->SetFont('Times', 'B', 12);
        $this->SetMargins(5, 10);
        $this->Cell($w, 12, utf8_decode('Listado de productos por proveedor al ' . date('d/m/Y')), 0, 0, 'L');
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo()), 0, 0, 'C');
    }

}

$a = new PDF('P', 'mm', 'A4');
$a->AddPage();

$a->Header();

/* * ******************************** */

$oProv = new VoProveedores();
$mProv = $oMysql->getProveedores();

if ($prov == "T") {
    $oProv = $mProv->buscar();
} else {
    $oProv->setId($prov);
    $oProv = $mProv->buscarProveedor($oProv);
}

foreach ($oProv as $proveedor) {
    $a->Ln();
    $a->SetFont('Arial', 'i', 10);
    $a->SetFillColor(200, 200, 200);
    $a->Cell($w, 5, 'Proveedor: ' . $proveedor->getNombre(), 1, 0, 'C', 1);
    $a->Ln();
    $a->SetFillColor(255, 255, 255);
    $a->Cell($w * 0.15, 5, utf8_decode('Código'), 1, 0, 'C');
    $a->Cell($w * 0.85, 5, 'Producto', 1, 0, 'C');

    $sql = "SELECT * FROM listado1_vw WHERE proveedor_id = " . $proveedor->getId() . ";";
    $resultado = mysqli_query($_SESSION['con'], $sql);
    $fila = mysqli_fetch_object($resultado);
    if ($fila) {
        do {
            $a->Ln();
            $a->Cell($w * 0.15, 5, $fila->cod_barra, 1, 0, 'C', TRUE);
            $a->Cell($w * 0.85, 5, utf8_encode(trim($fila->descripcion)), 1, 0, 'L', TRUE);
        } while ($fila = mysqli_fetch_object($resultado));
    } else {
        $a->Ln();
        $a->Cell($w, 5, "No hay datos para mostrar.", 1, 0, 'C', TRUE);
    }
    $a->Ln();
}
$a->Output('plantillaPFD.pdf', 'I');
