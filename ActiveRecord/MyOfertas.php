<?php

include_once '../ValueObject/VoOfertas.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyOfertasç
 *
 * @author ssrolanr
 */
class MyOfertas implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    public function borrar($oValueObject) {
        
    }

    public function buscar($oValueObject) {
        
    }

    /**
     * Devuelve todas las ofertas con fecha mayor al dia actual.
     * @return boolean|\VoProductos
     */
    public function buscarTodo() {
        $sql = "SELECT o.id, producto_id, porcentaje, precio, fin, descripcion, img "
                . "FROM ofertas o "
                . "JOIN productos p ON p.id = o.producto_id "
                . "WHERE fin >= DATE_FORMAT(NOW(), '%Y-%m-%d') "
                . "ORDER BY orden, descripcion;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $aProducts = array();
            do {
                $oOferta = new VoOfertas();
                $oOferta->setId($fila->id);
                $oOferta->setFin($fila->fin);
                $oOferta->setPorcentaje($fila->porcentaje);
                $oOferta->setPrecio($fila->precio);
                $oOferta->setProducto_id($fila->descripcion);
                $oOferta->setImg($fila->img);
                $aOfertas[] = $oOferta;
                unset($oOferta);
            } while ($fila = mysqli_fetch_object($resultado));
            return $aOfertas;
        } else {
            return FALSE;
        }
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @param VoOfertas $oObject
     * @return boolean
     */
    public function guardar($oObject) {
        $con = $_SESSION['con'];
        $sentencia = $con->prepare("INSERT INTO ofertas (id, producto_id, "
                . "porcentaje, precio, fin, img) VALUES (NULL, ?, ?, ?, ?, ?);");
        $sentencia->bind_param("iidss", $oObject->getProducto_id(), $oObject->getPorcentaje(), $oObject->getPrecio(), $oObject->getFin(), $oObject->getImg());
        $resultado = $sentencia->execute();
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
