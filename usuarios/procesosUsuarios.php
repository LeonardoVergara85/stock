<?php

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);


if (isset($_POST['tipo']) && $_POST['tipo'] == 'guardarUsuario') {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $nacimiento = $_POST['nacimiento'];
//    $item = explode('/', $nacimiento);
//    $nacimiento = $item[2] . '-' . $item[1] . '-' . $item[0];
    $usuario = $_POST['usuario'];
    $pass = $_POST['pass'];
    $tipou = $_POST['tipou'];


    $oMysql->conectar();
    $oUsu = $oMysql->getUsuarios();
    $oPer = $oMysql->getPersonas();
    $oVoUsu = new VoUsuarios();
    $oVoPer = new VoPersonas();

    $oVoPer->setNombre($nombre);
    $oVoPer->setApellido($apellido);
    $oVoPer->setDni($dni);
    $oVoPer->setEmail($correo);
    $oVoPer->setTelefono($telefono);
    $oVoPer->setDireccion($domicilio);
    $oVoPer->setFechaNac($nacimiento);
    $oVoPer->setUsuario_id(1);

    $oVoUsu->setNombre($usuario);
    $oVoUsu->setPass($pass);
    $oVoUsu->setPersona_id(10);
    $oVoUsu->setNivel_id($tipou);

    $oPer->guardar($oVoPer); // guardamos en la tabla de personas
    $oUsu->guardar($oVoUsu); // guardamos en la tabla de usuarios
    echo json_decode(100);
}


if (isset($_POST['tipo']) && $_POST['tipo'] == 'bloquearusuario') {
   $idU = $_POST['id'];
   $oMysql->conectar();
   $oUsu = $oMysql->getUsuarios();
   $oVoUsu = new VoUsuarios();
   $oVoUsu->setId($idU);
   $oUsu->bloquear($oVoUsu);
   echo 10;
} 

if (isset($_POST['tipo']) && $_POST['tipo'] == 'habilitarU') {
   $idU = $_POST['id'];
   $oMysql->conectar();
   $oUsu = $oMysql->getUsuarios();
   $oVoUsu = new VoUsuarios();
   $oVoUsu->setId($idU);
   $oUsu->habilitar($oVoUsu);
   echo 10;
} 


if (isset($_POST['tipo']) && $_POST['tipo'] == 'busqueda') {
   $idU = $_POST['id'];
   $oMysql->conectar();
   $oUsu = $oMysql->getUsuarios();
   $oVoUsu = new VoUsuarios();
   $oVoUsu->setId($idU);
   $oVoUsu = $oUsu->buscarUsuario($oVoUsu);
   $datos = array();
   foreach ($oVoUsu as $valores) {
     $datos[0] = $valores->getId();
     $datos[1] = $valores->getPersona()->getNombre();
     $datos[2] = $valores->getPersona()->getApellido();
     $datos[3] = $valores->getPersona()->getDni();
     $datos[4] = $valores->getPersona()->getDireccion();
     $datos[5] = $valores->getPersona()->getTelefono();
     $datos[6] = $valores->getPersona()->getEmail();
     $datos[7] = $valores->getPersona()->getFechaNac();
     $datos[8] = $valores->getNombre();
     $datos[9] = $valores->getPass();
     $datos[10] = $valores->getNivel_id();
     $datos[11] = $valores->getNiveles()->getDescripcion();
     $datos[12] = $valores->getPersona()->getId();
   }

   echo json_encode($datos);
} 


if (isset($_POST['tipo']) && $_POST['tipo'] == 'modificarUsu') {
   $idU = $_POST['id'];
   $idP = $_POST['idper'];
   $pass = $_POST['passu'];
   $nombreU = $_POST['usuariou'];
   // $idPer = $_POST['id'];
   $nivel = $_POST['nivelu'];
   $dni = $_POST['dniu'];
   $nombre = $_POST['nombreu'];
   $apellido = $_POST['apellidou'];
   $domicilio = $_POST['domiciliou'];
   $telefono = $_POST['telefonou'];
   $correo = $_POST['correou'];
   $naci = $_POST['nacu'];

   $oMysql->conectar();
   $oUsu = $oMysql->getUsuarios();
   $oVoUsu = new VoUsuarios();
   $oVoUsu->setId($idU);
   $oVoUsu->setPass($pass);
   $oVoUsu->setNombre($nombreU);
   $oVoUsu->setNivel_id($nivel);
   //////////////////////////////////////////////////////////////////
   $oVoPer = new VoPersonas();
   $oVoPer->setId($idP);
   $oVoPer->setDni($dni);
   $oVoPer->setNombre($nombre);
   $oVoPer->setApellido($apellido);
   $oVoPer->setDireccion($domicilio);
   $oVoPer->setTelefono($telefono);
   $oVoPer->setEmail($correo);
   $oVoPer->setFechaNac($naci);
   //////////////////////////////////////////////////////////////        
            
  
   $oVoUsu = $oUsu->modificar($oVoUsu,$oVoPer);
   // $datos = array();
  

   echo json_encode(500);
} 

?>