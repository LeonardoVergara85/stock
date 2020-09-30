<?php

/**
 * Description of VoPrecios
 *
 * @author ssrolanr
 */
class VoPrecios {

    private $id, $fecha, $producto_id, $precio, $presupuesto;

    function getId() {
        return $this->id;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getProducto_id() {
        return $this->producto_id;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getPresupuesto() {
        return $this->presupuesto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setProducto_id($producto_id) {
        $this->producto_id = $producto_id;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setPresupuesto($presupuesto) {
        $this->presupuesto = $presupuesto;
    }

}
