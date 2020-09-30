<?php
include_once 'activeRecordInterface.php';
include_once '../clases/ValueObject/UsuarioValueObject.php';

class MysqlUsuarioActiveRecord implements ActiveRecord{
    /**
     * 
     * @param UsuarioValueObject $oValueObject
     * @return boolean
     */
    public function actualizar($oValueObject) {
        $sql = "UPDATE usuario SET";
        $sql = " apellido = '" . $oValueObject->getApellido() . "'";
        $sql = ", fechaalta = '" . $oValueObject->getFechaalta() . "'";
        $sql = ", nombre = '" . $oValueObject->getNombre() . "'";
        $sql = ", tipousuario = '" . $oValueObject->getTipousuario() . "'";
        $sql = ", clave = MD5('" . $oValueObject->getClave() . "')";
        $sql .= " WHERE u.identificador = '".$oValueObject->getIdentificador()."';";
        if(mysql_query($sql)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function borrar($oValueObject) {
        
        if($oValueObject) return FALSE;
        else return FALSE;
    }

   /**
     * 
     * @return \UsuarioValueObject|boolean
     */
    public function buscar($oValueObject) {
        $sql="SELECT * FROM usuarios WHERE nombreUser='".$oValueObject->get_nombreUser()."'";
        $resultado = mysql_query($sql);
        if($resultado)
            {
            $aUsuario = array();
            while ($fila = mysql_fetch_object($resultado))
            {
            $oUsuario = new UsuarioValueObject();
            $oUsuario->set_nombreUser($fila->nombreUser);
            $oUsuario->set_pass($fila->pass);
            $oUsuario->setNombreReal($fila->nombreReal);
            $oUsuario->set_apellidoReal($fila->apellidoReal);
            $oUsuario->set_idUsuario($fila->idUsuario);
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
     * @param UsuarioValueObject $oValueObject
     * @return UsuarioValueObject | false
     */
    public function loguearse($oValueObject) {
        $sql = "SELECT * FROM usuario u";
        $sql .= " WHERE u.identificador = '".$oValueObject->getIdentificador()."'";
        $sql .= " AND u.clave = md5('".$oValueObject->getClave()."');";
        $resultado = mysql_query($sql);
        echo $sql ."<br>";
//        var_dump($resultado);
        $fila = mysql_fetch_object($resultado);
        if($fila){
            $oValueObject->setApellido($fila->apellido);
            $oValueObject->setFechaalta($fila->fechaalta);
            $oValueObject->setIdentificador($fila->identificador);
            $oValueObject->setNombre($fila->nombre);
//            $oValueObject->setTipousuario($fila->tipousuario);
            $oValueObject->setClave('');
            return $oValueObject;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return \UsuarioValueObject|boolean
     */
    public function buscarTodo() {
        $sql = "SELECT * FROM usuarios u;";
        $resultado = mysql_query($sql);
        if($resultado){
            $aUsuario = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oUsuario = new UsuarioValueObject();
                $oUsuario->set_nombreUser($fila->nombreUser);
                $oUsuario->set_pass($fila->pass);
                $oUsuario->setNombreReal($fila->nombreReal);
                $oUsuario->set_apellidoReal($fila->apellidoReal);
                
                $oUsuario->set_idUsuario($fila->idUsuario);
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
     * @return \UsuarioValueObject|boolean
     */
    public function buscarId($oValueObject) {
        $sql="SELECT * FROM usuarios WHERE idUsuario='".$oValueObject->get_idUsuario()."'";
        $resultado = mysql_query($sql);
        if($resultado)
            {
            $aUsuario = array();
            while ($fila = mysql_fetch_object($resultado))
            {
            $oUsuario = new UsuarioValueObject();
            $oUsuario->set_nombreUser($fila->nombreUser);
            $oUsuario->set_pass($fila->pass);
            $oUsuario->setNombreReal($fila->nombreReal);
            $oUsuario->set_apellidoReal($fila->apellidoReal);
            $oUsuario->set_idUsuario($fila->idUsuario);
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
     * @return int
     */
    public function contar() {
        $sql = "SELECT COUNT(*) FROM usuario;";
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            return $resultado[0];
        } else {
            return 0;
        }
    }

    /**
     * 
     * @param UsuarioValueObject $oValueObject
     * @return boolean
     */
    public function existe($oValueObject) {
        $sql = "SELECT COUNT(*) FROM usuario u";
        $sql .= " WHERE u.identificador = '".$oValueObject->getIdentificador()."'";
        $sql .= " AND u.clave = md5('".$oValueObject->getClave()."');";
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param UsuarioValueObject $oValueObject
     * @return boolean
     */
    public function guardar($oValueObject) {
        $sql = "INSERT INTO usuarios (nombreUser,pass,nombreReal,apellidoReal,baja)"
                . "VALUES ('".$oValueObject->get_nombreUser()."','".$oValueObject->get_pass()."',"
                . "'".$oValueObject->getNombreReal()."','".$oValueObject->get_apellidoReal()."',"
                . "1)";
//        if(!existe($oValueObject)){
            if(mysql_query($sql)) return TRUE;
            else return FALSE;
//        } else {
//            return FALSE;
//        }
    }
}
?>