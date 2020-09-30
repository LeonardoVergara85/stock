<?php

/**
 * Description of VoPreciosProveedor
 *
 * @author ssrolanr
 */
class VoPreciosProveedor {

    private $id, $idPP, $precio, $fecha, $porcentaje, $vigente;

    function getId() {
        return $this->id;
    }
    function getIdPP() {
        return $this->idPP;
    }
    function getPrecio() {
        return $this->precio;
    }
    function getFecha() {
        return $this->fecha;
    }
    function getPorcentaje() {
        return $this->porcentaje;
    }
    function getVigente() {
        return $this->vigente;
    }

  

    function setId($id) {
        $this->id = $id;
    }
    function setIdPP($idPP) {
        $this->idPP = $idPP;
    }
    function setPrecio($precio) {
        $this->precio = $precio;
    }
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    function setPorcentaje($porcentaje) {
        $this->porcentaje = $porcentaje;
    }
    function setVigente($vigente) {
        $this->vigente = $vigente;
    }

  

}
