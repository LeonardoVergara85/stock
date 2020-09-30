<?php
include_once '../ValueObject/VoPersonas.php';

/**
 * Description of MyPersonas
 *
 * @author Usuario
 */

/**
* 
*/
class MyPersonas{
	
	/**
     * 
     * @param VoPersonas $oPersona
     * @return VoPersonas
     */
	public function buscar() {
        $sql = "SELECT * FROM personas";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aPersona = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oPer = new VoPersonas();
                $oPer->setId($fila->id);
                $oPer->setNombre($fila->nombre);
                $oPer->setApellido($fila->apellido);
                $oPer->setDni($fila->dni);
                $oPer->setEmail($fila->email);
                $oPer->setTelefono($fila->telefono);
                $oPer->setDireccion($fila->direccion);
                $oPer->setFechaNac($fila->fechaNac);
                $oPer->setUsuario_id($fila->usuario_id);
                $aPersona[] = $oPer;
                unset($oPer);
            }
            return $aPersona;
        } else {
            return FALSE;
        }
    }


    /**
     * 
     * @param VoPersonas $oPersona
     * @return VoPersonas
     */

    public function guardar($oPersona){
       $sql = "INSERT INTO `personas` (`id`, `nombre`, `apellido`, `dni`, `email`, `telefono`, `direccion`, `fecha_nac`, `usuario_id`) VALUES (NULL, '".$oPersona->getNombre()."', '".$oPersona->getApellido()."', '".$oPersona->getDni()."', '".$oPersona->getEmail()."', '".$oPersona->getTelefono()."', '".$oPersona->getDireccion()."', '".$oPersona->getFechaNac()."', '0');";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}