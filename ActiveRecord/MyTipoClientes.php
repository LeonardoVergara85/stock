<?php
include_once '../ValueObject/VoTipoClientes.php';

/**
 * Description of MyTipoClientes
 * @author Usuario
 */

class MyTipoClientes{

   public function buscarTodo(){
    $sql="SELECT * FROM `tipo_cliente` ";
    $resultado = mysqli_query($_SESSION['con'], $sql);
    if ($resultado) {
            $aTipoCli = array();
            while ($fila = mysqli_fetch_object($resultado)) {
                $oTipoCli = new VoTipoClientes();
                $oTipoCli->setId($fila->id);
                $oTipoCli->setNombre($fila->nombre);
                $oTipoCli->setDescripcion($fila->descripcion);
                $aTipoCli[] = $oTipoCli;
                unset($oTipoCli);
            }
            return $aTipoCli;
           } else {
              return FALSE;
           }
   }

}