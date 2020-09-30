<?php

include_once '../ValueObject/VoProductos.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyProductos
 *
 * @author ssrolanr
 */
class MyProductos implements ActiveRecord {

    /**
     * 
     * @param VoProductos $oProd
     */
    public function actualizar($oProd) {
        $sql = "UPDATE productos SET cod_barra = '" . $oProd->getCod_barra() . "', "
                . "descripcion = '" . $oProd->getDescripcion() . "', "
                . "umed_id = " . $oProd->getUmed_id() . ", "
                . "paquete = " . $oProd->getPaquete() . ", "
                . "habilitado = 0 , "
                . "punto_reposicion = " . $oProd->getPunto_reposicion() . ", "
                . "orden = " . $oProd->getOrden() . ", "
                . "categoria_id = " . $oProd->getCategoria_id()
                . " WHERE id = " . $oProd->getId();

        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProductos $oProd
     */
    public function deshabilitar($oProd) {
        $sql = "UPDATE productos SET habilitado = 1 WHERE id = " . $oProd->getId();

        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function borrar($oValueObject) {
        
    }

    /**
     * 
     * @param VoProductos $oValueObject
     * @return boolean|\VoProductos
     */
    public function buscarBarra($oValueObject) {
        $sql = "SELECT * FROM productos WHERE habilitado = 0 AND "
                . "cod_barra = '" . $oValueObject->getCod_barra() . "';";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $oProduct = new VoProductos();
            $oProduct->setId($fila->id);
            $oProduct->setCod_barra($fila->cod_barra);
            $oProduct->setDescripcion($fila->descripcion);
            $oProduct->setPaquete($fila->paquete);
            $oProduct->setPunto_reposicion($fila->punto_reposicion);
            $oProduct->setUmed_id($fila->umed_id);
            $oProduct->setCategoria_id($fila->categoria_id);
            return $oProduct;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProductos $oValueObject
     * @return boolean|\VoProductos
     */
    public function buscarNombre($oValueObject) {
        $sql = "SELECT * FROM productos WHERE descripcion = '" . $oValueObject->getDescripcion() . "'"
                . " ORDER by orden;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $oProduct = new VoProductos();
            $oProduct->setId($fila->id);
            $oProduct->setCod_barra($fila->cod_barra);
            $oProduct->setDescripcion($fila->descripcion);
            $oProduct->setPaquete($fila->paquete);
            $oProduct->setPunto_reposicion($fila->punto_reposicion);
            $oProduct->setUmed_id($fila->umed_id);
            $oProduct->setOrden($fila->orden);
            $oProduct->setCategoria_id($fila->categoria_id);
            return $oProduct;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProductos $oValueObject
     * @return boolean|\VoProductos
     */
    public function buscar($oValueObject) {
        $sql = 'SELECT * FROM productos WHERE id = ' . $oValueObject->getId()
                . " ORDER by orden;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $oProduct = new VoProductos();
            $oProduct->setId($fila->id);
            $oProduct->setCod_barra($fila->cod_barra);
            $oProduct->setDescripcion($fila->descripcion);
            $oProduct->setPaquete($fila->paquete);
            $oProduct->setPunto_reposicion($fila->punto_reposicion);
            $oProduct->setUmed_id($fila->umed_id);
            $oProduct->setCategoria_id($fila->categoria_id);
            return $oProduct;
        } else {
            return FALSE;
        }
    }

    public function buscarTodo() {
        $sql = "SELECT p.id, p.cod_barra, p.descripcion, p.umed_id, p.paquete,p.punto_reposicion, p.habilitado, p.categoria_id, p.orden FROM productos p ORDER BY orden ;";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $aProducts = array();
            do {
                $oProduct = new VoProductos();
                $oProduct->setId($fila->id);
                $oProduct->setCod_barra($fila->cod_barra);
                $oProduct->setDescripcion($fila->descripcion);
                $oProduct->setPaquete($fila->paquete);
                $oProduct->setPunto_reposicion($fila->punto_reposicion);
                $oProduct->setUmed_id($fila->umed_id);
                $oProduct->setHabilitado($fila->habilitado);
                $oProduct->setCategoria_id($fila->categoria_id);
                $oProduct->setOrden($fila->orden);
                $aProducts[] = $oProduct;
                unset($oProduct);
                unset($oPre);
            } while ($fila = mysqli_fetch_object($resultado));
            return $aProducts;
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
     * @param VoProductos $producto
     */
    public function guardar($producto) {
        $sql = "INSERT INTO productos (cod_barra, descripcion, umed_id, paquete, "
                . "punto_reposicion, orden, categoria_id) "
                . "VALUES('" . $producto->getCod_barra() . "', "
                . "'" . $producto->getDescripcion() . "', "
                . $producto->getUmed_id() . ", ";
        $sql .= ($producto->getPaquete()) ? $producto->getPaquete() : 'NULL';
        $sql .= ($producto->getPunto_reposicion() != 0) ? ", " . $producto->getPunto_reposicion() : ', NULL';
        $sql .= ($producto->getOrden() != 0) ? ", " . $producto->getOrden() : ', 0';
        $sql .= ($producto->getCategoria_id() != 0) ? ", " . $producto->getCategoria_id() . ")" : ', NULL)';

        if (mysqli_query($_SESSION['con'], $sql)) {
            $result = mysqli_query($_SESSION['con'], "SELECT DISTINCT LAST_INSERT_ID() FROM productos");
            $id = mysqli_fetch_array($result);
            if ($id[0] <> 0) {
                $producto->setId($id[0]);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
