<?php

session_name('stock');
session_start();
extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();
$oProd->setId($data);
$oProd = $mProd->buscar($oProd);

$resp['id'] = $oProd->getId();
$resp['cod_barra'] = $oProd->getCod_barra();
$resp['descripcion'] = $oProd->getDescripcion();
$resp['umed_id'] = $oProd->getUmed_id();
$resp['paquete'] = $oProd->getPaquete();
$resp['punto_reposicion'] = $oProd->getPunto_reposicion();
echo json_encode($resp);
