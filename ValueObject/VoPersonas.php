<?php

/**
 * Description of VoUsuarios
 *
 * @author Usuario
 */
class VoPersonas {

    private $id, $nombre, $apellido,$dni,$email,$telefono,$direccion,$fechaNac,$usuario_id;

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getDni() {
        return $this->dni;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getFechaNac() {
        return $this->fechaNac;
    }

    function getUsuario_id() {
        return $this->usuario_id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }
    function setDni($dni) {
        $this->dni = $dni;
    }
    function setEmail($email) {
        $this->email = $email;
    }
    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    function setFechaNac($fechaNac) {
        $this->fechaNac = $fechaNac;
    }

    function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

}
