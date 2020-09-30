<?php

session_name('stock');
session_start();

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$mProd = $oMysql->getProductos();
$mPre = $oMysql->getPrecios();
$oPre = new VoPrecios();

$oProd = new VoProductos();

$oProd->setDescripcion($nombre);
$oProd->setUmed_id($umedida);
$oProd->setCod_barra($codigo);

$oProd->setOrden($orden);

/*Familia de productos*/
$oProd->setCategoria_id($categoria);

$oProd->setPaquete(1);
if (isset($cantidad)) {
    $oProd->setPaquete($cantidad);
}

$oProd->setPunto_reposicion($reposicion);
$error = 0;

if ($mProd->guardar($oProd)) {

    $oMovimi = new VoMovimientos();

    $oMovimi->setProducto_id($oProd->getId());
    $oMovimi->setCantidad($inicial);
//    $oMovimi->setFecha(date('Y-m-d'));
    $oMovimi->setTipo_mov_id(1);
    $oMovimi->setRemito_id('NULL');
    $oMovimi->setfactura_id('NULL');
    $oMovimi->setUsuario_id(1);
    $mMovimi = $oMysql->getMovimientos();
    if (!$mMovimi->guardar($oMovimi)) {
        $error ++;
    }

    $oPre->setPrecio($precio);
    $oPre->setPresupuesto('FALSE');
    $oPre->setProducto_id($oProd->getId());
    if (!$mPre->guardar($oPre)) {
        $error += 10;
    }


    if ($error == 0) {
        $oProv = $oMysql->getProductos();
        $oVoProv = $oProv->buscarTodo();
        $myfile = fopen("data/datos.txt", "w") or die("Unable to open file!");
        $txt = "{\n\t\"data\": [";
        fwrite($myfile, $txt);

        $i = 0;
        $mPrecio = $oMysql->getPrecios();
        $oPre = new VoPrecios();

        foreach ($oVoProv as $key => $prod) {
            $oPre->setProducto_id($prod->getId());
            $oPre = $mPrecio->buscar($oPre);

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

                $txt = "\t\"unitario\": \"$" . $oPre->getPrecio() . "\",\n";
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
        $_SESSION['estado'] = TRUE;
        echo "Exito";
    } else {
        $_SESSION['estado'] = FALSE;
        echo "Error";
    }
} else {
    $_SESSION['estado'] = FALSE;
    echo "Error";
}