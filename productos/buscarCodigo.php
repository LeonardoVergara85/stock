<?php

session_name('stock');
session_start();
extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();
$oProd->setCod_barra($cod_barra);
$oProd = $mProd->buscarBarra($oProd);
if ($oProd) {
    echo "Exito";
} else {
    echo "Fracaso";
}
//echo json_encode($resp);
