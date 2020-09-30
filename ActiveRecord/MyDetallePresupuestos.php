<?php

include_once '../ValueObject/VoDetallePresupuestos.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyPrecios
 *
 * @author ssrolanr
 */
class MyDetallePresupuestos implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    public function borrar($oValueObject) {
        
    }

    /**
     * 
     * @param VoPresupuestos $oPresupuesto
     */
    public function buscar($oPresupuesto) {
    }

    public function buscarTodo() {
        
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @param VoDetallePresupuestos $oDetallePresupuesto
     */
    public function guardar($oDetallePresupuesto) {
        try {
             $sql = "INSERT INTO `detallepresupuestos` (`id`, `presupuestos_id`, `productos_id`, `precio_id`, `precio`, `cantidad`) VALUES (NULL, " . $oDetallePresupuesto->getPresupuesto_id() . ", " . $oDetallePresupuesto->getProducto_id() . ", " . $oDetallePresupuesto->getPrecio_id() . ", '" . $oDetallePresupuesto->getPrecio() . "', '" . $oDetallePresupuesto->getCantidad() . "')";
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

}