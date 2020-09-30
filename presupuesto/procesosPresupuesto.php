<?php
session_name('stock');
session_start();

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);

if (isset($_POST['tipo']) && $_POST['tipo'] == 'busp') {
    $oMysql->conectar();
    $idProd = $_POST['idp'];
    $oPre = $oMysql->getPrecios();
    $oVoPre = new VoPrecios();
    $oVoPre->setProducto_id($idProd);
    $precio = $oPre->buscar($oVoPre);
    $preciou = array();
    
      $preciou[0] = $precio->getPrecio();
    
    echo json_encode($preciou);
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'nuevopresupuesto') {
    $oMysql->conectar();
    $oPresu = $oMysql->getPresupuestos();
    $oDetallePresu = $oMysql->getDetallePresupuestos();
    $oVoPresu = new VoPresupuestos(); 
    $oVoDetallePresu = new VoDetallePresupuestos(); 
    $soli = $_POST['solicitante'];
    $contact = $_POST['contacto'];
    $cant = $_POST['cantidad'];
    $usuario = $_POST['usu'];
    ///////////////////////////////////////
    $data = json_decode($_POST['array']);
    /////////////////////////////////////// 
    $oVoPresu->setSolicitante($soli);
    $oVoPresu->setContacto($contact);
    $oVoPresu->setUsuario_id($usuario);
    $idPre = $oPresu->guardar($oVoPresu); 

    //cargamos detalle
    for ($i = 1; $i < $cant; $i++) {
        /*$oVoMov->setProducto_id($data[$i][0]);
        $oVoMov->setCantidad($data[$i][3]);
        $oVoMov->setTipo_mov_id(2);
        $oVoMov->setRemito_id($idR);
        $oVoMov->setFactura_id(0);
        $oVoMov->setUsuario_id($_SESSION["id"]);
        $oMov->guardar($oVoMov);*/
        $oVoDetallePresu->setPresupuesto_id($idPre);
	    $oVoDetallePresu->setProducto_id($data[$i][0]);
	    $oVoDetallePresu->setPrecio_id(1);
	    $oVoDetallePresu->setPrecio($data[$i][4]);
	    $oVoDetallePresu->setCantidad($data[$i][3]);
	    $oDetallePresu->guardar($oVoDetallePresu);
    }
    
    echo $idPre;
}

if (isset($_POST['tipo']) && $_POST['tipo'] == 'buscarDetalle') {
    $oMysql->conectar();
    $oPresu = $oMysql->getPresupuestos();
    $oDetallePresu = $oMysql->getDetallePresupuestos();
    $oVoPresu = new VoPresupuestos();
    $oVoDetallePresu = new VoDetallePresupuestos();
    $oVoPresu->setId($_POST['id']);
    $detalle = $oPresu->buscar($oVoPresu);
    $arreglo = array();
    $cont = 0;
    foreach ($detalle as $detail) {
      $arreglo['id'] = $detail->getDetalle()->getPresupuesto_id();
      $arreglo['solicitante'] = $detail->getSolicitante();
      $arreglo['contacto'] = $detail->getContacto();
      $arreglo['fecha'] = $detail->getFecha();
      $arreglo['usuario'] = $detail->getUsuario_id();
      $arreglo['usuarioname'] = $detail->getUsuario()->getNombre();
      $arreglo['vig'] = $detail->getVigente();
      $arreglo['producto'][$cont] = $detail->getDetalle()->getProducto_id();
      $arreglo['precio_id'][$cont] = $detail->getDetalle()->getPrecio_id();
      $arreglo['precio'][$cont] = $detail->getDetalle()->getPrecio();
      $arreglo['cantidad'][$cont] = $detail->getDetalle()->getCantidad();
      $arreglo['idd'][$cont] = $detail->getDetalle()->getId();
      $arreglo['productoname'][$cont] = $detail->getProducto()->getDescripcion();
      $arreglo['productocod'][$cont] = $detail->getProducto()->getCod_barra();
      $arreglo['rows'] = $cont;
      $cont++;
    }
     echo json_encode($arreglo);
}
if (isset($_POST['tipo']) && $_POST['tipo'] == 'eliminar') {
    $oMysql->conectar();
    $oPresu = $oMysql->getPresupuestos();
    $oVoPresu = new VoPresupuestos();
    $oVoPresu->setId($_POST['id']);
    $detalle = $oPresu->borrar($oVoPresu);
    echo 100;
}
// pasamos a egreso el presupuesto ;)
// 
if (isset($_POST['tipo']) && $_POST['tipo'] == 'pasaraegreso') {
    $usu = $_POST['usuario'];
    $cant = $_POST['cantidad'];
    $idp = $_POST['idpresupuesto'];

	$oMysql->conectar();
	$mFactura = $oMysql->getFacturas();
    $oFactura = new VoFacturas();
    $oFactura->setFecha(date('Y-m-d'));
    $oFactura->setNumero($mFactura->ultima());
    $oFactura->setNumero_ticket(0);
    $oFactura->setSucursal(1);
    $oFactura->setUsuario_id($usu);

    $res = $mFactura->guardar($oFactura);
    unset($mFactura);

    $mProd = $oMysql->getProductos();
    $oProd = new VoProductos();
    $data = json_decode($_POST['array']);
    if ($res) {  
         for ($i = 0; $i < $cant; $i++) {
         $oProd->setCod_barra($data[$i][2]);   
         $oProd = $mProd->buscarBarra($oProd);
         $oMovimi = new VoMovimientos();

         $oMovimi->setProducto_id($data[$i][6]);
         $oMovimi->setCantidad($data[$i][4]);
          //    $oMovimi->setFecha(date('Y-m-d'));
         $oMovimi->setTipo_mov_id(3);
         $oMovimi->setRemito_id('NULL');
         $oMovimi->setfactura_id($oFactura->getId());
         $oMovimi->setUsuario_id(1);
         $mMovimi = $oMysql->getMovimientos();
         $error = $mMovimi->guardar($oMovimi);

    }   


} else {
    mysqli_query($_SESSION['con'], "ROLLBACK;");
    echo "Error";
}
 $oPresu = $oMysql->getPresupuestos();
 $oVoPresu = new VoPresupuestos();
 $oVoPresu->setId($idp);
 $detalle = $oPresu->concretar($oVoPresu);
 echo 210;
}


?>