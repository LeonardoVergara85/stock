<?php

/**
 * Description of VoUsuarios
 *
 * @author Usuario
 */
class VoUsuarios {

    private $id, $nombre, $pass, $persona_id, $nivel_id, $baja, $persona, $niveles;

    function getId() {
        return $this->id;
    }

    function getPersona() {
        return $this->persona;
    }

    function getNiveles() {
        return $this->niveles;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getPass() {
        return $this->pass;
    }

    function getPersona_id() {
        return $this->persona_id;
    }

    function getNivel_id() {
        return $this->nivel_id;
    }

    function getBaja() {
        return $this->baja;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setPass($pass) {
        $this->pass = $pass;
    }

    function setPersona_id($persona_id) {
        $this->persona_id = $persona_id;
    }

    function setNivel_id($nivel_id) {
        $this->nivel_id = $nivel_id;
    }

    function setBaja($baja) {
        $this->baja = $baja;
    }
    function setPersona($persona) {
        $this->persona = $persona;
    }
    function setNiveles($niveles) {
        $this->niveles = $niveles;
    }

}
