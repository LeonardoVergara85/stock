<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oProv = $oMysql->getProveedores();
$oVoProv = new VoProveedores();
$oVoProv = $oProv->buscar();

$myfile = fopen("data/datos.txt", "w") or die("Unable to open file!");
$txt = "{\n\t\"data\": [";
fwrite($myfile, $txt);
$txt = "\n\t]\n}";
fwrite($myfile, $txt);
fclose($myfile);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Proveedores</title>
        <link href="../assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Proveedores</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Proveedor</div>
                                        <select name="proveedor" id="proveedor" class="form-control">
                                            <option value="0">Seleccione un proveedor</option>
                                            <?php
                                            foreach ($oVoProv as $variable) {
                                                $idProveedor = $variable->getId();
                                                $nombre = $variable->getNombre();
                                                ?>
                                                <option value="<?php echo $variable->getId(); ?>">
                                                    <?php echo $variable->getNombre(); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-sm-2 col-lg-offset-2">
                                <button class="btn btn-success" style="width: 100%;" id="guardar" name="guardar"><i class="fa fa-check"></i> Guardar</button>
                            </div>
                        </div>
                        <br>

                        <div class="row" id="msjguardar" style="display: none;">
                            <div class="alert alert-success alert-dismissable text-center"><i class="fa fa-check"></i> Se Guardó con éxito <button class="btn btn-default" onclick="msjguardar()"> Aceptar</button></div>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="display table table-hover table-condensed">
                                <thead style="background-color: darkgray;">
                                    <tr>
                                        <th></th>
                                        <th class="col col-sm-2">Código</th>
                                        <th class="col col-sm-7">Descripción</th>
                                        <th class="col col-sm-2">Precio Costo</th>
                                        <th class="col col-sm-1">% ganancia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>checkeado</th>
                                        <th>codigo</th>
                                        <th>descripcion</th>
                                        <th>costo</th>
                                        <th class="col col-sm-1">porcen</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include_once '../assets/php/footer.php'; ?>
        <script src="../assets/DataTables/datatables.min.js" type="text/javascript"></script>

        <script src="../assets/DataTables/DataTables-1.10.16/js/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
        <script src="js/funcionesProv_1.js" type="text/javascript"></script>
    </body>
</html>