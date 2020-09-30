<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();

$oProd->setId($iddesha);

if ($mProd->deshabilitar($oProd)) {
    $_SESSION['habilitado'] = TRUE;
    echo "Exito";
} else {
    $_SESSION['habilitado'] = FALSE;
    echo "Error";
}