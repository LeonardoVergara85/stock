<?php
$producto = $_POST['id_producto_img'];
$ruta = '../archivos/ofertas/';
if ($_FILES['img']['name'] != '') {
    $temporal = $_FILES['img']['tmp_name'];
    $nombreImagen = date("YmdHis_") . $producto . '.jpg';
    $Destino = $ruta . $nombreImagen;

    if (move_uploaded_file($temporal, $Destino)) {

        header('location: ofertas.php');

    }else{

        header('location: ofertas.php');

    }

}

//header('location: index.php');