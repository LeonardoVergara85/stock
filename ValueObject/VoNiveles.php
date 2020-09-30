<?php

/**
 * Description of VoUsuarios
 *
 * @author Usuario
 */
class VoNiveles {
	private $id, $descripcion;

	 function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }
    /////////////////////////////

    function setId($id) {
        $this->id = $id;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}