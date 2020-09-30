<?php

session_name('stock');
session_start();

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);

if (isset($_POST['tipo']) && $_POST['tipo'] == 'reajustar') {
    $oMysql->conectar();
    $oMov = $oMysql->getMovimientos();
    $oVoMov = new VoMovimientos();
    ///////////////////////nos traemos las varibales para el remito////////////////////////////////
    $id = $_POST['idp'];
    $codigo = $_POST['cod'];
    $usu = $_SESSION["id"];
    $cant = $_POST['cantidad'];
    $comentario = $_POST['comentario'];

    /////////////////////////////////////////////////////////////
    $oVoMov->setProducto_id($id);
    $oVoMov->setCantidad($cant);
    $oVoMov->setTipo_mov_id(4);
    $oVoMov->setRemito_id(0);
    $oVoMov->setFactura_id(0);
    $oVoMov->setUsuario_id($_SESSION["id"]);
    $oVoMov->setComentario($comentario);
    $oMov->guardar($oVoMov);
    //////////////////finalizamos la registracion ///////////////
    echo "700";
}
if (isset($_POST['tipo']) && $_POST['tipo'] == 'preciosHistoricos') {
    $idproducto = $_POST['idp'];
    $oMysql->conectar();
    $oPP = $oMysql->getProveedorProducto();
    $oVoPP = new VoProvProd();
    $oVoPP->setProducto_id($idproducto);
    $datos = $oPP->buscarPrecioHistorico($oVoPP);
    $arreglo = array();
    $cont = 0;
    foreach ($datos as $key) {
        $cont = $cont + 1;
        $arreglo['cant'] = $cont;
        $arreglo['id'][$cont] = $key->getID();
        $arreglo['vig'][$cont] = $key->getPrecio()->getVigente();
        $arreglo['nomprod'][$cont] = $key->getProducto()->getDescripcion();
        $arreglo['codprod'][$cont] = $key->getProducto()->getCod_barra();
        $arreglo['nomp'][$cont] = $key->getProveedor()->getNombre();
        $arreglo['precio'][$cont] = $key->getPrecio()->getPrecio();
        $arreglo['fechap'][$cont] = $key->getPrecio()->getfecha();
        $arreglo['porc'][$cont] = $key->getPrecio()->getPorcentaje();
    }
    echo json_encode($arreglo);
}