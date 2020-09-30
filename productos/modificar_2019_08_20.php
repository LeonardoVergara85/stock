<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();

$oProd = new VoProductos();

$oProd->setDescripcion($nombre_modal);
$oProd->setUmed_id($umedida_modal);
$oProd->setCod_barra($codigo_modal);

/*Familia de productos*/
$oProd->setCategoria_id($categoria_modal);

$oProd->setId($id_modal);

$oProd->setPaquete(1);
if (isset($cantidad_modal)) {
    $oProd->setPaquete($cantidad_modal);
}

$oProd->setPunto_reposicion($reposicion_modal);

$mPre = $oMysql->getPrecios();
$oPre = new VoPrecios();
$error = 0;

$oPre->setPrecio($precio_modal);
$oPre->setPresupuesto('FALSE');
$oPre->setProducto_id($oProd->getId());
if (!$mPre->guardar($oPre)) {
    $error += 10;
}

if (!$mProd->actualizar($oProd)) {
    $error ++;
}

if ($error == 0) {

    $oProv = $oMysql->getProductos();
    $oVoProv = $oProv->buscarTodo();
    $myfile = fopen("data/datos.txt", "w") or die("Unable to open file!");
    $txt = "{\n\t\"data\": [";
    fwrite($myfile, $txt);

    $i = 0;
    $mPrecio = $oMysql->getPrecios();
    $oPre1 = new VoPrecios();

    foreach ($oVoProv as $key => $prod) {
        $oPre1->setProducto_id($prod->getId());
        $oPre1 = $mPrecio->buscar($oPre1);

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

            $txt = "\t\"descripcion\": \"" . utf8_encode(trim($prod->getDescripcion())) . "\",\n";
            fwrite($myfile, $txt);

            $medida = "";
            switch ($prod->getUmed_id()) {
                case 1:
                    $medida = " Centimetros";
                    break;
                case 2:
                    $medida = " Metros";
                    break;
                case 3:
                    $medida = " Toneladas";
                    break;
                case 4:
                    $medida = " Unidades";
                    break;
                default:
                    break;
            }
            $txt = "\t\"paquete\": \"" . $prod->getPaquete() . $medida . "\",\n";
            fwrite($myfile, $txt);

            $txt = "\t\"repo\": \"" . $prod->getPunto_reposicion() . $medida . "\",\n";
            fwrite($myfile, $txt);

            $txt = "\t\"unitario\": \"$" . $oPre1->getPrecio() . "\",\n";
            fwrite($myfile, $txt);

            $habil = ($prod->getHabilitado() != 1) ? '' : 'disabled';
            $txt = "\t\"boton\": \"<button class='btn btn-warning btn-sm' onclick='modificar(" . $prod->getId() . ")' title='modificar'><i class='fa fa-pencil-square-o'></i></button> ";
            $txt .= "<button class='btn btn-success btn-sm' onclick='codigoBarra(" . $prod->getCod_barra() . ")' title='Imprimir Código'><i class='fa fa-barcode' aria-hidden='true'></i></button> ";
            $txt .= "<button class='btn btn-danger btn-sm' " . $habil . "onclick='eliminar( " . $prod->getId() . ", \\\"" . utf8_encode(trim($prod->getDescripcion())) . "\\\")'" . " title='eliminar'><i class='fa fa-minus-circle'></i></button>\"";
            fwrite($myfile, $txt);

            $txt = "\t}";
            fwrite($myfile, $txt);
        }
    }
    $txt = "\n\t]\n}";
    fwrite($myfile, $txt);
    fclose($myfile);

    echo "Exito";
} else {
    echo $error;
}