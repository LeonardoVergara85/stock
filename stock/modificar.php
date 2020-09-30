<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();

$oProd->setDescripcion($nombre_modal);
$oProd->setUmed_id($umedida_modal);
$oProd->setCod_barra($codigo_modal);

$oProd->setId($id_modal);

$oProd->setPaquete(1);
if (isset($cantidad_modal)) {
    $oProd->setPaquete($cantidad_modal);
}

$oProd->setPunto_reposicion($reposicion_modal);

if ($mProd->actualizar($oProd)) {
    echo "Exito";
} else {
    echo "Error";
}