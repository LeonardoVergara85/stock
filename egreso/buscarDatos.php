<?php

session_name('stock');
session_start();
extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$resultado = mysqli_query($_SESSION['con'], "SELECT * FROM `stock_vw` WHERE cod_barra = " . $valor . ";");
$fila = mysqli_fetch_object($resultado);
if ($fila) {
    $resp['cantidad'] = $fila->cantidad;
} else {
    $resp['cantidad'] = FALSE;
}
echo json_encode($resp);
