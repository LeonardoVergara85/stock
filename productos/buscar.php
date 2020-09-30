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

$mPre = $oMysql->getPrecios();
$oPre = new VoPrecios();
$oPre->setProducto_id($oProd->getId());
$Precio = $mPre->buscar($oPre);

$resp['id'] = $oProd->getId();
$resp['cod_barra'] = $oProd->getCod_barra();
$resp['descripcion'] = $oProd->getDescripcion();
$resp['umed_id'] = $oProd->getUmed_id();
$resp['paquete'] = $oProd->getPaquete();
$resp['punto_reposicion'] = $oProd->getPunto_reposicion();
$resp['precio'] = $Precio->getPrecio();
$resp['categoria'] = $oProd->getCategoria_id();
echo json_encode($resp);
