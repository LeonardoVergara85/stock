<?php

session_name('stock');
session_start();
extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$sentencia = "SELECT m.id, cantidad, (cantidad/paquete) AS paquete, factura_id, cod_barra, descripcion, umed_id "
        . "FROM movimientos m "
        . "LEFT JOIN productos p ON p.id = m.producto_id "
        . "LEFT JOIN unidades_medidas um ON um.id = p.umed_id "
        . "WHERE factura_id = " . $valor . ";";

$resultado = mysqli_query($_SESSION['con'], $sentencia);
$fila = mysqli_fetch_object($resultado);
$indice = 0;
if ($fila) {
    do {
        $resp['id'][$indice] = $fila->id;
        $resp['cantidad'][$indice] = $fila->cantidad;
        $resp['paquete'][$indice] = $fila->paquete;
        $resp['cod_barra'][$indice] = $fila->cod_barra;
        $resp['descripcion'][$indice] = $fila->descripcion;
        $resp['umed_id'][$indice] = $fila->umed_id;
        $indice++;
    } while ($fila = mysqli_fetch_object($resultado));
} else {
    $resp['cantidad'] = FALSE;
}
echo json_encode($resp);
