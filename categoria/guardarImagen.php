<?php

$ruta = '../archivos/categorias/';
if ($_FILES['archivo1']['name'] != '') {
    $temporal = $_FILES['archivo1']['tmp_name'];
    $nombreImagen = date("YmdHis_") . $_POST['idcategoriai'] . '.jpg';
    $Destino = $ruta . $nombreImagen;
    if (move_uploaded_file($temporal, $Destino)) {

        require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        $oCat = $oMysql->getCategorias();
        // $oCat->updateImagen($_POST['idcategoriai'], $nombreImagen);
        $oCat->updateImagen_($_POST['idcategoriai'], $nombreImagen);
        echo "Exitos";
    }
    echo "error";
}

header('location: index.php');
