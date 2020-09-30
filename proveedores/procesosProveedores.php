<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);


if (isset($_POST['tipo']) && $_POST['tipo'] == 'guardarProveedor') {
    $nombre = $_POST['nombrep'];
    $domicilio = $_POST['domiciliop'];
    $telefono = $_POST['telefonop'];
    $correo = $_POST['correop'];
    $comentario = $_POST['comentariop'];
    $cuit = $_POST['cuitp'];


    $oMysql->conectar();
    $oProv = $oMysql->getProveedores();
    $oVoProv = new VoProveedores();
    $oVoProv->setNombre($nombre);
    $oVoProv->setDomicilio($domicilio);
    $oVoProv->setTelefono($telefono);
    $oVoProv->setCorreo($correo);
    $oVoProv->setComentario($comentario);
    $oVoProv->setCuit($cuit);
    $oProv->guardar($oVoProv);

    echo json_decode(100);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'buscarProveedor') {
    $id = $_POST['idp'];
    $oMysql->conectar();
    $oProv = $oMysql->getProveedores();
    $oVoProv = new VoProveedores();
    $oVoProv->setId($id);
    $oVoProv = $oProv->buscarProveedor($oVoProv);
    $datos = array();
    foreach ($oVoProv as $valores) {
        $datos[0] = $valores->getNombre();
        $datos[1] = $valores->getTelefono();
        $datos[2] = $valores->getDomicilio();
        $datos[3] = $valores->getCorreo();
        $datos[4] = $valores->getComentario();
        $datos[5] = $valores->getCuit();
        $datos[6] = $valores->getFecha_baja();
    }
    echo json_encode($datos);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'eliminarProv') {
    $id = $_POST['idp'];
    $oMysql->conectar();
    $oProv = $oMysql->getProveedores();
    $oVoProv = new VoProveedores();
    $oVoProv->setId($id);
    $oVoProv = $oProv->eliminarProveedor($oVoProv);
    echo json_encode(110);
}


if (isset($_POST['tipo']) && $_POST['tipo'] == 'editarProveedor') {
    $id = $_POST['idp'];
    $nombre = $_POST['nombrep'];
    $cuit = $_POST['cuitp'];
    $telefono = $_POST['telp'];
    $domicilio = $_POST['domip'];
    $correo = $_POST['correop'];
    $comentario = $_POST['comp'];
    $oMysql->conectar();
    $oProv = $oMysql->getProveedores();
    $oVoProv = new VoProveedores();
//////////////////////////////////////////////////////////////
    $oVoProv->setId($id);
    $oVoProv->setNombre($nombre);
    $oVoProv->setCuit($cuit);
    $oVoProv->setTelefono($telefono);
    $oVoProv->setDomicilio($domicilio);
    $oVoProv->setCorreo($correo);
    $oVoProv->setComentario($comentario);
////////////////////////////////////////////////////////////////
    $oVoProv = $oProv->editarProveedor($oVoProv);
    echo json_encode(120);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'buscarProductosProv') {
    $idp = $_POST['idp'];
    $oMysql->conectar();
    $oProdProv = new VoProvProd();
    $mPp = $oMysql->getProveedorProducto();
    $oProdProv->setProveedor_id($idp);
    $prod = $mPp->buscar($oProdProv);

    $cont = 0;
    $datos = array();
    foreach ($prod as $valores) {
        $datos['id' . $cont] = $valores->getId();
        $datos['desc' . $cont] = $valores->getProducto()->getDescripcion();
        $datos['codbarra' . $cont] = $valores->getProducto()->getCod_barra();
        $datos['puntor' . $cont] = $valores->getProducto()->getPunto_reposicion();
        $datos['precio' . $cont] = $valores->getPrecio()->getPrecio();
        $datos['porc' . $cont] = $valores->getPrecio()->getPorcentaje();
        $datos['fechaprecio' . $cont] = $valores->getPrecio()->getFecha();
        $cont = $cont + 1;
    }
    $datos['cantidad'] = $cont;
    echo json_encode($datos);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'actualizarprecioprov') {
    $idprodprov = $_POST['idp'];
    $porcentaje = $_POST['porc'];
    $prods = $_POST['productos'];
    $oMysql->conectar();
    $oPrecioPP = $oMysql->getPreciosProveedor();
    $oVOProdProv = new VoPreciosProveedor();
    $oVOProdProv->setIdPP($idprodprov);
    $oVOProdProv->setPorcentaje($porcentaje);

    foreach ($prods as $value) {
        $aux = explode('/', $value);
        $idpp = $aux[0];
        $precio = $aux[1];
        $preciop = round((($precio * $porcentaje) / 100) + $precio, 2);

        $oVOProdProv->setIdPP($idpp);
        $oVOProdProv->setPrecio($preciop);

        $oPrecioPP->sacarVigencia($oVOProdProv); //busco y saco de vigencia el precio.
        $oPrecioPP->guardar($oVOProdProv); //busco y saco de vigencia el precio.
        /* Hasta acá guardo el precio actualizado */
        /// HASTA ACA FUNCIONA BIEN ///////////////////////////////////////////
        /* Ahora Guardamos el precio más alto con respecto a los proveedores. */
        $mPp_aux = $oMysql->getProveedorProducto();
        $oPp_aux = new VoProvProd();

        $oPp_aux->setId($idpp);
        $oPp_aux = $mPp_aux->buscarId($oPp_aux);
//        echo $preciop . "<br>";
        $preciop = round($preciop * (1 + ($oPp_aux->getGanancia() / 100)), 2);
//        echo $preciop . "<br>";

        $oVOProdProv->setIdPP($oPp_aux->getProducto_id());
        $oVOProdProv = $oPrecioPP->buscarPrecioMasAlto($oVOProdProv);

        $oPPr = new VoPreciosProveedor();
        $precio_aux = $oPPr->getPrecio();

        $mPrecio = $oMysql->getPrecios();
        $oPrecio = new VoPrecios();

        $oPrecio->setProducto_id($oPp_aux->getProducto_id());
        $oPrecio = $mPrecio->buscar($oPrecio);

        if (!$oPrecio) {
            $oPrecio->setProducto_id($oPp_aux->getProducto_id());
            $oPrecio->setPrecio($preciop);
            $oPrecio->setPresupuesto(0);
            $mPrecio->guardar($oPrecio);
        } else {
            if ($oVOProdProv->getPrecio() < $preciop) {
                $oPrecio->setPrecio($preciop);
            } else {
                $oPrecio->setPrecio($oVOProdProv->getPrecio());
            }
            $oPrecio->setProducto_id($oPp_aux->getProducto_id());
            $oPrecio->setPresupuesto(0);
            $mPrecio->guardar($oPrecio);
        }

        unset($mPrecio);
        unset($oPrecio);
    }


    echo json_encode($prods);
//    echo json_encode(100);
}