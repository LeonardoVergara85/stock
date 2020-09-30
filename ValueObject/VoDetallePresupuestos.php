<?php

/**
 * Description of VoDetallePresupuestos
 *
 * @author Usuario
 */
class VoDetallePresupuestos {
   private $id, $presupuesto_id, $producto_id, $precio_id, $precio, $cantidad;
    //////// SETTERS ///////////////////////////////
    function getId() {
        return $this->id;
    }
    function getPresupuesto_id() {
        return $this->presupuesto_id;
    }
    function getProducto_id() {
        return $this->producto_id;
    }
    function getPrecio_id() {
        return $this->precio_id;
    }
    function getPrecio() {
        return $this->precio;
    }
    function getCantidad() {
        return $this->cantidad;
    }

  /////// GETTERS ////////////////////////////
    function setId($id) {
        $this->id = $id;
    }
    function setPresupuesto_id($presupuesto_id) {
        $this->presupuesto_id = $presupuesto_id;
    }
    function setProducto_id($producto_id) {
        $this->producto_id = $producto_id;
    }
    function setPrecio_id($precio_id) {
        $this->precio_id = $precio_id;
    }
    function setPrecio($precio) {
        $this->precio = $precio;
    }
    function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

}