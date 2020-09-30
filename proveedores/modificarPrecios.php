<?php
require_once '../ActiveRecord/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$oVoPrecioPP = new VoPreciosProveedor();
$oVoProveedor = new VoProveedores();
$oProveedor = $oMysql->getProveedores();
$proveedores = $oProveedor->buscar();
/* $precios = $oPrecioPP->buscarTodo(); */

// var_dump($prod);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Modificar Precios-Proveedor</title>
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.core.css" />
        <link rel="stylesheet" href="../assets/alertify.js-0.3.11/themes/alertify.default.css" id="toggleCSS" />
        <link href="../assets/datatable/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php
        include_once '../assets/php/header.php';
        ?>
        <div class="content-wrapper">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading panel-title">Modificar Precios</div>
                    <div class="panel-body">
                        <div class="row" id="contenedor_proveedores">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Proveedor</div>
                                        <select class="form-control" id="proveedores" name="proveedores">
                                            <option value="0">Seleccione un proveedor</option>
                                            <?php
                                            foreach ($proveedores as $key => $value) {
                                                ?><option value="<?php echo $value->getId() ?>">
                                                    <?php echo $value->getNombre() ?>   
                                                </option><?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">%</div>
                                        <input type="text" class="form-control" name="porc" id="porc" placeholder="porcentaje de incremento">
                                    </div>
                                </div>  
                            </div>
                            <div class="col-sm-3 text-right">
                                <button type="button" class="btn btn-success" onclick="modificarPrecios()"><i class="fa fa-edit"></i> Modificar</button>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-default" onclick="informeProdProv()"><i class="fa fa-file-pdf-o"></i> PDF</button>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed table-bordered" id="datatablasScroll">
                                <thead style="background-color: darkgray;">
                                <th style="display: none;">id</th>
                                <th class="text-center" style="width: 10%;">Código</th>
                                <th class="text-center" style="width: 60%;">Descripción</th>
                                <th class="text-center" style="width: 12%;">Fecha precio</th>
                                <th class="text-center" style="width: 14%;">Precio</th>
                                <th class="text-center" style="width: 10%;"><input type="checkbox" value="" onclick="SelectCompleto()" id="completo" name="completo"></th>
                                </thead>
                                <tbody id="productosProv">

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>

            </div>  
        </div>
        <?php include_once '../assets/php/footer.php'; ?>

        <script src="../assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/datatable/funciones.js" type="text/javascript"></script>
        <script src="../assets/alertify.js-0.3.11/lib/alertify.min.js"></script>
        <script src="js/funcionesPrecios.js" type="text/javascript"></script>
    </body>
</html>