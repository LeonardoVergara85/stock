<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();

$oProd->setDescripcion($nombre);
$oProd->setUmed_id($umedida);
$oProd->setCod_barra($codigo);

$oProd->setPaquete(1);
if (isset($cantidad)) {
    $oProd->setPaquete($cantidad);
}

$oProd->setPunto_reposicion($reposicion);

if ($mProd->guardar($oProd)) {

    $oMovimi = new VoMovimientos();
    
    $oMovimi->setProducto_id($oProd->getId());
    $oMovimi->setCantidad($inicial);
//    $oMovimi->setFecha(date('Y-m-d'));
    $oMovimi->setTipo_mov_id(1);
    $oMovimi->setRemito_id('NULL');
    $oMovimi->setfactura_id('NULL');
    $oMovimi->setUsuario_id(1);
    $mMovimi = $oMysql->getMovimientos();
    if ($mMovimi->guardar($oMovimi)) {
        echo "Exito";
    } else {
        echo "Error";
    }
} else {
    echo "Error";
}