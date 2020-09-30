<?php
include_once '../ValueObject/VoClientes.php';

/**
 * Description of MyClientes
 *
 * @author Usuario
 */

class MyClientes{

   public function buscarTodo(){
    $sql="SELECT * FROM `clientes` WHERE `vigente` IS NULL";
    $resultado = mysqli_query($_SESSION['con'], $sql);
    if ($resultado) {
            $aClientes = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oClientes = new VoClientes();
                $oClientes->setId($fila->id);
                $oClientes->setPersona_id($fila->persona_id);
                $oClientes->setLocalidad_id($fila->localidad_id);
                $oClientes->setProvincia_id($fila->provincia_id);
                $oClientes->setTipoCliente_id($fila->tipocliente_id);
                $oClientes->setCuilCuit($fila->cuilcuit);
                $oClientes->setEmpresa($fila->empresa);
                $oClientes->setFecha_alta($fila->fecha_alta);
                $oClientes->setVigente($fila->vigente);
                $aClientes[] = $oClientes;
                unset($oClientes);
            }
            return $aClientes;
           } else {
              return FALSE;
           }
   }
   
}