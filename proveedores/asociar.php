<?php

session_name('stock');
session_start();
$error = 0;

extract($_POST, EXTR_OVERWRITE);

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$mPp = $oMysql->getProveedorProducto();
$mPPr = $oMysql->getPreciosProveedor();

$oPp = new VoProvProd();
$oPp->setProducto_id($noids);
$oPp->setProveedor_id($prov);
$mPp->borrar($oPp);
unset($oPp);

$ids_ = explode(', ', $ids);
$valor_ = explode(', ', $valor);
$porcentaje_ = explode(', ', $porcentaje);

foreach ($ids_ as $key => $value) {
    $oPp = new VoProvProd();
    $oPp->setProveedor_id($prov);
    $oPp->setProducto_id($value);

    if (!$mPp->existe($oPp)) {
        $oPp->setGanancia($porcentaje_[$key]);
        if (!$mPp->guardar($oPp)) {
            $error++;
        }
    } else {
        $oPp->setGanancia($porcentaje_[$key]);
        $mPp->actualizar($oPp);
    }

    /* Almaceno el precio de compra del producto */
    $oPPr = new VoPreciosProveedor();
    $oPPr->setFecha(date('Y-m-d'));
    $oPPr->setPorcentaje(0);
    $oPPr->setPrecio($valor_[$key]);
    $oPPr->setVigente(0);
    $oPPr->setIdPP($oPp->getId());

    $mPPr->guardar($oPPr);

    $oPPr->setIdPP($value);
    $oPPr = $mPPr->buscarPrecioMasAlto($oPPr);

    $precio_aux = $oPPr->getPrecio();

    unset($oPPr);
    unset($oPp);

    /* Buscar y comparar los precios de los productos con el precio "sugerido".
     * Almacenar el precio nuevo si es mayor al guardado. */

    $mPrecio = $oMysql->getPrecios();
    $oPrecio = new VoPrecios();

    $oPrecio->setProducto_id($value);
    $oPrecio = $mPrecio->buscar($oPrecio);
    $sugerido = ($valor_[$key] * (1 + ($porcentaje_[$key] / 100)));
    $sugerido = round($sugerido, 2);

    if (!$oPrecio) {
        $oPrecio->setProducto_id($value);
        $oPrecio->setPrecio($sugerido);
        $oPrecio->setPresupuesto(0);
        $mPrecio->guardar($oPrecio);
    } else {
        if ($precio_aux < $sugerido) {
            $oPrecio->setPrecio($preciop);
        } else {
            $oPrecio->setPrecio($precio_aux);
        }

        $oPrecio->setPrecio(round($precio_aux, 2));
        $oPrecio->setPresupuesto(0);
        $mPrecio->guardar($oPrecio);
    }

    unset($mPrecio);
    unset($oPrecio);
}

if ($error == 0) {
    $resp['c'] = "Exito";
} else {
    $resp['c'] = "Error";
}

echo json_encode($resp);
