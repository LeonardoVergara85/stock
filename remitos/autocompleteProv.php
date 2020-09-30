<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
try {
    $datos = array();
    if (isset($_GET['nom'])) {
        $nom = $_GET['nom'];
        $sql = "SELECT id, nombre FROM proveedores WHERE nombre LIKE '%" . $nom . "%' "
                . "AND fecha_baja = '0000-00-00' ORDER BY nombre ASC ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        while ($fila = mysqli_fetch_object($resultado)) {
            // $datos[0] = $fila->id;
            // $datos[1] = $fila->nombre;
            $datos[$fila->id] = $fila->nombre;
        }
    }

    //print_r($datos);
    echo json_encode($datos);
} catch (exception $e) {
    print_r($e);
}
