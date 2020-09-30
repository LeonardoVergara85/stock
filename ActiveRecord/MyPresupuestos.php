<?php

include_once '../ValueObject/VoPresupuestos.php';
include_once '../ValueObject/VoDetallePresupuestos.php';
include_once '../ValueObject/VoProductos.php';
include_once '../ValueObject/VoUsuarios.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyPrecios
 *
 * @author ssrolanr
 */
class MyPresupuestos implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    /**
     * 
     * @param VoPresupuestos $oPresupuesto
     */
    public function borrar($oPresupuesto) {
        try {
            $sql = "UPDATE `presupuestos` SET `fechafin`= NOW() WHERE id = ".$oPresupuesto->getId()." ";
              $resultado = mysqli_query($_SESSION['con'], $sql);
              if($resultado){
                   return TRUE;
              }else{
                return FALSE;
              }
            }
            catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }   
    }

    /**
     * 
     * @param VoPresupuestos $oPresupuesto
     */
    public function concretar($oPresupuesto) {
        try {
            $sql = "UPDATE `presupuestos` SET `vigente`= 'no' WHERE id = ".$oPresupuesto->getId()." ";
              $resultado = mysqli_query($_SESSION['con'], $sql);
              if($resultado){
                   return TRUE;
              }else{
                return FALSE;
              }
            }
            catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }   
    }

    /**
     * 
     * @param VoPresupuestos $oPresupuesto
     */
    public function buscar($oPresupuesto) {
      try {
          $sql = "SELECT  dp.id, dp.presupuestos_id, dp.productos_id, dp.precio_id, dp.precio, dp.cantidad, DATE_FORMAT(p.fecha, '%d/%m/%Y') AS fechap, p.fechafin, p.usuario_id, p.solicitante, p.contacto,p.vigente,pd.descripcion,pd.cod_barra,u.nombre
            FROM detallepresupuestos dp
            JOIN presupuestos p ON dp.presupuestos_id = p.id
            JOIN productos pd ON dp.productos_id = pd.id
            JOIN usuarios u ON p.usuario_id = u.id
            WHERE p.id = ".$oPresupuesto->getId()." ";
           $resultado = mysqli_query($_SESSION['con'], $sql);
            if ($resultado) {
            $aPresupuesto = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oPresu = new VoPresupuestos();
                $oDetail = new VoDetallePresupuestos();
                $oProd = new VoProductos();
                $oUsu = new VoUsuarios();
                $oDetail->setId($fila->id);
                $oDetail->setPresupuesto_id($fila->presupuestos_id);
                $oDetail->setProducto_id($fila->productos_id);
                $oDetail->setPrecio_id($fila->precio_id);
                $oDetail->setPrecio($fila->precio);
                $oDetail->setCantidad($fila->cantidad);
                $oPresu->setVigente($fila->vigente);
                $oPresu->setId($fila->presupuestos_id);
                $oPresu->setFecha($fila->fechap);
                $oPresu->setFecha_fin($fila->fechafin);
                $oPresu->setSolicitante($fila->solicitante);
                $oPresu->setContacto($fila->contacto);
                $oPresu->setUsuario_id($fila->usuario_id);
                $oProd->setDescripcion($fila->descripcion);
                $oProd->setCod_barra($fila->cod_barra);
                $oUsu->setNombre($fila->nombre);
                $oPresu->setDetalle($oDetail);
                $oPresu->setProducto($oProd);
                $oPresu->setUsuario($oUsu);
                $aPresupuesto[] = $oPresu;
                unset($oPresu);
                unset($oDetail);
                unset($oProd);
                unset($oUsu);
            }
            return $aPresupuesto;
          } else {
            return FALSE;
          }      
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

    public function buscarTodo() {
        try {
          $sql = "SELECT id, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha, DATE_FORMAT(fechafin, '%d/%m/%Y') AS fechafin, solicitante, contacto,vigente FROM presupuestos WHERE fechafin is null order by id desc";
           $resultado = mysqli_query($_SESSION['con'], $sql);
            if ($resultado) {
            $aPresupuesto = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oPresu = new VoPresupuestos();
                $oPresu->setId($fila->id);
                $oPresu->setFecha($fila->fecha);
                $oPresu->setFecha_fin($fila->fechafin);
                $oPresu->setSolicitante($fila->solicitante);
                $oPresu->setContacto($fila->contacto);
                $oPresu->setVigente($fila->vigente);
                $aPresupuesto[] = $oPresu;
                unset($oPresu);
            }
            return $aPresupuesto;
          } else {
            return FALSE;
          }      
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @param VoPresupuestos $oPresupuesto
     */
    public function guardar($oPresupuesto) {
        try {
            $sql = "INSERT INTO `presupuestos` (`id`, `fecha`, `fechafin`, `solicitante`, `contacto`,`usuario_id`,`vigente`) VALUES (NULL, NOW(), NULL, '" . $oPresupuesto->getSolicitante() . "', '" . $oPresupuesto->getContacto() . "',". $oPresupuesto->getUsuario_id() .",'si');";
              $resultado = mysqli_query($_SESSION['con'], $sql);
              if($resultado){
                $sql2 = "select MAX(id) AS id FROM presupuestos";
                  $resuid = mysqli_query($_SESSION['con'], $sql2);
                  if ($resuid) {
                    $row = mysqli_fetch_assoc($resuid);
                    $idp = $row['id'];
                   }
                return $idp;
              }else{
                return FALSE;
              }
            }
            catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
    }

}
