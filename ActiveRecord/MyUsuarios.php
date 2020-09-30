<?php

include_once '../ValueObject/VoUsuarios.php';
include_once '../ValueObject/VoPersonas.php';
include_once '../ValueObject/VoNiveles.php';

/**
 * Description of MyUsuarios
 *
 * @author Usuario
 */
class MyUsuarios {

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function buscar() {
        $sql = "SELECT * FROM usuarios";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aUsuario = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oUsuario = new VoUsuarios();
                $oUsuario->setId($fila->id);
                $oUsuario->setPass($fila->pass);
                $oUsuario->setNombre($fila->nombre);
                $oUsuario->setPersona_id($fila->persona_id);
                $oUsuario->setNivel_id($fila->nivel_id);
                $oUsuario->setBaja($fila->baja);
                $aUsuario[] = $oUsuario;
                unset($oUsuario);
            }
            return $aUsuario;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function buscarUsuario($oUsuario) {
        $sql = "SELECT u.id, u.nombre, u.pass, u.persona_id, u.nivel_id, u.baja,"
                . " p.nombre, p.apellido, p.dni,p.email, p.telefono, p.direccion, "
                . "DATE_FORMAT(p.fecha_nac, '%d/%m/%Y') AS fecha_nac, n.descripcion "
                . "from usuarios u, personas p, niveles n "
                . "where u.persona_id = p.id AND u.nivel_id = n.id AND "
                . "u.id = '" . $oUsuario->getId() . "';";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aUsuario = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oUsuario = new VoUsuarios();
                $oPersona = new VoPersonas();
                $oNivel = new VoNiveles();
                $oUsuario->setId($fila->id);
                $oUsuario->setPass($fila->pass);
                $oUsuario->setNombre($fila->nombre);
                $oUsuario->setPersona_id($fila->persona_id);
                $oUsuario->setNivel_id($fila->nivel_id);
                $oUsuario->setBaja($fila->baja);
                //////////////////////////////////
                $oPersona->setId($fila->persona_id);
                $oPersona->setNombre($fila->nombre);
                $oPersona->setApellido($fila->apellido);
                $oPersona->setDni($fila->dni);
                $oPersona->setEmail($fila->email);
                $oPersona->setTelefono($fila->telefono);
                $oPersona->setDireccion($fila->direccion);
                $oPersona->setFechaNac($fila->fecha_nac);
                //////////////////////////////////
                $oNivel->setDescripcion($fila->descripcion);
                /////////////////////////////////
                $oUsuario->setPersona($oPersona);
                $oUsuario->setNiveles($oNivel);
                $aUsuario[] = $oUsuario;
                unset($oUsuario);
            }
            return $aUsuario;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function buscarUsuarios() {
        $sql = "SELECT u.id,u.nombre,u.pass,u.persona_id,u.nivel_id,u.baja,p.nombre,"
                . "p.apellido,p.dni,p.email,p.telefono,p.direccion,"
                . "DATE_FORMAT(p.fecha_nac, '%d/%m/%Y') AS fecha,n.descripcion from usuarios u, "
                . "personas p, niveles n where u.persona_id = p.id AND u.nivel_id = n.id ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aUsuario = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oUsuario = new VoUsuarios();
                $oPersona = new VoPersonas();
                $oNivel = new VoNiveles();
                $oUsuario->setId($fila->id);
                $oUsuario->setPass($fila->pass);
                $oUsuario->setNombre($fila->nombre);
                $oUsuario->setPersona_id($fila->persona_id);
                $oUsuario->setNivel_id($fila->nivel_id);
                $oUsuario->setBaja($fila->baja);
                //////////////////////////////////
                $oPersona->setNombre($fila->nombre);
                $oPersona->setApellido($fila->apellido);
                $oPersona->setDni($fila->dni);
                $oPersona->setEmail($fila->email);
                $oPersona->setTelefono($fila->telefono);
                $oPersona->setDireccion($fila->direccion);
                $oPersona->setFechaNac($fila->fecha);
                //////////////////////////////////
                $oNivel->setDescripcion($fila->descripcion);
                /////////////////////////////////
                $oUsuario->setPersona($oPersona);
                $oUsuario->setNiveles($oNivel);
                $aUsuario[] = $oUsuario;
                unset($oUsuario);
            }
            return $aUsuario;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function logueo($oUsuario) {
        $sql = "SELECT * FROM `usuarios` "
                . "WHERE nombre = '" . $oUsuario->getNombre() . "' "
                . "AND pass = '" . $oUsuario->getPass() . "' AND baja != 'S';";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $fila = mysqli_fetch_object($resultado);
        if ($fila) {
            $oUsuario = new VoUsuarios();
            $oUsuario->setId($fila->id);
            $oUsuario->setPass($fila->pass);
            $oUsuario->setNombre($fila->nombre);
            $oUsuario->setPersona_id($fila->persona_id);
            $oUsuario->setNivel_id($fila->nivel_id);
            $oUsuario->setBaja($fila->baja);
            return $oUsuario;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function guardar($oUsuario) {

        // recuperamos el id recientemente ingresado     
        $sqlid = "SELECT MAX(id) AS id FROM personas";
        $resultadoid = mysqli_query($_SESSION['con'], $sqlid);

        if ($resultadoid) {
            $row = mysqli_fetch_assoc($resultadoid);
            $idP = $row['id'];
        }
        // guardamos en la tabla de usuarios
        $sql = "INSERT INTO `usuarios` (`id`, `nombre`, `pass`, `persona_id`, `nivel_id`, `baja`) "
                . "VALUES (NULL, '" . $oUsuario->getNombre() . "', '"
                . $oUsuario->getPass() . "', '" . $idP . "', '"
                . $oUsuario->getNivel_id() . "', '');";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario, VoPersonas $oPersona
     * @return VoUsuarios, VoPersonas
     */
    public function modificar($oUsuario, $oPersona) {
        $sql = "UPDATE `usuarios` SET `nombre` = '" . $oUsuario->getNombre() . "',"
                . "`pass` = '" . $oUsuario->getPass() .
                "',`nivel_id` = '" . $oUsuario->getNivel_id()
                . "' WHERE `usuarios`.`id` = " . $oUsuario->getId() . ";";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        $sql2 = "UPDATE `personas` SET `nombre` = '" . $oPersona->getNombre() . "',"
                . "`apellido` = '" . $oPersona->getApellido() . "',`dni` = '"
                . $oPersona->getDni() . "', `email` = '" . $oPersona->getEmail()
                . "', `telefono` = '" . $oPersona->getTelefono()
                . "', `direccion` = '" . $oPersona->getDireccion()
                . "', `fecha_nac` = '" . $oPersona->getFechaNac()
                . "' WHERE `personas`.`id` = " . $oPersona->getId() . ";";
        $resultado2 = mysqli_query($_SESSION['con'], $sql2);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function bloquear($oUsuario) {
        $sql = "UPDATE `usuarios` SET `baja` = 'S' WHERE `usuarios`.`id` = " . $oUsuario->getId() . " ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoUsuarios $oUsuario
     * @return VoUsuarios
     */
    public function habilitar($oUsuario) {
        $sql = "UPDATE `usuarios` SET `baja` = NULL WHERE `usuarios`.`id` = " . $oUsuario->getId() . " ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
