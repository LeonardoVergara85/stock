<?php

/**
 * Description of VoUsuarios
 *
 * @author Usuario
 */
class VoRemitos {
    private $id, $proveedor_id,$numero,$fecha,$usuario_id,$fecha_baja,$proveedor,$usuario;

     function getId() {
        return $this->id;
    }

    function getProveedor_id() {
        return $this->proveedor_id;
    }
    function getNumero() {
        return $this->numero;
    }
    function getFecha() {
        return $this->fecha;
    }
    function getUsuario_id() {
        return $this->usuario_id;
    }
    function getFecha_baja() {
        return $this->fecha_baja;
    }
    function getProveedor() {
        return $this->proveedor;
    }
    function getUsuario() {
        return $this->usuario;
    }
    /////////////////////////////

    function setId($id) {
        $this->id = $id;
    }

    function setProveedor_id($proveedor_id) {
        $this->proveedor_id = $proveedor_id;
    }
    function setNumero($numero) {
        $this->numero = $numero;
    }
    function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }
    function setFecha_baja($fecha_baja) {
        $this->fecha_baja = $fecha_baja;
    }
     function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }
    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
}