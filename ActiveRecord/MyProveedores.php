<?php

include_once '../ValueObject/VoProveedores.php';

/**
 * Description of MyUsuarios
 *
 * @author Usuario
 */
class MyProveedores {

    /**
     * 
     * @param VoProveedores $oProveedor
     * @return VoProveedores
     */
    public function buscar() {
        $sql = "SELECT * FROM proveedores where fecha_baja is null";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aProveedor = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oProv = new VoProveedores();
                $oProv->setId($fila->id);
                $oProv->setNombre($fila->nombre);
                $oProv->setDomicilio($fila->domicilio);
                $oProv->setTelefono($fila->telefono);
                $oProv->setCorreo($fila->correo);
                $oProv->setComentario($fila->comentario);
                $oProv->setCuit($fila->cuit);
                $aProveedor[] = $oProv;
                unset($oProv);
            }
            return $aProveedor;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProveedores $oProveedor
     * @return VoProveedores
     */
    public function guardar($oProveedor) {
        $sql = "INSERT INTO `proveedores` (`id`, `nombre`, `telefono`, `domicilio`, `correo`, `comentario`, `cuit`) VALUES (NULL, '" . $oProveedor->getNombre() . "', '" . $oProveedor->getTelefono() . "', '" . $oProveedor->getDomicilio() . "', '" . $oProveedor->getCorreo() . "', '" . $oProveedor->getComentario() . "', '" . $oProveedor->getCuit() . "');";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProveedores $oProveedor
     * @return VoProveedores
     */
    public function buscarProveedor($oProveedor) {
        $sql = "SELECT * FROM proveedores where fecha_baja is null and id = " 
                . $oProveedor->getID() . ";";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            $aProveedor = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oProv = new VoProveedores();
                $oProv->setId($fila->id);
                $oProv->setNombre($fila->nombre);
                $oProv->setDomicilio($fila->domicilio);
                $oProv->setTelefono($fila->telefono);
                $oProv->setCorreo($fila->correo);
                $oProv->setComentario($fila->comentario);
                $oProv->setCuit($fila->cuit);
                $aProveedor[] = $oProv;
                unset($oProv);
            }
            return $aProveedor;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProveedores $oProveedor
     * @return VoProveedores
     */
    public function eliminarProveedor($oProveedor) {
        $fecha = date("Y-m-d");
        $sql = "UPDATE `proveedores` SET `fecha_baja` = '" . $fecha . "' WHERE `proveedores`.`id` = " . $oProveedor->getID() . " ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param VoProveedores $oProveedor
     * @return VoProveedores
     */
    public function editarProveedor($oProveedor) {
        $sql = "UPDATE `proveedores` SET `nombre` = '" . $oProveedor->getNombre() . "', `telefono` = '" . $oProveedor->getTelefono() . "', `domicilio` = '" . $oProveedor->getDomicilio() . "', `correo` = '" . $oProveedor->getCorreo() . "', `comentario` = '" . $oProveedor->getComentario() . "', `cuit` = '" . $oProveedor->getCuit() . "' WHERE `proveedores`.`id` = " . $oProveedor->getId() . " ";
        $resultado = mysqli_query($_SESSION['con'], $sql);
        if ($resultado) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
