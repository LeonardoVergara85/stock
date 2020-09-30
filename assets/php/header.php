<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");               // Expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // Siempre p?gina modificada
header("Cache-Control: no-cache, must-revalidate");             // HTTP/1.1
header("Pragma: no-cache");                                     // HTTP/1.0
date_default_timezone_set('America/Argentina/Buenos_Aires');
header('Content-Type: text/html; charset=utf-8');
session_name('stock');
session_start();
require_once '../logueo/verifica_logueo.php';

$idU = $_SESSION['id'];

require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oUsu = $oMysql->getUsuarios();
$oN = $oMysql->getNiveles();

$oVoUsu = new VoUsuarios();
$oVoUsu->setId($idU);
$oVN = new VoNiveles();
$oVN = $oN->buscar();
$oVoUsu = $oUsu->buscarUsuario($oVoUsu);

foreach ($oVoUsu as $key) {
    $nombreu = $key->getNombre();
    $nom = $key->getPersona()->getNombre();
    $apeu = $key->getPersona()->getApellido();
    $mail = $key->getPersona()->getEmail();
    $tel = $key->getPersona()->getTelefono();
    $dir = $key->getPersona()->getDireccion();
    $nac = $key->getPersona()->getFechaNac();
    $nivel = $key->getNiveles()->getDescripcion();
    $nivel_id = $key->getNivel_id();
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
        <link href="../assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-inner">
                    <?php
                    if ($nivel_id != 2) {
                        ?>
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="../inicio">Inicio</a></li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Productos <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../productos/nuevo.php">Nuevo</a></li>
                                    <li><a href="../productos">Buscar</a></li>
                                    <?php
                                    if ($nivel_id == 1) {
                                        ?>
                                        <li><a href="../productos/preciosHistoricos.php">Precios Hist&oacute;ricos</a></li>
                                        <li class="divider"></li>
                                        <li><a href="../categoria/index.php">Categorias</a></li>
                                        <li class="divider"></li>
                                        <li><a href="../productos/reajuste.php">Reajuste</a></li>
                                        <li><a href="../productos/misReajustes.php">Mis reajuste</a></li>
                                        <li class="divider"></li>
                                        <li><a href="../productos/ofertas.php">Ofertas</a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proveedores <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../proveedores/index.php">Administrar</a></li>
                                    <li><a href="../proveedores/index_1.php">Vincular Productos</a></li>
                                    <li><a href="../proveedores/modificarPrecios.php">Incrementar Precios</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../proveedores/index_1_1.php">Listado Precios</a></li>
                                    <li><a href="../proveedores/index_1_2.php">Listado Productos</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-line-chart" aria-hidden="true"></i> Ingreso/Egreso <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../remitos/index.php"><i class="fa fa-file-text-o"></i> Remito</a></li>
                                    <li><a href="../remitos/buscarRemitos.php"><i class="fa fa-files-o"></i> Listar Remito</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../egreso"><i class="fa fa-file-text-o"></i> Egreso</a></li>
                                    <li><a href="../egreso/listarEgresos.php"><i class="fa fa-files-o"></i> Listar Egreso</a></li>
                                    <li class="divider"></li>
                                    <li><a href="../presupuesto"><i class="fa fa-file-text-o"></i> Presupuesto</a></li>
                                    <li><a href="../presupuesto/presupuestos.php"><i class="fa fa-files-o"></i> Listar Presupuestos</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Informes <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="../stock">Productos</a></li>
                                    <li><a href="../stock/index_1.php">Pto. Reposici&oacute;n</a></li>
                                    <li><a href="../stock/index_2.php">Productos Precio</a></li>
                                </ul>
                            </li>

                            <?php
                            if ($nivel_id == 1) {
                                ?>
                                <li><a href="../usuarios/index.php">Usuarios</a></li>
                                <li><a href="../respaldo/">Respaldo</a></li>
                                <?php
                            }
                            ?>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span> Usuario <i class="fa fa-user-circle" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-toggle="modal" data-target="#myModalMisDatos">Mis Datos</a></li>
                                    <li><a href="#" data-toggle="modal" onclick="cerrar()">Cerrar Sesion</a></li>
                                </ul>
                            </li>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#" data-toggle="modal" onclick="cerrar()">Cerrar Sesion</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Cerrar Sesi�n</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p>Esta seguro de cerrar la sesi�n?</p>
                        <input type="hidden" name="idUsu" id="idUsu" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-default" onclick="window.location.href = '../logueo/salir.php'"><i class="fa fa-check"></i> Aceptar</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade" id="myModalMisDatos">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Datos de Usuario</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="label label-default">Nombre</label>
                                <input type="text" class="form-control" name="" value="<?php echo $nom; ?>" disabled="">
                            </div>
                            <div class="col-sm-4">
                                <label class="label label-default">Apellido</label>
                                <input type="text" class="form-control" name="" value="<?php echo $apeu; ?>" disabled="">
                            </div>
                            <div class="col-sm-4">
                                <label class="label label-default">Nacimiento</label>
                                <input type="text" class="form-control" name="" value="<?php echo $nac; ?>" disabled="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-7">
                                <label class="label label-default">Direccion</label>
                                <input type="text" class="form-control" name="" value="<?php echo $dir; ?>" disabled="">
                            </div>
                            <div class="col-sm-5">
                                <label class="label label-default">Telefono</label>
                                <input type="text" class="form-control" name="" value="<?php echo $tel; ?>" disabled="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="label label-default">E-mail</label>
                                <input type="text" class="form-control" name="" value="<?php echo $mail; ?>" disabled="">
                            </div>
                            <div class="col-sm-4">
                                <label class="label label-default">Nivel</label>
                                <input type="text" class="form-control" name="" value="<?php echo $nivel; ?>" disabled="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-check"></i> Aceptar</button>
                    </div>
                </div>

            </div>
        </div>
    </body>
    <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
    <script type="text/javascript">
                            function cerrar() {
                                alertify.confirm("Desea salir del sistema?", function (e) {
                                    if (e) {
                                        window.location.href = '../logueo/salir.php';
                                    }
                                });
                            }
                            ;
    </script>
</html>