<?php

/**
 * Description of VoFacturas
 *
 * @author Usuario
 */
class VoFacturas {

    private $id, $numero, $sucursal, $fecha, $numero_ticket, $usuario_id;

    function getId() {
        return $this->id;
    }

    function getNumero() {
        return $this->numero;
    }

    function getSucursal() {
        return $this->sucursal;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getNumero_ticket() {
        return $this->numero_ticket;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setSucursal($sucursal) {
        $this->sucursal = $sucursal;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setNumero_ticket($numero_ticket) {
        $this->numero_ticket = $numero_ticket;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

}
