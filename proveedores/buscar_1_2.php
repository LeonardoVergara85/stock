<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);

$oProv = new VoProveedores();
$mProv = $oMysql->getProveedores();

if ($prov == "T") {
    $oProv = $mProv->buscar();
} else {
    $oProv->setId($prov);
    $oProv = $mProv->buscarProveedor($oProv);
}

$mostrar = "";
foreach ($oProv as $key => $proveedor) {
    $mostrar .= "<div class = 'panel panel-default'>"
            . "<div class = 'panel-heading'>"
            . $proveedor->getNombre()
            . "</div>"
            . "<div class = 'panel-body'>"
            . "<table class='table table-hover table-striped table-condensed'>";
    /* Acá van los productos del prveedor */

    $sql = "SELECT * FROM listado1_vw WHERE proveedor_id = " . $proveedor->getId() . ";";
    $resultado = mysqli_query($_SESSION['con'], $sql);
    $fila = mysqli_fetch_object($resultado);

    if ($fila) {
        $mostrar .= "<tr>"
                . "<th class='col-sm-2' style='background-color: darkgray;'>código</th>"
                . "<th style='background-color: darkgray;'>Descripción</th>"
                . "</tr>";
        do {
            $mostrar .= "<tr>"
                    . "<td>" . $fila->cod_barra . "</td>"
                    . "<td>" . utf8_encode(trim($fila->descripcion)) . "</td>"
                    . "</tr>";
        } while ($fila = mysqli_fetch_object($resultado));
    } else {
        $mostrar .= "<tr><td>No hay datos para mostrar.</td></tr>";
    }
    $mostrar .= "</table>"
            . "</div>"
            . "</div>";
}

echo $mostrar;
