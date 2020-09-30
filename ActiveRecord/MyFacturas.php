<?php

include_once '../ValueObject/VoFacturas.php';
include_once '../ActiveRecord/activeRecordInterface.php';

/**
 * Description of MyFacturas
 *
 * @author Usuario
 */
class MyFacturas implements ActiveRecord {

    public function actualizar($oValueObject) {
        
    }

    public function borrar($oValueObject) {
        
    }

    public function buscar($oValueObject) {
        
    }

    public function buscarTodo() {
        
    }

    public function contar() {
        
    }

    public function existe($oValueObject) {
        
    }

    /**
     * 
     * @return boolean
     */
    public function ultima() {
        $result = mysqli_query($_SESSION['con'], "SELECT IF(MAX(numero) IS NULL, 1, MAX(numero) +1) FROM facturas");
        $id = mysqli_fetch_array($result);
        if ($id[0] <> 0) {
            return $id[0];
        } else {
            return false;
        }
    }

    /**
     * 
     * @param VoFacturas $oFactura
     * @return boolean
     */
    public function guardar($oFactura) {
        $sql = "INSERT INTO facturas (numero, sucursal, fecha, numero_ticket, usuario_id) "
                . "VALUES(" . $oFactura->getNumero() . ", "
                . $oFactura->getSucursal() . ", '" . $oFactura->getFecha() . "', "
                . $oFactura->getNumero_ticket() . ", " . $oFactura->getUsuario_id() . ")";

        if (mysqli_query($_SESSION['con'], $sql)) {
            $result = mysqli_query($_SESSION['con'], "SELECT DISTINCT LAST_INSERT_ID() FROM facturas");
            $id = mysqli_fetch_array($result);
            if ($id[0] <> 0) {
                $oFactura->setId($id[0]);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
