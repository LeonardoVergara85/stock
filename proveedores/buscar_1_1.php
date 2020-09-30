<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);
if ($prov == "T") {
    $sql = "SELECT * FROM listado2_vw;";
} else {
    $sql = "SELECT * FROM listado2_vw WHERE proveedor_id = " . $prov . ";";
}

$myfile = fopen("data/busqueda.json", "w") or die("Unable to open file!");
$txt = "{\n\t\"data\": [";
fwrite($myfile, $txt);
$i = 0;

$resultado = mysqli_query($_SESSION['con'], $sql);
$fila = mysqli_fetch_object($resultado);
if ($fila) {
    do {
        if ($i == 0) {
            $txt = "\n\t{\n";
        } else {
            $txt = ",\n\t{\n";
        }

        $i++;
        $txt .= "\t\"DT_RowId\": \"" . $i . "\",\n";

        $txt .= "\t\"codigo\": \"" . $fila->cod_barra . "\",\n";

        $txt .= "\t\"descripcion\": \"" . (trim($fila->descripcion)) . "\",\n";

        $txt .= "\t\"stock\": \"" . $fila->cantidad . "\",\n";

        $txt .= "\t\"costo\": \"" . $fila->compra . "\",\n";

        $txt .= "\t\"venta\": \"" . $fila->venta . "\",\n";

//        $txt .= "\t\"sugerido\": \"" . $fila->sugerido . "\",\n";

        $txt .= "\t\"ganancia\": \"" . $fila->ganancia . "\"\n";

        $txt .= "\t}";
        fwrite($myfile, $txt);
    } while ($fila = mysqli_fetch_object($resultado));
}

$txt = "\n\t]\n}";
fwrite($myfile, $txt);
fclose($myfile);

$resp['Fin'] = "Fin";
echo json_encode($resp);
