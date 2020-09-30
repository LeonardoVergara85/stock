<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$mFactura = $oMysql->getFacturas();
$oFactura = new VoFacturas();

mysqli_query($_SESSION['con'], "BEGIN;");

$oFactura->setFecha(date('Y-m-d'));
$oFactura->setNumero($mFactura->ultima());
$oFactura->setNumero_ticket(0);
$oFactura->setSucursal(1);
$oFactura->setUsuario_id(1);

$res = $mFactura->guardar($oFactura);

unset($mFactura);

$mProd = $oMysql->getProductos();
$oProd = new VoProductos();
if ($res) {
    foreach ($arregle as $key => $value) {
        if ($value != '') {
            $oProd->setCod_barra($value);
            $oProd = $mProd->buscarBarra($oProd);
            $oMovimi = new VoMovimientos();

            $oMovimi->setProducto_id($oProd->getId());
            $oMovimi->setCantidad($cantidad[$key]);
//    $oMovimi->setFecha(date('Y-m-d'));
            $oMovimi->setTipo_mov_id(3);
            $oMovimi->setRemito_id('NULL');
            $oMovimi->setfactura_id($oFactura->getId());
            $oMovimi->setUsuario_id(1);
            $mMovimi = $oMysql->getMovimientos();

            $error = $mMovimi->guardar($oMovimi);

            if (!$error) {
                break;
            }
        }
    }
    if ($error) {
        mysqli_query($_SESSION['con'], "COMMIT;");
        $_SESSION['Producto'] = true;
        echo "Exito";
    } else {
        mysqli_query($_SESSION['con'], "ROLLBACK;");
        echo "Error";
    }
} else {
    mysqli_query($_SESSION['con'], "ROLLBACK;");
    echo "Error";
}
