<?php

include_once '../assets/fpdf17/fpdf.php';
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
extract($_POST, EXTR_OVERWRITE);

$sentencia = "SELECT m.id, cantidad, (cantidad/paquete) AS paquete, factura_id, cod_barra, descripcion, umed_id, fecha "
        . "FROM movimientos m "
        . "LEFT JOIN productos p ON p.id = m.producto_id "
        . "LEFT JOIN unidades_medidas um ON um.id = p.umed_id "
        . "WHERE factura_id = " . $valor . ";";

$resultado = mysqli_query($_SESSION['con'], $sentencia);
$fila = mysqli_fetch_object($resultado);

$arreglo = array();
$cont = 0;

$fecha = date('d/m/Y');

class PDF extends FPDF {

    function Header() {
        global $valor, $fecha;
        $this->SetMargins(5, 0);
        $this->Image('../assets/img/emporio.jpg', 10, 8, 190, 0, 'JPG', '');
        $this->Ln(50);
        
    }

    function Footer() {
        // Go to 1.5 cm from bottom
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
$a->SetFont('Arial', 'I', 10);
$a->Ln();
$a->Ln();

if ($fila) {
    $a->SetFont('Arial', 'I', 12);
    $a->Cell(100, 10, utf8_decode('Egreso Número: ' . $valor), 0, 0, 'L');
    $a->Cell(100, 10, utf8_decode('Fecha: ' . $fecha), 0, 0, 'R');
    $a->Ln();
    
    $a->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
    $a->Cell(95, 5, 'Producto', 1, 0, 'C');
    $a->Cell(25, 5, 'Cantidad', 1, 0, 'C');
    $a->Cell(25, 5, 'Paquete', 1, 0, 'C');
    $a->Cell(25, 5, 'Total', 1, 0, 'C');
    $a->Ln();

    do {
        $a->Cell(30, 5, $fila->cod_barra, 1, 0, 'L');
        $a->Cell(95, 5, utf8_decode($fila->descripcion), 1, 0, 'L');
        $a->Cell(25, 5, $fila->paquete, 1, 0, 'C');
        $a->Cell(25, 5, ($fila->cantidad / $fila->paquete), 1, 0, 'C');
        $a->Cell(25, 5, $fila->cantidad, 1, 0, 'C');

        $a->Ln();
    } while ($fila = mysqli_fetch_object($resultado));
} else {
    $a->Cell(180, 5, "No se han encontrado registros para mostrar.", 1, 0, 'L');
}
$a->Output('plantillaPFD.pdf', 'I');
