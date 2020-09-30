<?php

/**
 * 
 */
class VoProveedores {

    private $id, $nombre, $domicilio, $telefono, $correo, $comentario, $fecha_baja, $cuit;

    function getId() {
        return $this->id;
    }

    function getCuit() {
        return $this->cuit;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDomicilio() {
        return $this->domicilio;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getComentario() {
        return $this->comentario;
    }

    function getFecha_baja() {
        return $this->fecha_baja;
    }

    //////////////////////////////

    function setId($id) {
        $this->id = $id;
    }

    function setCuit($cuit) {
        $this->cuit = $cuit;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCorreo($correo) {
        $this->correo = $correo;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    function setFecha_baja($fecha_baja) {
        $this->fecha_baja = $fecha_baja;
    }

}
