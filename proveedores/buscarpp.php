<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProveedores();
$oVoProv = new VoProveedores();
$oVoProv = $oProv->buscar();

extract($_POST, EXTR_OVERWRITE);

/*
 * TENGO QUE BUSCAR LOS PRODUCTOS CORRESPONDIENTES A LOS DISTINTOS PROVEEDORES
 * CON ESE DATO MOSTRAR LA INFORMACIÓN EN LA TABLA.
 *  */

$oProd_ = $oMysql->getProductos();
$oVoProd_ = $oProd_->buscarTodo();

$mPp = $oMysql->getProveedorProducto();

$myfile = fopen("data/datos.txt", "w") or die("Unable to open file!");
$txt = "{\n\t\"data\": [";
fwrite($myfile, $txt);

$i = 0;
$mPPP = $oMysql->getPreciosProveedor();

foreach ($oVoProd_ as $key => $prod) {
    $sql = "SELECT ganancia, precio "
            . "FROM `provprod_precio_vw` WHERE proveedor_id = " . $prov
            . " AND producto_id = " . $prod->getId() . ";";

    $resultado = mysqli_query($_SESSION['con'], $sql);
    $fila1 = mysqli_fetch_object($resultado);
    if ($fila1) {
        $ganancia = $fila1->ganancia;
        $precio = $fila1->precio;
    } else {
        $ganancia = 0;
        $precio = 0;
    }
    $color = '';
    if ($prod->getHabilitado() != 1) {
        if ($i == 0) {
            $txt = "\n\t{\n";
        } else {
            $txt = ",\n\t{\n";
        }

        $i++;
        fwrite($myfile, $txt);
        $txt = "\t\"DT_RowId\": \"" . $i . "\",\n";

        fwrite($myfile, $txt);
        $txt = "\t\"codigo\": \"" . $prod->getCod_barra() . "\",\n";
        fwrite($myfile, $txt);

        $txt = "\t\"descripcion\": \"" . (trim($prod->getDescripcion())) . "\",\n";
        fwrite($myfile, $txt);

        if ($fila1) {
            $txt = "\t\"costo\": \"<input type='number' class='form-control' id='precio" . $prod->getId() . "' value='" . $precio . "' name='precio" . $prod->getId() . "' placeholder='Precio del Producto' step='0.01' >\",\n";
            fwrite($myfile, $txt);
            $txt = "\t\"porcen\": \"<input type='number' class='form-control' value='" . $ganancia . "' id='porcent" . $prod->getId() . "' name='porcent" . $prod->getId() . "' placeholder='Porcentaje de ganancia' step='0.1' >\",\n";
            fwrite($myfile, $txt);
            $txt = "\t\"checkeado\": \"<input type='checkbox' checked id='che" . $prod->getId() . "' name='che" . $prod->getId() . "' />\"";
            fwrite($myfile, $txt);
        } else {
            $txt = "\t\"costo\": \"<input type='number' class='form-control' id='precio" . $prod->getId() . "' value='' name='precio" . $prod->getId() . "' placeholder='Precio del Producto' step='0.01' >\",\n";
            fwrite($myfile, $txt);
            $txt = "\t\"porcen\": \"<input type='number' class='form-control' value='' id='porcent" . $prod->getId() . "' name='porcent" . $prod->getId() . "' placeholder='Porcentaje de ganancia' step='0.1' >\",\n";
            fwrite($myfile, $txt);
            $txt = "\t\"checkeado\": \"<input type='checkbox' id='che" . $prod->getId() . "' name='che" . $prod->getId() . "' />\"";
            fwrite($myfile, $txt);
        }

        $txt = "\t}";
        fwrite($myfile, $txt);
        unset($oPPP);
    }
}
$txt = "\n\t]\n}";
fwrite($myfile, $txt);
fclose($myfile);

$resp['Fin'] = "Fin";
echo json_encode($resp);
