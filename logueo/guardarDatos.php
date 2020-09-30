<?php
include_once '../logueo/verifica_logueo.php';

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);

$oMysql->conectar();

extract($_POST, EXTR_OVERWRITE);

$oMyUsers = $oMysql->getUsersActiveRecord();

$oUser = new VoUsers();

$oUser->set_id($_SESSION['id']);

$oUser->set_clave($cactual);

if (!$oMyUsers->existe($oUser)) {
    ?>
    <div class="alert alert-warning" role="alert">
        
        Clave <strong>no</strong> valida.
        
    </div>
    <?php
    exit();
}

$oUser->set_clave($nueva);

if ($oMyUsers->actualizar($oUser)) {
    ?>

    <div class="alert alert-success" role="alert">

        Los datos se han almacenado <strong>correctamente!</strong>

    </div>
    <?php
} else {
    ?>

    <div class="alert alert-warning" role="alert">

        Los datos <strong>no</strong> se han almacenado.

    </div>

    <?php
}