<?php

/**
 * Description of VoProvProd
 *
 * @author Usuario
 */
class VoProvProd {

    private $id, $proveedor_id, $producto_id, $ganancia, $baja;
    private $producto, $precio, $proveedor;

    function getProducto() {
        return $this->producto;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getProveedor() {
        return $this->proveedor;
    }

    function setProducto($producto) {
        $this->producto = $producto;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    function getId() {
        return $this->id;
    }

    function getProveedor_id() {
        return $this->proveedor_id;
    }

    function getProducto_id() {
        return $this->producto_id;
    }

    function getGanancia() {
        return $this->ganancia;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProveedor_id($proveedor_id) {
        $this->proveedor_id = $proveedor_id;
    }

    function setProducto_id($producto_id) {
        $this->producto_id = $producto_id;
    }

    function setGanancia($ganancia) {
        $this->ganancia = $ganancia;
    }

    function getBaja() {
        return $this->baja;
    }

    function setBaja($baja) {
        $this->baja = $baja;
    }

}
