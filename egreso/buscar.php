<?php

session_name('stock');
session_start();
extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();
$oProd->setCod_barra($valor);
$oProd = $mProd->buscarBarra($oProd);
if ($oProd) {
    $resp['descripcion'] = $oProd->getDescripcion();
    $resp['paquete'] = $oProd->getPaquete();
    $resp['repo'] = $oProd->getPunto_reposicion();
} else {
    $resp['descripcion'] = FALSE;
}
echo json_encode($resp);
