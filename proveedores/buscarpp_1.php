<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);


$sentencia = "SELECT p.id AS DT_RowId, p.cod_barra AS codigo, p.descripcion AS descripcion"
        . ", p3.precio AS costo, pp.ganancia AS porcen, IF(p3.precio>0,0,1) AS orden"
        . " FROM productos p"
        . " LEFT JOIN provprod pp ON baja = 0 AND pp.producto_id = p.id"
        . " AND pp.proveedor_id = " . $prov
        . " LEFT JOIN precios_prod_prov p3 ON p3.idProdProv = pp.id AND vigente = 'S'"
        . " WHERE p.habilitado = 0"
        . " ORDER BY orden, p.id;";

$res = mysqli_query($_SESSION['con'], $sentencia) or die(false);

$myfile = fopen("data/datos.txt", "w") or die("Unable to open file!");

$json_array = array();
while ($file = mysqli_fetch_assoc($res)) {
    $file['checkeado'] = "<input type='checkbox' checked id='che" . $file['DT_RowId']
            . "' name='che" . $file['DT_RowId'] . "' />";
    if (!$file['porcen']) {
        $file['checkeado'] = "<input type='checkbox' id='che" . $file['DT_RowId']
                . "' name='che" . $file['DT_RowId'] . "' />";
    }

    $file['costo'] = "<input type='number' class='form-control' value='" . $file['costo'] . "'"
            . " id='precio" . $file['DT_RowId'] . "' value='' name='precio" . $file['DT_RowId']
            . "' placeholder='Precio del Producto' step='0.01' >";

    $file['porcen'] = "<input type='number' class='form-control' value='" . $file['porcen'] . "'"
            . "id='porcent" . $file['DT_RowId'] . "' name='porcent" . $file['DT_RowId']
            . "' placeholder='Porcentaje de ganancia' step='0.01' >";

    $json_array[] = $file;
}
fwrite($myfile, '{ "data": ' . json_encode($json_array) . ' }');
fclose($myfile);

$resp['Fin'] = "Fin";
echo json_encode($resp);
