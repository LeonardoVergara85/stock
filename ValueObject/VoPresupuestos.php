<?php

/**
 * Description of VoPresupuestos
 *
 * @author Usuario
 */
class VoPresupuestos {

    private $id, $fecha, $fecha_fin, $solicitante, $contacto, $detalle, $producto, $usuario_id, $usuario, $vigente;
//////// SETTERS ///////////////////////////////
    function getId() {
        return $this->id;
    }
    function getFecha() {
        return $this->fecha;
    }
    function getFecha_fin() {
        return $this->fecha_fin;
    }
    function getSolicitante() {
        return $this->solicitante;
    }
    function getContacto() {
        return $this->contacto;
    }
    function getUsuario_id() {
        return $this->usuario_id;
    }
    function getDetalle() {
        return $this->detalle;
    }
     function getProducto() {
            return $this->producto;
    }
    function getUsuario() {
            return $this->usuario;
    }
    function getVigente() {
            return $this->vigente;
    }


  /////// GETTERS ////////////////////////////
    function setId($id) {
        $this->id = $id;
    }
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    function setFecha_fin($fecha_fin) {
        $this->fecha_fin = $fecha_fin;
    }
    function setSolicitante($solicitante) {
        $this->solicitante = $solicitante;
    }
    function setContacto($contacto) {
        $this->contacto = $contacto;
    }
    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }
    function setDetalle($detalle) {
        $this->detalle = $detalle;
    }
    function setProducto($producto) {
        $this->producto = $producto;
    } 
    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    function setVigente($vigente) {
        $this->vigente = $vigente;
    } 

}
