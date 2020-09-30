<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

if($imagen == 1){
	$nombreImagen = date("YmdHis_") . $id_producto . '.jpg';
}else{
	$nombreImagen = NULL;
}


$oOferta = new VoOfertas();
$oOferta->setFin($fin_oferta);
$oOferta->setPorcentaje($porcentaje_producto);
$oOferta->setPrecio($descuento_producto);
$oOferta->setProducto_id($id_producto);
$oOferta->setImg($nombreImagen);

$oMyOferta = $oMysql->getOfertas();


if ($oMyOferta->guardar($oOferta)) {
    $_SESSION['estado'] = TRUE;
    echo "Exito";
} else {
    $_SESSION['estado'] = FALSE;
    echo "Error";
}