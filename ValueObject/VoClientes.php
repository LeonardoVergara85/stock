<?php
/**
 * Description of VoClientes
 *
 * @author Usuario
 */
class VoClientes {
	private $id, $persona_id, $localidad_id, $provincia_id, $tipoCliente_id, $cuilcuit, $empresa, $fecha_alta, $vigente;
    //////////////////////////////////////////
	 function getId() {
        return $this->id;
    }

    function getPersona_id() {
        return $this->persona_id;
    }

    function getLocalidad_id() {
        return $this->localidad_id;
    }
    function getProvinca_id() {
        return $this->provincia_id;
    }

    function getTipoCliente_id() {
        return $this->tipoCliente_id;
    }

    function getCuilCuit() {
        return $this->cuilcuit;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getFecha_alta() {
        return $this->fecha_alta;
    }

    function getVigente() {
        return $this->vigente;
    }
    ///////////////////////////////////////////////

    function setId($id) {
        $this->id = $id;
    }
    function setPersona_id($persona_id) {
        $this->persona_id = $persona_id;
    }
    function setLocalidad_id($localidad_id) {
        $this->localidad_id = $localidad_id;
    }
    function setProvincia_id($provincia_id) {
        $this->provincia_id = $provincia_id;
    }
    function setTipoCliente_id($tipoCliente_id) {
        $this->tipoCliente_id = $tipoCliente_id;
    }
    function setCuilCuit($cuilcuit) {
        $this->cuilcuit = $cuilcuit;
    }
    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }
    function setFecha_alta($fecha_alta) {
        $this->fecha_alta = $fecha_alta;
    }
    function setVigente($vigente) {
        $this->vigente = $vigente;
    }

}