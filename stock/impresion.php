<?php

include_once '../assets/fpdf17/fpdf.php';
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$resultado = mysqli_query($_SESSION['con'], "SELECT * FROM `stock_vw`;");
$fila = mysqli_fetch_object($resultado);
if ($fila) {
    $i = 0;
    $aProducts = array();
    $mPrecio = $oMysql->getPrecios();

    do {
        $oPre = new VoPrecios();
        $oPre->setProducto_id($fila->id);
        $oPre = $mPrecio->buscar($oPre);

        $aProducts[$i]['cod_barra'] = $fila->cod_barra;
        $aProducts[$i]['descripcion'] = $fila->descripcion;
        $aProducts[$i]['cantidad'] = $fila->cantidad;
        $aProducts[$i]['punto_reposicion'] = $fila->punto_reposicion;
        $aProducts[$i]['precio'] = '$' . $oPre->getPrecio();
        $aProducts[$i]['precio_total'] = ($oPre->getPrecio() * $fila->cantidad);
        unset($oPre);

        $i++;
    } while ($fila = mysqli_fetch_object($resultado));
}

$cont = 0;
$totalc = 0;
$totalp = 0;

$fecha = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
        global $fech, $fecha, $numero, $nomProveedor, $cuitProveedor, $domProveedor, $telProveedor, $correoProveedor, $fechaRemito;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg', 10, 8, 190, 0, 'JPG', '');
        $this->Ln(50);
        $this->SetFont('Times', 'B', 12);
        $this->SetMargins(5, 10);
        $this->Cell(110, 12, utf8_decode('Stock de productos al ' . date('d/m/Y')), 0, 0, 'L');
        $this->Ln(8);
        $this->SetFont('Arial', 'i', 10);
//        $this->SetMargins(10, 0);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(110, 5, 'Producto', 1, 0, 'C');
        $this->Cell(11, 5, 'Stock', 1, 0, 'C');
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(11, 5, 'Pto. Rep.', 1, 0, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(16, 5, 'Precio', 1, 0, 'C');
        $this->Cell(16, 5, 'Total', 1, 0, 'C');
//        $this->Ln();
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


foreach ($aProducts as $key => $prod) {
    $totalc = $totalc + $prod['cantidad'];
    $totalp = $totalp + (float) $prod['precio_total'];
    if ($prod['cantidad'] < $prod['punto_reposicion']) {
//        $color = "danger";
        $a->SetFillColor(242, 222, 222);
    } else {
//        $color = "";
        $a->SetFillColor(219, 219, 219);
        $a->SetFillColor(255, 255, 255);
    }
    $a->SetFont('Arial', 'I', 10);

    $a->Ln();
    $a->Cell(30, 5, $prod['cod_barra'], 1, 0, 'C', TRUE);
    $a->Cell(110, 5, utf8_decode($prod['descripcion']), 1, 0, 'L', TRUE);
    $a->SetFont('Arial', 'I', 9);
    $a->Cell(11, 5, $prod['cantidad'], 1, 0, 'R', TRUE);
    $a->Cell(11, 5, $prod['punto_reposicion'], 1, 0, 'R', TRUE);
    $a->SetFont('Arial', 'I', 8);
    $a->Cell(16, 5, $prod['precio'], 1, 0, 'R', TRUE);
    $a->Cell(16, 5, '$' . $prod['precio_total'], 1, 0, 'R', TRUE);
    $a->SetFont('Arial', 'I', 10);
}
$a->Ln();
//$a->Cell(119, 5, '', 1, 0, 'R', TRUE);
$a->Cell(151, 5, $totalc, 'T', 0, 'R', TRUE);
$a->Cell(43, 5, '$' . $totalp, 'T', 0, 'R', TRUE);

//foreach ($data as $key) {
//    $a->SetFont('Arial', 'I', 10);
//    $a->SetMargins(10, 0);
//    $a->Ln(4);
//    $a->SetMargins(10, 0);
//    $a->Cell(15, 5, $key->getProducto_id(), 0, 0, 'C');
//    $a->Cell(125, 5, $key->getProducto()->getDescripcion(), 0, 0, 'L');
//    $a->Cell(30, 5, $key->getProducto()->getCod_barra(), 0, 0, 'L');
//    $a->Cell(20, 5, $key->getCantidad(), 0, 0, 'C');
//    $a->Ln(4);
//}
$a->Output('plantillaPFD.pdf', 'I');
