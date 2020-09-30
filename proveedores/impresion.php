<?php

include_once '../assets/fpdf17/fpdf.php';
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);

$oProv = new VoProveedores();
$oProv->setId($prov);
$mProv = $oMysql->getProveedores();
$oProv = $mProv->buscarProveedor($oProv);

$proveedor = $oProv[0]->getNombre();
unset($oProv);
unset($mProv);

if ($prov == "T") {
    $sql = "SELECT * FROM listado2_vw;";
} else {
    $sql = "SELECT * FROM listado2_vw WHERE proveedor_id = " . $prov . ";";
}

$resultado = mysqli_query($_SESSION['con'], $sql);
$fila = mysqli_fetch_object($resultado);
if ($fila) {
    $i = 0;
    $aDatos = array();

    do {
        $aDatos[$i]['cod_barra'] = $fila->cod_barra;
        $aDatos[$i]['descripcion'] = $fila->descripcion;
        $aDatos[$i]['compra'] = $fila->compra;
        $aDatos[$i]['venta'] = $fila->venta; 
        $aDatos[$i]['ganancia'] = $fila->ganancia;
        $aDatos[$i]['sugerido'] = $fila->sugerido;
        $aDatos[$i]['stock'] = $fila->cantidad;

        $i++;
    } while ($fila = mysqli_fetch_object($resultado));
}

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
        $this->Cell($w, 12, utf8_decode('Listado de productos de ' . $proveedor . ' al ' . date('d/m/Y')), 0, 0, 'L');
        $this->Ln();
        $this->SetFont('Arial', 'i', 10);

        $this->Cell($w * 0.12, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell($w * 0.44, 5, 'Producto', 1, 0, 'C');
        $this->Cell($w * 0.085, 5, 'Stock', 1, 0, 'C');
        $this->Cell($w * 0.085, 5, '$ Costo', 1, 0, 'C');
        $this->Cell($w * 0.085, 5, '% Inc.', 1, 0, 'C');
        $this->Cell($w * 0.085, 5, '$ Sug.', 1, 0, 'C');
        $this->Cell($w * 0.085, 5, '$ Venta', 1, 0, 'C');
    }

    function Footer() {
//           // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print current and total page numbers
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo()), 0, 0, 'C');
    }

}

$a = new PDF('P', 'mm', 'A4');
$a->AddPage();

$a->Header();


foreach ($aDatos as $key => $datos) {
    $a->SetFillColor(255, 255, 255);
    $a->SetFont('Arial', 'I', 9);

    $a->Ln();
    $a->Cell($w * 0.12, 5, $datos['cod_barra'], 1, 0, 'C', TRUE);
    $a->Cell($w * 0.44, 5, utf8_decode($datos['descripcion']), 1, 0, 'L', TRUE);
    $a->Cell($w * 0.085, 5, $datos['stock'], 1, 0, 'R', TRUE);
    $a->Cell($w * 0.085, 5, $datos['compra'], 1, 0, 'R', TRUE);
    $a->Cell($w * 0.085, 5, $datos['ganancia'], 1, 0, 'R', TRUE);
    $a->Cell($w * 0.085, 5, $datos['sugerido'], 1, 0, 'R', TRUE);
    $a->Cell($w * 0.085, 5, $datos['venta'], 1, 0, 'R', TRUE);
}
$a->Output('plantillaPFD.pdf', 'I');
