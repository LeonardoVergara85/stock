<?php

/**
 * Description of VoOfertas
 *
 * @author ssrolanr
 */
class VoOfertas {

    private $id, $producto_id, $porcentaje, $precio, $fin, $img;

    function getId() {
        return $this->id;
    }

    function getProducto_id() {
        return $this->producto_id;
    }

    function getPorcentaje() {
        return $this->porcentaje;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getFin() {
        return $this->fin;
    }

    function getImg() {
        return $this->img;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProducto_id($producto_id) {
        $this->producto_id = $producto_id;
    }

    function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }

    function setFin($fin) {
        $this->fin = $fin;
    }

    function setImg($img) {
        $this->img = $img;
    }

}
