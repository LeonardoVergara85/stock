<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);

if (isset($_POST['tipo']) && $_POST['tipo'] == 'cargarCategoria') {
    $nombreCategoria = $_POST['nombrec'];
    $descCategoria = $_POST['descc'];
    $ordenCategoria = $_POST['orden'];
    $oMysql->conectar();
    $oCat = $oMysql->getCategorias();
    $oCat->altaCategoria($nombreCategoria, $descCategoria, $ordenCategoria);

    echo json_encode(1000);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'verificarCat') {
    $nombreCategoria = $_POST['nombrec'];
    $oMysql->conectar();
    $oCat = $oMysql->getCategorias();
    $resultado = $oCat->buscarNombre($nombreCategoria);
    $arreglo = array();
    $aux = 0;
    foreach ($resultado as $value) {
        $arreglo['id'] = $value->getId();
        $aux++;
    }
    echo json_encode($aux);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'modificarCat') {
    $id = $_POST['id'];
    $nombreCategoria = $_POST['nombrec'];
    $descCategoria = $_POST['descc'];
    $ordenCategoria = $_POST['orden'];
    
    $oMysql->conectar();
    $oCat = $oMysql->getCategorias();
    $oCat->modCategoria($id, $nombreCategoria, $descCategoria, $ordenCategoria);
    echo json_encode(2000);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'eliminarCat') {
    $id = $_POST['idcc'];
    $oMysql->conectar();
    $oCat = $oMysql->getCategorias();
    $oCat->eliminarCategoria($id);
    echo json_encode(3000);
}


if (isset($_POST['tipo']) && $_POST['tipo'] == 'buscar_imagenes') {
    $id = $_POST['idcat'];
    $oMysql->conectar();
    $oCat = $oMysql->getCategorias();
    $arreglo = $oCat->buscarImagenes_($id);
    $lista = array();
    foreach ($arreglo as $val) {

                array_push($lista, ['id' => $val[1],'img' => $val[3]]);

            }
    echo json_encode($lista);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'eliminarImg') {

    $id = $_POST['id_img'];


    $oMysql->conectar();
    $oCat = $oMysql->getCategorias();
    $lista = array();
    $arreglo = $oCat->buscarImagen($id);
    $oCat->eliminarImagen($id);               

    unlink('../archivos/categorias/'.$arreglo[3]);

     echo json_encode(1);
    
}
