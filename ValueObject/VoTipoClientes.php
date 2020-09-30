<?php
/**
 * Description of VoTipoClientes
 *
 * @author Usuario
 */
class VoTipoClientes {
	private $id, $nombre, $descripcion;

	 function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }
    /////////////////////////////

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}