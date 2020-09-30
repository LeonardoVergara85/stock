<?php
session_name('stock');
session_start();

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);

if (isset($_POST['tipo']) && $_POST['tipo'] == 'guardarRemito') {
    $oMysql->conectar();
    $oRem = $oMysql->getRemitos();
    $oMov = $oMysql->getMovimientos();
    $oVoRem = new VoRemitos();
    $oVoMov = new VoMovimientos();
    ///////////////////////nos traemos las varibales para el remito////////////////////////////////
    $id = $_POST['idp'];
    $numero = $_POST['numero'];
    $usu = $_SESSION["id"];
    $fecha = $_POST['fecha'];
    $cant = $_POST['cantidad'];
    ///////////////////////nos traemos los datos de la tabla productos en el arreglo////////////////
    $data = json_decode($_POST['array']);
    ///////////////////////seteamos las varibles para cargar remito/////////////////////////////////
    $oVoRem->setProveedor_id($id);
    $oVoRem->setNumero($numero);
    $oVoRem->setUsuario_id($usu);
    $oVoRem->setFecha($fecha);
    $idR = $oRem->guardar($oVoRem);
    /////////////////////////////////////////////////////////////
    for ($i = 1; $i < $cant; $i++) {
        $oVoMov->setProducto_id($data[$i][0]);
        $oVoMov->setCantidad($data[$i][3]);
        $oVoMov->setTipo_mov_id(2);
        $oVoMov->setRemito_id($idR);
        $oVoMov->setFactura_id(0);
        $oVoMov->setUsuario_id($_SESSION["id"]);
        $oMov->guardar($oVoMov);
    }
    //////////////////finalizamos la registracion ///////////////
    echo "700";
}


if (isset($_POST['tipo']) && $_POST['tipo'] == 'guardarRemito2') {
    $oMysql->conectar();
    $oMov = $oMysql->getMovimientos();
    $oVoMov = new VoMovimientos();
    $idRemito = $_POST['idr'];
    $cant = $_POST['cantidad'];
    $data = json_decode($_POST['array']);
    for ($i = 1; $i < $cant; $i++) {
        $oVoMov->setProducto_id($data[$i][0]);
        $oVoMov->setCantidad($data[$i][3]);
        $oVoMov->setTipo_mov_id(2);
        $oVoMov->setRemito_id($idRemito);
        $oVoMov->setFactura_id(0);
        $oVoMov->setUsuario_id(1);
        $oMov->guardar($oVoMov);
    }
    //////////////////finalizamos la registracion ///////////////
    echo "800";
}

// BUSCARMOS EL DETALLE DEL REMITO
if (isset($_POST['tipo']) && $_POST['tipo'] == 'buscarDetalle') {
    $oMysql->conectar();
    $idP = $_POST['id'];
    $oVoMov = new VoMovimientos();
    $oMov = $oMysql->getMovimientos();
    $oVoMov->setRemito_id($idP);
    $data = $oMov->buscarMovRemitos($oVoMov);
    $arreglo = array();
    $cont = 0;
    foreach ($data as $key) {
        $cont = $cont + 1;
        $arreglo[0] = $cont;
        $arreglo[1][] = $key->getID();
        $arreglo[2][] = $key->getProducto_id();
        $arreglo[3][] = $key->getCantidad();
        $arreglo[4][] = $key->getFecha();
        $arreglo[5][] = $key->getProducto()->getDescripcion();
        $arreglo[6][] = $key->getProducto()->getCod_barra();
        $arreglo[7] = $key->getRemito()->getNumero();
        $arreglo[8] = $key->getRemito()->getFecha();
        $arreglo[9] = $key->getUsuario()->getNombre();
    }

    echo json_encode($arreglo);
}
?>