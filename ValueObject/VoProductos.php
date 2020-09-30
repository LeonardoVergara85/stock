<?php

/**
 * Description of VoProductos
 *
 * @author ssrolanr
 */
class VoProductos {

    private $id, $cod_barra, $descripcion, $umed_id, $paquete,
            $punto_reposicion, $habilitado, $categoria_id, $orden;

    function getId() {
        return $this->id;
    }

    function getCod_barra() {
        return $this->cod_barra;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getUmed_id() {
        return $this->umed_id;
    }

    function getPaquete() {
        return $this->paquete;
    }

    function getPunto_reposicion() {
        return $this->punto_reposicion;
    }

    function getHabilitado() {
        return $this->habilitado;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCod_barra($cod_barra) {
        $this->cod_barra = $cod_barra;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setUmed_id($umed_id) {
        $this->umed_id = $umed_id;
    }

    function setPaquete($paquete) {
        $this->paquete = $paquete;
    }

    function setPunto_reposicion($punto_reposicion) {
        $this->punto_reposicion = $punto_reposicion;
    }

    function setHabilitado($habilitado) {
        $this->habilitado = $habilitado;
    }

    function getCategoria_id() {
        return $this->categoria_id;
    }

    function setCategoria_id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    function getOrden() {
        return $this->orden;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

}
