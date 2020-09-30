<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
try {
    $datos = array();
    if (isset($_GET['nom'])) {
        $nom = $_GET['nom'];
        $sql = "SELECT id, cod_barra, descripcion FROM productos WHERE "
                . "descripcion LIKE '%" . $nom . "%' AND habilitado = 0 "
                . "ORDER BY descripcion ASC;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        while ($fila = mysqli_fetch_object($resultado)) {
            $datos[$fila->id][0] = $fila->cod_barra;
            $datos[$fila->id][1] = $fila->descripcion;
        }
    }
    echo json_encode($datos);
} catch (exception $e) {
    print_r($e);
}