<?php

/**
 * Description of VoCategorias
 *
 * @author Usuario
 */
class VoCategorias {

    private $id, $nombre, $descripcion, $vigente, $orden, $imagen;

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getVigente() {
        return $this->vigente;
    }

    function getOrden() {
        return $this->orden;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setVigente($vigente) {
        $this->vigente = $vigente;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }

}
