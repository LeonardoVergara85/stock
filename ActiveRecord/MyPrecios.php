<?php

include_once '../ValueObject/VoPrecios.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyPrecios
 *
 * @author ssrolanr
 */
class MyPrecios implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    public function borrar($oValueObject) {
        
    }

    /**
     * 
     * @param VoPrecios $oPrecio
     */
    public function buscar($oPrecio) {
        $sentence = "SELECT * FROM `precios` WHERE producto_id = "
                . $oPrecio->getProducto_id() . " ORDER BY fecha DESC LIMIT 1;";

        $result = mysqli_query($_SESSION['con'], $sentence);
        $file = mysqli_fetch_object($result);
        if ($file) {
            $oPrecio->setId($file->id);
            $oPrecio->setFecha($file->fecha);
            $oPrecio->setPrecio($file->precio);
            $oPrecio->setPresupuesto($file->presupuesto);
            $oPrecio->setProducto_id($file->producto_id);
        } else {
            $oPrecio->setPrecio('0');
        }
        return $oPrecio;
    }

    public function buscarTodo() {
        
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @param VoPrecios $oPrecio
     */
    public function guardar($oPrecio) {
        $sentence = "INSERT INTO precios (fecha, producto_id, precio, presupuesto) "
                . "VALUES(NOW(), " . $oPrecio->getProducto_id() . ", '"
                . $oPrecio->getPrecio() . "', " . $oPrecio->getPresupuesto() . ")";

        if (mysqli_query($_SESSION['con'], $sentence)) {
            $result = mysqli_query($_SESSION['con'], "SELECT DISTINCT LAST_INSERT_ID() FROM precios;");
            $id = mysqli_fetch_array($result);
            if ($id[0] <> 0) {
                $oPrecio->setId($id[0]);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return false;
        }
    }

}
