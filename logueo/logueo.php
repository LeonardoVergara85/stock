<?php

date_default_timezone_set('America/Argentina/Buenos_Aires');
extract($_POST, EXTR_OVERWRITE);
session_name('stock');
session_start();

if (isset($_SESSION['username']) && $_SESSION['username'] == $username) {

    header('location: /emergencia');
} else {
    require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
    $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
    $oMysql->conectar();
    $oUsers = $oMysql->getUsuarios();
    $oVoUser = new VoUsuarios();
    $oVoUser->setNombre($username);
    $oVoUser->setPass($password);
    $oVoUser = $oUsers->logueo($oVoUser);
    
    if ($oVoUser) {
        $_SESSION['id'] = $oVoUser->getId();
        $_SESSION['nombre'] = $oVoUser->getNombre();
        $_SESSION['Nivel_id'] = $oVoUser->getNivel_id();
        echo 'yes';
        return;
    } else {
        echo 'Error al ingresar, compruebe que los datos sean correctos y vuelva a intentarlo.';
        return;
    }
}